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
        {{-- Scroll Progress Bar --}}
        <div class="scroll-progress" aria-hidden="true"></div>

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

        {{-- Back to Top --}}
        <button class="back-to-top fixed bottom-6 right-6 z-50 w-10 h-10 rounded-full bg-emerald-600 text-white shadow-lg flex items-center justify-center transition-all duration-300 opacity-0 invisible hover:bg-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2" aria-label="Kembali ke atas">
            <i data-lucide="chevron-up" class="h-5 w-5" aria-hidden="true"></i>
        </button>

        @if(session('success'))<div data-toast="success" data-message="{{ session('success') }}"></div>@endif
        @if(session('error'))<div data-toast="error" data-message="{{ session('error') }}"></div>@endif
        <x-toast />
    </body>
</html>
