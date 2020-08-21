<x-app>
    <div class="container mx-auto">
        <x-main>
            <x-slot name="head">
                <div class="px-4 flex items-center justify-between border-b border-gray-100">
                    <h2 class="py-3 leading-none text-2xl">{{ __($this->title) }}</h2>

                    <div class="flex">
                        <button wire:click="next" type="button" class="text-gray-300 hover-black flex items-center justify-center hover:text-black"><x-heroicon-s-chevron-left class="w-6 h-6 fill-current" /></button>
                        <button type="button" class="text-gray-300 hover-black flex items-center justify-center hover:text-black ml-1"><x-heroicon-s-calendar class="w-6 h-6 fill-current" /></button>
                        <button wire:click="previous" type="button" class="text-gray-300 hover-black flex items-center justify-center hover:text-black ml-1"><x-heroicon-s-chevron-right class="w-6 h-6 fill-current" /></button>
                        <button type="button" class="text-gray-300 hover-black flex items-center justify-center hover:text-black ml-1"><x-heroicon-s-dots-vertical class="w-6 h-6 fill-current" /></button>
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