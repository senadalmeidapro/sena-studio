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
    $role = str_contains($cv->headline ?? '', ' - ')
        ? \Illuminate\Support\Str::afterLast($cv->headline, ' - ')
        : ($cv->headline ?: 'Software Engineer');
    $contactIcon = function (string $label): string {
        $label = strtolower($label);

        return match (true) {
            str_contains($label, 'mail') => 'M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z',
            str_contains($label, 'phone'), str_contains($label, 'télé'), str_contains($label, 'tele') => 'M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.3 1L6.6 10.8z',
            str_contains($label, 'local'), str_contains($label, 'location') => 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z',
            str_contains($label, 'github') => 'M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12',
            str_contains($label, 'linkedin') => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.125 2.062 2.062 0 0 1 0 4.125zM7.119 20.452H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
            default => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm1 17.93V18h-2v1.93A8.01 8.01 0 0 1 4.07 13H6v-2H4.07A8.01 8.01 0 0 1 11 4.07V6h2V4.07A8.01 8.01 0 0 1 19.93 11H18v2h1.93A8.01 8.01 0 0 1 13 19.93z',
        };
    };
    $contactHref = function (string $label, string $value): ?string {
        $label = strtolower($label);

        return match (true) {
            str_contains($label, 'mail') => 'mailto:'.$value,
            str_contains($label, 'phone'), str_contains($label, 'télé'), str_contains($label, 'tele') => 'tel:'.preg_replace('/[^+\d]/', '', $value),
            str_contains($label, 'site'), str_contains($label, 'web') => $value,
            default => null,
        };
    };
@endphp

