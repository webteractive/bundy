@extends('layouts.base')

@section('body')
@php
    $menu = [
        'home' => ['heroicon-s-home', route('home'), 'Home'],
        'me' => ['heroicon-s-user-circle', route('me'), 'Me'],
        'notification' => ['heroicon-s-bell', route('notification'), 'Notifications'],
        'performance' => ['heroicon-s-heart', route('performance'), 'Perfs'],
        'calendar' => ['heroicon-s-calendar', route('calendar'), 'Calendar'],
    ];
@endphp

    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="container mx-auto flex justify-between">
            <div class="flex">
            @foreach ($menu as $route => $item)
                <a
                href="{{ $item[1] }}"
                title="{{ __($item[2]) }}"
                class="
                    px-4 py-3 border-b-2 
                    @if (Route::current()->getName() == $route)
                    border-black
                    @else
                    border-white
                    text-gray-300
                    hover:text-gray-900
                    hover:border-gray-900
                    @endif
                "
                >
                @svg($item[0], 'w-8 h-8 inline-block fill-current')
                </a>
            @endforeach
            </div>

            <div class="flex items-center flex-0">
                <div class="relative" x-data="{ dropdownShown: false }">
                    <div class="flex pr-2 items-center cursor-pointer hover:underline" @click="dropdownShown = !dropdownShown">
                        <x-avatar />
                        <span class="pl-2 pr-1">{{ auth()->user()->first_name }}</span>
                        <x-heroicon-s-chevron-down class="h-6 w-6 fill-current" />
                    </div>

                    <div class="bg-white shadow z-50 w-64 absolute top-full mt-2 right-0" x-show="dropdownShown" @click.away="dropdownShown = false">
                        <a href="" class="block px-4 py-2 hover:bg-gray-100 hover:underline">Settings</a>
                        <a href="" class="block px-4 py-2 hover:bg-gray-100 hover:underline">Admin</a>
                        <a href="" class="block px-4 py-2 hover:bg-gray-100 hover:underline hover:text-red-500">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')
@endsection
