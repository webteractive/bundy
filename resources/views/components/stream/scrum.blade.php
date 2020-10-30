<x-stream.base :data="$data">
    @if($data->yesterday)
        <div class="mb-4">
            <h3 class="tracking-wider font-bold mb-2">{{ __('Yesterday') }}</h3>
            @foreach($data->yesterday as $item)
                <x-scrum-item
                    icon="heroicon-o-check-circle"
                    icon-class="text-green-500"
                >
                    {{ $item }}
                </x-scrum-item>
            @endforeach
        </div>
    @endif

    @if($data->blockers)
        <div class="mb-4">
            <h3 class="tracking-wider font-bold mb-2">{{ __('Blockers') }}</h3>
            @foreach($data->blockers as $item)
                <x-scrum-item
                    icon="heroicon-o-thumb-down"
                    icon-class="text-red-500"
                >
                    {{ $item }}
                </x-scrum-item>
            @endforeach
        </div>
    @endif

    @if($data->today)
        <div>
            <h3 class="tracking-wider font-bold mb-2">{{ __('Today') }}</h3>
            @foreach($data->today as $item)
                <x-scrum-item
                    icon="heroicon-o-information-circle"
                >
                    {{ $item }}
                </x-scrum-item>
            @endforeach
        </div>
    @endif
</x-stream.base>