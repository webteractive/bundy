@php
  $styles = [
    'icon' => 'text-gray-300 hover-black flex items-center justify-center hover:text-black',
    'outline-rounded' => 'bg-white border px-4 py-2 border-black mt-3 text-black hover:underline'
  ]
@endphp

<a
  href="{{ $href ?? '#' }}"
  {{ $attributes->except(['style', 'type', 'class']) }}
  class="{{ $styles[$style] ?? '' }} {{ $class ?? '' }}"
>
  {{ $slot }}
</a>