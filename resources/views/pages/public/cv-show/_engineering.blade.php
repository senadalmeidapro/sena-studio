@php
    $experience = $cv->experience ?? [];
    $projects = $cv->projects ?? [];
    $education = $cv->education ?? [];
    $skills = collect($cv->skills ?? [])->groupBy('group');
    $languages = $cv->languages ?? [];
    $hobbies = $cv->hobbies ?? [];
    $contacts = $cv->contacts();
    $years = fn (?string $date): ?string => $date ? \Illuminate\Support\Carbon::parse($date)->format('Y') : null;
    $period = function (?string $start, ?string $end) use ($years): string {
        $from = $years($start);
        $to = $years($end);

        return $from.($to && $to !== $from ? ' - '.$to : ($to ? '' : ' - Present'));
    };
@endphp

<style>
    .cv-engineering { --cv-ink: #1a1d29; --cv-muted: #565b6c; --cv-soft: #f6f7fa; --cv-line: #d5d9ea; --cv-navy: #1f3552; --cv-navy-2: #2c4a70; --cv-navy-soft: #e9eef4; --cv-coral: #e2572b; --cv-coral-soft: #fbe9e2; color: var(--cv-ink); font-family: Inter, ui-sans-serif, system-ui, sans-serif; font-size: 12px; line-height: 1.5; }
    .cv-engineering * { box-sizing: border-box; }
    .cv-engineering a { color: inherit; text-decoration: none; }
    .cv-engineering a:hover { color: var(--cv-coral); }
    .cv-engineering-header { display: flex; align-items: center; gap: 22px; padding: 28px 34px; color: white; background: linear-gradient(135deg, var(--cv-navy), var(--cv-navy-2)); }
    .cv-engineering-mark { display: block; width: 84px; height: 84px; flex: 0 0 auto; border: 2px solid rgba(255,255,255,.35); border-radius: 50%; background: var(--cv-coral); color: white; object-fit: cover; font: 800 22px/1 Manrope, ui-sans-serif, sans-serif; }
    .cv-engineering-headline { min-width: 0; flex: 1; }
    .cv-engineering-name { font: 800 25px/1.12 Manrope, ui-sans-serif, sans-serif; letter-spacing: -.03em; }
    .cv-engineering-role { display: inline-block; margin-top: 9px; padding: 4px 11px; border-radius: 999px; background: white; color: var(--cv-navy); font: 700 10px/1.2 'JetBrains Mono', ui-monospace, monospace; }
    .cv-engineering-contacts { display: grid; grid-template-columns: repeat(2, minmax(0, auto)); gap: 6px 18px; flex: 0 0 auto; }
    .cv-engineering-contact { display: flex; gap: 7px; align-items: center; white-space: nowrap; font-size: 10px; }
    .cv-engineering-contact::before { width: 5px; height: 5px; flex: 0 0 auto; border-radius: 50%; background: var(--cv-coral); content: ''; }
    .cv-engineering-body { display: grid; grid-template-columns: 190px minmax(0, 1fr); }
    .cv-engineering-sidebar { display: flex; flex-direction: column; gap: 24px; padding: 24px 20px 30px; border-right: 1px solid var(--cv-line); background: var(--cv-soft); }
    .cv-engineering-main { display: flex; flex-direction: column; gap: 22px; padding: 26px 30px; }
    .cv-engineering-title { display: flex; gap: 10px; align-items: baseline; margin-bottom: 8px; color: var(--cv-navy); font: 800 13px/1.2 Manrope, ui-sans-serif, sans-serif; letter-spacing: .08em; text-transform: uppercase; }
    .cv-engineering-title::after { height: 1px; flex: 1; background: var(--cv-line); content: ''; }
    .cv-engineering-side-title { display: flex; gap: 6px; align-items: center; margin-bottom: 11px; font: 800 10px/1.2 Manrope, ui-sans-serif, sans-serif; letter-spacing: .09em; text-transform: uppercase; }
    .cv-engineering-side-title::before { width: 7px; height: 7px; border-radius: 50%; background: var(--cv-coral); content: ''; }
    .cv-engineering-summary { color: var(--cv-muted); font-size: 12px; line-height: 1.68; text-align: justify; }
    .cv-engineering-list { display: flex; flex-direction: column; gap: 15px; }
    .cv-engineering-item { break-inside: avoid; }
    .cv-engineering-item-top { display: flex; gap: 10px; align-items: baseline; justify-content: space-between; }
    .cv-engineering-item-title { color: var(--cv-muted); font-size: 13px; font-weight: 700; }
    .cv-engineering-period { padding: 2px 8px; border-radius: 999px; background: var(--cv-coral-soft); color: var(--cv-coral); font: 600 9px/1.3 'JetBrains Mono', ui-monospace, monospace; white-space: nowrap; }
    .cv-engineering-subtitle { margin-top: 2px; color: var(--cv-muted); font-size: 11px; }
    .cv-engineering-description { margin-top: 6px; color: var(--cv-muted); font-size: 11.5px; line-height: 1.55; }
    .cv-engineering-link { display: inline-block; margin-top: 5px; color: var(--cv-navy-2) !important; font: 500 10px/1.3 'JetBrains Mono', ui-monospace, monospace; }
    .cv-engineering-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 7px; }
    .cv-engineering-tag { padding: 3px 8px; border-radius: 999px; background: var(--cv-navy-soft); color: var(--cv-navy); font: 600 9px/1.3 'JetBrains Mono', ui-monospace, monospace; }
    .cv-engineering-edu { padding-left: 10px; border-left: 2px solid var(--cv-coral); }
    .cv-engineering-edu-title { font-size: 11px; font-weight: 600; line-height: 1.35; }
    .cv-engineering-edu-sub { margin-top: 3px; color: var(--cv-muted); font: 9px/1.35 'JetBrains Mono', ui-monospace, monospace; }
    .cv-engineering-skill-groups { display: flex; flex-direction: column; gap: 13px; }
    .cv-engineering-skill-group-title { margin-bottom: 5px; font-size: 9px; font-weight: 700; letter-spacing: .03em; text-transform: uppercase; }
    .cv-engineering-skill-tags { display: flex; flex-wrap: wrap; gap: 5px; }
    .cv-engineering-skill-tags span { padding: 3px 8px; border: 1px solid var(--cv-line); border-radius: 999px; background: white; color: var(--cv-navy); font-size: 9px; font-weight: 500; }
    .cv-engineering-languages { display: flex; flex-direction: column; gap: 6px; }
    .cv-engineering-language { display: flex; justify-content: space-between; gap: 8px; font-size: 10.5px; }
    .cv-engineering-language span:last-child { color: var(--cv-navy); font: 700 9px/1.3 'JetBrains Mono', ui-monospace, monospace; }
    .cv-engineering-soft { display: flex; flex-direction: column; gap: 5px; padding: 0; list-style: none; }
    .cv-engineering-soft li { padding-left: 12px; font-size: 10px; position: relative; }
    .cv-engineering-soft li::before { position: absolute; top: 6px; left: 0; width: 5px; height: 5px; border-radius: 50%; background: var(--cv-coral); content: ''; }
    @media (max-width: 720px) {
        .cv-engineering-header, .cv-engineering-body { display: block; }
        .cv-engineering-header { padding: 24px 20px; }
        .cv-engineering-contacts { grid-template-columns: 1fr; margin-top: 18px; }
        .cv-engineering-sidebar { border-right: 0; border-bottom: 1px solid var(--cv-line); }
        .cv-engineering-main { padding: 24px 20px; }
    }
    @media print { .cv-engineering { font-size: 10px; } .cv-engineering-header { padding: 22px 26px; } .cv-engineering-main { padding: 22px 26px; } }
