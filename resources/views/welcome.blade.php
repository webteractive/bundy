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
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('/css/flatpickr.css') }}">
    </head>
    <body>
        <div id="bundy"></div>
        @pathfinder()
        <script>var BUNDY = {!! json_encode($payload) !!};</script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
