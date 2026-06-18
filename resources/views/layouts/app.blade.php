<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title') @yield('title') – @endif{{ config('app.name', 'SIPSH') }}</title>

        <!-- Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">

        <!-- Lucide Icons -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen gradient-green-subtle">
            <x-navbar />

            @hasSection('header')
                <div class="page-header">
                    <div class="max-w-7xl mx-auto w-full py-1 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </div>
            @elseif(isset($header))
                <div class="page-header">
                    <div class="max-w-7xl mx-auto w-full py-1 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main class="pb-16">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>


    </body>
</html>
