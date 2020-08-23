<x-app>
    <div class="container mx-auto">
        <div class="flex">
            <div class="bg-white shadow w-8/12">
                <div class="relative mb-16">
                    <img class="z-10 object-cover h-64 w-full" alt="cover" src="{{ $this->profile->cover['banner'] }}" />

                    <div class="absolute h-24 w-24 left-4 -mt-12 border-2 border-white bg-gray-200">
                        <img class="object-cover h-24 w-24" alt="cover" src="{{ $this->profile->photo['original'] }}" />
                    </div>

                    <x-action style="outline-rounded" class="absolute right-4">
                        {{ __('Edit Profile') }}
                    </x-action>
                </div>

                <div class="px-4 pb-2 text-gray-900">
                    <div class="mt-1">
                        {{ $this->profile->bio }}
                    </div>
    
                    @if ($this->profile->address)
                        <div class="mt-1">
                            <x-heroicon-s-location-marker class="w-4 h-4 fill-current mr-1 inline-block" />
                            {{ $this->profile->address }}
                        </div>
                    @endif

                    @if ($this->profile->contact_numbers)
                        <div class="mt-1">
                            @foreach ($this->profile->contact_numbers as $number)
                                <div class="text-gray-600 inline-flex items-center hover:underline hover:text-gray-800">
                                    <x-heroicon-s-phone class="w-4 h-4 fill-current mr-1 inline-block" />
                                    {{ $number }}
                                </div>
                            @endforeach
                        </div>
                    @endif
    
                    @if ($this->profile->links)
                        <div class="mt-1">
                            @foreach ($this->profile->links as $link)
                                <a href="{{ $link }}" class="text-gray-600 inline-flex items-center hover:underline hover:text-gray-800">
                                    <x-heroicon-s-external-link class="w-4 h-4 fill-current mr-1 inline-block" />
                                    {{ $link }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app>