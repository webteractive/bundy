<div id="edit-profile">
    <x-page-header
        title="Edit Profile"
        back-url="{{ route('tall.profile', ['username' => auth()->user()->username]) }}"    
    >
        <x-slot name="actions">
            <div>
                <x-button
                    type="button"
                    wire:click.prevent="save"
                    wire:target="save"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.class="hidden" wire:target="save">{{ __('Save Changes') }}</span>
                    <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
                </x-button>
            </div>
        </x-slot>
    </x-page-header>

    <x-toast class="px-4" />

    <div class="relative pb-24">
        <x-fields.cover
            model="coverFile"
            :file="$coverFile"
            :profile="$this->profile"
        />

        <x-fields.photo
            :file="$photoFile"
            model="photoFile"
            current="{{ optional($this->profile->photo)['small'] }}"
        />
    </div>

    <div class="p-4">
        <div class="mt-6 grid grid-cols-2 gap-4">
            <div>
                <x-field-wrapper for="firstName" label="First Name" required>
                    <x-fields.text
                        placeholder=""
                        wire:model="firstName"
                    />
                </x-field-wrapper>
            </div>

            <div>
                <x-field-wrapper for="lastName" label="Last Name" required>
                    <x-fields.text
                        placeholder=""
                        wire:model="lastName"
                    />
                </x-field-wrapper>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4">
            <div>
                <x-field-wrapper for="username" label="Username" required>
                    <x-fields.text
                        placeholder=""
                        wire:model="username"
                    />
                </x-field-wrapper>
            </div>

            <div>
                <x-field-wrapper for="alias" label="Alias">
                    <x-fields.text
                        placeholder=""
                        wire:model="alias"
                    />
                </x-field-wrapper>
            </div>
        </div>

        <x-field-wrapper class="mt-6" for="bio" label="Bio">
            <x-fields.textarea
                wire:model="bio"
                rows="5"
            />
        </x-field-wrapper>

        <x-field-wrapper class="mt-6" for="address" label="Address">
            <x-fields.textarea
                wire:model="address"
                rows="4"
            />
        </x-field-wrapper>

        <x-field-wrapper class="mt-6" for="contactNumbers" label="Contact Numbers">
            <x-fields.list 
                :items="$contactNumbers"
                name="contactNumbers"
                icon="heroicon-o-phone"
            />
        </x-field-wrapper>

        <x-field-wrapper class="mt-6" for="links" label="Links">
            <x-fields.list 
                :items="$links"
                name="links"
                icon="heroicon-o-link"
            />
        </x-field-wrapper>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function listField() {
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
@endonce