@extends('layouts.admin')
@section('page', 'Log Aktivitas')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
            <i data-lucide="scroll-text" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Log Aktivitas Sistem') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Semua aktivitas yang tercatat</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <div class="card overflow-hidden">
            <div class="p-6">
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
                            @foreach($logs as $log)
                                <tr>
                                    <td class="whitespace-nowrap text-xs text-gray-400">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System/Guest' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $log->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <span class="badge {{ $log->action === 'login' || $log->action === 'checkout' ? 'badge-green' : 'badge-gray' }}">
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td class="text-sm text-gray-500">{{ $log->description }}</td>
                                    <td class="whitespace-nowrap text-xs text-gray-300 font-mono">{{ $log->ip_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
