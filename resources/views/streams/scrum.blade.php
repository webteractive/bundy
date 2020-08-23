<x-stream>
  <div class="w-20 h-20 bg-gray-300">

  </div>

  <div class="pl-4 flex-1">
    <div class="flex justify-between">
      <h3 class="flex items-center mb-2">
        <a href="{{ $stream->user->profile_url }}" class="font-bold mr-2 hover:underline tracking-wide">{{ $stream->user->name }}</a>
        <a href="{{ $stream->user->profile_url }}" class="text-gray-500 text-sm hover:text-black hover:underline">{{ join('', ['@', $stream->user->username]) }}</a>
        <span class="px-2">&middot;</span>
        <time class="text-gray-500 text-sm" datetime="{{ $stream->created_at }}" title="{{ $stream->created_at }}">{{ $stream->created_at->diffForHumans() }}</time>
      </h3>

      <div class="flex-0">
        <x-button style="icon"><x-heroicon-s-dots-vertical class="w-6 h-6 fill-current" /></x-button>
      </div>
    </div>

    <div>
      <h4 class="mb-1 font-bold">{{ __('Yesterday') }}</h4>
      @foreach ($stream->yesterday as $item)
        <div class="flex items-center mb-1 text-gray-700 hover:text-black">
          <x-heroicon-s-check-circle class="w-6 h-6 fill-current inline-flex text-green-500" />
          <span class="pl-1">{{ ucfirst($item) }}</span>
        </div>
      @endforeach
    </div>

    @if ($stream->blockers)
      <div class="mt-4">
        <h4 class="mb-1 font-bold">{{ __('Blockers') }}</h4>
        @foreach ($stream->blockers as $item)
          <div class="flex items-center mb-1 text-gray-700 hover:text-black">
            <x-heroicon-s-exclamation-circle class="w-6 h-6 fill-current inline-flex text-red-500" />
            <span class="pl-1">{{ ucfirst($item) }}</span>
          </div>
        @endforeach
      </div>
    @endif

    <div class="mt-4">
      <h4 class="mb-1 font-bold">{{ __('Today') }}</h4>
      @foreach ($stream->today as $item)
        <div class="flex items-center mb-1 text-gray-700 hover:text-black">
          <x-heroicon-s-flag class="w-6 h-6 fill-current inline-flex text-gray-600" />
          <span class="pl-1">{{ ucfirst($item) }}</span>
        </div>
      @endforeach
    </div>
  </div>
</x-stream>