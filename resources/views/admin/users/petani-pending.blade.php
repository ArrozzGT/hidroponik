@extends('layouts.admin')
@section('page', 'Verifikasi Petani')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="user-check" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Verifikasi Petani Baru') }}</h2>
            <p class="text-sm text-gray-600 mt-0.5">Setujui atau tolak permohonan petani</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Manajemen User', 'url' => route('admin.users.index')], ['label' => 'Verifikasi Petani']]" />

        @if($petani->isEmpty())
            <x-empty-state icon="check-circle" title="Tidak ada permohonan verifikasi" description="Semua petani telah terverifikasi." />
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($petani as $p)
                    <x-ui.card>
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-5">
                                @if($p->foto)
                                    <img src="{{ asset('storage/' . $p->foto) }}" class="w-16 h-16 rounded-xl object-cover" loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="w-16 h-16 rounded-xl hidden bg-green-100 items-center justify-center text-green-600 font-bold text-xl">{{ substr($p->name, 0, 1) }}</div>
                                @else
                                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center text-green-600 font-bold text-xl">{{ substr($p->name, 0, 1) }}</div>
                                @endif
                                <div class="min-w-0">
                                    <h3 class="font-bold text-lg text-gray-900 truncate">{{ $p->name }}</h3>
                                    <p class="text-sm text-gray-600 truncate">{{ $p->email }}</p>
                                    <p class="text-sm text-gray-600 truncate">{{ $p->no_hp }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50/50 rounded-xl p-4 space-y-2 mb-5">
                                <p class="text-sm"><span class="font-semibold text-gray-700">Nama Kebun:</span> <span class="text-gray-600">{{ $p->petaniProfile->nama_kebun ?? '-' }}</span></p>
                                <p class="text-sm"><span class="font-semibold text-gray-700">Lokasi:</span> <span class="text-gray-600">{{ $p->petaniProfile->lokasi_kebun ?? '-' }}</span></p>
                                <p class="text-sm"><span class="font-semibold text-gray-700">Deskripsi:</span> <span class="text-gray-600 truncate max-w-[200px] inline-block">{{ $p->petaniProfile->deskripsi_kebun ?? '-' }}</span></p>
                            </div>

                            <div class="flex space-x-3">
                                <form action="{{ route('admin.users.verify', $p) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors flex items-center gap-1.5">
                                        <i data-lucide="check" style="width:16px;height:16px;" aria-hidden="true"></i>
                                        Setujui
                                    </button>
                                </form>
                                <button onclick="document.getElementById('reject-form-{{ $p->id }}').classList.toggle('hidden')" class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors flex items-center gap-1.5">
                                    <i data-lucide="x" style="width:16px;height:16px;" aria-hidden="true"></i>
                                    Tolak
                                </button>
                            </div>

                            <div id="reject-form-{{ $p->id }}" class="mt-4 hidden">
                                <form action="{{ route('admin.users.verify', $p) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <textarea name="alasan_reject" placeholder="Alasan penolakan..." class="form-input text-sm mb-3" rows="2" required></textarea>
                                    <button type="submit" class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors w-full">Kirim Penolakan</button>
                                </form>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
        @endif
    </div>
@endsection
