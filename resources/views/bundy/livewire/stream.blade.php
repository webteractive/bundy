<x-content-wrapper title="Home">
    <x-slot name="header">
        <div 
            @if(! $inTheProfilePage)
                class="sticky z-40 {{ $this->user ? 'top-32' : 'top-0' }}"
            @endif
        >
            <div
                class="
                    bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700 px-4 py-2 md:py-0 md:flex md:items-center md:h-16
                "
            >
                <h2 class="font-bold tracking-wide md:text-xl flex-1">{{ $this->streamTitle }}</h2>

                <div class="flex items-center justify-end mt-2 md:mt-0 md:justify-start">
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

                    <span wire:ignore x-data="naveDatePicker()" x-init="init($wire)" class="relative inline-block">
                        <x-icon-button
                            icon="heroicon-o-calendar"
                            class="mr-1"
                            x-ref="dateFieldElement"
                        />
                    </span>

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
        <div class="relative border-b hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
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

@once
    @push('styles')
        <link href="{{ asset(mix('/css/flatpickr.css')) }}" rel="stylesheet">
    @endpush

    @push('headscripts')
        <script src="{{ asset(mix('/js/flatpickr.js')) }}"></script>
    @endpush

    @push('scripts')
        <script>
            function naveDatePicker () {
                return {
                    init (wire) {
                        flatpickr(this.$refs.dateFieldElement, {
                            disableMobile: true,
                            onChange: function (selectedDates, dateStr) {
                                wire.setDate(selectedDates[0].getTime() / 1000);
                            }
                        });
                    }
                }
            }
        
        </script>
    @endpush
@endonce