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
        'small' => 'w-24 h-24 text-3xl tracking-wider',
        'smaller' => 'w-12 h-12',
        'smallest' => 'w-8 h-8 text-sm',
        'extrasmall' => 'w-4 h-4 text-sm',
    ];

    if (isset($user->photo) && $user->photo) {
        if (in_array($size, ['extrasmall'])) {
            $photoSize = $user->photo['smaller'];
        } else {
            $photoSize = $user->photo[$size];
        }
    }
    $organicUser = isset($user->id);
    $tag = $organicUser ? 'a' : 'div'
@endphp

<{{ $tag }}
    @if($organicUser)
        href="{{ route('tall.profile', ['username' => $user->username])}}"
        title="{{ $user->name }}"
    @endif
    class="
        {{ $baseClass }}
        {{ $sizes[$size] }}
        {{ $class ?? '' }}
    "
>
    @if(isset($user->photo) && $user->photo)
        <img
            src="{{ $photoSize }}"
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
</{{ $tag }}>