<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-canvas text-ink-900 antialiased selection:bg-blue-500 selection:text-white dark:bg-canvas dark:text-ink-100">
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