<x-app>
    <div class="container mx-auto">
        <x-main title="Notification">
            @foreach ($this->notifications as $notification)
                <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-100">
                    {{ $notification->data['type'] }}
                </div>
            @endforeach
        </x-main>
    </div>
</x-app>