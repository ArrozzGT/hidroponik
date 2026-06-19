@extends('layouts.admin')
@section('page', 'Log Aktivitas')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="scroll-text" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Log Aktivitas Sistem') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Semua aktivitas yang tercatat</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Log Aktivitas']]" />

        <x-ui.card>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.logs.index') }}" class="flex items-center gap-3 mb-5">
                    <div>
                        <select name="action" class="form-input text-sm" onchange="this.form.submit()">
                            <option value="">Semua Aksi</option>
                            <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>Logout</option>
                            <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                            <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                            <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                            <option value="checkout" {{ request('action') === 'checkout' ? 'selected' : '' }}>Checkout</option>
                            <option value="payment" {{ request('action') === 'payment' ? 'selected' : '' }}>Payment</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors">Filter</button>
                </form>

                <div class="table-wrap overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr x-data="{ open: false }">
                                    <td class="whitespace-nowrap text-xs text-gray-400">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System/Guest' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $log->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @php
                                            $av = in_array($log->action, ['login', 'checkout', 'payment']) ? 'success' : 'default';
                                        @endphp
                                        <x-ui.badge :variant="$av">{{ str_replace('_', ' ', $log->action) }}</x-ui.badge>
                                    </td>
                                    <td class="text-sm text-gray-500 max-w-xs">
                                        <button @click="open = !open" class="text-left cursor-pointer hover:text-gray-700">
                                            <span x-show="!open" class="truncate block max-w-[200px]">{{ \Illuminate\Support\Str::limit($log->description, 60) }}</span>
                                            <span x-show="open" class="block">{{ $log->description }}</span>
                                            @if(strlen($log->description) > 60)
                                                <span x-text="open ? 'Lebih sedikit' : 'Selengkapnya'" class="text-xs text-emerald-600 hover:underline ml-1"></span>
                                            @endif
                                        </button>
                                    </td>
                                    <td class="whitespace-nowrap text-xs text-gray-300 font-mono">{{ $log->ip_address }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <x-empty-state icon="scroll-text" title="Belum ada log" description="Log aktivitas akan muncul di sini." />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $logs->links() }}
                </div>
            </div>
        </x-ui.card>
    </div>
@endsection
