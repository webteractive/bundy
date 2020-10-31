<div class="relative cover z-40">
    @if($file)
        <img
            src="{{ $file->temporaryUrl() }}"
            class="w-full h-64 object-cover z-0"
        />
    @else
        @if($profile->cover)
            <img
                src="{{ $profile->cover['banner'] }}"
                class="w-full h-64 object-cover z-0"
            />
        @else
            <x-image-placeholder class="h-64 z-0" />
        @endif
    @endif

    <div class="bg-black bg-opacity-50 z-40 absolute inset-0 flex items-center justify-center">
        <x-uploader
            file-model="{{ $model }}"
            only=".svg,.jpg,.jpeg,.png,.svg"
        />
    </div>
</div>