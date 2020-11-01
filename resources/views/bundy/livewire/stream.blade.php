<x-content-wrapper title="Home">
    <x-slot name="header">
        <div 
            class="
                sticky z-50
                @unless($this->user)
                    top-0
                @else
                    top-32
                @endunless
            "
        >
            <div class="bg-gray-800 flex items-center h-16 border-b border-gray-700 px-4">
                <h2 class="font-bold tracking-wide text-xl flex-1">{{ $this->streamTitle }}</h2>

                <div class="flex items-center">
                    <x-icon-button
                        icon="heroicon-o-arrow-left"
                        class="mr-1"
                        wire:click="previous"
                        title="{{ __('Previous') }}"
                    />                

                    <button
                        type="button"
                        class="text-sm mr-1 hover:underline"
                        wire:click="today"
                    >
                        {{ __('Today') }}
                    </button>

                    <x-icon-button
                        icon="heroicon-o-calendar"
                        class="mr-1"
                    />

                    <x-icon-button
                        icon="heroicon-o-arrow-right"
                        title="{{ __('Next') }}"
                        wire:click="next"
                    />
                </div>
            </div>
        </div>
    </x-slot>

    @unless($this->user)
        <x-toast class="px-4" />
    @endunless

     @foreach($this->stream as $stream)
        <div class="relative border-b bg-opacity-25 border-gray-700 hover:bg-gray-700">
            <x-dynamic-component
                :component="'stream.' . str_replace('_', '-', $stream->stream_type)"
                :data="$stream"
            />
        </div>
    @endforeach

    @if($this->stream->isEmpty())
        <x-empty-placeholder />
    @endif
</x-content-wrapper>