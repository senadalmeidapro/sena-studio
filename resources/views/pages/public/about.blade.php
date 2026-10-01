<div class="public-page mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête --}}
    <header class="border-b border-border pb-10 motion-safe:animate-fade-up ">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('about.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-text  sm:text-5xl">
            {{ __('about.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-text-muted ">
            {{ __('about.subtitle') }}
        </p>
    </header>

    <div class="mt-14 grid gap-16 lg:grid-cols-[1.1fr_0.9fr]">
        {{-- Récit --}}
        <div class="prose-blog motion-safe:animate-fade-up">
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
            <blockquote>
                {{ __('about.quote') }}
            </blockquote>
        </div>

        {{-- Chiffres --}}
        <aside class="grid content-start gap-6 motion-safe:animate-fade-up [animation-delay:120ms]">
            <div class="rounded-2xl border border-border bg-surface p-8 shadow-soft ">
                <p class="eyebrow">{{ __('about.stats_eyebrow') }}</p>
                <dl class="mt-6 grid grid-cols-3 gap-6">
                    @foreach ([
                        ['value' => $this->stats['projects'], 'label' => __('about.stats_projects')],
                        ['value' => $this->stats['skills'], 'label' => __('about.stats_skills')],
                        ['value' => $this->stats['testimonials'], 'label' => __('about.stats_reviews')],
                    ] as $stat)
                        <div>
                            <dd class="font-display text-3xl font-medium tabular-nums text-text ">{{ $stat['value'] }}</dd>
                            <dt class="mt-1 font-mono text-[0.64rem] uppercase tracking-[0.14em] text-text-muted ">{{ $stat['label'] }}</dt>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="rounded-2xl border border-border bg-surface-muted p-8 shadow-soft  ">
                <p class="eyebrow">{{ __('about.availability_eyebrow') }}</p>
                <p class="mt-4 text-pretty leading-relaxed text-text-muted ">
                    {{ __('about.availability_text') }}
                </p>
                <x-front.arrow-link :href="localized_route('contact')" wire:navigate class="mt-5">
                    {{ __('common.start_project') }}
                </x-front.arrow-link>
            </div>
        </aside>
    </div>

    {{-- Principes d'ingénierie --}}
    @if ($this->proofProjects->isNotEmpty())
        <section class="mt-16 rounded-3xl border border-border bg-gradient-to-br from-surface-muted via-surface to-surface p-6   sm:p-9">
            <div class="grid gap-7 lg:grid-cols-[0.75fr_1.25fr] lg:items-start">
                <div>
                    <p class="eyebrow">{{ __('about.proof_eyebrow') }}</p>
                    <h2 class="mt-3 font-display text-2xl font-semibold tracking-tight text-text ">{{ __('about.proof_title') }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-text-muted ">{{ __('about.proof_text') }}</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($this->proofProjects as $proof)
                        <a href="{{ localized_route('projects.show', $proof->slug) }}" wire:navigate class="group rounded-2xl border border-border bg-surface/80 p-5 transition-all hover:-translate-y-0.5 hover:border-border hover:shadow-card  ">
                            <span class="font-mono text-[0.65rem] uppercase tracking-[0.12em] text-text-muted">{{ $proof->role ?: $proof->type->label() }}</span>
                            <h3 class="mt-2 font-display text-lg font-semibold text-text transition-colors group-hover:text-accent  ">{{ $proof->name }}</h3>
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-text-muted ">{{ $proof->problem }}</p>
                            @if ($proof->result)
                                <p class="mt-4 border-t border-border pt-3 text-sm leading-relaxed text-text-muted  ">{{ $proof->result }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mt-20 border-t border-border pt-14 ">
        <div class="max-w-2xl">
            <p class="eyebrow">{{ __('about.principles_eyebrow') }}</p>
            <h2 class="mt-4 font-display text-3xl font-bold tracking-[-0.035em] text-text  sm:text-4xl">
                {{ __('about.principles_title') }}
            </h2>
        </div>

        <ol class="mt-8 grid gap-px overflow-hidden rounded-xl border border-border bg-border sm:grid-cols-2  ">
            @foreach (range(1, 4) as $number)
                <li class="bg-surface p-6 transition-colors hover:bg-surface-muted ">
                    <span class="block size-2 rounded-full bg-accent"></span>
                    <h3 class="mt-5 font-display text-lg font-semibold tracking-tight text-text ">{{ __('about.principle_'.$number) }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-text-muted ">{{ __('about.principle_'.$number.'_text') }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Témoignages --}}
    @if ($this->testimonials->isNotEmpty())
        <section class="mt-20 border-t border-border pt-14 ">
            <div>
                <h2 class="eyebrow">{{ __('about.testimonials_eyebrow') }}</h2>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach ($this->testimonials as $testimonial)
                    <figure class="flex flex-col rounded-2xl border border-border bg-surface p-6 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-card ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-text-muted">
                            <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 3.01 1.693 5.192 4.554 6.15.163 1.363.947 2.353 2.081 2.904Z" clip-rule="evenodd" />
                        </svg>
                        <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-text-muted ">
                            {{ $testimonial->content }}
                        </blockquote>
                        <figcaption class="mt-5 flex items-center gap-3 border-t border-border pt-4 ">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-surface-muted font-display text-sm font-semibold text-text-muted  ">
                                {{ mb_substr($testimonial->name, 0, 1) }}
                            </span>
                            <span>
                                <span class="block text-sm font-medium text-text ">{{ $testimonial->name }}</span>
                                <span class="block font-mono text-[0.66rem] uppercase tracking-[0.1em] text-text-muted ">
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