<style>
    .cv-engineering { --cv-ink: #1a1d29; --cv-muted: #565b6c; --cv-soft: #f6f7fa; --cv-line: #d5d9ea; --cv-navy: #1f3552; --cv-navy-2: #2c4a70; --cv-navy-soft: #e9eef4; --cv-coral: #e2572b; --cv-coral-soft: #fbe9e2; width: 210mm; max-width: 100%; color: var(--cv-ink); background: #fff; font-family: Inter, ui-sans-serif, system-ui, sans-serif; font-size: 12.5px; line-height: 1.5; }
    .cv-engineering * { box-sizing: border-box; }
    .cv-engineering a { color: inherit; text-decoration: none; }
    .cv-engineering a:hover { color: var(--cv-coral); }
    .cv-engineering-header { display: flex; align-items: center; gap: 22px; padding: 26px 34px; color: white; background: linear-gradient(135deg, var(--cv-navy), var(--cv-navy-2)); }
    .cv-engineering-mark { display: block; width: 90px; height: 90px; flex: 0 0 auto; border: 2px solid rgba(255,255,255,.35); border-radius: 50%; background: var(--cv-coral); color: white; object-fit: cover; font: 800 22px/1 Manrope, ui-sans-serif, sans-serif; }
    .cv-engineering-headline { min-width: 0; flex: 1; }
    .cv-engineering-name { font: 800 24px/1.15 Manrope, ui-sans-serif, sans-serif; letter-spacing: -.01em; }
    .cv-engineering-role { display: inline-block; margin-top: 8px; padding: 4px 11px; border-radius: 999px; background: white; color: var(--cv-navy); font: 700 11px/1.2 'JetBrains Mono', ui-monospace, monospace; }
    .cv-engineering-contacts { display: grid; grid-template-columns: repeat(2, auto); gap: 6px 22px; flex: 0 0 auto; }
    .cv-engineering-contact { display: flex; gap: 7px; align-items: center; white-space: nowrap; font-size: 10.8px; }
    .cv-engineering-contact-icon { width: 13px; height: 13px; flex: 0 0 auto; color: var(--cv-coral); }
    .cv-engineering-body { display: grid; grid-template-columns: 190px minmax(0, 1fr); }
    .cv-engineering-sidebar { display: flex; flex-direction: column; gap: 24px; padding: 24px 20px 30px; border-right: 1px solid var(--cv-line); background: var(--cv-soft); }
    .cv-engineering-main { display: flex; flex-direction: column; gap: 22px; padding: 26px 30px; }
    .cv-engineering-title { display: flex; gap: 10px; align-items: baseline; margin-bottom: 8px; color: var(--cv-navy); font: 800 13px/1.2 Manrope, ui-sans-serif, sans-serif; letter-spacing: .08em; text-transform: uppercase; }
    .cv-engineering-title::after { height: 1px; flex: 1; background: var(--cv-line); content: ''; }
    .cv-engineering-side-title { display: flex; gap: 6px; align-items: center; margin-bottom: 11px; font: 800 10px/1.2 Manrope, ui-sans-serif, sans-serif; letter-spacing: .09em; text-transform: uppercase; }
    .cv-engineering-side-title::before { width: 7px; height: 7px; border-radius: 50%; background: var(--cv-coral); content: ''; }
    .cv-engineering-summary { color: var(--cv-muted); font-size: 12.3px; line-height: 1.68; text-align: justify; }
    .cv-engineering-list { display: flex; flex-direction: column; gap: 18px; }
    .cv-engineering-item { break-inside: avoid; }
    .cv-engineering-item-top { display: flex; gap: 10px; align-items: baseline; justify-content: space-between; }
    .cv-engineering-item-title { color: var(--cv-muted); font-size: 13px; font-weight: 700; }
    .cv-engineering-period { padding: 2px 8px; border-radius: 999px; background: var(--cv-coral-soft); color: var(--cv-coral); font: 600 9px/1.3 'JetBrains Mono', ui-monospace, monospace; white-space: nowrap; }
    .cv-engineering-subtitle { margin-top: 2px; color: var(--cv-muted); font-size: 11px; }
    .cv-engineering-description-list { display: flex; flex-direction: column; gap: 5px; margin: 6px 0 0; padding: 0; color: var(--cv-muted); font-size: 11.8px; line-height: 1.55; list-style: none; }
    .cv-engineering-description-list li { position: relative; padding-left: 14px; }
    .cv-engineering-description-list li::before { position: absolute; top: 6px; left: 0; width: 5px; height: 5px; border-radius: 50%; background: var(--cv-navy-2); content: ''; }
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
            <span class="cv-engineering-role">{{ $role }}</span>
        </div>
        @if ($contacts || $cv->links)
            <div class="cv-engineering-contacts">
                @foreach ($contacts as $label => $value)
                    @php($href = $contactHref($label, $value))
                    @if ($href)
                        <a class="cv-engineering-contact" href="{{ $href }}" @if (str_starts_with($href, 'http')) target="_blank" rel="noopener noreferrer" @endif>
                            <svg class="cv-engineering-contact-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="{{ $contactIcon($label) }}" /></svg>
                            {{ $value }}
                        </a>
                    @else
                        <span class="cv-engineering-contact">
                            <svg class="cv-engineering-contact-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="{{ $contactIcon($label) }}" /></svg>
                            {{ $value }}
                        </span>
                    @endif
                @endforeach
                @foreach ($cv->links ?? [] as $link)
                    <a class="cv-engineering-contact" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer">
                        <svg class="cv-engineering-contact-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="{{ $contactIcon($link['label']) }}" /></svg>
                        {{ $link['label'] }}
                    </a>
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
                    <div class="cv-engineering-side-title">Soft Skills</div>
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
                                @if (! blank($job['description'] ?? null)) <ul class="cv-engineering-description-list"><li>{{ $job['description'] }}</li></ul> @endif
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
                                @if (! blank($project['description'] ?? null)) <ul class="cv-engineering-description-list"><li>{{ $project['description'] }}</li></ul> @endif
                                @if (! blank($project['url'] ?? null)) <a class="cv-engineering-link" href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">{{ $project['url'] }}</a> @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</div>
