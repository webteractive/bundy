<x-app>
    <div class="container mx-auto">
        Notifications
        @foreach ($this->Notifications as $notification)
            <div>@dump($notification)</div>
        @endforeach
    </div>
</x-app>