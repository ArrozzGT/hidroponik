<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title') @yield('title') – @endif{{ config('app.name', 'SIPSH') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-body antialiased">
        <div class="min-h-screen bg-white">
            <x-navbar />

            @hasSection('header')
                <div class="border-b border-gray-100 bg-white">
                    <div class="max-w-7xl mx-auto w-full py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </div>
            @elseif(isset($header))
                <div class="border-b border-gray-100 bg-white">
                    <div class="max-w-7xl mx-auto w-full py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main class="py-8 sm:py-12 lg:py-16">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>

        @if(session('success'))<div data-toast="success" data-message="{{ session('success') }}"></div>@endif
        @if(session('error'))<div data-toast="error" data-message="{{ session('error') }}"></div>@endif
        <x-toast />
    </body>
</html>
