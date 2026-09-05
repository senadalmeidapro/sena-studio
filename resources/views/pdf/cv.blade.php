<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>CV — {{ $cv->headline }}</title>
    <style>
        :root { --accent: {{ $cv->accentStyle() }}; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1c1917;
            font-size: 10.5px;
            line-height: 1.55;
        }
        .page { width: 100%; padding: 28px 34px; }
        .topbar { height: 6px; background: var(--accent); }

        h1 { font-size: 21px; letter-spacing: -0.3px; margin-bottom: 1px; }
        .role { color: var(--accent); font-size: 11.5px; font-weight: bold; letter-spacing: 0.6px; text-transform: uppercase; }
        .summary { margin-top: 8px; font-size: 10.5px; color: #44403c; }

        .contact { margin-top: 8px; border-top: 1px solid #e7e5e4; border-bottom: 1px solid #e7e5e4; padding: 6px 0; font-size: 9px; color: #57534e; }
        .contact span { margin-right: 12px; }
        .contact a { color: var(--accent); text-decoration: none; }

        section { margin-top: 18px; }
        h2 {
            font-size: 11px; letter-spacing: 1.2px; text-transform: uppercase;
            color: var(--accent); font-weight: bold;
            border-bottom: 1.5px solid #e7e5e4; padding-bottom: 3px; margin-bottom: 8px;
        }

        .item { margin-bottom: 9px; page-break-inside: avoid; }
        .item h3 { font-size: 11px; color: #292524; display: inline; }
        .item .sub { color: var(--accent); font-weight: bold; }
        .item .dates { float: right; font-size: 9px; color: #78716c; font-weight: normal; }
        .item p { margin-top: 2px; color: #44403c; }

        .skills-grid { width: 100%; }
        .skills-grid td { padding: 3px 0; vertical-align: top; width: 50%; }
        .skill-bar { display: inline-block; width: 90px; height: 5px; background: #e7e5e4; margin-left: 6px; vertical-align: middle; border-radius: 3px; }
        .skill-bar i { display: inline-block; height: 5px; background: var(--accent); border-radius: 3px; }

        .chips { margin-top: 4px; }
        .chip { display: inline-block; border: 1px solid #e7e5e4; border-radius: 20px; padding: 2px 9px; margin: 0 4px 4px 0; font-size: 9px; color: #44403c; }
        .lang td { padding: 2px 0; }
        .cert td { padding: 2px 0; font-size: 10px; }
        .cert .year { float: right; }
    </style>
</head>
<body>
    <div class="topbar"></div>
    <div class="page">
        <h1>{{ $cv->headline }}</h1>
        @if ($cv->version_label)
            <div class="role">{{ $cv->version_label }}</div>
        @endif

        @if ($cv->summary)
            <p class="summary">{{ $cv->summary }}</p>
        @endif

        @php
            $contacts = $cv->contacts();
            $links = $cv->links ?? [];
            $years = function (?string $date): ?string { return $date ? Illuminate\Support\Carbon::parse($date)->format('Y') : null; };
            $period = function (?string $start, ?string $end) use ($years): string {
                $from = $years($start);
                $to = $years($end);
                return $from.($to && $to !== $from ? ' – '.$to : ($to ? '' : ' – Aujourd’hui'));
            };
        @endphp

        @if ($contacts || $links)
            <div class="contact">
                @foreach ($contacts as $label => $value)
                    <span><b>{{ $label }} :</b> {{ $value }}</span>
                @endforeach
                @foreach ($links as $link)
                    <span><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></span>
                @endforeach
            </div>
        @endif

        @if ($cv->experience)
            <section>
                <h2>Expérience</h2>
                @foreach ($cv->experience as $job)
                    <div class="item">
                        @if (($job['period_start'] ?? null) || ($job['period_end'] ?? null))
                            <span class="dates">{{ $period($job['period_start'] ?? null, $job['period_end'] ?? null) }}</span>
                        @endif
                        <h3>{{ $job['title'] }}</h3>
                        @if (! blank($job['subtitle'] ?? null))
                            <span class="sub"> — {{ $job['subtitle'] }}</span>
                        @endif
                        @if (! blank($job['description'] ?? null))
                            <p>{{ $job['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($cv->education)
            <section>
                <h2>Formation</h2>
                @foreach ($cv->education as $study)
                    <div class="item">
                        @if (($study['period_start'] ?? null) || ($study['period_end'] ?? null))
                            <span class="dates">{{ $period($study['period_start'] ?? null, $study['period_end'] ?? null) }}</span>
                        @endif
                        <h3>{{ $study['title'] }}</h3>
                        @if (! blank($study['subtitle'] ?? null))
                            <span class="sub"> — {{ $study['subtitle'] }}</span>
                        @endif
                        @if (! blank($study['description'] ?? null))
                            <p>{{ $study['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($cv->skills)
            <section>
                <h2>Compétences</h2>
                <table class="skills-grid">
                    @foreach (array_chunk($cv->skills, 2) as $row)
                        <tr>
                            @foreach (array_pad($row, 2, null) as $skill)
                                <td>
                                    @if ($skill)
                                        {{ $skill['name'] }}
                                        @isset($skill['level'])
                                            <span class="skill-bar">
                                                <i style="width: {{ match ($skill['level']) {
                                                    'expert' => '100%', 'avance' => '75%', 'intermediaire' => '50%', default => '30%',
                                                } }}"></i>
                                            </span>
                                            <span style="font-size:8px;color:#78716c">{{ $skill['level'] }}</span>
                                        @endisset
                                        @isset($skill['experience'])
                                            <span style="font-size:8px;color:#78716c;margin-left:4px">{{ $skill['experience'] }}</span>
                                        @endisset
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </section>
        @endif

        @if ($cv->languages)
            <section>
                <h2>Langues</h2>
                <table class="lang">
                    @foreach ($cv->languages as $language)
                        <tr>
                            <td style="font-weight:bold">{{ $language['name'] }}</td>
                            <td>{{ $language['level'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </section>
        @endif

        @if ($cv->certifications)
            <section>
                <h2>Certifications</h2>
                <table class="cert">
                    @foreach ($cv->certifications as $certification)
                        <tr>
                            <td>
                                <b>{{ $certification['title'] }}</b>
                                @if (! blank($certification['subtitle'] ?? null))
                                    — {{ $certification['subtitle'] }}
                                @endif
                            </td>
                            @if (! blank($certification['year'] ?? null))
                                <td class="year"><b>{{ $certification['year'] }}</b></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </section>
        @endif

        @if ($cv->hobbies)
            <section>
                <h2>Centres d’intérêt</h2>
                <div class="chips">
                    @foreach ($cv->hobbies as $hobby)
                        <span class="chip">{{ $hobby['name'] }}</span>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</body>
</html>