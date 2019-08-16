@component('mail::message')

Hey {{ $user->first_name }},

Your password has been changed! Attached herein is the copy of your new password just in case ;-)

Password: `{{ $password }}`

Cheers,<br>
{{ config('app.name') }}
@endcomponent