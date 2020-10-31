@php
    $size = 'w-160 h-160';
@endphp

<div class="absolute photo overflow-hidden {{ $size }} z-40 bottom-4 left-4 rounded-full {{ $class ?? '' }}">
    @if($file)
        <img
            src="{{ $file->temporaryUrl() }}"
            class="{{ $size }} object-cover rounded-full z-0"
        />
    @else
        @if($current)
            <img
                src="{{ $current }}"
                class="{{ $size }} object-cover rounded-full z-0"
            />
        @else
            <x-image-placeholder class="{{ $size }} rounded-full z-0" />
        @endif
    @endif

    <x-overlay class="z-40 {{ $size }} rounded-full absolute inset-0 flex items-center justify-center">
        <x-uploader
            file-model="{{ $model }}"
            only=".svg,.jpg,.jpeg,.png,.svg"
        />
    </x-overlay>
</div>