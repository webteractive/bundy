@php
    $user = (object) [
        'name' => 'Bundy',
        'username' => 'bundy',
        'icon' => 'heroicon-o-speakerphone'
    ];

    $timeTitle = '';
    if ($data->late) {
        $timeTitle = $data->tardiness . ' late';
    } else if ($data->early_bird) {
        $timeTitle = $data->punctuality . ' early';
    }
@endphp

<x-stream.base
    :data="$data"
    :custom-user="$user"
>
    <div class="flex items-center flex-wrap">
        <a href="{{ route('tall.profile', ['username' => $data->user->username]) }}" class="inline-flex items-end hover:underline">
            <x-avatar :user="$data->user" size="extrasmall" />
            <span class="leading-none tracking-wide font-bold pl-1">{{ $data->user->name }}</span>
        </a>

        <span class="mx-1">{{ __('has clocked in at') }}</span>
        
        <span
            class="
                mx-1 font-bold
                @if($data->late)
                    text-red-500 hover:underline
                @elseif($data->on_time)
                    text-blue-500
                @elseif($data->early_bird)
                    text-green-500 hover:underline
                @endif
            "
            title="{{ $timeTitle }}"
        >
            {{ $data->started_at->format('g:i:s A') }}.
        </span>
    </div>

    {{-- @dump($data) --}}
</x-stream.base>