@php
$redirect = '';
if(auth()->user()->hasRole('admin')) $redirect = route('admin.dashboard');
elseif(auth()->user()->hasRole('pembeli')) $redirect = route('pembeli.dashboard');
elseif(auth()->user()->hasRole('petani')) $redirect = route('petani.dashboard');
@endphp

@if($redirect)
    <script>window.location.href = '{{ $redirect }}';</script>
@else
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">{{ __("You're logged in!") }}</div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
