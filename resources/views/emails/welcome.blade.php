@component('mail::message')

Hey {{ $user->first_name }},

Welcome to Bundy! We are thrilled to have you on board. We have attached herein your account to login to Bundy, see below.

Email: {{ $user->email }}<br/>
Password: `{{ $password }}`

Cheers,<br>
{{ config('app.name') }}
@endcomponent