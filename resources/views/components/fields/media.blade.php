<div x-data class="h-32 border-2 border-gray-600 rounded-lg grid grid-cols-3 gap-4 p-2">
    <div class="col-span-1 border border-dashed border-gray-600 rounded-lg flex items-center">
        @if(isset($file) && $file && $file->temporaryUrl())
            <img
                src="{{ $file->temporaryUrl() }}"
                class="w-full object-contain"
            />
        @endif
    </div>

    <div class="col-span-2">
        <div>
            <x-outlined-button
                tag="button"
                type="button"
                size="small"
                x-on:click.prevent="$refs.browser.click()"
            >
                <x-heroicon-o-upload class="inline-block w-5 h-5 mr-2" />
                <span>{{ __('Browse files') }}</span>
            </x-outlined-button>
        </div>

        <div class="text-xs leading-relaxed font-thin mt-4">
            <p>You can upload scg, jpg, jpeg, png and gif.</p>
            <p>Files size should not exceed 5MB.</p>
        </div>
    </div>

    <input type="file" wire:model="{{ $model }}" style="display: none;" x-ref="browser" />
</div>