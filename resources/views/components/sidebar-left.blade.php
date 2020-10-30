@php
    $menu = [
        'tall.home' => [
            'label' => 'Home',
            'route' => route('tall.home'),
            'icon' => 'heroicon-s-home'
        ],
        'tall.performance' => [
            'label' => 'Performance',
            'route' => route('tall.performance'),
            'icon' => 'heroicon-s-lightning-bolt'
        ],
        'tall.notification' => [
            'label' => 'Notifications',
            'route' => route('tall.notification'),
            'icon' => 'heroicon-s-bell'
        ],
        'tall.profile' => [
            'label' => 'Profile',
            'route' => route('tall.profile', ['username' => auth()->user()->username]),
            'icon' => 'heroicon-s-user-circle'
        ],
        'tall.settings' => [
            'label' => 'Settings',
            'route' => route('tall.settings'),
            'icon' => 'heroicon-s-cog'
        ],
    ];
@endphp

<div class="h-screen">
    <x-logo />

    <div class="mt-6">
        @foreach($menu as $name => $value)
            <a
                href="{{ $value['route'] }}"
                class="
                    flex w-full items-center text-xl py-1 hover:underline
                    @if(request()->route()->getName() == $name)
                        text-white font-bold hover:text-gray-100
                    @else
                        text-gray-500 hover:text-white
                    @endif
                "
            >
                @isset($value['icon'])
                    @svg($value['icon'], 'inline-block fill-current w-6 h-6 mr-2')
                @endisset
                {{ __($value['label']) }}
            </a>
        @endforeach
    </div>

    <p class="absolute left-0 bottom-0 right-0 py-2 text-xs">
        <span>{{ __('Made with') }}</span>
        <x-heroicon-o-heart class="inline-block w-4 h-4 text-red-500 fill-current" />
        <span>{{ __('by Webteractive') }}</span>
    </p>
</div>