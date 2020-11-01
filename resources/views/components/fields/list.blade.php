<div class="list-field rounded-lg bg-gray-600 text-gray-900">
    <div class="text-sm {{ count($items) > 0 ? 'pt-2' : '' }}">
        @foreach($items as $index => $value)
            <div
                wire:key="{{ $name }}-{{ $index }}"
                class="
                    leading-none flex items-center py-1
                    @error(join('.', [$name, $index]))
                        bg-red-400 text-red-900 hover:bg-red-500
                    @enderror
                    {{ count($items) > 0 ? 'px-4' : '' }}
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

    <div x-data="listField()" wire:ignore>
        <x-fields.text
            data-field="{{ $name }}"
            placeholder="{{ __($placeholder ?? 'Type in and enter') }}"
            x-on:keydown.enter="append($event, $wire)"
        />
    </div>
</div>