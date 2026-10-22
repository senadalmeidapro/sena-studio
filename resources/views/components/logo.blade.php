@props(['class' => 'size-8'])

<img
    src="{{ asset('images/brand/sena-mark.svg') }}"
    alt=""
    aria-hidden="true"
    {{ $attributes->merge([
        'class' => 'block shrink-0 object-contain '.$class,
    ]) }}
>
