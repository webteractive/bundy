<div {{ $attributes }}>
    @isset($header)
        {{ $header }}
    @else
        @isset($title)
            <x-h2>{{ $title }}</x-h2>
        @endisset
    @endisset

    {{ $slot }}
</div>