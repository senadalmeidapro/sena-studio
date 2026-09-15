<div>
    <div class="mb-8 flex items-end justify-between gap-4">
        <div><p class="font-mono text-xs uppercase tracking-[0.2em] text-blue-400">Backoffice</p><h1 class="mt-2 text-3xl font-semibold tracking-tight text-white">Tableau de bord</h1></div>
        <a href="{{ route('backoffice.projects.create') }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500">Nouveau projet</a>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $label => $value)
            <div class="rounded-xl border border-slate-800 bg-slate-900 p-5"><p class="text-sm text-slate-400">{{ ucfirst($label) }}</p><p class="mt-3 text-3xl font-semibold text-white">{{ $value }}</p></div>
        @endforeach
    </div>
    <section class="mt-8 rounded-xl border border-slate-800 bg-slate-900">
        <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4"><h2 class="font-semibold text-white">Projets récents</h2><a href="{{ route('backoffice.projects.index') }}" class="text-sm text-blue-400 hover:text-blue-300">Voir tous</a></div>
        <div class="divide-y divide-slate-800">
            @forelse ($recentProjects as $project)
                <a href="{{ route('backoffice.projects.edit', $project) }}" class="flex items-center justify-between gap-4 px-5 py-4 transition hover:bg-slate-800/60"><span class="font-medium text-slate-200">{{ $project->name }}</span><span class="font-mono text-xs text-slate-500">{{ $project->status?->label() }}</span></a>
            @empty
                <p class="px-5 py-8 text-sm text-slate-400">Aucun projet.</p>
            @endforelse
        </div>
    </section>
</div>
