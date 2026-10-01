<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;color:#172554;font-size:12px}h1,h2{color:#1d4ed8}.meta{color:#475569}.box{border:1px solid #cbd5e1;padding:14px;margin:18px 0;white-space:pre-line}.row{margin:8px 0}.label{font-weight:bold}</style></head>
<body>
    <h1>Quote</h1>
    <div class="meta">Issued {{ today()->format('Y-m-d') }} · Valid until {{ $validUntil }}</div>
    <div class="box"><strong>{{ $issuer['legal_name'] }}</strong><br>{{ $issuer['address'] }}<br>Tax ID: {{ $issuer['tax_id'] }}<br>{{ $issuer['bank_details'] }}</div>
    <h2>{{ $engagement->title }}</h2>
    <div class="row"><span class="label">Client:</span> {{ $engagement->client->name }}@if($engagement->client->company) · {{ $engagement->client->company }}@endif</div>
    <div class="row"><span class="label">Pricing model:</span> {{ $engagement->pricing_model->label() }}</div>
    <h2>Scope</h2><div class="box">{{ $engagement->scope }}</div>
    <div class="row"><span class="label">Amount:</span> {{ $engagement->amount === null ? 'TODO: FIX ME — set quote amount' : $money->format($engagement->amount, $engagement->currency) }}</div>
    <h2>Payment terms</h2><div class="box">{{ $paymentTerms }}</div>
    <div class="box">Payment details: {{ $issuer['payment_details'] }}</div>
</body>
</html>
