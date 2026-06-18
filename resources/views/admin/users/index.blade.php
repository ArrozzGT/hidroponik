@extends('layouts.admin')
@section('page', 'Manajemen User')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
                <i data-lucide="users" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Manajemen User') }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Kelola semua pengguna SIPSH</p>
            </div>
        </div>
        <a href="{{ route('admin.users.petani-pending') }}" class="btn-primary">
            <i data-lucide="user-check" style="width:16px;height:16px;" aria-hidden="true"></i>
            {{ __('Verifikasi Petani') }}
        </a>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <div class="card overflow-hidden">
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-5 text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="table-wrap overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="hover:bg-green-50/50 transition-colors">
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm" style="background:linear-gradient(135deg,#22c55e,#15803d);">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                            <span class="font-semibold text-sm text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role === 'petani' ? 'badge-green' : 'badge-gray' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $user->status === 'aktif' ? 'badge-green' : 'badge-red' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-ghost text-xs px-3 py-1.5">
                                                    {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger text-xs px-3 py-1.5">
                                                    <i data-lucide="trash-2" style="width:11px;height:11px;" aria-hidden="true"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
