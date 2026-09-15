<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $seo = app(\App\Services\Seo::class);
    $seoTitle = $seo->title($title ?? null);
    $seoDescription = $seo->description();
    $canonical = $seo->canonical();
    $ogType = $seo->type();
    $ogImage = $seo->image();
    $structuredData = $seo->structuredData();
    $robots = $seo->robots();
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}" />
<meta name="robots" content="{{ $robots }}" />
<link rel="canonical" href="{{ $canonical }}" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:type" content="{{ $ogType }}" />
<meta property="og:title" content="{{ $seoTitle }}" />
<meta property="og:description" content="{{ $seoDescription }}" />
<meta property="og:url" content="{{ $canonical }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $seoTitle }}" />
<meta name="twitter:description" content="{{ $seoDescription }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />

@if ($structuredData !== [])
    <script type="application/ld+json">@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endif

<link rel="icon" href="/favicon.svg" type="image/svg+xml">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&family=jetbrains-mono:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
