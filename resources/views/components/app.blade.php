@php
$menu = [
  'home' => ['heroicon-s-home'],
  'notification' => ['heroicon-s-bell'],
  'performance' => ['heroicon-s-heart'],
  'profile' => ['heroicon-s-user-circle'],
];
@endphp

<nav class="bg-white shadow">
  <div class="container mx-auto flex justify-between">
    <div class="flex">
      @foreach ($menu as $route => $item)
        <a
          href="{{ route($route) }}"
          class="
            px-4 py-2 border-b-2 
            @if (Route::current()->getName() == $route)
              border-black
            @else
              border-white
              text-gray-500
              hover:border-gray-500
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