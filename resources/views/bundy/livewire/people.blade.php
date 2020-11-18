@section('title', 'People')

<div id="people">
    <x-page-header title="People">
    
        <x-slot name="actions">
            <div>
                <input
                    wire:model.debounce.500ms="search"
                    type="text"
                    placeholder="Search here"
                    class="bg-gray-700 h-8 px-4 rounded-full outline-none"
                />
            </div>
        </x-slot>
    </x-page-header>

    @foreach($this->people as $someone)
        <div class="relative px-4 py-3 flex border-b border-gray-700">
            <x-avatar
                :user="$someone"
                size="small"
                class="flex-0"
            />

            <div class="flex-1 pl-4">
                <h2 class="leading-tight">
                    <a
                        href="{{ route('tall.profile', ['username' => $someone->username]) }}"
                        class="hover:underline"
                    >
                        {{ $someone->name }}
                    </a>
                </h2>
                <h3 class="text-gray-500 text-xs">
                    <span>{{ '@' . $someone->username }}</span>
                    @if($someone->alias)
                        <span>/</span>
                        <span>{{ $someone->alias }}</span>
                    @endif
                </h3>

                <div class="mt-2 text-sm">
                    @if($someone->position)
                        <x-people-item icon="heroicon-s-user">
                            <span>{{ $someone->position }}</span>
                            @if($someone->level)
                                <span class="ml-1">({{ $someone->level }})</span>
                            @endif
                        </x-people-item>
                    @endif

                    @if($someone->hired_on)
                        <x-people-item icon="heroicon-s-calendar">
                            <span>Hired {{ $someone->hired_on->format('F d, Y') }}</span>
                        </x-people-item>
                    @endif

                    <x-people-item icon="heroicon-s-at-symbol">
                        <a href="mailto:{{ $someone->email }}">{{ $someone->email }}</a>
                    </x-people-item>

                    @if($someone->address)
                        <x-people-item icon="heroicon-s-location-marker">
                            <span>{{ $someone->address }}</span>
                        </x-people-item>
                    @endif

                    @if($someone->dob)
                        <x-people-item icon="heroicon-s-cake">
                            <span>Born {{ $someone->dob->format('jS \o\f F') }}</span>
                        </x-people-item>
                    @endif

                    @if($someone->contact_numbers)
                        <x-people-item icon="heroicon-s-phone">
                            <span>{{ join(', ', $someone->contact_numbers) }}</span>
                        </x-people-item>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @if($this->people->isEmpty())
        <x-empty-placeholder message="No search results found for `{{ $search }}`." />
    @endif
</div>