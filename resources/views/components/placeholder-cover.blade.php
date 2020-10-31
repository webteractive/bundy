@php
    $color = collect([
        'bg-green-500',
        'bg-blue-600',
        'bg-pink-700',
        'bg-yellow-700',
        'bg-orange-500',
        'bg-red-700',
    ])->random();
@endphp


<div class="h-64 {{ $color }}"></div>