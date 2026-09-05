<div class="mx-auto max-w-4xl px-4 pb-24 pt-10 sm:px-6 lg:px-8">
    <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-ink-500 transition-colors hover:text-emerald-600 dark:text-ink-400 dark:hover:text-emerald-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5m5.25 15L8.25 12l7.5-7.5" />
        </svg>
        Retour au site
    </a>

    @if (! $cv->isPublished())
        <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-4 py-1.5 text-xs font-medium text-amber-800 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-amber-300">
            <span class="relative flex size-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex size-2 rounded-full bg-amber-500"></span>
            </span>
            Brouillon — aperçu, publiéz cette version depuis l’admin
        </div>
    @endif

    @php
        $accent = $cv->accentStyle();
        $experience = $cv->experience ?? [];
        $education = $cv->education ?? [];
        $skills = $cv->skills ?? [];
        $languages = $cv->languages ?? [];
        $certifications = $cv->certifications ?? [];
        $hobbies = $cv->hobbies ?? [];
        $contacts = $cv->contacts();
        $years = fn (?string $date): ?string => $date ? \Illuminate\Support\Carbon::parse($date)->format('Y') : null;
    @endphp

    <article
        style="--accent: {{ $accent }};"
        class="mt-8 overflow-hidden rounded-3xl border border-ink-200 bg-white shadow-xl shadow-ink-900/5 dark:border-ink-800 dark:bg-ink-950"
    >
        @if ($cv->template->value === 'moderne')
            {{-- Modern : bandeau accent + double colonne --}}
            <div class="bg-[var(--accent)] px-8 py-8 sm:px-10">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/80">{{ $cv->version_label ?? $cv->title }}</p>
                        <h1 class="mt-1 text-3xl font-bold text-white sm:text-4xl">{{ $cv->headline }}</h1>
                        @if ($cv->summary)
                            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/90">{{ $cv->summary }}</p>
                        @endif
                    </div>
                    @if (! empty($contacts))
                        <div class="grid gap-1">
                            @foreach ($contacts as $label => $value)
                                <span class="text-xs font-medium text-white/90">
                                    <span class="inline-block w-24 text-white/70">{{ $label }}</span>{{ $value }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if ($cv->links)
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($cv->links as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                               class="rounded-full bg-white/15 px-3 py-1 text-xs font-medium text-white transition-colors hover:bg-white/25">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="grid gap-8 px-8 py-8 sm:grid-cols-[1fr_2.2fr] sm:px-10">
                <aside class="space-y-6">
                    @if ($skills)
                        <section>
                            <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Compétences</h2>
                            <div class="mt-3 space-y-2.5">
                                @foreach ($skills as $skill)
                                    <div>
                                        <div class="flex items-center justify-between text-sm text-ink-800 dark:text-ink-100">
                                            <span class="font-medium">{{ $skill['name'] }}</span>
                                            @isset($skill['experience'])
                                                <span class="text-xs text-ink-400">{{ $skill['experience'] }}</span>
                                            @endisset
                                        </div>
                                        @isset($skill['level'])
                                            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-ink-100 dark:bg-ink-800">
                                                <div class="h-full rounded-full bg-[var(--accent)]" style="width: {{ match ($skill['level']) {
                                                    'expert' => '100%', 'avance' => '75%', 'intermediaire' => '50%', default => '30%',
                                                } }}"></div>
                                            </div>
                                        @endisset
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($languages)
                        <section>
                            <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Langues</h2>
                            <ul class="mt-3 space-y-1.5 text-sm text-ink-700 dark:text-ink-200">
                                @foreach ($languages as $language)
                                    <li class="flex justify-between gap-3">
                                        <span class="font-medium">{{ $language['name'] }}</span>
                                        <span class="text-xs text-ink-400">{{ $language['level'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    @if ($hobbies)
                        <section>
                            <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Centres d’intérêt</h2>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($hobbies as $hobby)
                                    <span class="rounded-md bg-ink-100 px-2 py-1 text-xs text-ink-600 dark:bg-ink-800 dark:text-ink-300">{{ $hobby['name'] }}</span>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </aside>

                <div class="space-y-8">
                    @include('pages.public.cv-show._sections', ['compact' => false, 'skipAside' => true])
                </div>
            </div>
        @elseif ($cv->template->value === 'minimal')
            {{-- Minimal : typographie, filets fins, contrastes --}}
            <div class="px-8 py-8 sm:px-10">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-ink-200 pb-6 dark:border-ink-800">
                    <div>
                        <h1 class="text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ $cv->headline }}</h1>
                        @if ($cv->version_label)
                            <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ $cv->version_label }}</p>
                        @endif
                        @if ($cv->summary)
                            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ $cv->summary }}</p>
                        @endif
                    </div>
                    @if (! empty($contacts))
                        <div class="text-right text-xs leading-relaxed text-ink-500 dark:text-ink-400">
                            @foreach ($contacts as $value)
                                <div>{{ $value }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if ($cv->links)
                    <div class="flex flex-wrap gap-4 border-b border-ink-200 py-4 text-sm dark:border-ink-800">
                        @foreach ($cv->links as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                               class="font-medium text-[var(--accent)] underline-offset-4 hover:underline">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 space-y-6">
                    @include('pages.public.cv-show._sections', ['compact' => true])
                </div>
            </div>
        @else
            {{-- Classique : en-tête centré + sections aérées --}}
            <div class="px-8 py-8 text-center sm:px-10">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[var(--accent)]">{{ $cv->version_label ?? $cv->title }}</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">{{ $cv->headline }}</h1>

                <div class="mx-auto mt-4 flex max-w-2xl flex-wrap items-center justify-center gap-x-4 gap-y-1 text-sm text-ink-500 dark:text-ink-400">
                    @foreach ($contacts as $label => $value)
                        <span>{{ $value }}</span>
                    @endforeach
                    @if ($cv->links)
                        @foreach ($cv->links as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="text-[var(--accent)] underline-offset-4 hover:underline">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    @endif
                </div>

                @if ($cv->summary)
                    <p class="mx-auto mt-6 max-w-2xl text-balance text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ $cv->summary }}</p>
                @endif
            </div>

            <div class="border-t border-ink-200 px-8 py-8 sm:px-10 dark:border-ink-800">
                <div class="space-y-8">
                    @include('pages.public.cv-show._sections', ['compact' => false])
                </div>
            </div>
        @endif
    </article>
</div>