@extends('layouts.admin')
@section('page', 'Verifikasi Petani')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
            <i data-lucide="user-check" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Verifikasi Petani Baru') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Setujui atau tolak permohonan petani</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        @if($petani->isEmpty())
            <div class="card p-12 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="check-circle" style="width:32px;height:32px;color:#16a34a;" aria-hidden="true"></i>
                </div>
                <p class="text-gray-500 font-medium">Tidak ada permohonan verifikasi petani baru.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($petani as $p)
                    <div class="card overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-5">
                                @if($p->foto)
                                    <img src="{{ asset('storage/' . $p->foto) }}" class="w-16 h-16 rounded-2xl object-cover">
                                @else
                                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 font-bold text-xl">{{ substr($p->name, 0, 1) }}</div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $p->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $p->email }}</p>
                                    <p class="text-sm text-gray-400">{{ $p->no_hp }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50/50 rounded-2xl p-4 space-y-2 mb-5">
                                <p class="text-sm"><span class="font-semibold text-gray-700">Nama Kebun:</span> <span class="text-gray-500">{{ $p->petaniProfile->nama_kebun ?? '-' }}</span></p>
                                <p class="text-sm"><span class="font-semibold text-gray-700">Lokasi:</span> <span class="text-gray-500">{{ $p->petaniProfile->lokasi_kebun ?? '-' }}</span></p>
                                <p class="text-sm"><span class="font-semibold text-gray-700">Deskripsi:</span> <span class="text-gray-500">{{ $p->petaniProfile->deskripsi_kebun ?? '-' }}</span></p>
                            </div>

                            <div class="flex space-x-3">
                                <form action="{{ route('admin.users.verify', $p) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn-primary flex items-center gap-1.5">
                                        <i data-lucide="check" style="width:16px;height:16px;" aria-hidden="true"></i>
                                        Setujui
                                    </button>
                                </form>
                                <button onclick="document.getElementById('reject-form-{{ $p->id }}').classList.toggle('hidden')" class="btn-danger flex items-center gap-1.5">
                                    <i data-lucide="x" style="width:16px;height:16px;" aria-hidden="true"></i>
                                    Tolak
                                </button>
                            </div>

                            <div id="reject-form-{{ $p->id }}" class="mt-4 hidden">
                                <form action="{{ route('admin.users.verify', $p) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <textarea name="alasan_reject" placeholder="Alasan penolakan..." class="form-input text-sm mb-3" rows="2" required></textarea>
                                    <button type="submit" class="btn-danger w-full">Kirim Penolakan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
