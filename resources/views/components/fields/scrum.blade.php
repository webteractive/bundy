<div class="scrum-field">
    <div class="text-sm">
        @foreach($items as $index => $value)
            <div
                wire:key="{{ $name }}-{{ $index }}"
                class="
                    leading-none flex items-center p-1 
                    @error(join('.', [$name, $index]))
                        bg-red-400 text-red-900 hover:bg-red-500
                    @else
                        bg-gray-400 text-gray-900 hover:bg-gray-500
                    @enderror
                "
            >
                @if($icon)
                    @svg($icon, $iconClass ?? 'inline-block w-5 h-5 mr-1')
                @endif

                <input
                    type="text"
                    class="block w-full outline-none bg-transparent"
                    wire:model.lazy="{{ $name }}.{{ $index }}"
                />
                
                <button
                    type="button"
                    title="{{ __('Click to remove item') }}"
                    class="text-red-700 hover:text-red-900"
                    onclick="confirm('{{ __('Are you sure you want to remove this item?') }}') || event.stopImmediatePropagation()"
                    wire:click="removeFrom('{{ $name }}', {{ $index }})"
                >
                    <x-heroicon-o-trash class="inline-block w-5 h-5 ml-1" />
                </button>
            </div>
        @endforeach
    </div>

    <div x-data="scrum()" wire:ignore>
        <input
            type="text"
            data-field="{{ $name }}"
            class="block w-full bg-gray-400 text-gray-900 p-1 px-2"
            placeholder="{{ __($placeholder ?? 'Type in and enter') }}"
            x-on:keydown.enter="append($event, $wire)"
        />
    </div>
</div>