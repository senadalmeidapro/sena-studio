<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>CV — {{ $cv->headline }}</title>
    <style>@page { margin: 12mm; } body { margin: 0; }</style>
</head>
<body>
    @include('pdf.cv-engineering')
</body>
</html>