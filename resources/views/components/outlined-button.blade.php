@props([
    'tag' => 'a'
])


<{{ $tag }}
    class="
        inline-flex items-center justify-center h-10 px-6 border border-gray-600
        rounded-full text-gray-500 hover:border-white hover:text-white
    "
    {{ $attributes->except('tag', 'class') }}
>
    {{ $slot }}
</{{ $tag }}>