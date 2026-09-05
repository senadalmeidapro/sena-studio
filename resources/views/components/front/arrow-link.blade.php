@props(['class' => null])

<a
    {{ $attributes->merge(['class' => 'group inline-flex items-center gap-1.5 font-medium text-emerald-600 transition-colors hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 '.$class]) }}
>
    <span class="ink-link">{{ $slot }}</span>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
         class="size-4 transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
    </svg>
</a>