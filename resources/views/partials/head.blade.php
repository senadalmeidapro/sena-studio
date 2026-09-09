<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $seo = app(\App\Services\Seo::class);
    $seoTitle = $seo->title($title ?? null);
    $seoDescription = $seo->description();
    $canonical = $seo->canonical();
    $ogType = $seo->type();
    $ogImage = $seo->image();
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}" />
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

<link rel="icon" href="/favicon.svg" type="image/svg+xml">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&family=space-grotesk:400,500,600,700&family=jetbrains-mono:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance