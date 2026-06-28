@extends('layouts.admin')
@section('page', 'Manajemen User')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                <i data-lucide="users" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">{{ __('Manajemen User') }}</h2>
                <p class="text-sm text-gray-600 mt-0.5">Kelola semua pengguna SIPSH</p>
            </div>
        </div>
        <a href="{{ route('admin.users.petani-pending') }}" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
            <i data-lucide="user-check" style="width:16px;height:16px;" aria-hidden="true"></i>
            {{ __('Verifikasi Petani') }}
        </a>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Manajemen User']]" />

        <x-ui.card>
            <div class="hidden md:block overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar size="md" fallback="{{ strtoupper(substr($user->name, 0, 1)) }}" />
                                        <span class="font-medium text-sm text-gray-900 truncate max-w-[160px]">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-sm text-gray-600">{{ $user->email }}</td>
                                <td>
                                    @php $rc = $user->hasRole('petani') ? 'success' : 'default'; @endphp
                                    <x-ui.badge :variant="$rc">{{ ucfirst($user->getRoleNames()->first()) }}</x-ui.badge>
                                </td>
                                <td>
                                    @php $us = $user->status === 'aktif' ? 'success' : 'danger'; @endphp
                                    <x-ui.badge :variant="$us">{{ ucfirst($user->status) }}</x-ui.badge>
                                </td>
                                <td class="text-xs text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-gray-600 hover:text-gray-900 text-xs font-medium px-3 py-1.5 hover:bg-gray-50 rounded-lg transition-colors">
                                                {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 text-xs font-medium px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1">
                                                <i data-lucide="trash-2" style="width:11px;height:11px;" aria-hidden="true"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-empty-state icon="users" title="Tidak ada user" description="Belum ada pengguna terdaftar." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-3">
                @forelse($users as $user)
                    @php $rc = $user->hasRole('petani') ? 'success' : 'default'; $us = $user->status === 'aktif' ? 'success' : 'danger'; @endphp
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-3">
                            <x-ui.avatar size="md" fallback="{{ strtoupper(substr($user->name, 0, 1)) }}" />
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600 truncate">{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <x-ui.badge :variant="$rc">{{ ucfirst($user->getRoleNames()->first()) }}</x-ui.badge>
                                <x-ui.badge :variant="$us">{{ ucfirst($user->status) }}</x-ui.badge>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 border-t border-gray-100 pt-3">
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full text-gray-600 hover:text-gray-900 text-xs font-medium px-3 py-2 hover:bg-gray-50 rounded-lg transition-colors">
                                    {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 text-red-700 hover:bg-red-200 text-xs font-medium px-3 py-2 rounded-lg transition-colors inline-flex items-center justify-center gap-1">
                                    <i data-lucide="trash-2" style="width:11px;height:11px;" aria-hidden="true"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <x-empty-state icon="users" title="Tidak ada user" description="Belum ada pengguna terdaftar." />
                @endforelse
            </div>
            <div class="mt-5">
                {{ $users->links() }}
            </div>
        </x-ui.card>
    </div>
@endsection
