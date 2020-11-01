@php
    $theme = collect([
        'bg-green-800 text-green-200 bg-gradient-to-r from-blue-800 to-green-800',
        'bg-blue-800 text-blue-200 bg-gradient-to-r from-purple-800 to-blue-800',
        'bg-pink-800 text-pink-200 bg-gradient-to-r from-blue-800 to-pink-800',
        'bg-yellow-800 text-yellow-200 bg-gradient-to-r from-orange-800 to-yellow-800',
        'bg-orange-800 text-orange-200 bg-gradient-to-r from-red-800 to-orange-800',
        'bg-red-800 text-yellow-200 bg-gradient-to-r from-orange-800 to-yellow-800',
        'bg-teal-800 text-teal-100 bg-gradient-to-r from-blue-800 to-teal-800'
    ])->random();
@endphp

<div
    class="
        {{ $this->celebrants->isEmpty() ? 'hidden' : '' }}
        px-4 py-6 rounded-lg text-xs
        {{ $theme }}
    "
    @if($this->celebrants->isEmpty())
        x-data
        x-init="$el.remove()"
    @endif
>
    <div class="flex flex-wrap justify-center">
        @foreach($this->celebrants as $celebrant)
            <x-avatar
                :user="$celebrant"
                size="small"
                class="m-2"
            />
        @endforeach
    </div>

    <p class="text-center tracking-wide px-4 mt-4">{{ $this->greetings }}</p>
</div>