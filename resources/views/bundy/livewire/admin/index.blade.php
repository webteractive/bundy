<div>
    <x-page-header title="Admin" />

    <div class="relative">
        <div class="sticky top-16 h-16 bg-gray-800 z-40 border-b-2 border-gray-700">
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
                        wire:click.prevent="switchTab('{{ $name }}')"
                    >
                        {{ __($label) }}
                    </button>
                @endforeach
            </div>                        
        </div>
    </div>

    @if($tab === 'users')
        <livewire:admin.user />
    @endif

</div>