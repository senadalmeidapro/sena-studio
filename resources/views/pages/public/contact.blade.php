<div class="mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    @if ($sent)
        <div class="mx-auto max-w-2xl rounded-3xl border border-emerald-200 bg-emerald-50 p-10 text-center motion-safe:animate-fade-up dark:border-emerald-700/40 dark:bg-emerald-950/40">
            <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-emerald-500/15">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-emerald-600 dark:text-emerald-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h2 class="mt-5 font-display text-3xl font-medium tracking-tight text-ink-900 dark:text-ink-50">Message envoyé&nbsp;!</h2>
            <p class="mt-3 text-ink-600 dark:text-ink-300">
                Merci pour votre message. Je reviens vers vous dans les plus brefs délais.
            </p>
            <button wire:click="$set('sent', false)" class="mt-7 font-medium text-emerald-600 underline-offset-4 transition-colors hover:text-emerald-700 hover:underline dark:text-emerald-300 dark:hover:text-emerald-200">
                Envoyer un autre message
            </button>
        </div>
    @else
        {{-- En-tête éditorial --}}
        <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
<div class="flex items-center gap-3">
            <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">SEN</span>
            <span class="eyebrow">Échange</span>
        </div>
            <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
                Contact
            </h1>
            <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
                Vous avez un projet, une idée ou une question&nbsp;? Remplissez le formulaire et discutons-en.
            </p>
        </header>

        <div class="mt-12 grid gap-12 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
            {{-- Colonne infos --}}
            <aside class="motion-safe:animate-fade-up">
                <h2 class="font-display text-2xl font-medium tracking-tight text-ink-900 dark:text-ink-50">
                    Une réponse sous 24&nbsp;h
                </h2>
                <p class="mt-3 text-pretty leading-relaxed text-ink-600 dark:text-ink-400">
                    Pour affiner votre demande, précisez autant que possible le contexte de votre projet :
                    objectifs, délais envisagés et budget indicatif.
                </p>

                <dl class="mt-10 space-y-6 border-t border-ink-300 pt-8 dark:border-ink-700">
                    <div class="grid grid-cols-[auto_1fr] gap-4">
                        <dt class="pt-0.5 text-emerald-600 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </dt>
                        <dd class="font-mono text-sm uppercase tracking-[0.1em] text-ink-700 dark:text-ink-200">contact@senastudio.fr</dd>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-4">
                        <dt class="pt-0.5 text-emerald-600 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </dt>
                        <dd class="font-mono text-sm uppercase tracking-[0.1em] text-ink-700 dark:text-ink-200">Basé à Lyon — télétravail</dd>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-4">
                        <dt class="pt-0.5 text-emerald-600 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </dt>
                        <dd class="font-mono text-sm uppercase tracking-[0.1em] text-ink-700 dark:text-ink-200">Réponse sous 24&nbsp;h ouvrées</dd>
                    </div>
                </dl>
            </aside>

            {{-- Formulaire --}}
            @php
                $input = 'rounded-lg border border-ink-300 bg-white px-4 py-2.5 text-ink-900 placeholder-ink-400 outline-none transition-colors focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:border-ink-700 dark:bg-ink-900 dark:text-ink-100 dark:placeholder-ink-500 dark:focus:border-emerald-400';
                $label = 'text-sm font-medium text-ink-700 dark:text-ink-200';
            @endphp

            <form wire:submit="submit" class="motion-safe:animate-fade-up [animation-delay:120ms]">
                <div class="mb-6 flex items-center gap-3">
                    <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">01</span>
                    <span class="eyebrow">Formulaire de contact</span>
                </div>

                <p class="mb-6 text-sm text-ink-500 dark:text-ink-400">
                    Les champs notés <span class="font-medium text-ink-700 dark:text-ink-200">*</span> sont obligatoires, les autres sont optionnels.
                </p>

                <div class="grid gap-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="grid gap-2">
                            <label for="contact-name" class="{{ $label }}">Nom <span class="text-emerald-600 dark:text-emerald-300">*</span></label>
                            <input
                                id="contact-name"
                                type="text"
                                wire:model="name"
                                class="{{ $input }}"
                                placeholder="Votre nom"
                            />
                            @error('name') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid gap-2">
                            <label for="contact-email" class="{{ $label }}">Email <span class="text-emerald-600 dark:text-emerald-300">*</span></label>
                            <input
                                id="contact-email"
                                type="email"
                                wire:model="email"
                                class="{{ $input }}"
                                placeholder="vous@exemple.com"
                            />
                            @error('email') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="grid gap-2">
                            <label for="contact-phone" class="{{ $label }}">Téléphone <span class="font-normal text-ink-400 dark:text-ink-500">(optionnel)</span></label>
                            <input
                                id="contact-phone"
                                type="tel"
                                wire:model="phone"
                                class="{{ $input }}"
                                placeholder="06 12 34 56 78"
                            />
                            @error('phone') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid gap-2">
                            <label for="contact-company" class="{{ $label }}">Société / organisation <span class="font-normal text-ink-400 dark:text-ink-500">(optionnel)</span></label>
                            <input
                                id="contact-company"
                                type="text"
                                wire:model="company"
                                class="{{ $input }}"
                                placeholder="Nom de votre entreprise"
                            />
                            @error('company') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="grid gap-2">
                            <label for="contact-subject" class="{{ $label }}">Sujet <span class="text-emerald-600 dark:text-emerald-300">*</span></label>
                            <input
                                id="contact-subject"
                                type="text"
                                wire:model="subject"
                                class="{{ $input }}"
                                placeholder="Objet de votre message"
                            />
                            @error('subject') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid gap-2">
                            <label for="contact-budget" class="{{ $label }}">Budget estimé <span class="font-normal text-ink-400 dark:text-ink-500">(optionnel)</span></label>
                            <select
                                id="contact-budget"
                                wire:model="budget"
                                class="{{ $input }} bg-white dark:bg-ink-900"
                            >
                                <option value="">Sélectionner un budget…</option>
                                @foreach ($this->budgetOptions() as $key => $budgetLabel)
                                    <option value="{{ $key }}" class="text-ink-900 dark:text-ink-100">{{ $budgetLabel }}</option>
                                @endforeach
                            </select>
                            @error('budget') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <label for="contact-message" class="{{ $label }}">Message <span class="text-emerald-600 dark:text-emerald-300">*</span></label>
                        <textarea
                            id="contact-message"
                            wire:model="message"
                            rows="6"
                            class="resize-none {{ $input }}"
                            placeholder="Décrivez votre projet..."
                        ></textarea>
                        @error('message') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-wrap items-center gap-6">
                        <button type="submit"
                                class="group inline-flex items-center gap-2.5 rounded-full bg-emerald-600 px-7 py-3.5 font-display text-base font-medium text-white transition-colors hover:bg-emerald-700 dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400">
                            Envoyer le message
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                        <span class="font-mono text-[0.68rem] uppercase tracking-[0.14em] text-ink-400 dark:text-ink-500">Chiffré &amp; confidentiel</span>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>