</style>

<div class="cv-engineering">
    <header class="cv-engineering-header">
        <img class="cv-engineering-mark" src="{{ asset('images/portrait.jpeg') }}" alt="Portrait de D'ALMEIDA Sèna Gédéon" />
        <div class="cv-engineering-headline">
            <div class="cv-engineering-name">D'ALMEIDA<br>Sèna Gédéon O.</div>
            <span class="cv-engineering-role">{{ $cv->headline }}</span>
        </div>
        @if ($contacts || $cv->links)
            <div class="cv-engineering-contacts">
                @foreach ($contacts as $value)
                    <span class="cv-engineering-contact">{{ $value }}</span>
                @endforeach
                @foreach ($cv->links ?? [] as $link)
                    <a class="cv-engineering-contact" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer">{{ $link['label'] }}</a>
                @endforeach
            </div>
        @endif
    </header>

    <div class="cv-engineering-body">
        <aside class="cv-engineering-sidebar">
            @if ($education)
                <section>
                    <div class="cv-engineering-side-title">Education</div>
                    <div class="cv-engineering-list">
                        @foreach ($education as $study)
                            <div class="cv-engineering-edu">
                                <div class="cv-engineering-edu-title">{{ $study['title'] }}</div>
                                <div class="cv-engineering-edu-sub">{{ $study['subtitle'] ?? '' }}@if (($study['period_start'] ?? null) || ($study['period_end'] ?? null)) · {{ $period($study['period_start'] ?? null, $study['period_end'] ?? null) }}@endif</div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($languages)
                <section>
                    <div class="cv-engineering-side-title">Languages</div>
                    <div class="cv-engineering-languages">
                        @foreach ($languages as $language)
                            <div class="cv-engineering-language"><span>{{ $language['name'] }}</span><span>{{ $language['level'] ?? '' }}</span></div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($skills->isNotEmpty())
                <section>
                    <div class="cv-engineering-side-title">Skills</div>
                    <div class="cv-engineering-skill-groups">
                        @foreach ($skills as $group => $groupSkills)
                            <div>
                                <div class="cv-engineering-skill-group-title">{{ $group ?: 'Technical' }}</div>
                                <div class="cv-engineering-skill-tags">
                                    @foreach ($groupSkills as $skill)
                                        <span>{{ $skill['name'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($hobbies)
                <section>
                    <div class="cv-engineering-side-title">Focus</div>
                    <ul class="cv-engineering-soft">
                        @foreach ($hobbies as $hobby)
                            <li>{{ $hobby['name'] }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>

        <main class="cv-engineering-main">
            @if ($cv->summary)
                <section>
                    <div class="cv-engineering-title">Professional Summary</div>
                    <p class="cv-engineering-summary">{{ $cv->summary }}</p>
                </section>
            @endif

            @if ($experience)
                <section>
                    <div class="cv-engineering-title">Experience</div>
                    <div class="cv-engineering-list">
                        @foreach ($experience as $job)
                            <article class="cv-engineering-item">
                                <div class="cv-engineering-item-top">
                                    <div class="cv-engineering-item-title">{{ $job['title'] }}</div>
                                    @if (($job['period_start'] ?? null) || ($job['period_end'] ?? null))
                                        <span class="cv-engineering-period">{{ $period($job['period_start'] ?? null, $job['period_end'] ?? null) }}</span>
                                    @endif
                                </div>
                                @if (! blank($job['subtitle'] ?? null)) <div class="cv-engineering-subtitle">{{ $job['subtitle'] }}</div> @endif
                                @if (! blank($job['description'] ?? null)) <p class="cv-engineering-description">{{ $job['description'] }}</p> @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($projects)
                <section>
                    <div class="cv-engineering-title">Selected Projects</div>
                    <div class="cv-engineering-list">
                        @foreach ($projects as $project)
                            <article class="cv-engineering-item">
                                <div class="cv-engineering-item-title">{{ $project['title'] }}</div>
                                @if (! blank($project['subtitle'] ?? null)) <div class="cv-engineering-subtitle">{{ $project['subtitle'] }}</div> @endif
                                @if (! blank($project['stack'] ?? null)) <div class="cv-engineering-tags"><span class="cv-engineering-tag">{{ $project['stack'] }}</span></div> @endif
                                @if (! blank($project['description'] ?? null)) <p class="cv-engineering-description">{{ $project['description'] }}</p> @endif
                                @if (! blank($project['url'] ?? null)) <a class="cv-engineering-link" href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">{{ $project['url'] }}</a> @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</div>
