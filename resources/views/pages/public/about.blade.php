<div class="mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête --}}
    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-blue-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-blue-500 dark:text-blue-950">ID</span>
            <span class="eyebrow">{{ __('about.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('about.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
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
            <div class="rounded-2xl border border-ink-300 bg-card p-8 shadow-soft dark:border-ink-700">
                <p class="eyebrow">{{ __('about.stats_eyebrow') }}</p>
                <dl class="mt-6 grid grid-cols-3 gap-6">
                    @foreach ([
                        ['value' => $this->stats['projects'], 'label' => __('about.stats_projects')],
                        ['value' => $this->stats['skills'], 'label' => __('about.stats_skills')],
                        ['value' => $this->stats['testimonials'], 'label' => __('about.stats_reviews')],
                    ] as $stat)
                        <div>
                            <dd class="font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">{{ $stat['value'] }}</dd>
                            <dt class="mt-1 font-mono text-[0.64rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ $stat['label'] }}</dt>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="rounded-2xl border border-ink-300 bg-blue-50/50 p-8 shadow-soft dark:border-ink-700 dark:bg-blue-950/20">
                <p class="eyebrow">{{ __('about.availability_eyebrow') }}</p>
                <p class="mt-4 text-pretty leading-relaxed text-ink-600 dark:text-ink-300">
                    {{ __('about.availability_text') }}
                </p>
                <x-front.arrow-link :href="localized_route('contact')" wire:navigate class="mt-5">
                    {{ __('common.start_project') }}
                </x-front.arrow-link>
            </div>
        </aside>
    </div>

    {{-- Témoignages --}}
    @if ($this->testimonials->isNotEmpty())
        <section class="mt-20 border-t border-ink-300 pt-14 dark:border-ink-700">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-blue-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-blue-500 dark:text-blue-950">02</span>
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