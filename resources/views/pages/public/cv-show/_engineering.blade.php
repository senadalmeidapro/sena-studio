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

<article class="cv-engineering" aria-labelledby="cv-name">
    <header class="cv-profile">
        <img
            class="cv-profile-portrait"
            src="{{ asset('images/portrait.jpeg') }}"
            alt="Portrait de D'ALMEIDA Sèna Gédéon"
        />

        <div class="cv-profile-heading">
            <p class="cv-profile-context">Curriculum vitae</p>
            <h1 class="cv-profile-name" id="cv-name">D'ALMEIDA Sèna Gédéon O.</h1>
            <p class="cv-profile-role">{{ $cv->headline }}</p>
        </div>

        @if ($contacts || $cv->links)
            <address class="cv-profile-contacts" aria-label="Contact information">
                @foreach ($contacts as $value)
                    <span class="cv-contact">{{ $value }}</span>
                @endforeach
                @foreach ($cv->links ?? [] as $link)
                    <a class="cv-contact" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer">{{ $link['label'] }}</a>
                @endforeach
            </address>
        @endif
    </header>

    <div class="cv-layout">
        <aside class="cv-sidebar" aria-label="Education and skills">
            @if ($education)
                <section class="cv-side-section" aria-labelledby="cv-education-title">
                    <h2 class="cv-side-title" id="cv-education-title">Education</h2>
                    <div class="cv-education-list">
                        @foreach ($education as $study)
                            <article class="cv-education-item">
                                <h3 class="cv-education-name">{{ $study['title'] }}</h3>
                                @if (filled($study['subtitle'] ?? null))
                                    <p class="cv-education-school">{{ $study['subtitle'] }}</p>
                                @endif
                                @if (($study['period_start'] ?? null) || ($study['period_end'] ?? null))
                                    <p class="cv-metadata">{{ $period($study['period_start'] ?? null, $study['period_end'] ?? null) }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($languages)
                <section class="cv-side-section" aria-labelledby="cv-languages-title">
                    <h2 class="cv-side-title" id="cv-languages-title">Languages</h2>
                    <ul class="cv-language-list">
                        @foreach ($languages as $language)
                            <li class="cv-language-item">
                                <span>{{ $language['name'] }}</span>
                                <span class="cv-language-level">{{ $language['level'] ?? '' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if ($skills->isNotEmpty())
                <section class="cv-side-section" aria-labelledby="cv-skills-title">
                    <h2 class="cv-side-title" id="cv-skills-title">Skills</h2>
                    <div class="cv-skill-groups">
                        @foreach ($skills as $group => $groupSkills)
                            <div class="cv-skill-group">
                                <h3 class="cv-skill-group-title">{{ $group ?: 'Technical' }}</h3>
                                <ul class="cv-skill-list">
                                    @foreach ($groupSkills as $skill)
                                        <li>{{ $skill['name'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($hobbies)
                <section class="cv-side-section" aria-labelledby="cv-focus-title">
                    <h2 class="cv-side-title" id="cv-focus-title">Focus</h2>
                    <ul class="cv-focus-list">
                        @foreach ($hobbies as $hobby)
                            <li>{{ $hobby['name'] }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>

        <main class="cv-main">
            @if ($cv->summary)
                <section class="cv-main-section" aria-labelledby="cv-summary-title">
                    <h2 class="cv-section-title" id="cv-summary-title">Professional Summary</h2>
                    <p class="cv-summary">{{ $cv->summary }}</p>
                </section>
            @endif

            @if ($experience)
                <section class="cv-main-section" aria-labelledby="cv-experience-title">
                    <h2 class="cv-section-title" id="cv-experience-title">Experience</h2>
                    <div class="cv-timeline">
                        @foreach ($experience as $job)
                            <article class="cv-timeline-entry">
                                <div class="cv-entry-heading">
                                    <h3 class="cv-entry-title">{{ $job['title'] }}</h3>
                                    @if (($job['period_start'] ?? null) || ($job['period_end'] ?? null))
                                        <span class="cv-metadata">{{ $period($job['period_start'] ?? null, $job['period_end'] ?? null) }}</span>
                                    @endif
                                </div>
                                @if (! blank($job['subtitle'] ?? null))
                                    <p class="cv-entry-subtitle">{{ $job['subtitle'] }}</p>
                                @endif
                                @if (! blank($job['description'] ?? null))
                                    <p class="cv-entry-description">{{ $job['description'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($projects)
                <section class="cv-main-section" aria-labelledby="cv-projects-title">
                    <h2 class="cv-section-title" id="cv-projects-title">Selected Projects</h2>
                    <div class="cv-project-list">
                        @foreach ($projects as $project)
                            <article class="cv-project-entry">
                                <h3 class="cv-entry-title">{{ $project['title'] }}</h3>
                                @if (! blank($project['subtitle'] ?? null))
                                    <p class="cv-entry-subtitle">{{ $project['subtitle'] }}</p>
                                @endif
                                @if (! blank($project['stack'] ?? null))
                                    <p class="cv-project-stack">{{ $project['stack'] }}</p>
                                @endif
                                @if (! blank($project['description'] ?? null))
                                    <p class="cv-entry-description">{{ $project['description'] }}</p>
                                @endif
                                @if (! blank($project['url'] ?? null))
                                    <a class="cv-project-link" href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">{{ $project['url'] }}</a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</article>
