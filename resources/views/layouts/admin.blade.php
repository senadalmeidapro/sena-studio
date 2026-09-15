<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-950">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-[#07111f] text-slate-100 antialiased selection:bg-blue-500 selection:text-white">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-slate-800/80 bg-[#0b1728] lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-b-0 lg:border-r">
                <div class="flex h-20 items-center justify-between border-b border-slate-800/80 px-6">
                    <a href="{{ route('backoffice.dashboard') }}" class="group flex items-center gap-3 font-semibold tracking-tight text-white"><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 font-mono text-sm shadow-lg shadow-blue-950/40">S</span><span>Sena Studio <small class="block font-mono text-[10px] font-normal uppercase tracking-[0.18em] text-blue-400">control room</small></span></a>
                </div>
                <nav class="flex gap-1 overflow-x-auto p-4 lg:block lg:space-y-7 lg:overflow-visible">
                    <div><p class="mb-2 px-3 font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">Workspace</p><div class="space-y-1"><a href="{{ route('backoffice.dashboard') }}" @class(['flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition', 'bg-blue-500/10 text-blue-300 ring-1 ring-blue-500/20' => request()->routeIs('backoffice.dashboard'), 'text-slate-400 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('backoffice.dashboard')])><span class="font-mono text-xs text-blue-400">00</span>Tableau de bord</a><a href="{{ route('backoffice.projects.index') }}" @class(['flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition', 'bg-blue-500/10 text-blue-300 ring-1 ring-blue-500/20' => request()->routeIs('backoffice.projects.*'), 'text-slate-400 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('backoffice.projects.*')])><span class="font-mono text-xs text-blue-400">01</span>Projets</a></div></div>
                    <div><p class="mb-2 px-3 font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">Contenu</p><div class="space-y-1"><a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-500 transition hover:bg-slate-800 hover:text-slate-300"><span class="font-mono text-xs text-slate-600">02</span>Articles <span class="ml-auto font-mono text-[9px] uppercase">soon</span></a><a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-500 transition hover:bg-slate-800 hover:text-slate-300"><span class="font-mono text-xs text-slate-600">03</span>CV et parcours <span class="ml-auto font-mono text-[9px] uppercase">soon</span></a><a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-500 transition hover:bg-slate-800 hover:text-slate-300"><span class="font-mono text-xs text-slate-600">04</span>Témoignages <span class="ml-auto font-mono text-[9px] uppercase">soon</span></a></div></div>
                    <div><p class="mb-2 px-3 font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">Système</p><div class="space-y-1"><a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-500 transition hover:bg-slate-800 hover:text-slate-300"><span class="font-mono text-xs text-slate-600">05</span>Messages <span class="ml-auto font-mono text-[9px] uppercase">soon</span></a><a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-500 transition hover:bg-slate-800 hover:text-slate-300"><span class="font-mono text-xs text-slate-600">06</span>Paramètres <span class="ml-auto font-mono text-[9px] uppercase">soon</span></a></div></div>
                    <div class="hidden lg:block"><p class="mb-2 px-3 font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">Legacy</p><a href="{{ url('/admin') }}" class="block rounded-lg px-3 py-2.5 text-sm text-slate-500 transition hover:bg-slate-800 hover:text-slate-300">Ouvrir Filament</a></div>
                    <form method="POST" action="{{ route('logout') }}" class="lg:pt-6">@csrf<button class="w-full rounded-lg px-3 py-2.5 text-left text-sm text-slate-500 transition hover:bg-red-500/10 hover:text-red-300">Déconnexion</button></form>
                </nav>
                <div class="mt-auto hidden border-t border-slate-800/80 p-5 lg:block"><p class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">Environment</p><div class="mt-2 flex items-center gap-2 text-xs text-slate-400"><span class="h-2 w-2 rounded-full bg-emerald-400 shadow-lg shadow-emerald-500/50"></span>{{ app()->environment() }} <span class="ml-auto font-mono text-slate-600">v1.0</span></div></div>
            </aside>
            <main class="w-full lg:pl-72">
                <header class="flex h-20 items-center justify-between border-b border-slate-800/80 px-5 sm:px-8"><div class="font-mono text-xs text-slate-500"><span class="text-blue-400">~/sena-studio</span> / backoffice</div><div class="flex items-center gap-3"><a href="{{ route('home') }}" class="hidden text-sm text-slate-500 transition hover:text-white sm:block">Voir le site</a><div class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-xs font-semibold text-blue-300">{{ auth()->user()->initials() }}</div></div></header><div class="mx-auto max-w-7xl p-5 sm:p-8">{{ $slot }}</div>
            </main>
        </div>
        @livewireScripts
        @fluxScripts
    </body>
</html>
