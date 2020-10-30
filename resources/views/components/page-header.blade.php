<div class="sticky top-0 z-50">
    <div class="bg-gray-800 h-16 flex items-center border-b border-gray-600 px-4">
        <x-icon-button
            icon="heroicon-o-arrow-left"
            class="mr-4"
            tag="a"
            href="{{ $backUrl ?? route('tall.home') }}"
        />

        <h2 class="font-bold tracking-wide text-xl flex-1">{{ $title ?? '' }}</h2>

        {{ $actions ?? '' }}
    </div>
</div>