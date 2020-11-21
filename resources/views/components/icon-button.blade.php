@props([
    'icon',
    'class',
    'tag' => 'button'
])

<{{ $tag }}
    {{ $tag == 'button' ? 'type="button"' : '' }}
    class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 {{ $class ?? '' }}"
    {{ $attributes->except('type', 'class', 'icon') }}
>
    @svg($icon, 'inline-block w-4 h-4')
</{{ $tag }}>