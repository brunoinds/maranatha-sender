<?php

namespace App\Http\Controllers;

use App\Helpers\Enums\ReportStatus;
use App\Helpers\Toolbox;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Mail\NewReportSent;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\Assistants\ReportAssistant;
use Illuminate\Support\Facades\Mail;
use App\Support\Generators\ReportGenerator;
use App\Support\GoogleSheets\Excel;
use OneSignal;
use App\Models\User;
use App\Support\Assistants\BalanceAssistant;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use DateTime;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $report = Report::create($request->validated());
        return response()->json(['message' => 'Report created', 'report' => $report->toArray()]);
    }

    /**
     * Display the specified resource.
     */
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


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {

        $previousStatus = $report->status;


        $report->update($request->validated());


        if ($report->status === ReportStatus::Approved){
            $report->approved_at = (new DateTime())->format('c');
            BalanceAssistant::createBalanceExpenseFromReport($report);
        } else {
            $report->approved_at = null;
        }

        if ($report->status === ReportStatus::Restituted){
            $report->restituted_at = (new DateTime())->format('c');
            BalanceAssistant::createBalanceRestitutionFromReport($report);
        } else {
            $report->restituted_at = null;
        }

        if ($report->status === ReportStatus::Rejected){
            $report->rejected_at = (new DateTime())->format('c');
            BalanceAssistant::deleteBalancesFromReport($report);
        } else {
            $report->rejected_at = null;
        }

        if ($report->status === ReportStatus::Submitted){
            $report->submitted_at = (new DateTime())->format('c');
            BalanceAssistant::deleteBalancesFromReport($report);
        }

        if ($report->status === ReportStatus::Draft){
            $report->submitted_at = null;
            BalanceAssistant::deleteBalancesFromReport($report);
        }

        $report->save();

        if ($previousStatus !== $report->status && env('APP_ENV') === 'production'){
            $excelOutput = ReportGenerator::generateExcelOutput();
            Excel::updateDBSheet($excelOutput);
        }


        if ($previousStatus === ReportStatus::Draft && $report->status === ReportStatus::Submitted){
            //Send notification
            $user = $report->user()->get()->first();
            $adminUser = User::where('username', 'admin')->first();

            if (env('APP_ENV') === 'production'){
                OneSignal::sendNotificationToExternalUser(
                    headings: "Nuevo reporte recibido 📥",
                    message: $user->name . " ha enviado un nuevo reporte de " . Toolbox::moneyPrefix($report->money_type->value) . number_format($report->amount(), 2) . " y está esperando por su aprobación.", 
                    userId: (string) 'user-id-'.$adminUser->id
                );
            }
            
        }

        if ($previousStatus === ReportStatus::Submitted && $report->status === ReportStatus::Approved){
            //Send notification
            $user = $report->user()->get()->first();

            if (env('APP_ENV') === 'production'){
                OneSignal::sendNotificationToExternalUser(
                    headings: "Reporte aprobado ✅",
                    message: "El administrador ha aprobado su reporte de " . Toolbox::moneyPrefix($report->money_type->value) . number_format($report->amount(), 2) . ". Pronto recibirás su reembolso.", 
                    userId: (string) 'user-id-'.$user->id
                );
            }
        }

        if ($previousStatus === ReportStatus::Approved && $report->status === ReportStatus::Restituted){
            //Send notification
            $user = $report->user()->get()->first();

            if (env('APP_ENV') === 'production'){
                OneSignal::sendNotificationToExternalUser(
                    headings: "Reporte reembolsado 💰",
                    message: "El administrador ha reembolsado " . Toolbox::moneyPrefix($report->money_type->value) . number_format($report->amount(), 2) . " vía depósito en su cuenta bancária por su reporte aprobado.", 
                    userId: (string) 'user-id-'.$user->id
                );
            }
        }

        if ($previousStatus === ReportStatus::Submitted && $report->status === ReportStatus::Rejected){
            //Send notification
            $user = $report->user()->get()->first();

            if (env('APP_ENV') === 'production'){
                OneSignal::sendNotificationToExternalUser(
                    headings: "Reporte rechazado ❌",
                    message: "El administrador ha rechazado su reporte de " . Toolbox::moneyPrefix($report->money_type->value) . number_format($report->amount(), 2) . ". Ingrese a la aplicación para ver el motivo de rechazo.", 
                    userId: (string) 'user-id-'.$user->id
                );
            }
        }

        return response()->json(['message' => 'Report updated', 'report' => $report->toArray()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return response()->json(['message' => 'Report deleted']);
    }

    public function invoices(Report $report)
    {
        $invoices = $report->invoices()->get();
        return response()->json(collect($invoices)->toArray());
    }


    /**
     * Upload report PDF
     */
    public function uploadReportPDF(Request $request, Report $report)
    {
        $base64PDF = $request->input('pdf');
        $documentId = Str::random(40);
        $path = 'reports/' . $documentId;

        $pdfDecoded = base64_decode($base64PDF);

        $wasSuccessfull = Storage::disk('public')->put($path, $pdfDecoded);

        if (!$wasSuccessfull) {
            return response()->json([
                'error' => [
                    'message' => 'PDF upload failed',
                ]
            ], 500);
        }

        $report->exported_pdf = $documentId;
        $report->save();

        return response()->json([
            'message' => 'PDF uploaded',
            'pdf' => [
                'id' => $documentId,
                'url' => Storage::disk('public')->url($path),
            ]
        ]);
    }

    public function downloadPDF(Report $report){
        $assetId = $report->exported_pdf;
        if ($assetId == null) {
            return response()->json(['message' => 'Report not generated yet'], 400);
        }

        return Storage::disk('public')->download('reports/' . $assetId, $report->title . '.pdf');
    }
    public function downloadExcel(Report $report){
        $excel = ReportAssistant::generateExcelDocument($report);
        $documentName = $report->title . '.xlsx';
        //Generate a temp directory and save the file there:
        
        $temporaryDirectory = (new TemporaryDirectory())->create();
        $tempPath = $temporaryDirectory->path($documentName);

        $excel->save($tempPath, true);

        return response()->download($tempPath, $documentName)->deleteFileAfterSend(true);
    }
}
