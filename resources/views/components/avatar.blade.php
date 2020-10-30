@props([
    'user',
    'class',
    'size' => 'smaller'
])

@php
    $initials = array_map(function($part) {
        return substr($part, 0, 1);
    }, explode(' ', $user->name));

    $baseClass = 'bg-gray-600 flex items-center justify-center rounded-full';

    $sizes = [
        'small' => 'w-24 h-24',
        'smaller' => 'w-12 h-12',
        'smallest' => 'w-4 h-4 text-xs',
    ];
@endphp

<div class="{{ $baseClass }} {{ $sizes[$size] }} {{ $class ?? '' }}">
    @if(isset($user->photo) && $user->photo)
        <img
            src="{{ $user->photo[$size] }}"
            class="{{ $baseClass }} {{ $sizes[$size] }}"
            alt="{{ join('', $initials) }}"
        />
    @else        
        @if($size == 'smallest')
            <x-heroicon-s-user class="inline-block w-3 h-3" />
        @else
            <span>{{ join('', $initials) }}</span>
        @endif
    @endif        
</div>