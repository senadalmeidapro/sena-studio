<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @if (filled(config('services.analytics.script')))
            {!! config('services.analytics.script') !!}
        @endif
    </head>
    <body class="engineering-shell min-h-screen bg-canvas text-ink-900 antialiased selection:bg-blue-500 selection:text-white dark:bg-canvas dark:text-ink-100">
        <div class="public-site-shell relative flex min-h-screen flex-col">

            <x-site-navbar />

            <main class="public-main relative z-10 flex-1">
                {{ $slot }}
            </main>

            <x-site-footer />
        </div>

        @fluxScripts
    </body>
</html>
