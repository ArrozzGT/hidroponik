<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                <i data-lucide="settings" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">{{ __('Profile') }}</h2>
                <p class="text-sm text-gray-600 mt-0.5">Kelola informasi akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-breadcrumb :crumbs="[['label' => 'Pengaturan Profil']]" />

            <div class="flex border-b border-gray-100 mb-6">
                <a href="#profile" class="px-5 py-3 text-sm font-medium text-emerald-600 border-b-2 border-emerald-600">Profil</a>
                <a href="#password" class="px-5 py-3 text-sm font-medium text-gray-600 hover:text-gray-700 transition-colors">Kata Sandi</a>
                <a href="#delete" class="px-5 py-3 text-sm font-medium text-gray-600 hover:text-gray-700 transition-colors">Hapus Akun</a>
            </div>

            <div id="profile">
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div id="password">
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div id="delete">
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
