{{-- <div class="relative container mx-auto">
    <x-sidebar-left />

    <div class="max-w-lg min-h-screen mx-auto border-r border-l border-gray-700">
        {{ $slot }}
    </div>

    <div class="absolute right-0 top-0 w-240 pl-4 py-2">
        <div class="sticky top-0">
            <x-user-button />
        </div>
    </div>
</div> --}}

<div class="container mx-auto">
    <div class="grid grid-cols-10 gap-4">
        <div class="col-span-2">
            <div class="sticky top-0">
                <x-sidebar-left />
            </div>
        </div>
        
        <div class="col-span-6 border-l border-r border-gray-700">
            {{ $slot }}
        </div>
        
        <div class="col-span-2">
            <div class="sticky top-0">
                <x-user-button />
            </div>
        </div>
    </div>
</div>