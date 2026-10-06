<div class="public-page about-page">

    {{-- En-tête --}}
    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('about.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('about.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            {{ __('about.subtitle') }}
        </p>
    </header>

    <div class="about-opening">
        <figure class="about-portrait">
            <img src="{{ asset('images/portrait1.png') }}" alt="{{ __('home.portrait_alt') }}" loading="lazy" decoding="async" />
            <figcaption class="home-portrait-caption">
                <strong>D’ALMEIDA Sèna Gédéon</strong>
                <span>{{ __('home.stats_location') }}</span>
            </figcaption>
        </figure>

        <div class="about-opening-copy">
            <blockquote>{{ __('about.quote') }}</blockquote>
            <h2>{{ __('about.narrative_h2') }}</h2>
            <p>
                {{ __('about.narrative_p1') }}
            </p>
            <p>
                {{ __('about.narrative_p2') }}
            </p>
            <h2>{{ __('about.work_h2') }}</h2>
            <ul>
                <li>{!! __('about.work_1') !!}</li>
                <li>{{ __('about.work_2') }}</li>
                <li>{{ __('about.work_3') }}</li>
                <li>{{ __('about.work_4') }}</li>
            </ul>
        </div>
    </div>

    <aside class="about-stats-strip">
        <p class="studio-kicker">{{ __('about.stats_eyebrow') }}</p>
        <dl>
            @foreach ([
                ['value' => $this->stats['projects'], 'label' => __('about.stats_projects')],
                ['value' => $this->stats['skills'], 'label' => __('about.stats_skills')],
                ['value' => $this->stats['testimonials'], 'label' => __('about.stats_reviews')],
            ] as $stat)
                <div><dd>{{ $stat['value'] }}</dd><dt>{{ $stat['label'] }}</dt></div>
            @endforeach
        </dl>
        <div class="about-availability-note">
            <span class="studio-kicker">{{ __('about.availability_eyebrow') }}</span>
            <p>{{ __('about.availability_text') }}</p>
            <a href="{{ localized_route('contact') }}" wire:navigate class="studio-button">{{ __('common.start_project') }} ↗</a>
        </div>
    </aside>

    {{-- Principes d'ingénierie --}}
    @if ($this->proofProjects->isNotEmpty())
        <section class="about-section about-proof">
            <div class="grid gap-7 lg:grid-cols-[0.75fr_1.25fr] lg:items-start">
                <div>
                    <p class="eyebrow">{{ __('about.proof_eyebrow') }}</p>
                    <h2 class="mt-3 font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('about.proof_title') }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ __('about.proof_text') }}</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($this->proofProjects as $proof)
                        <a href="{{ localized_route('projects.show', $proof->slug) }}" wire:navigate class="group rounded-2xl border border-ink-200 bg-card/80 p-5 transition-all hover:-translate-y-0.5 hover:border-blue-400/70 hover:shadow-card dark:border-ink-700 dark:bg-elevated/70">
                            <span class="font-mono text-[0.65rem] uppercase tracking-[0.12em] text-blue-700 dark:text-blue-300">{{ $proof->role ?: $proof->type->label() }}</span>
                            <h3 class="mt-2 font-display text-lg font-semibold text-ink-900 transition-colors group-hover:text-blue-700 dark:text-ink-50 dark:group-hover:text-blue-300">{{ $proof->name }}</h3>
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ $proof->problem }}</p>
{{--                            @if ($proof->result)--}}
{{--                                <p class="mt-4 border-t border-ink-200 pt-3 text-sm leading-relaxed text-ink-600 dark:border-ink-700 dark:text-ink-300">{{ $proof->result }}</p>--}}
{{--                            @endif--}}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="about-section about-principles">
        <div class="max-w-2xl">
            <p class="eyebrow">{{ __('about.principles_eyebrow') }}</p>
            <h2 class="mt-4 font-display text-3xl font-bold tracking-[-0.035em] text-ink-900 dark:text-ink-50 sm:text-4xl">
                {{ __('about.principles_title') }}
            </h2>
        </div>

        <ol class="mt-8 grid gap-px overflow-hidden rounded-xl border border-ink-300 bg-ink-300/80 sm:grid-cols-2 dark:border-ink-700 dark:bg-ink-700/60">
            @foreach (range(1, 4) as $number)
                <li class="bg-card p-6 transition-colors hover:bg-blue-50/60 dark:hover:bg-blue-950/20">
                    <span class="block size-2 rounded-full bg-blue-500"></span>
                    <h3 class="mt-5 font-display text-lg font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('about.principle_'.$number) }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ __('about.principle_'.$number.'_text') }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Témoignages --}}
    @if ($this->testimonials->isNotEmpty())
        <section class="about-section about-testimonials">
            <div>
                <h2 class="eyebrow">{{ __('about.testimonials_eyebrow') }}</h2>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach ($this->testimonials as $testimonial)
                    <figure class="flex flex-col rounded-2xl border border-ink-300 bg-card p-6 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-card dark:border-ink-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-blue-600 dark:text-blue-400">
                            <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 3.01 1.693 5.192 4.554 6.15.163 1.363.947 2.353 2.081 2.904Z" clip-rule="evenodd" />
                        </svg>
                        <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-ink-600 dark:text-ink-300">
                            {{ $testimonial->content }}
                        </blockquote>
                        <figcaption class="mt-5 flex items-center gap-3 border-t border-ink-200 pt-4 dark:border-ink-700/70">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-blue-600 font-display text-sm font-semibold text-white dark:bg-blue-500 dark:text-blue-950">
                                {{ mb_substr($testimonial->name, 0, 1) }}
                            </span>
                            <span>
                                <span class="block text-sm font-medium text-ink-900 dark:text-ink-50">{{ $testimonial->name }}</span>
                                <span class="block font-mono text-[0.66rem] uppercase tracking-[0.1em] text-ink-500 dark:text-ink-400">
                                    {{ collect([$testimonial->role, $testimonial->company])->filter()->implode(' · ') }}
                                </span>
                            </span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif
</div>
