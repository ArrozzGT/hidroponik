<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
                <i data-lucide="settings" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Profile') }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Kelola informasi akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card card-pad">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card card-pad">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card card-pad">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
