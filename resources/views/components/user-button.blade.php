<div class="flex items-center h-16">
    <button
        type="button"
        class="flex w-full items-center p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700"
    >
        <img
            class="rounded-full"
            src="{{ auth()->user()->photo['smallest'] }}"
            alt="{{ auth()->user()->name }}"
        />
        <span class="text-left flex-1 pl-2 pr-4">
            <span class="leading-none block text-sm mb-1">{{ auth()->user()->alias ?? auth()->user()->first_name }}</span>
            <span class="leading-none block text-xs">{{ '@' . auth()->user()->username }}</span>
        </span>

        <x-heroicon-o-chevron-down class="inline-block w-4 h-4" />
    </button>
</div>