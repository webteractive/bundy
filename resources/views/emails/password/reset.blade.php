@component('mail::message')

Hey {{ $user->first_name }},

We have changed your password as per your request and we have attached it here.
Use this password to login in order for you to change it to your liking.

New Password: `{{ $password }}`

Cheers,<br>
{{ config('app.name') }}
@endcomponent