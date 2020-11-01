<div id="scrum">
    @if($this->shown)
        <div class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">        
            <div
                @if(! $this->notYet)
                    x-data
                    x-on:click.away="$wire.close()"
                @endif
                class="w-500 min-h-56"
            >
                <div class="bg-gray-800 rounded-lg">
                    <div class="h-16 flex items-center px-4 border-b border-gray-700">
                        <h2 class="font-bold leading-none tracking-wider text-xl flex-1">
                            <span>{{ __('Scrum') }}</span>
                        </h2>

                        <div>
                            @if(! $this->notYet)
                                <x-outlined-button
                                    tag="button"
                                    type="button"
                                    wire:click.prevent="close"
                                    wire:target="save"
                                    wire:loading.attr="disabled"
                                >
                                    {{ __('Cancel') }}
                                </x-outlined-button>
                            @endif

                            <x-button
                                type="button"
                                wire:click.prevent="save"
                                wire:target="save"
                                wire:loading.attr="disabled"
                            >                                
                                <span wire:loading.class="hidden" wire:target="save">{{ __($this->buttonLabel) }}</span>
                                <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
                            </x-button>
                        </div>
                    </div>

                    <x-toast class="px-4" />

                    <div class="p-4 pb-6">
                        <p class="mb-4 text-xs font-thin tracking-wide leading-snug">
                            {{ __('Fields marked with * (asterisk) are required.') }}<br/>
                            {{ __('Type in to the input and hit return/enter key to add items.') }}
                        </p>

                        <x-field-wrapper for="yesterday" label="Yesterday">
                            <p class="text-xs italic font-thin leading-none mb-2">
                                {{ __('What did you do and accomplished yesterday?') }}
                            </p>
                            
                            <x-fields.scrum 
                                :items="$yesterday"
                                name="yesterday"
                                icon="heroicon-o-check-circle"
                                icon-class="inline-block w-5 h-5 mr-1 text-green-700"
                            />
                        </x-field-wrapper>

                        <x-field-wrapper class="mt-6" for="blockers" label="Blockers">
                            <p class="text-xs italic font-thin leading-snug mb-2">
                                {{ __('What did stop you for completing your tasks yesterday?') }}<br />
                                {{ __('Leave it empty if no encountered blockers.') }}
                            </p>
                            
                            <x-fields.scrum 
                                :items="$blockers"
                                name="blockers"
                                icon="heroicon-o-thumb-down"
                                icon-class="inline-block w-5 h-5 mr-1 text-red-700"
                            />
                        </x-field-wrapper>

                        <x-field-wrapper class="mt-6" required for="today" label="Today">
                            <p class="text-xs italic font-thin leading-none mb-2">
                                {{ __('What will you do today?') }}
                            </p>
                            
                            <x-fields.scrum 
                                :items="$today"
                                name="today"
                                icon="heroicon-o-information-circle"
                                icon-class="inline-block w-5 h-5 mr-1 text-gray-900"
                            />
                        </x-field-wrapper>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        function scrum() {
            return {
                append (event, wire) {
                    var element = event.target;
                    var field = element.dataset.field;

                    wire.appendTo(field, element.value);

                    element.value = ''
                    element.focus()
                },

                remove (field, index, wire, message) {
                    if (confirm(message)) {
                        wire.removeFrom(field, index)
                    }
                }
            }
        }
    </script>
@endpush


