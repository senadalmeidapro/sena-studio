<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-950">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-slate-800 bg-slate-900 lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-b-0 lg:border-r">
                <div class="flex h-16 items-center justify-between border-b border-slate-800 px-6">
                    <a href="{{ route('backoffice.dashboard') }}" class="font-semibold tracking-tight text-white">Sena Studio <span class="font-mono text-xs text-blue-400">/ admin</span></a>
                </div>
                <nav class="flex gap-1 overflow-x-auto p-4 lg:block lg:space-y-1">
                    <a href="{{ route('backoffice.dashboard') }}" class="block whitespace-nowrap rounded-lg px-3 py-2 text-sm text-slate-300 transition hover:bg-slate-800 hover:text-white">Tableau de bord</a>
                    <a href="{{ route('backoffice.projects.index') }}" class="block whitespace-nowrap rounded-lg px-3 py-2 text-sm text-slate-300 transition hover:bg-slate-800 hover:text-white">Projets</a>
                    <a href="{{ url('/admin') }}" class="block whitespace-nowrap rounded-lg px-3 py-2 text-sm text-slate-400 transition hover:bg-slate-800 hover:text-white">Ancien admin Filament</a>
                    <form method="POST" action="{{ route('logout') }}" class="lg:mt-8">@csrf<button class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-400 transition hover:bg-red-500/10 hover:text-red-300">Déconnexion</button></form>
                </nav>
            </aside>
            <main class="w-full lg:pl-72">
                <div class="mx-auto max-w-7xl p-5 sm:p-8">{{ $slot }}</div>
            </main>
        </div>
        @livewireScripts
        @fluxScripts
    </body>
</html>
