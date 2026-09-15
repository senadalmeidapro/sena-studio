@props(['title', 'eyebrow' => null])
<section class="rounded-xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
    <div class="mb-5">
        @if ($eyebrow)<p class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">{{ $eyebrow }}</p>@endif
        <h2 class="mt-1 text-lg font-semibold text-white">{{ $title }}</h2>
    </div>
    {{ $slot }}
</section>
