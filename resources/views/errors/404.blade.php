<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-canvas text-ink-900 antialiased selection:bg-blue-500 selection:text-white dark:bg-canvas dark:text-ink-100">
        <div class="relative flex min-h-screen flex-col overflow-x-clip">

            <x-site-navbar />

            <main class="relative z-10 flex flex-1 items-center justify-center px-4 py-24">
                <div class="text-center motion-safe:animate-fade-up">
                    <p class="font-mono text-[0.7rem] uppercase tracking-[0.3em] text-blue-600 dark:text-blue-400">{{ __('errors.404.code') }}</p>
                    <h1 class="mt-6 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-6xl">
                        {!! __('errors.404.title') !!}
                    </h1>
                    <p class="mx-auto mt-4 max-w-md text-pretty text-ink-600 dark:text-ink-300">
                        {{ __('errors.404.text') }}
                    </p>
                    <div class="mt-10 flex flex-wrap items-center justify-center gap-6">
                        <a href="{{ localized_route('home') }}" wire:navigate
                           class="group inline-flex items-center gap-2.5 rounded-xl bg-blue-600 px-6 py-3.5 font-display text-base font-medium text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-card dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">
                            {{ __('errors.404.home') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a href="{{ localized_route('contact') }}" wire:navigate class="font-medium text-ink-600 underline-offset-4 transition-colors hover:text-blue-600 hover:underline dark:text-ink-300 dark:hover:text-blue-300">
                            {{ __('errors.404.contact') }}
                        </a>
                    </div>
                </div>
            </main>

            <x-site-footer />
        </div>

        @fluxScripts
    </body>
</html>