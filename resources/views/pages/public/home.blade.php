<div class="public-page home-page">
    <section class="home-hero" aria-labelledby="home-title">
        <div class="home-hero-inner">
            <div class="home-hero-meta-top">
                <span class="studio-kicker">{{ __('home.hero_eyebrow') }}</span>
                <span class="home-status" data-state="{{ $availability }}"><i aria-hidden="true"></i>{{ __('availability.'.$availability) }}</span>
            </div>

            <div class="home-hero-copy">
                <span class="studio-index">01 / Sena Studio</span>
                <h1 id="home-title">{{ __('home.tagline') }}</h1>
                <p class="home-hero-intro">{{ __('home.intro') }}</p>
                <div class="home-hero-actions">
                    <a href="{{ localized_route('projects.index') }}" wire:navigate class="studio-button">
                        {{ __('home.cta_projects') }} <span aria-hidden="true">↗</span>
                    </a>
                    <a href="{{ localized_route('contact') }}" wire:navigate class="studio-button studio-button--quiet">
                        {{ __('home.cta_discuss') }}
                    </a>
                </div>
            </div>

            <figure class="home-portrait">
                <img src="{{ asset('images/portrait.png') }}" alt="{{ __('home.portrait_alt') }}" fetchpriority="high" decoding="async" />
                <span class="home-portrait-index" aria-hidden="true">01 / PORTRAIT</span>
                <figcaption class="home-portrait-caption">
                    <strong>D’ALMEIDA Sèna Gédéon</strong>
                    <span>{{ __('home.badge_sub') }}</span>
                </figcaption>
            </figure>

            <div class="home-hero-bottom" role="group" aria-label="{{ __('home.stats_projects') }}">
                <div class="home-hero-stat">
                    <strong>{{ $this->projectCount }}</strong>
                    <span>{{ __('home.stats_projects') }}</span>
                </div>
                <div class="home-hero-stat">
                    <strong>{{ $this->caseStudyCount }}</strong>
                    <span>{{ __('home.stats_case_studies') }}</span>
                </div>
                <div class="home-hero-stat">
                    <strong class="home-hero-stat-location">{{ __('home.stats_location') }}</strong>
                    <span>{{ __('home.stats_base') }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="home-scene home-scene--petrol" aria-labelledby="home-services-title">
        <div class="home-scene-inner">
            <div class="home-scene-heading">
                <span class="studio-kicker">{{ __('home.services.label') }}</span>
                <div>
                    <h2 id="home-services-title">{{ __('home.services.title') }}</h2>
                    <p>{{ __('home.services.subtitle') }}</p>
                </div>
            </div>

            <ol class="home-service-list">
                @foreach ([
                    [__('home.services.web'), __('home.services.web_text')],
                    [__('home.services.saas'), __('home.services.saas_text')],
                    [__('home.services.apis'), __('home.services.apis_text')],
                    [__('home.services.perf'), __('home.services.perf_text')],
                ] as [$title, $text])
                    <li class="home-service-item">
                        <span class="home-service-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <h3>{{ $title }}</h3>
                            <p>{{ $text }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @if ($this->featuredProjects->isNotEmpty())
        <section class="home-scene home-work-scene" aria-labelledby="home-work-title">
            <div class="home-scene-inner">
                <div class="home-scene-heading">
                    <span class="studio-kicker">{{ __('home.portfolio.label') }}</span>
                    <div>
                        <h2 id="home-work-title">{{ __('home.portfolio.title') }}</h2>
                        <p>{{ __('home.portfolio.subtitle') }}</p>
                    </div>
                </div>

                <div class="home-work-grid">
                    @foreach ($this->featuredProjects as $project)
                        <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate class="home-work-item">
                            <x-project-media :image="$project->image" :label="$project->name" class="home-work-media" />
                            <div class="home-work-caption">
                                <span class="home-work-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3>{{ $project->name }}</h3>
                                <span class="studio-meta">{{ $project->type->label() }}</span>
                                <p>{{ $project->result ?: $project->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <a href="{{ localized_route('projects.index') }}" wire:navigate class="home-scene-link">{{ __('common.see_all') }} <span aria-hidden="true">↗</span></a>
            </div>
        </section>
    @endif

    @if ($this->topSkills->isNotEmpty())
        <section class="home-scene home-capabilities" aria-labelledby="home-capabilities-title">
            <div class="home-scene-inner">
                <div class="home-scene-heading">
                    <span class="studio-kicker">{{ __('home.expertise.label') }}</span>
                    <div>
                        <h2 id="home-capabilities-title">{{ __('home.expertise.title') }}</h2>
                        <p>{{ __('home.expertise.subtitle') }}</p>
                    </div>
                </div>

                <div class="home-capability-list">
                    @foreach ($this->topSkills as $skill)
                        <a href="{{ skill_url($skill->name) }}" class="home-capability-item">
                            <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} · {{ $skill->category }}</span>
                            <h3>{{ $skill->name }}</h3>
                            <p>{{ __('home.expertise.action') }} <span aria-hidden="true">↗</span></p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="home-scene home-method" aria-labelledby="home-method-title">
        <div class="home-scene-inner">
            <div class="home-scene-heading">
                <span class="studio-kicker">{{ __('home.method.label') }}</span>
                <div>
                    <h2 id="home-method-title">{{ __('home.method.title') }}</h2>
                    <p>{{ __('home.method.subtitle') }}</p>
                </div>
            </div>

            <ol class="home-method-track">
                @foreach ([
                    [__('home.method.step1'), __('home.method.step1_text')],
                    [__('home.method.step2'), __('home.method.step2_text')],
                    [__('home.method.step3'), __('home.method.step3_text')],
                    [__('home.method.step4'), __('home.method.step4_text')],
                ] as [$title, $text])
                    <li class="home-method-step">
                        <span class="home-method-step-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="home-scene home-perspective" aria-labelledby="home-perspective-title">
        <div class="home-scene-inner">
            <div class="home-scene-heading">
                <span class="studio-kicker">{{ __('home.engagement.label') }}</span>
                <div>
                    <h2 id="home-perspective-title">{{ __('home.engagement.title') }}</h2>
                    <p>{{ __('home.engagement.subtitle') }}</p>
                </div>
            </div>
            <div class="home-perspective-list">
                @foreach ([
                    [__('home.engagement.mvp'), __('home.engagement.mvp_text')],
                    [__('home.engagement.audit'), __('home.engagement.audit_text')],
                    [__('home.engagement.continuous'), __('home.engagement.continuous_text')],
                ] as [$title, $text])
                    <article>
                        <span class="studio-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($this->stackHighlights->isNotEmpty())
        <section class="home-stack-scene" aria-labelledby="home-stack-title">
            <div class="home-stack-inner">
                <div>
                    <span class="studio-kicker">{{ __('home.stack.label') }}</span>
                    <h2 id="home-stack-title">{{ __('home.stack.title') }}</h2>
                    <p>{{ __('home.stack.subtitle') }}</p>
                </div>
                <div class="home-stack-groups">
                    @foreach ($this->stackHighlights as $category => $items)
                        <div>
                            <h3>{{ __('skills.role_'.$category) }}</h3>
                            <p>
                                @foreach ($items->take(4) as $item)
                                    <a href="{{ skill_url($item->name) }}">{{ $item->name }}</a>@if (! $loop->last)<span aria-hidden="true"> · </span>@endif
                                @endforeach
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

{{--    <section class="home-cta-scene" aria-labelledby="home-cta-title">--}}
{{--        <div class="home-cta-inner">--}}
{{--            <div>--}}
{{--                <span class="studio-kicker">{{ __('home.cta_banner.eyebrow') }}</span>--}}
{{--                <h2 id="home-cta-title">{{ __('home.cta_banner.title') }}</h2>--}}
{{--                <p>{{ __('home.cta_banner.text') }}</p>--}}
{{--            </div>--}}
{{--            <a href="{{ localized_route('contact') }}" wire:navigate class="studio-button">--}}
{{--                {{ __('home.cta_banner.action') }} <span aria-hidden="true">↗</span>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </section>--}}
</div>
