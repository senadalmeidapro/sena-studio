<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-ink-50 text-ink-900 antialiased selection:bg-sage-300 selection:text-sage-950 dark:bg-ink-950 dark:text-ink-100 dark:selection:bg-sage-500 dark:selection:text-white">
        <div class="relative flex min-h-screen flex-col overflow-x-clip">

            {{-- Ambient background glow --}}
            <div class="pointer-events-none fixed inset-x-0 top-0 z-0 h-[40rem] overflow-hidden" aria-hidden="true">
                <div class="absolute -top-40 left-1/2 h-[34rem] w-[56rem] -translate-x-1/2 animate-drift rounded-full bg-sage-300/40 blur-3xl dark:bg-sage-500/10"></div>
                <div class="absolute -top-24 left-[8%] h-80 w-80 animate-drift rounded-full bg-sage-200/50 blur-3xl [animation-delay:-8s] dark:bg-sage-700/10"></div>
                <div class="absolute -top-16 right-[8%] h-72 w-72 animate-drift rounded-full bg-sage-400/20 blur-3xl [animation-delay:-14s] dark:bg-ink-500/20"></div>
            </div>

            <x-site-navbar />

            <main class="relative z-10 flex-1">
                {{ $slot }}
            </main>

            <x-site-footer />
        </div>

        @fluxScripts
    </body>
</html>