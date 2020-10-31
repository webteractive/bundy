<input
    type="{{ $type ?? 'text' }}"
    class="
        block h-12 w-full rounded-lg outline-none
         px-4 text-lg bg-gray-600 text-gray-900
        {{ $class ?? '' }}
    "
    {{ $attributes->except('type', 'class') }}
/>