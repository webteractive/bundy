@php
$menu = [
  'home' => ['heroicon-s-home', route('home')],
  'profile' => ['heroicon-s-user-circle', route('me')],
  'notification' => ['heroicon-s-bell', route('notification')],
  'performance' => ['heroicon-s-heart', route('performance')],
];
@endphp

<nav class="bg-white shadow sticky top-0 z-50">
  <div class="container mx-auto flex justify-between">
    <div class="flex">
      @foreach ($menu as $route => $item)
        <a
          href="{{ $item[1] }}"
          class="
            px-4 py-3 border-b-2 
            @if (Route::current()->getName() == $route)
              border-black
            @else
              border-white
              text-gray-300
              hover:text-gray-900
              hover:border-gray-900
            @endif
          "
        >
          @svg($item[0], 'w-6 h-6 inline-block fill-current')
        </a>
      @endforeach
    </div>

    <div>

    </div>
  </div>
</nav>

<main class="py-4">
  {{ $slot }}
</main>