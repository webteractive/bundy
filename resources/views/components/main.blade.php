<div class="flex justify-between">
  <div class="bg-white shadow w-8/12">
    @empty($head)
      @if ($title)
        <h2 class="py-3 px-4 text-xl border-b border-gray-100">{{ __($title) }}</h2>
      @endif
    @else
      {{ $head }}
    @endempty

    {{ $slot }}
  </div>

  <div class="w-4/12 pl-4 sticky top-16 z-40 self-start">
    <div class="bg-white shadow">
      <h3 class="px-4 py-3 text-xl">Should float</h3>
    </div>

    
  </div>

</div>