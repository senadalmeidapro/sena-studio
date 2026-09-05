@props(['class' => 'size-8'])

<span
    {{ $attributes->merge([
        'class' => 'inline-flex shrink-0 items-center justify-center rounded-[0.4rem] bg-emerald-500 dark:bg-emerald-300 '.$class,
        'aria-hidden' => 'true',
    ]) }}
>
    <svg viewBox="0 0 32 32" fill="none" class="h-[62%] w-[62%] text-white dark:text-emerald-950">
        <path
            d="M23 11.5 C23 7.9 20.3 6 16.5 6 C13 6 11 7.6 11 10.2 C11 13 13.4 14.4 16.8 15.6 C20 16.7 22 18.3 22 21 C22 23.9 19.4 25.6 16 25.6 C12.6 25.6 9.8 24 9 21"
            stroke="currentColor"
            stroke-width="5"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</span>