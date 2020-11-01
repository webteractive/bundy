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

                <livewire:widgets.birthdays :sidebar="true" />

                <livewire:widgets.presence />
            </div>
        </div>
    </div>
</div>

<livewire:scrum />