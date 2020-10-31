@props([
    'tag' => 'button',
    'style' => 'submit'
])

@php
    $styles = [
        'submit' => 'bg-green-700 text-green-100 hover:bg-green-600'
    ];
@endphp

<{{ $tag }}
    class="
        inline-flex items-center justify-center h-10 px-6 border-none
        rounded-full {{ $styles[$style] }}
    "
    {{ $attributes->except('tag', 'class') }}
>
    {{ $slot }}
</{{ $tag }}>