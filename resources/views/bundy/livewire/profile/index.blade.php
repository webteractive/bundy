<x-app-layout>
    <x-page-header title="{{ $this->profile->name }}" />
    
    <div class="relative">
        <img
            src="{{ $this->profile->cover['banner'] }}"
            class="w-full h-64 object-cover"
        />

        <x-avatar
            :user="$this->profile"
            size="small"
            class="absolute left-4 -mt-12"
        />

        
        <div class="px-4 h-16 flex items-center justify-end">
            @if(auth()->user()->is($this->profile))
                <x-outlined-button href="{{ route('tall.profile.edit') }}">
                    {{ __('Edit Profile') }}
                </x-outlined-button>
            @endif
        </div>
    </div>

    <div class="px-4">
        <h2 class="text-xl leading-none">
            {{ $this->profile->name }}
            @if($this->profile->alias)
                ({{ $this->profile->alias }})
            @endif
        </h2>

        <div class="mt-1 text-sm text-gray-500">
            <span>{{ '@' . $this->profile->username }}</span>
            @if($this->profile->position)
                <span>|</span>
                <span>{{ $this->profile->position }}</span>
            @endif
        </div>

        @if($this->profile->bio)
            <div class="mt-2 text-sm leading-snug">{{ $this->profile->bio }}</div>
        @endif
        
        @if($this->profile->links)
            <div class="text-xs text-gray-400 mt-2 leading-snug">
                @foreach($this->profile->links as $link)
                    <a
                        href="{{ $link }}"
                        class="pr-1 hover:underline hover:text-white"
                        rel="noopener noreferer"
                        target="_blank"
                    >
                        {{ $link }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($this->profile->contact_numbers)
            <div class="text-xs text-gray-400 mt-2 leading-snug">
                @foreach($this->profile->contact_numbers as $number)
                    <a
                        href="tel:{{ $number }}"
                        class="pr-1 hover:underline hover:text-white"
                        rel="noopener noreferer"
                        target="_blank"
                    >
                        {{ $number }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>