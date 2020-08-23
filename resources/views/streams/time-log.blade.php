<x-stream class="{{ $stream->late ? 'bg-red-50 border-red-100 hover:bg-red-100 hover:border-red-200' : '' }}">
  <div class="w-20 h-20 bg-gray-300">

  </div>

  <div class="pl-4">
    <h3 class="flex items-center mb-2">
      <span class="font-bold tracking-wide">{{ __('Bundy') }}</span>
      <span class="px-2">&middot;</span>
      <time class="text-gray-500 text-sm" datetime="{{ $stream->stream_date }}" title="{{ $stream->stream_date }}">{{ $stream->stream_date->diffForHumans() }}</time>
    </h3>

    <p>
      <a href="{{ $stream->user->profile_url }}" class="font-bold tracking-wide hover:underline">{{ $stream->user->name }}</a> {{ __('has clocked in at') }} <time class="font-bold" datetime="{{ $stream->created_at }}" title="{{ $stream->created_at }}">{{ $stream->created_at->format('h:m A') }}</time>.
    </p>
  </div>
</x-stream>