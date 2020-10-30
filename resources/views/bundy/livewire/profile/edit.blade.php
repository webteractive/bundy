<x-app-layout>
    <x-page-header
        title="Edit Profile"
        back-url="{{ route('tall.profile', ['username' => auth()->user()->username]) }}"
    
    >
        <x-slot name="actions">
            <div>
                <x-outlined-button tag="button" type="button">
                    {{ __('Save Changes') }}
                </x-outlined-button>
            </div>
        </x-slot>
    </x-page-header>
</x-app-layout>