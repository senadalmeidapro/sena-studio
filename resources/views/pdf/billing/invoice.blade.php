<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;color:#172554;font-size:12px}h1,h2{color:#1d4ed8}.meta{color:#475569}.box{border:1px solid #cbd5e1;padding:14px;margin:18px 0;white-space:pre-line}.row{margin:8px 0}.label{font-weight:bold}</style></head>
<body>
    <h1>Invoice {{ $invoice->number }}</h1>
    <div class="meta">Issued {{ $invoice->issued_at?->format('Y-m-d') ?? 'TODO: set issue date' }} · Due {{ $invoice->due_at?->format('Y-m-d') ?? 'TODO: set due date' }}</div>
    <div class="box"><strong>{{ $issuer['legal_name'] }}</strong><br>{{ $issuer['address'] }}<br>Tax ID: {{ $issuer['tax_id'] }}<br>{{ $issuer['bank_details'] }}</div>
    <h2>{{ $invoice->engagement->title }}</h2>
    <div class="row"><span class="label">Client:</span> {{ $invoice->engagement->client->name }}@if($invoice->engagement->client->company) · {{ $invoice->engagement->client->company }}@endif</div>
    <div class="row"><span class="label">Amount:</span> {{ $money->format($invoice->amount, $invoice->currency) }}</div>
    <div class="box">Payment details: {{ $issuer['payment_details'] }}<br>{{ $issuer['bank_details'] }}</div>
</body>
</html>
