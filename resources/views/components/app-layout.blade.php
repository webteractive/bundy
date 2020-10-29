@php
    $menu = [
        'tall.home' => ['label' => 'Home', 'route' => route('tall.home')],
        'tall.performance' => ['label' => 'Performance', 'route' => route('tall.performance')],
        'tall.notification' => ['label' => 'Notifications', 'route' => route('tall.notification')],
        'tall.profile' => ['label' => 'Profile', 'route' => route('tall.profile')],
        'tall.settings' => ['label' => 'Settings', 'route' => route('tall.settings')],
    ];
@endphp

<div class="relative container mx-auto flex h-screen">
    <div class="sticky top-0 w-240 pr-4 py-2">
        <x-logo />

        <div class="mt-6">
            @foreach($menu as $name => $value)
                <a
                    href="{{ $value['route'] }}"
                    class="
                        block text-2xl py-2 hover:underline
                        @if(request()->route()->getName() == $name)
                            'text-white hover:text-gray-100
                        @else
                            text-gray-500 hover:text-white
                        @endif
                    "
                >
                    {{ __($value['label']) }}
                </a>
            @endforeach
        </div>


    </div>

    <div class="flex-1 min-h-screen border-r border-l border-gray-700">
        @isset($title)
            <h2 class="px-4 leading-none py-3 text-xl border-b border-gray-700">{{ $title }}</h2>
        @endisset

        {{ $slot }}
    </div>

    <div class="sticky top-0 w-240 pl-4 py-2">
        <div class="flex justify-between">
            <a href="{{ route('tall.profile') }}" class="inline-flex items-center p-2 rounded-full hover:bg-gray-700">
                <img
                    class="rounded-full"
                    src="{{ auth()->user()->photo['smallest'] }}"
                    alt="{{ auth()->user()->name }}"
                />
                <span class="inline-block pl-2 pr-4 text-base leading-none">
                    <span class="block text-sm mb-1">{{ auth()->user()->name }}</span>
                    <span class="block text-xs">{{ '@' . auth()->user()->username }}</span>
                </span>
            </a>

            <button>Out</button>
        </div> 
    </div>
</div>