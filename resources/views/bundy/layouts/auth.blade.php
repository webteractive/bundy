<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bundy by Webteractive</title>
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=VT323&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Codystar&display=swap" rel="stylesheet">
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('/css/flatpickr.css') }}" rel="stylesheet">
        <livewire:styles />
    </head>
    <body class="bg-gray-800 text-white">
        {{ $slot }}
        <livewire:scripts />
    </body>
</html>
