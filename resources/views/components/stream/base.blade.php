@props([
    'data',
    'class',
    'timestamped' => true,
    'customUser' => null,
])

@php
    $user = $customUser ?? $data->user;
    $profileUrl = route('tall.profile', ['username' => $user->username]);
@endphp

<div class="flex p-4 min-h-20 {{ $class ?? '' }}">
    <x-avatar :user="$user" />

    <div class="flex-1 pl-4">
        <div class="mb-2 flex items-center">
            @if($customUser)
                <span class="font-bold">{{ $user->name }}</span> 
            @else
                <a href="{{ $profileUrl }}" class="font-bold hover:underline">{{ $user->name }}</a>
            @endif
            
            @if(isset($customUser) && isset($customUser->icon))
                @svg($customUser->icon, 'inline-block w-5 h-5 ml-1')
            @endif

            @if($timestamped)
                <span class="px-2">·</span>
                <span class="font-thin text-sm" title="{{ $data->stream_date }}">{{ $data->stream_date->diffForHumans() }}</span>
            @endif
        </div>

        {{ $slot }}
    </div>
</div>