@php
    $stages = [
        ['key' => 'clarify', 'steps' => [1, 2]],
        ['key' => 'design', 'steps' => [3, 4, 5]],
        ['key' => 'build', 'steps' => [6, 7, 8]],
        ['key' => 'deliver', 'steps' => [9, 10]],
    ];
@endphp

<div class="public-page process-page mx-auto">
    <header class="process-intro">
        <div class="process-intro-heading">
            <span class="eyebrow">{{ __('process.eyebrow') }}</span>
            <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('process.title') }}</h1>
            <p class="process-intro-summary text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('process.subtitle') }}</p>
            <div class="process-thesis">
                <span>{{ __('process.thesis_label') }}</span>
                <p>{{ __('process.thesis') }}</p>
            </div>
        </div>
        <figure class="process-hero-art" aria-hidden="true">
            <svg viewBox="0 0 580 440" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="process-blueprint-grid" width="22" height="22" patternUnits="userSpaceOnUse">
                        <circle cx="1" cy="1" r="1" class="process-art-grid-dot" />
                    </pattern>
                    <radialGradient id="process-blueprint-glow" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(344 189) rotate(90) scale(190 220)">
                        <stop stop-color="var(--ds-primary)" stop-opacity=".15" />
                        <stop offset="1" stop-color="var(--ds-primary)" stop-opacity="0" />
                    </radialGradient>
                </defs>

                <rect x="1" y="1" width="578" height="438" rx="28" class="process-art-frame" />
                <rect x="2" y="2" width="576" height="436" rx="27" fill="url(#process-blueprint-grid)" opacity=".62" />
                <ellipse cx="344" cy="189" rx="220" ry="190" fill="url(#process-blueprint-glow)" />
                <circle cx="288" cy="219" r="157" class="process-art-orbit" />
                <circle cx="288" cy="219" r="126" class="process-art-orbit process-art-orbit-inner" />

                <path d="M94 288C143 288 153 151 222 151C286 151 287 266 362 266C421 266 420 124 486 124" class="process-art-route" />
                <path d="M95 288H48M222 151V91M362 266H430M486 124V70" class="process-art-branch" />

                <g class="process-art-module">
                    <rect x="40" y="236" width="93" height="91" rx="12" />
                    <path d="M58 260H114M58 273H101M58 300H78M84 300H114" />
                    <circle cx="58" cy="312" r="3" class="process-art-accent-fill" />
                </g>
                <g class="process-art-module">
                    <rect x="179" y="94" width="86" height="82" rx="12" />
                    <ellipse cx="222" cy="113" rx="23" ry="8" />
                    <path d="M199 113V142C199 146 209 150 222 150C235 150 245 146 245 142V113M199 128C199 132 209 136 222 136C235 136 245 132 245 128" />
                </g>
                <g class="process-art-module">
                    <rect x="321" y="219" width="83" height="92" rx="12" />
                    <rect x="337" y="236" width="23" height="22" rx="5" />
                    <rect x="367" y="236" width="21" height="22" rx="5" />
                    <path d="M337 275H388M337 287H378" />
                </g>
                <g class="process-art-module">
                    <rect x="447" y="80" width="78" height="88" rx="12" />
                    <path d="M447 99H525M459 91H460M468 91H469" />
                    <path d="M464 130L475 141L505 111" class="process-art-check" />
                </g>

                <g class="process-art-node">
                    <circle cx="94" cy="288" r="13" /><circle cx="94" cy="288" r="4" class="process-art-node-core" />
                    <circle cx="222" cy="151" r="13" /><circle cx="222" cy="151" r="4" class="process-art-node-core" />
                    <circle cx="362" cy="266" r="13" /><circle cx="362" cy="266" r="4" class="process-art-node-core" />
                    <circle cx="486" cy="124" r="13" /><circle cx="486" cy="124" r="4" class="process-art-node-core" />
                </g>
                <circle cx="48" cy="288" r="3" class="process-art-accent-fill" />
                <circle cx="222" cy="91" r="3" class="process-art-accent-fill" />
                <circle cx="430" cy="266" r="3" class="process-art-accent-fill" />
                <circle cx="486" cy="70" r="3" class="process-art-accent-fill" />
            </svg>
        </figure>
    </header>

    <section class="process-lifecycle" aria-labelledby="process-lifecycle-title">
        <header class="process-section-heading">
            <h2 id="process-lifecycle-title">{{ __('process.lifecycle.title') }}</h2>
            <p>{{ __('process.lifecycle.text') }}</p>
        </header>

        <nav class="process-map" aria-label="{{ __('process.lifecycle.title') }}">
            @foreach ($stages as $index => $stage)
                <a href="#process-stage-{{ $stage['key'] }}">
                    <span class="process-map-index font-mono tabular-nums" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ __('process.stage_'.$stage['key'].'.title') }}</span>
                </a>
            @endforeach
        </nav>

        <div class="process-stages">
            @foreach ($stages as $index => $stage)
                <section id="process-stage-{{ $stage['key'] }}" class="process-stage" aria-labelledby="process-stage-heading-{{ $stage['key'] }}">
                    <header class="process-stage-heading">
                        <span class="process-stage-index font-mono tabular-nums" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <h3 id="process-stage-heading-{{ $stage['key'] }}">{{ __('process.stage_'.$stage['key'].'.title') }}</h3>
                            <p>{{ __('process.stage_'.$stage['key'].'.text') }}</p>
                        </div>
                    </header>

                    <ol class="process-phase-list">
                        @foreach ($stage['steps'] as $step)
                            <li>
                                <h4>
                                    <span class="process-phase-index font-mono tabular-nums" aria-hidden="true">{{ str_pad((string) $step, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span>{{ __('process.phase_'.$step.'.title') }}</span>
                                </h4>
                                <p>{{ __('process.phase_'.$step.'.text') }}</p>
                            </li>
                        @endforeach
                    </ol>
                </section>
            @endforeach
        </div>
    </section>

    <section class="process-daily" aria-labelledby="process-daily-title">
        <header class="process-section-heading">
            <h2 id="process-daily-title">{{ __('process.daily.title') }}</h2>
            <p>{{ __('process.daily.text') }}</p>
        </header>

        <ol class="process-daily-cycle">
            @foreach (range(1, 6) as $step)
                <li>
                    <span class="process-daily-index font-mono tabular-nums" aria-hidden="true">{{ str_pad((string) $step, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ __('process.daily_'.$step.'.title') }}</h3>
                    <p>{{ __('process.daily_'.$step.'.text') }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    <section class="process-principles" aria-labelledby="process-principles-title">
        <header class="process-section-heading">
            <h2 id="process-principles-title">{{ __('process.principles.title') }}</h2>
            <p>{{ __('process.principles.text') }}</p>
        </header>

        <dl class="process-principle-list">
            @foreach (['clarity', 'structure', 'judgment', 'depth', 'iteration'] as $principle)
                <div>
                    <dt>{{ __('process.principle_'.$principle.'.title') }}</dt>
                    <dd>{{ __('process.principle_'.$principle.'.text') }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    <div class="process-actions">
        <a href="{{ localized_route('contact') }}" wire:navigate class="process-action-primary inline-flex rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition-colors hover:bg-blue-700 dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">{{ __('common.start_project') }}</a>
        <a href="{{ localized_route('services') }}" wire:navigate class="process-action-secondary inline-flex rounded-lg border border-ink-300 px-5 py-3 font-medium text-ink-700 transition-colors hover:border-blue-400 hover:text-blue-700 dark:border-ink-700 dark:text-ink-200 dark:hover:text-blue-300">{{ __('nav.services') }}</a>
    </div>
</div>
