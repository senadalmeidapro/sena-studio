<?php

namespace App\Http\Controllers\Admin;

use App\Models\Engagement;
use App\Models\Invoice;
use App\Support\BillingIssuer;
use App\Support\MoneyFormatter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BillingPdfController
{
    public function quote(Request $request, Engagement $engagement, BillingIssuer $issuer, MoneyFormatter $money): Response
    {
        $this->authorizeAdmin($request);
        if (app()->isProduction() && $issuer->missing() !== []) {
            return response('PDF generation is unavailable. Configure these billing issuer values first: '.implode(', ', $issuer->missing()).'.', 503);
        }

        $days = config('services.billing.quote_validity_days');
        $paymentTerms = config('services.billing.payment_terms');

        if (app()->isProduction() && (! is_numeric($days) || (int) $days < 1 || blank($paymentTerms))) {
            return response('Quote PDF generation is unavailable. Configure BILLING_QUOTE_VALIDITY_DAYS and BILLING_PAYMENT_TERMS first.', 503);
        }

        $pdf = Pdf::loadView('pdf.billing.quote', [
            'engagement' => $engagement->loadMissing('client', 'project'),
            'issuer' => $issuer->details(),
            'money' => $money,
            'validUntil' => is_numeric($days) && (int) $days > 0
                ? today()->addDays((int) $days)->format('Y-m-d')
                : 'TODO: configure quote validity period',
            'paymentTerms' => filled($paymentTerms) ? $paymentTerms : 'TODO: replace with agreed payment terms',
        ])->setPaper('a4')->setOptions(['isRemoteEnabled' => false, 'isHtml5ParserEnabled' => true]);

        return $pdf->download('Quote-'.$engagement->id.'.pdf');
    }

    public function invoice(Request $request, Invoice $invoice, BillingIssuer $issuer, MoneyFormatter $money): Response
    {
        $this->authorizeAdmin($request);
        if (app()->isProduction() && $issuer->missing() !== []) {
            return response('PDF generation is unavailable. Configure these billing issuer values first: '.implode(', ', $issuer->missing()).'.', 503);
        }

        $pdf = Pdf::loadView('pdf.billing.invoice', [
            'invoice' => $invoice->loadMissing('engagement.client'),
            'issuer' => $issuer->details(),
            'money' => $money,
        ])->setPaper('a4')->setOptions(['isRemoteEnabled' => false, 'isHtml5ParserEnabled' => true]);

        return $pdf->download('Invoice-'.$invoice->number.'.pdf');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->isAdmin(), 403);
    }
}
