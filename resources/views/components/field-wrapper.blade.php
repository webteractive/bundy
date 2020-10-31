<div {{ $attributes->except('for') }}>
    <label for="{{ $for }}" class="block mb-1">
        <span class="text-gray-400">{{ __($label) }}</span>
        @if(isset($required) && $required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    {{ $slot }}

    @error($for)
        <p class="mt-1 italic text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>