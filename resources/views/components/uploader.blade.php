<div x-data class="inline-block">
    <x-outlined-button
        tag="button"
        type="button"
        size="small"
        x-on:click.prevent="$refs.browser.click()"
    >
        <x-heroicon-o-upload class="inline-block w-5 h-5 mr-2" />
        <span wire:target="{{ $fileModel }}" wire:loading.class="hidden">{{ __($label ?? 'Upload') }}</span>
        <span wire:target="{{ $fileModel }}" wire:loading>Uploading...</span>
    </x-outlined-button>
    <input type="file" wire:model="{{ $fileModel }}" style="display: none;" x-ref="browser" />
</div>