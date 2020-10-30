<button
    type="button"
    class="flex w-full items-center mt-2 p-2 rounded-full hover:bg-gray-700"
>
    <img
        class="rounded-full"
        src="{{ auth()->user()->photo['smallest'] }}"
        alt="{{ auth()->user()->name }}"
    />
    <span class="text-left flex-1 pl-2 pr-4 text-base leading-none">
        <span class="block text-sm mb-1">{{ auth()->user()->name }}</span>
        <span class="block text-xs">{{ '@' . auth()->user()->username }}</span>
    </span>

    <x-heroicon-o-chevron-down class="inline-block w-4 h-4" />
</button>