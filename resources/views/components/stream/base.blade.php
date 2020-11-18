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

<div class="block md:grid md:grid-cols-7 p-4 min-h-20 {{ $class ?? '' }}">
    <div class="col-span-1 hidden md:block">
        <x-avatar :user="$user"/>
    </div>

    <div class="col-span-6">
        <div class="mb-4 md:mb-2 flex items-center">
            <div class="flex-1 md:flex md:items-center">
                <h2 class="text-xl md:text-base">
                    @if($customUser)
                        <span class="font-bold">{{ $user->name }}</span> 
                    @else
                        <a href="{{ $profileUrl }}" class="font-bold hover:underline">{{ $user->name }}</a>
                    @endif
                    
                    @if(isset($customUser) && isset($customUser->icon))
                        @svg($customUser->icon, 'inline-block w-5 h-5 ml-1')
                    @endif
                </h2>

                @if($timestamped)
                    <div>
                        <span class="px-2 hidden md:inline-block">·</span>
                        <x-heroicon-s-clock class="w-4 h-4 inline-block" />
                        <span class="font-thin text-xs" title="{{ $data->stream_date }}">{{ $data->stream_date->diffForHumans() }}</span>
                    </div>
                @endif
            </div>

            {{ $actions ?? '' }}
        </div>

        {{ $slot }}
    </div>
</div>