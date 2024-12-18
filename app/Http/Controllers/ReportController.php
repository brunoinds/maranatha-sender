<?php

namespace App\Http\Controllers;

use App\Helpers\Enums\ReportStatus;
use App\Helpers\Toolbox;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\Assistants\ReportAssistant;
use App\Support\Generators\ReportGenerator;
use App\Support\GoogleSheets\Excel;
use OneSignal;
use App\Models\User;
use App\Support\Assistants\BalanceAssistant;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use DateTime;
use App\Support\Creators\Reports\ReportPDFCreator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;
use App\Support\Cache\RecordsCache;

class ReportController extends Controller
{
    public function index()
    {

        if (!auth()->user()->isAdmin()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $allReports = Report::all();

        $allReports->each(function ($report) {
            $report->user = $report->user()->get()->first()->toArray();
        });

        $allReports->each(function ($report) {
            $report->invoices = [
                'count' => $report->invoices()->count(),
                'total_amount' => $report->invoices()->sum('amount'),
            ];
        });

        return response()->json($allReports->toArray());
    }

    public function create()
    {
        //
    }

    public function store(StoreReportRequest $request)
    {
        $report = Report::create($request->validated());
        RecordsCache::clearAll();
        return response()->json(['message' => 'Report created', 'report' => $report->toArray()]);
    }

    public function show(Report $report)
    {
        return response()->json($report->toArray());
    }

    public function myReports()
    {
        $myReports = collect(Report::all()->where('user_id', auth()->user()->id)->values());
        $myReports->each(function ($report) {
            $report->invoices = [
                'count' => $report->invoices()->count(),
                'total_amount' => $report->invoices()->sum('amount'),
            ];
        });
        return response()->json($myReports->toArray());
    }

    public function update(UpdateReportRequest $request, Report $report)
    {
        $notificationUrlOnManagmentReports = env('APP_WEB_URL') . '/management?showReportId=' . $report->id;
        $notificationUrlOnUserReports = env('APP_WEB_URL') . '/reports/' . $report->id;

        $previousStatus = $report->status;


        $report->update($request->validated());


        if ($report->status === ReportStatus::Approved){
            $report->approved_at = (new DateTime())->format('c');
            BalanceAssistant::createBalanceExpenseFromReport($report);
        }

        if ($report->status === ReportStatus::Restituted){
            $report->restituted_at = (new DateTime())->format('c');
            BalanceAssistant::createBalanceRestitutionFromReport($report);
        }

        if ($report->status === ReportStatus::Rejected){
            $report->rejected_at = (new DateTime())->format('c');
            BalanceAssistant::deleteBalancesFromReport($report);
        }

        if ($report->status === ReportStatus::Submitted){
            $report->submitted_at = (new DateTime())->format('c');
            BalanceAssistant::deleteBalancesFromReport($report);
        }

        if ($report->status === ReportStatus::Draft){
            $report->submitted_at = null;
            BalanceAssistant::deleteBalancesFromReport($report);
        }

        if ($report->status === ReportStatus::Draft){
            $report->rejected_at = null;
            $report->submitted_at = null;
            $report->approved_at = null;
            $report->restituted_at = null;
        }elseif ($report->status === ReportStatus::Submitted){
            $report->rejected_at = null;
            $report->approved_at = null;
            $report->restituted_at = null;
        }elseif ($report->status === ReportStatus::Approved){
            $report->rejected_at = null;
            $report->restituted_at = null;
        }elseif ($report->status === ReportStatus::Rejected){
            $report->approved_at = null;
            $report->restituted_at = null;
        }

        $report->save();

        /* if ($previousStatus !== $report->status && env('APP_ENV') === 'production'){
            $excelOutput = ReportGenerator::generateExcelOutput();
            Excel::updateDBSheet($excelOutput);
        } */
        if ($previousStatus === ReportStatus::Draft && $report->status === ReportStatus::Submitted){
            //Send notification
            $user = $report->user()->get()->first();
            $adminUser = User::where('username', 'admin')->first();

            OneSignal::sendNotificationToExternalUser(
                headings: "Nuevo reporte recibido 📥",
                message: $user->name . " ha enviado un nuevo reporte de " . Toolbox::moneyPrefix($report->money_type->value) . ' ' . number_format($report->amount(), 2) . " y está esperando por su aprobación.",
                userId: Toolbox::getOneSignalUserId($adminUser->id),
                data: [
                    'deepLink' => $notificationUrlOnUserReports
                ]
            );
        }
        if ($previousStatus === ReportStatus::Submitted && $report->status === ReportStatus::Approved){
            //Send notification
            $user = $report->user()->get()->first();

            OneSignal::sendNotificationToExternalUser(
                headings: "Reporte aprobado ✅",
                message: "El administrador ha aprobado su reporte de " . Toolbox::moneyPrefix($report->money_type->value) . ' ' . number_format($report->amount(), 2) . ". Pronto recibirás su reembolso.",
                userId: Toolbox::getOneSignalUserId($user->id),
                data: [
                    'deepLink' => $notificationUrlOnUserReports
                ]
            );
        }
        if ($previousStatus === ReportStatus::Approved && $report->status === ReportStatus::Restituted){
            //Send notification
            $user = $report->user()->get()->first();

            OneSignal::sendNotificationToExternalUser(
                headings: "Reporte reembolsado 💰",
                message: "El administrador ha reembolsado " . Toolbox::moneyPrefix($report->money_type->value) . ' ' . number_format($report->amount(), 2) . " vía depósito en su cuenta bancária por su reporte aprobado.",
                userId: Toolbox::getOneSignalUserId($user->id),
                data: [
                    'deepLink' => $notificationUrlOnUserReports
                ]
            );
        }
        if ($previousStatus === ReportStatus::Submitted && $report->status === ReportStatus::Rejected){
            //Send notification
            $user = $report->user()->get()->first();

            OneSignal::sendNotificationToExternalUser(
                headings: "Reporte rechazado ❌",
                message: "El administrador ha rechazado su reporte de " . Toolbox::moneyPrefix($report->money_type->value) . ' ' . number_format($report->amount(), 2) . ". Ingrese a la aplicación para ver el motivo de rechazo.",
                userId: Toolbox::getOneSignalUserId($user->id),
                data: [
                    'deepLink' => $notificationUrlOnUserReports
                ]
            );
        }
        RecordsCache::clearAll();
        return response()->json(['message' => 'Report updated', 'report' => $report->toArray()]);
    }

    public function destroy(Report $report)
    {
        $report->delete();
        RecordsCache::clearAll();
        return response()->json(['message' => 'Report deleted']);
    }

    public function invoices(Report $report)
    {
        $invoices = $report->invoices()->get();
        return response()->json(collect($invoices)->toArray());
    }

    public function checkProgressDownloadPDF(Request $request)
    {
        $progressId = request()->query('progress_id');

        if (!$progressId){
            return response()->json(['message' => 'Progress ID not found'], 404);
        }

        $progressItem = json_decode(Cache::store('file')->get('Maranatha/PDFRender/Progress/' . $progressId), true);
        if ($progressItem === null){
            return response()->json(['message' => 'Progress not found'], 404);
        }
        return response()->json($progressItem);
    }

    public function downloadPDF(Report $report)
    {
        //Check if request has query item called progress_id:
        $progressId = request()->query('progress_id');
        $options = [];
        if ($progressId){
            $options['progressId'] = $progressId;
        }


        $pdf = ReportPDFCreator::new($report);
        $content = $pdf->create($options);

        $documentName = Str::slug($report->title, '-') . '.pdf';



        $temporaryDirectory = (new TemporaryDirectory())->create();
        $tempPath = $temporaryDirectory->path($documentName);

        file_put_contents($tempPath, $content);

        return response()
            ->download($tempPath, $documentName, [
                'Content-Encoding' => 'base64',
                'Content-Length' => filesize($tempPath),
            ])->deleteFileAfterSend(true);
    }

    public function downloadExcel(Report $report)
    {
        $excel = ReportAssistant::generateExcelDocument($report);
        $documentName = Str::slug($report->title, '-') . '.xlsx';
        //Generate a temp directory and save the file there:

        $temporaryDirectory = (new TemporaryDirectory())->create();
        $tempPath = $temporaryDirectory->path($documentName);

        $excel->save($tempPath, true);

        return response()->download($tempPath, $documentName, [
            'Content-Length' => filesize($tempPath),
            'Maranatha-Content-Size' => filesize($tempPath),
        ])->deleteFileAfterSend(true);
    }
}
