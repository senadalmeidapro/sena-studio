<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @if (filled(config('services.analytics.script')))
            {!! config('services.analytics.script') !!}
        @endif
    </head>
    <body class="engineering-shell min-h-screen bg-bg text-text antialiased selection:bg-accent selection:text-on-accent  ">
        <div class="relative flex min-h-screen flex-col overflow-x-clip">

            <x-site-navbar />

            <main class="relative z-10 flex-1">
                {{ $slot }}
            </main>

            <x-site-footer />
        </div>

        @fluxScripts
    </body>
</html>
