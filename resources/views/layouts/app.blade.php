<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
        <title>@hasSection('title')@yield('title') &times; @endif Bundy by Webteractive</title>
        <link rel="preconnect" href="https://unpkg.com/" crossorigin>
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=VT323&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Codystar&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
        <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet">
        <livewire:styles />
        @stack('styles')
        <livewire:scripts />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
        @stack('headscripts')
    </head>
    <body class="bg-gray-800 text-white">
        <div id="app">
            <div class="container mx-auto">
                <div class="md:grid md:grid-cols-12">
                    <div class="hidden md:block md:col-span-3 md:border-gray-700 md:border-r">
                        <div class="sticky top-0 px-4">
                            <x-sidebar-left />
                        </div>
                    </div>
                    
                    <div class="md:col-span-6">
                        {{ $slot }}
                    </div>
                    
                    <div class="hidden md:block md:col-span-3 md:border-gray-700 md:border-l">
                        <div class="sticky top-0 px-4">
                            <x-user-button />

                            <livewire:widgets.birthdays :sidebar="true" />

                            <livewire:widgets.presence />
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-gray-800 border-t border-gray-700 px-4">
                <div class="container mx-auto flex items-center justify-between h-12">
                    <button>
                        <x-heroicon-s-menu class="inline-block w-8 h-8" />
                    </button>

                    <x-avatar :user="auth()->user()" size="smallest" />
                </div>
            </div>

            <livewire:scrum />
        </div>

        @stack('scripts')
        <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>

        <script>
            NProgress.configure({ showSpinner: false });

            document.addEventListener("DOMContentLoaded", () => {
                Livewire.hook('message.sent', (message, component) => {
                    NProgress.done(true);
                    NProgress.start();
                })
                
                Livewire.hook('message.processed', (message, component) => {
                   NProgress.done(true);
                })
            });
        </script>


    </body>
</html>
