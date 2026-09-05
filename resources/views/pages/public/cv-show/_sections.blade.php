@php
    $compact = $compact ?? false;
    $skipAside = $skipAside ?? false;
    $years = fn (?string $date): ?string => $date ? \Illuminate\Support\Carbon::parse($date)->format('Y') : null;
    $period = function (?string $start, ?string $end) use ($years): string {
        $from = $years($start);
        $to = $years($end);
        return $from.($to && $to !== $from ? ' – '.$to : ($to ? '' : ' – Aujourd’hui'));
    };
@endphp

@if ($experience)
    <section>
        <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Expérience</h2>
        <div class="{{ $compact ? 'mt-4 space-y-4' : 'mt-4 space-y-6' }}">
            @foreach ($experience as $job)
                <div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                        <h3 class="font-semibold text-ink-900 dark:text-ink-50">{{ $job['title'] }}</h3>
                        @if (($job['period_start'] ?? null) || ($job['period_end'] ?? null))
                            <span class="text-xs font-medium text-ink-400">{{ $period($job['period_start'] ?? null, $job['period_end'] ?? null) }}</span>
                        @endif
                    </div>
                    @if (! blank($job['subtitle'] ?? null))
                        <p class="text-sm text-[var(--accent)]">{{ $job['subtitle'] }}</p>
                    @endif
                    @if (! blank($job['description'] ?? null))
                        <p class="mt-2 text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ $job['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endif

@if ($education)
    <section>
        <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Formation</h2>
        <div class="{{ $compact ? 'mt-4 space-y-4' : 'mt-4 space-y-6' }}">
            @foreach ($education as $study)
                <div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                        <h3 class="font-semibold text-ink-900 dark:text-ink-50">{{ $study['title'] }}</h3>
                        @if (($study['period_start'] ?? null) || ($study['period_end'] ?? null))
                            <span class="text-xs font-medium text-ink-400">{{ $period($study['period_start'] ?? null, $study['period_end'] ?? null) }}</span>
                        @endif
                    </div>
                    @if (! blank($study['subtitle'] ?? null))
                        <p class="text-sm text-ink-500 dark:text-ink-400">{{ $study['subtitle'] }}</p>
                    @endif
                    @if (! blank($study['description'] ?? null))
                        <p class="mt-2 text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ $study['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endif

@if (! $skipAside && $skills)
    <section>
        <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Compétences</h2>
        <div class="mt-4 grid gap-x-8 gap-y-3 sm:grid-cols-2">
            @foreach ($skills as $skill)
                <div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-ink-800 dark:text-ink-100">{{ $skill['name'] }}</span>
                        @isset($skill['level'])
                            <span class="text-xs text-ink-400">{{ $skill['level'] }}</span>
                        @endisset
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

@if (! $skipAside && $languages)
    <section>
        <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Langues</h2>
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach ($languages as $language)
                <span class="rounded-md bg-ink-100 px-2 py-1 text-sm text-ink-700 dark:bg-ink-800 dark:text-ink-200">
                    {{ $language['name'] }}<span class="text-xs text-ink-400"> · {{ $language['level'] ?? '' }}</span>
                </span>
            @endforeach
        </div>
    </section>
@endif

@if ($certifications)
    <section>
        <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Certifications</h2>
        <div class="mt-4 space-y-3">
            @foreach ($certifications as $certification)
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="font-medium text-ink-800 dark:text-ink-100">{{ $certification['title'] }}</span>
                    @if (! blank($certification['subtitle'] ?? null))
                        <span class="text-sm text-ink-500 dark:text-ink-400">— {{ $certification['subtitle'] }}</span>
                    @endif
                    @if (! blank($certification['year'] ?? null))
                        <span class="rounded bg-[var(--accent)] px-1.5 py-0.5 text-xs font-semibold text-white">{{ $certification['year'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endif

@if (! $skipAside && $hobbies)
    <section>
        <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--accent)]">Centres d’intérêt</h2>
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach ($hobbies as $hobby)
                <span class="rounded-full border border-ink-300 px-3 py-1 text-sm text-ink-600 dark:border-ink-700 dark:text-ink-300">
                    {{ $hobby['name'] }}
                </span>
            @endforeach
        </div>
    </section>
@endif