@section('title', "{$this->profile->name}'s Profile")

<div id="profile">
    <x-page-header title="{{ $this->profile->name }}" />

    <div class="relative">
        @if($this->profile->cover)
            <img
                src="{{ $this->profile->cover['banner'] }}"
                class="w-full h-64 object-cover"
            />
        @else
            <x-image-placeholder class="h-64" />
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

    <div class="px-4 mb-6">
        <h2 class="text-xl leading-none">
            {{ $this->profile->name }}
            @if($this->profile->alias)
                ({{ $this->profile->alias }})
            @endif
        </h2>

        <div class="mt-1 text-sm text-gray-500">
            @if($this->profile->position)
                <span>{{ $this->profile->position }}</span>
                <span>/</span>
            @endif

            <span>{{ '@' . $this->profile->username }}</span>
        </div>

        @if($this->profile->bio)
            <div class="mt-4 text-sm leading-snug">{{ $this->profile->bio }}</div>
        @endif

        @if($this->profile->dob || $this->profile->hired_on)
            <div class="mt-4 text-sm leading-snug">
                @if($this->profile->dob)
                    <div class="inline-flex items-center mr-2">
                        <x-heroicon-s-cake class="inline-block text-blue-500 w-4 h-4 mr-1" />
                        <p class="flex-1 text-sm leading-snug">
                            {{ 'Born ' . $this->profile->dob->format('jS \o\f F') }}
                        </p>
                    </div>
                @endif

                @if($this->profile->hired_on)
                    <div class="inline-flex items-center mr-2">
                        <x-heroicon-o-calendar class="inline-block text-blue-500 w-4 h-4 mr-1" />
                        <p class="flex-1 text-sm leading-snug">
                            {{ 'Hired ' . $this->profile->hired_on->format('F d, Y') }}
                        </p>
                    </div>
                @endif
            </div>
        @endif

        @if($this->profile->address)
            <div class="mt-2 flex">
                <x-heroicon-o-location-marker class="inline-block text-blue-500 w-4 h-4 mt-1 mr-1" />
                <p class="flex-1 text-sm leading-snug">
                    {{ $this->profile->address }}
                </p>
            </div>
        @endif

        <div class="mt-2 flex text-sm">
            <x-heroicon-o-at-symbol class="inline-block text-blue-500 w-4 h-4 mt-1 mr-1" />
            <a
                href="mailto:{{ $this->profile->email }}"
                class="
                    leading-none inline-flex items-center py-1 px-2 rounded-full
                    hover:text-white hover:bg-gray-600
                "
            >
                {{ $this->profile->email }}
            </a>
        </div>

        @if($this->profile->contact_numbers)
            <div class="flex items-start text-sm text-gray-400 mt-2 leading-snug">
                <span class="mr-1"><x-heroicon-o-phone class="inline-block text-blue-500 w-4 h-4" /></span>
                <div>
                    @foreach($this->profile->contact_numbers as $number)
                        <a
                            href="tel:{{ $number }}"
                            class="
                                leading-none inline-flex items-center py-1 px-2 rounded-full
                                hover:text-white hover:bg-gray-600
                            "
                            rel="noopener noreferer"
                            target="_blank"
                        >
                            <span>{{ $number }}</span>
                        </a>
                    @endforeach
                </div>
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

    <div class="relative">
        <div class="md:sticky md:top-16 h-16 bg-gray-800 z-40 border-b-2 border-gray-700">
            <div class="flex text-lg">
                @foreach($this->tabs as $name => $label)
                    <button
                        type="button"
                        class="
                            flex-1 h-16 inline-flex justify-center items-center cursor-pointer border-b-2
                            @if($tab === $name)
                                border-white text-white
                            @else
                            border-transparent text-gray-500 hover:text-gray-400 hover:border-gray-400
                            @endif
                        "
                        wire:click.prevent="switchTab('{{ $username }}', '{{ $name }}')"
                    >
                        {{ __($label) }}
                    </button>
                @endforeach
            </div>                        
        </div>

        <div class="min-h-screen">
            @if ($tab === '')
                <livewire:stream :username="$username" :in-the-profile-page="true" />
            @else
                <x-empty-placeholder />
            @endif
        </div>
    </div>
</div>