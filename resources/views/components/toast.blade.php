@if (session()->has('toast'))
    @php
        $toast = session('toast');
        $type = $toast['type'];
        $message = $toast['message'];
    @endphp
    <div
        x-data
        class="
            @if($type === 'success')
                bg-green-600 text-green-100
            @elseif($type === 'error')
                bg-red-600 text-red-100
            @elseif($type === 'info')
                bg-blue-600 text-blue-100
            @endif
            relative flex items-center py-1 font-thin tracking-wide
            {{ $class ?? '' }}
        "
    >
        <p class="flex-1 leading-snug">{{ $message }}</p>
        <button
            x-on:click.stop="$el.remove()"
            class="absolute top-1 right-4 text-xl leading-none hover:text-red-600"
        >
            &times;
        </button>
    </div>
@endif