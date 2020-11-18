<div
    class="mt-6 py-4 {{ $this->present->isEmpty() ? 'hidden' : '' }}"
    @if($this->present->isEmpty())
        x-data
        x-init="$el.remove()"
    @endif
>
    <h2 class="tracking-wider font-thin text-xs mb-4">
        <span>{{ __('Present') }}</span>
        <span title="{{ now()->format('F d, Y') }}">{{ __('Today') }}</span>
    </h2>

    @foreach($this->present as $key => $log)
        <div class="inline-block relative">
            <x-avatar :user="$log->user" size="smallest" class="z-0" />
            <span
                class="
                    inline-block rounded-full w-3 h-3 z-10 absolute top-0 right-0 -mr-1
                    @if($log->late)
                        bg-red-500
                    @elseif($log->on_time)
                        bg-blue-500
                    @elseif($log->early_bird)
                        bg-green-500
                    @endif
                "
            ></span>
        </div>
    @endforeach
</div>
