<div class="mx-auto max-w-3xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">

    @if ($sent)
        <div class="rounded-2xl border border-sage-200 bg-sage-50 p-8 text-center dark:border-sage-700/40 dark:bg-sage-950/40">
            <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-sage-500/15">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-sage-600 dark:text-sage-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h2 class="mt-4 text-2xl font-semibold text-ink-900 dark:text-ink-50">Message envoyé !</h2>
            <p class="mt-2 text-ink-600 dark:text-ink-300">
                Merci pour votre message. Je reviens vers vous dans les plus brefs délais.
            </p>
            <button wire:click="$set('sent', false)" class="mt-6 text-sm font-medium text-sage-600 transition-colors hover:text-sage-700 hover:underline dark:text-sage-300 dark:hover:text-sage-200">
                Envoyer un autre message
            </button>
        </div>
    @else
        <header class="mb-10 motion-safe:animate-fade-up">
            <h1 class="text-balance text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">Contact</h1>
            <p class="mt-3 max-w-2xl text-pretty text-ink-600 dark:text-ink-300">
                Vous avez un projet, une idée ou une question ? Remplissez le formulaire et discutons-en.
            </p>
        </header>

        @php
            $input = 'rounded-lg border border-ink-300 bg-white px-4 py-2.5 text-ink-900 placeholder-ink-400 outline-none transition-colors focus:border-sage-500 focus:ring-2 focus:ring-sage-500/20 dark:border-ink-700 dark:bg-ink-900/60 dark:text-ink-100 dark:placeholder-ink-500 dark:focus:border-sage-400';
            $label = 'text-sm font-medium text-ink-700 dark:text-ink-200';
        @endphp

        <form wire:submit="submit" class="grid gap-6">
            <p class="text-sm text-ink-500 dark:text-ink-400">
                Les champs notés <span class="font-medium text-ink-700 dark:text-ink-200">*</span> sont obligatoires, les autres sont optionnels.
            </p>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="grid gap-2">
                    <label for="contact-name" class="{{ $label }}">Nom <span class="text-sage-600 dark:text-sage-300">*</span></label>
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
                    <label for="contact-email" class="{{ $label }}">Email <span class="text-sage-600 dark:text-sage-300">*</span></label>
                    <input
                        id="contact-email"
                        type="email"
                        wire:model="email"
                        class="{{ $input }}"
                        placeholder="vous@exemple.com"
                    />
                    @error('email') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                </div>

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
                    <label for="contact-subject" class="{{ $label }}">Sujet <span class="text-sage-600 dark:text-sage-300">*</span></label>
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
                        class="{{ $input }} bg-white dark:bg-ink-900/60"
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
                <label for="contact-message" class="{{ $label }}">Message <span class="text-sage-600 dark:text-sage-300">*</span></label>
                <textarea
                    id="contact-message"
                    wire:model="message"
                    rows="6"
                    class="resize-none {{ $input }}"
                    placeholder="Décrivez votre projet..."
                ></textarea>
                @error('message') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:button type="submit" variant="primary" size="base" class="rounded-xl">
                    Envoyer le message
                </flux:button>
            </div>
        </form>
    @endif
</div>