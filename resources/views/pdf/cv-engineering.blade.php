@php
    $experience = $cv->experience ?? [];
    $projects = $cv->projects ?? [];
    $education = $cv->education ?? [];
    $skills = collect($cv->skills ?? [])->groupBy('group');
    $languages = $cv->languages ?? [];
    $hobbies = $cv->hobbies ?? [];
    $contacts = $cv->contacts();
    $portrait = public_path('images/portrait.jpeg');
    $years = fn (?string $date): ?string => $date ? Illuminate\Support\Carbon::parse($date)->format('Y') : null;
    $period = function (?string $start, ?string $end) use ($years): string {
        $from = $years($start);
        $to = $years($end);

        return $from.($to && $to !== $from ? ' - '.$to : ($to ? '' : ' - Present'));
    };
@endphp

<style>
    .engineering { width: 100%; color: #1a1d29; font-family: DejaVu Sans, sans-serif; font-size: 9.5px; line-height: 1.45; }
    .engineering table { border-collapse: collapse; width: 100%; }
    .engineering-header { background: #1f3552; color: #fff; }
    .engineering-header td { padding: 20px 22px; vertical-align: middle; }
    .engineering-avatar { width: 66px; height: 66px; border: 2px solid #ffffff; border-radius: 50%; object-fit: cover; }
    .engineering-name { font-size: 19px; font-weight: bold; line-height: 1.1; }
    .engineering-role { display: inline-block; margin-top: 7px; padding: 3px 8px; border-radius: 12px; background: #fff; color: #1f3552; font-size: 8px; font-weight: bold; }
    .engineering-contacts { width: 190px; font-size: 7.8px; }
    .engineering-contacts div { padding: 2px 0; }
    .engineering-contacts a { color: #fff; text-decoration: none; }
    .engineering-body > tbody > tr > td { vertical-align: top; }
    .engineering-sidebar { width: 145px; padding: 18px 14px; background: #f6f7fa; border-right: 1px solid #d5d9ea; }
    .engineering-main { padding: 19px 22px; }
    .engineering-side-section { margin-bottom: 17px; }
    .engineering-side-title, .engineering-section-title { color: #1f3552; font-weight: bold; text-transform: uppercase; letter-spacing: .6px; }
    .engineering-side-title { margin-bottom: 7px; font-size: 8px; }
    .engineering-side-title:before { content: ''; display: inline-block; width: 5px; height: 5px; margin-right: 4px; border-radius: 50%; background: #e2572b; }
    .engineering-edu { margin-bottom: 9px; padding-left: 7px; border-left: 2px solid #e2572b; }
    .engineering-edu-title { font-size: 8px; font-weight: bold; }
    .engineering-edu-meta { margin-top: 2px; color: #565b6c; font-size: 7px; }
    .engineering-language { padding: 2px 0; }
    .engineering-language b { display: inline-block; width: 64px; }
    .engineering-language span { color: #1f3552; font-size: 7px; font-weight: bold; }
    .engineering-skill-group { margin-bottom: 8px; }
    .engineering-skill-group b { display: block; margin-bottom: 3px; font-size: 7px; text-transform: uppercase; }
    .engineering-tag { display: inline-block; margin: 0 2px 3px 0; padding: 2px 5px; border: 1px solid #d5d9ea; border-radius: 8px; color: #1f3552; background: #fff; font-size: 7px; }
    .engineering-focus { margin: 0; padding-left: 11px; }
    .engineering-focus li { margin-bottom: 3px; font-size: 8px; }
    .engineering-section { margin-bottom: 16px; page-break-inside: avoid; }
    .engineering-section-title { padding-bottom: 4px; border-bottom: 1px solid #d5d9ea; font-size: 10px; }
    .engineering-summary { margin-top: 7px; color: #565b6c; text-align: justify; }
    .engineering-item { margin-top: 10px; page-break-inside: avoid; }
    .engineering-item-title { color: #565b6c; font-size: 10px; font-weight: bold; }
    .engineering-period { float: right; padding: 2px 6px; border-radius: 8px; color: #e2572b; background: #fbe9e2; font-size: 7px; }
    .engineering-subtitle { margin-top: 2px; color: #565b6c; font-size: 8px; }
    .engineering-description { margin: 4px 0 0; color: #565b6c; font-size: 8.5px; }
    .engineering-link { display: block; margin-top: 3px; color: #2c4a70; font-size: 7.5px; }
</style>

<div class="engineering">
    <table class="engineering-header">
        <tr>
            <td style="width: 78px;"><img class="engineering-avatar" src="{{ $portrait }}" alt="Portrait"></td>
            <td>
                <div class="engineering-name">D'ALMEIDA<br>Sena Gedeon O.</div>
                <span class="engineering-role">{{ $cv->headline }}</span>
            </td>
            <td class="engineering-contacts">
                @foreach ($contacts as $value)
                    <div>{{ $value }}</div>
                @endforeach
                @foreach ($cv->links ?? [] as $link)
                    <div><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></div>
                @endforeach
            </td>
        </tr>
    </table>

    <table class="engineering-body">
        <tr>
            <td class="engineering-sidebar">
                @if ($education)
                    <div class="engineering-side-section">
                        <div class="engineering-side-title">Education</div>
                        @foreach ($education as $study)
                            <div class="engineering-edu">
                                <div class="engineering-edu-title">{{ $study['title'] }}</div>
                                <div class="engineering-edu-meta">{{ $study['subtitle'] ?? '' }}@if (($study['period_start'] ?? null) || ($study['period_end'] ?? null)) - {{ $period($study['period_start'] ?? null, $study['period_end'] ?? null) }}@endif</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($languages)
                    <div class="engineering-side-section">
                        <div class="engineering-side-title">Languages</div>
                        @foreach ($languages as $language)
                            <div class="engineering-language"><b>{{ $language['name'] }}</b><span>{{ $language['level'] ?? '' }}</span></div>
                        @endforeach
                    </div>
                @endif

                @if ($skills->isNotEmpty())
                    <div class="engineering-side-section">
                        <div class="engineering-side-title">Skills</div>
                        @foreach ($skills as $group => $groupSkills)
                            <div class="engineering-skill-group">
                                <b>{{ $group ?: 'Technical' }}</b>
                                @foreach ($groupSkills as $skill)
                                    <span class="engineering-tag">{{ $skill['name'] }}</span>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($hobbies)
                    <div class="engineering-side-section">
                        <div class="engineering-side-title">Focus</div>
                        <ul class="engineering-focus">
                            @foreach ($hobbies as $hobby)
                                <li>{{ $hobby['name'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </td>
            <td class="engineering-main">
                @if ($cv->summary)
                    <section class="engineering-section">
                        <div class="engineering-section-title">Professional Summary</div>
                        <p class="engineering-summary">{{ $cv->summary }}</p>
                    </section>
                @endif

                @if ($experience)
                    <section class="engineering-section">
                        <div class="engineering-section-title">Experience</div>
                        @foreach ($experience as $job)
                            <article class="engineering-item">
                                <div class="engineering-item-title">{{ $job['title'] }}@if (($job['period_start'] ?? null) || ($job['period_end'] ?? null)) <span class="engineering-period">{{ $period($job['period_start'] ?? null, $job['period_end'] ?? null) }}</span>@endif</div>
                                @if (! blank($job['subtitle'] ?? null)) <div class="engineering-subtitle">{{ $job['subtitle'] }}</div> @endif
                                @if (! blank($job['description'] ?? null)) <p class="engineering-description">{{ $job['description'] }}</p> @endif
                            </article>
                        @endforeach
                    </section>
                @endif

                @if ($projects)
                    <section class="engineering-section">
                        <div class="engineering-section-title">Selected Projects</div>
                        @foreach ($projects as $project)
                            <article class="engineering-item">
                                <div class="engineering-item-title">{{ $project['title'] }}</div>
                                @if (! blank($project['subtitle'] ?? null)) <div class="engineering-subtitle">{{ $project['subtitle'] }}</div> @endif
                                @if (! blank($project['stack'] ?? null)) <div class="engineering-subtitle"><b>Stack:</b> {{ $project['stack'] }}</div> @endif
                                @if (! blank($project['description'] ?? null)) <p class="engineering-description">{{ $project['description'] }}</p> @endif
                                @if (! blank($project['url'] ?? null)) <div class="engineering-link">{{ $project['url'] }}</div> @endif
                            </article>
                        @endforeach
                    </section>
                @endif
            </td>
        </tr>
    </table>
</div>
