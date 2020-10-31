<textarea
    class="
        block w-full bg-gray-600 rounded-lg outline-none
        text-gray-900 py-3 px-4
        {{ $class ?? '' }}
    "
    {{ $attributes->except('class') }}
></textarea>