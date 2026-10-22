<div class="public-page about-page mx-auto">
    <header class="about-hero">
        <div class="about-hero-copy">
            <span class="eyebrow">{{ __('about.eyebrow') }}</span>
            <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('about.title') }}</h1>
            <p class="about-hero-summary text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('about.subtitle') }}</p>
        </div>

        <figure class="about-portrait">
            <div class="about-portrait-art" aria-hidden="true">
                <svg viewBox="0 0 420 520" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M377 12C319 79 283 126 254 195C218 281 180 334 111 399C78 431 50 464 28 508" />
                    <path d="M413 52C352 116 317 165 288 232C250 318 209 370 139 435" />
                    <circle cx="255" cy="194" r="5" />
                    <circle cx="110" cy="400" r="3" />
                </svg>
            </div>
            <img src="{{ asset('images/portrait1.jpeg') }}" alt="{{ __('about.portrait_alt') }}" loading="eager" fetchpriority="high">
            <figcaption>
                <span>{{ config('app.name') }}</span>
                <span>{{ __('about.portrait_caption') }}</span>
            </figcaption>
        </figure>
    </header>

    <dl class="about-statline" aria-label="{{ __('about.stats_eyebrow') }}">
        @foreach ([
            ['value' => $this->stats['projects'], 'label' => __('about.stats_projects')],
            ['value' => $this->stats['skills'], 'label' => __('about.stats_skills')],
            ['value' => $this->stats['testimonials'], 'label' => __('about.stats_reviews')],
        ] as $stat)
            <div>
                <dt>{{ $stat['label'] }}</dt>
                <dd>{{ $stat['value'] }}</dd>
            </div>
        @endforeach
    </dl>

    <div class="about-story-grid">
        <article class="about-story prose-blog">
            <h2>{{ __('about.narrative_h2') }}</h2>
            <p>{{ __('about.narrative_p1') }}</p>
            <p>{{ __('about.narrative_p2') }}</p>
        </article>

        <aside class="about-work">
            <h2>{{ __('about.work_h2') }}</h2>
            <ul>
                <li>{!! __('about.work_1') !!}</li>
                <li>{{ __('about.work_2') }}</li>
                <li>{{ __('about.work_3') }}</li>
                <li>{{ __('about.work_4') }}</li>
            </ul>
            <blockquote>{{ __('about.quote') }}</blockquote>
        </aside>
    </div>

    <aside class="about-availability">
        <div>
            <p class="eyebrow">{{ __('about.availability_eyebrow') }}</p>
            <p class="about-availability-text">{{ __('about.availability_text') }}</p>
        </div>
        <x-front.arrow-link :href="localized_route('contact')" wire:navigate>
            {{ __('common.start_project') }}
        </x-front.arrow-link>
    </aside>

    @if ($this->proofProjects->isNotEmpty())
        <section class="about-proof" aria-labelledby="about-proof-title">
            <header class="about-section-heading">
                <div>
                    <p class="eyebrow">{{ __('about.proof_eyebrow') }}</p>
                    <h2 id="about-proof-title">{{ __('about.proof_title') }}</h2>
                </div>
                <p>{{ __('about.proof_text') }}</p>
            </header>

            <div class="about-proof-list">
                @foreach ($this->proofProjects as $proof)
                    <a href="{{ localized_route('projects.show', $proof->slug) }}" wire:navigate>
                        <span class="about-proof-role">{{ $proof->role ?: $proof->type->label() }}</span>
                        <h3>{{ $proof->name }}</h3>
                        <p>{{ $proof->problem }}</p>
                        @if ($proof->result)
                            <p class="about-proof-result">{{ $proof->result }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="about-principles" aria-labelledby="about-principles-title">
        <header class="about-section-heading">
            <div>
                <p class="eyebrow">{{ __('about.principles_eyebrow') }}</p>
                <h2 id="about-principles-title">{{ __('about.principles_title') }}</h2>
            </div>
        </header>

        <ol class="about-principles-list">
            @foreach (range(1, 4) as $number)
                <li>
                    <span aria-hidden="true">{{ str_pad((string) $number, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ __('about.principle_'.$number) }}</h3>
                    <p>{{ __('about.principle_'.$number.'_text') }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    @if ($this->testimonials->isNotEmpty())
        <section class="about-testimonials" aria-labelledby="about-testimonials-title">
            <header class="about-section-heading">
                <div>
                    <p class="eyebrow">{{ __('about.testimonials_eyebrow') }}</p>
                    <h2 id="about-testimonials-title">{{ __('about.testimonials_title') }}</h2>
                </div>
            </header>

            <div class="about-testimonial-grid">
                @foreach ($this->testimonials as $testimonial)
                    <figure>
                        <blockquote>{{ $testimonial->content }}</blockquote>
                        <figcaption>
                            <span class="about-testimonial-mark" aria-hidden="true">{{ mb_substr($testimonial->name, 0, 1) }}</span>
                            <span>
                                <span class="about-testimonial-name">{{ $testimonial->name }}</span>
                                <span class="about-testimonial-role">{{ collect([$testimonial->role, $testimonial->company])->filter()->implode(' · ') }}</span>
                            </span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif
</div>
