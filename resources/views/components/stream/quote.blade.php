@php
    $user = (object) [
        'name' => $data->user->name,
        'username' => Str::slug($data->user->name)
    ]
@endphp

<span class="absolute font-thin leading-none px-2 py-1 right-4 top-0 text-xs bg-gray-400 dark:bg-gray-600 bg-opacity-50">Quote</span>

<x-stream.base
    :data="$data"
    :custom-user="$user"
    :timestamped="false"
>
    <p>{{ $data->message }}</p>
</x-stream.base>
