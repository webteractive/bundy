<x-app-layout>
    <x-page-header title="{{ $this->profile->name }}" />
    
    <div class="relative">
        @if($this->profile->cover)
            <img
                src="{{ $this->profile->cover['banner'] }}"
                class="w-full h-64 object-cover"
            />
        @else
            <x-placeholder-cover />
        @endif

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

        @if($this->profile->dob || $this->profile->hired_on)
            <div class="mt-4 text-sm leading-snug">
                @if($this->profile->dob)
                    <div class="inline-flex items-center mr-2">
                        <x-icon-baloon class="inline-block fill-current w-4 h-4 mr-1" />
                        <p class="flex-1 text-sm leading-snug">
                            {{ 'Born ' . $this->profile->dob->format('F d, Y') }}
                        </p>
                    </div>
                @endif

                @if($this->profile->hired_on)
                    <div class="inline-flex items-center mr-2">
                        <x-heroicon-o-calendar class="inline-block w-4 h-4 mr-1" />
                        <p class="flex-1 text-sm leading-snug">
                            {{ 'Hired ' . $this->profile->hired_on->format('F d, Y') }}
                        </p>
                    </div>
                @endif
            </div>
        @endif

        @if($this->profile->address)
            <div class="mt-2 flex">
                <x-heroicon-o-location-marker class="inline-block w-4 h-4 mt-1 mr-1" />
                <p class="flex-1 text-sm leading-snug">
                    {{ $this->profile->address }}
                </p>
            </div>
        @endif

        @if($this->profile->contact_numbers)
            <div class="text-sm text-gray-400 mt-2 leading-snug">
                @foreach($this->profile->contact_numbers as $number)
                    <a
                        href="tel:{{ $number }}"
                        class="
                            leading-none inline-flex items-center p-1 pr-2 rounded-full
                            hover:text-white hover:bg-gray-600
                        "
                        rel="noopener noreferer"
                        target="_blank"
                    >
                        <x-heroicon-o-phone class="inline-block w-4 h-4 mr-1" />
                        <span>{{ $number }}</span>
                    </a>
                @endforeach
            </div>
        @endif
        
        @if($this->profile->links)
            <div class="text-xs text-gray-400 mt-2 leading-snug">
                @foreach($this->profile->links as $link)
                    <a
                        href="{{ $link }}"
                        class="
                            leading-none inline-flex items-center p-1 pr-2 rounded-full font-thin
                            hover:text-white hover:bg-gray-600
                        "
                        rel="noopener noreferer"
                        target="_blank"
                        title="Click to visi {{ $link }}"
                    >
                        <x-heroicon-o-link class="inline-block w-3 h-3 mr-1" />
                        <span>{{ $link }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>