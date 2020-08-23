<x-app>
    <div class="container mx-auto">
        <x-main>
            <x-slot name="head">
                <div class="px-4 flex items-center justify-between border-b border-gray-100">
                    <h2 class="py-5 tracking-wider leading-none text-xl" title="{{ $this->dateInCarbon }}">{{ __($this->title) }}</h2>

                    <div class="flex">
                        <x-button wire:click="previous" style="icon" class="ml-2"><x-heroicon-s-chevron-left class="w-6 h-6 fill-current" /></x-button>
                        <x-button wire:click="today" style="icon" class="ml-2">{{ __('Today') }}</x-button>
                        <x-button style="icon" class="ml-2"><x-heroicon-s-calendar class="w-6 h-6 fill-current" /></x-button>
                        <x-button wire:click="previous" style="icon" class="ml-2"><x-heroicon-s-chevron-right class="w-6 h-6 fill-current" /></x-button>
                        <x-button style="icon" class="ml-2"><x-heroicon-s-dots-vertical class="w-6 h-6 fill-current" /></x-button>
                    </div>
                </div>
            </x-slot>

            @foreach ($this->streams as $stream)
                @php
                    $component = [
                        'App\Scrum' => 'streams.scrum',
                        'App\TimeLog' => 'streams.time-log',
                    ][get_class($stream)]
                @endphp
                
                @include($component, ['stream' => $stream])
            @endforeach
        </x-main>
    </div>
</x-app>