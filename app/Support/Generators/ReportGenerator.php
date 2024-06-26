<?php

namespace App\Support\Generators;

use App\Models\Report;
use App\Models\Invoice;
use Carbon\Carbon;


class ReportGenerator{
    public static function generateExcelOutput(){
        $outputList = collect([]);

        Report::where('status', '=', 'Approved')->orWhere('status', '=', 'Restituted')->get()->each(function(Report $report) use (&$outputList){
            $reportAmount = number_format($report->amount(), 2);
            $reportUsername = $report->user()->get()->first()->username;
            $reportDate = Carbon::parse($report->to_date)->format('d/m/Y');
            $reportPaymentStatus = $report->status === 'Approved' ? 'APROBADO' : 'APROBADO Y REEMBOLSADO';
            $report->invoices()->each(function(Invoice $invoice) use (&$outputList, $report, $reportAmount, $reportUsername, $reportDate, $reportPaymentStatus){
                $invoiceTypeAbbreviationShort = $invoice->type === 'Facture' ? 'FT' : 'BV';
                $invoiceTypeAbbreviation = $invoice->type === 'Facture' ? 'FACTURAS' : 'BOLETAS';
                $invoiceDate = Carbon::parse($invoice->date)->format('d/m/Y');
                $invoiceData = [
                    'identifier' => $reportUsername . '-' . $invoiceTypeAbbreviationShort . '-' . $invoiceDate  . '-' . number_format($invoice->amount, 2),
                    'consumption_date' => $invoiceDate,
                    'creation_date' => Carbon::parse($invoice->created_at)->format('d/m/Y'),
                    'type' => $invoiceTypeAbbreviation,
                    'description' => $invoice->description,
                    'user' => $reportUsername,
                    'report' => [
                        'identifier' => $reportUsername . '-' . $invoiceTypeAbbreviationShort . '-' . $reportDate  . '-' . $reportAmount,
                        'amount' => $reportAmount,
                        'money_type' => $report->money_type,
                        'date' => $reportDate,
                        'country' => $report->country
                    ],
                    'ticket_number' => $invoice->ticket_number,
                    'commerce_number' => $invoice->commerce_number,
                    'job_code' => $invoice->job_code,
                    'expense_code' => $invoice->expense_code,
                    'amount' => number_format($invoice->amount, 2),
                    'payment_status' => $reportPaymentStatus
                ];
                $outputList->push($invoiceData);
            });
        });
        return $outputList;
    }
}
