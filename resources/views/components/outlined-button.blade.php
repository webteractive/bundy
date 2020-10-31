@props([
    'tag' => 'a',
    'size' => 'base'
])

@php
    $sizes = [
        'base' => 'h-10 px-6',
        'small' => 'h-8 px-4 text-sm'
    ];
@endphp

<{{ $tag }}
    class="
        inline-flex items-center justify-center {{ $sizes[$size] ?? $sizes['base'] }} border border-gray-600
        rounded-full text-gray-500 hover:border-white hover:text-white
    "
    {{ $attributes->except('tag', 'class') }}
>
    {{ $slot }}
</{{ $tag }}>