@extends('layouts.admin')
@section('page', 'Laporan')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
            <i data-lucide="bar-chart-2" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Laporan Transaksi</h2>
            <p class="text-sm text-gray-500 mt-0.5">Filter dan unduh laporan transaksi toko</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Laporan']]" />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-ui.card padding="lg">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Filter & Unduh Laporan</h3>
                <form action="{{ route('admin.reports.excel') }}" method="GET" class="space-y-5" id="report-form">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input id="start_date" name="start_date" type="date" class="form-input {{ $errors->has('start_date') ? 'border-red-400' : '' }}" required>
                            @error('start_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input id="end_date" name="end_date" type="date" class="form-input {{ $errors->has('end_date') ? 'border-red-400' : '' }}" required>
                            @error('end_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="type" class="form-label">Jenis Laporan</label>
                        <select name="type" id="type" class="form-input">
                            <option value="penjualan">Laporan Penjualan</option>
                            <option value="stok">Laporan Stok Produk</option>
                            <option value="aktivitas">Laporan Aktivitas</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors flex-1 flex items-center justify-center gap-2">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4" aria-hidden="true"></i>
                            Excel
                        </button>
                        <button type="button" onclick="downloadPdf()" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 text-sm rounded-lg font-medium transition-colors flex-1 flex items-center justify-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4" aria-hidden="true"></i>
                            PDF
                        </button>
                    </div>
                </form>
            </x-ui.card>

            <x-ui.card class="p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-5 bg-green-700 rounded-full"></span>
                    Riwayat Laporan
                </h3>
                <div class="space-y-3">
                    @forelse($laporan as $lap)
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $lap->jenis_laporan === 'pdf' ? 'bg-red-100' : 'bg-green-100' }}">
                                <i data-lucide="{{ $lap->jenis_laporan === 'pdf' ? 'file-text' : 'file-spreadsheet' }}"
                                   class="w-4 h-4 {{ $lap->jenis_laporan === 'pdf' ? 'text-red-600' : 'text-green-600' }}" aria-hidden="true"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-900 uppercase">{{ $lap->jenis_laporan }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $lap->periode_awal ? $lap->periode_awal->format('d/m/Y') : 'Semua' }}
                                    – {{ $lap->periode_akhir ? $lap->periode_akhir->format('d/m/Y') : 'Semua' }}
                                </p>
                            </div>
                            <span class="text-[10px] text-gray-500">{{ $lap->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic text-center py-8">Belum ada riwayat laporan.</p>
                    @endforelse
                </div>
                @if($laporan->hasPages())
                    <div class="mt-4">{{ $laporan->links() }}</div>
                @endif
            </x-ui.card>
        </div>
    </div>

    <script>
        function downloadPdf() {
            const form = document.getElementById('report-form');
            const baseUrl = "{{ route('admin.reports.pdf') }}";
            const params = new URLSearchParams(new FormData(form)).toString();
            window.location.href = baseUrl + '?' + params;
        }
    </script>
@endsection
