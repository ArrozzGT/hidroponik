@extends('layouts.admin')
@section('page', 'Kupon')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-600">
            <i data-lucide="ticket" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Manajemen Kupon') }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola kupon potongan harga belanja</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Kupon']]" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <x-ui.card class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5" id="form-title">Tambah Kupon</h3>
                    <form action="{{ route('admin.coupons.store') }}" method="POST" id="coupon-form">
                        @csrf
                        <div id="method-field"></div>
                        <div class="mb-4">
                            <x-ui.input id="code" name="code" label="Kode Kupon" placeholder="HEMATHIDRO" :error="$errors->first('code')" required />
                        </div>
                        <div class="mb-4">
                            <x-ui.input id="description" name="description" label="Deskripsi" placeholder="Diskon 10% minimal belanja Rp 30.000" :error="$errors->first('description')" />
                        </div>
                        <div class="mb-4">
                            <label for="type" class="form-label mb-1 block text-sm font-medium text-gray-700">Tipe Potongan</label>
                            <select name="type" id="type" class="form-input w-full rounded-lg border-gray-200" required>
                                <option value="percentage">Persentase (%)</option>
                                <option value="nominal">Nominal (Rupiah)</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-ui.input id="value" name="value" type="number" label="Nilai Potongan" placeholder="10 / 5000" :error="$errors->first('value')" required />
                        </div>
                        <div class="mb-4">
                            <x-ui.input id="min_purchase" name="min_purchase" type="number" label="Minimal Pembelian (Rp)" placeholder="0" :error="$errors->first('min_purchase')" required />
                        </div>
                        <div class="mb-4">
                            <x-ui.input id="max_uses" name="max_uses" type="number" label="Batas Penggunaan (Kali)" placeholder="0" :error="$errors->first('max_uses')" required />
                        </div>
                        <div class="mb-4">
                            <x-ui.input id="valid_until" name="valid_until" type="date" label="Masa Berlaku" :error="$errors->first('valid_until')" required />
                        </div>
                        <div class="mb-4 flex items-center gap-2">
                            <input type="checkbox" id="is_active" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500 border-gray-300">
                            <label for="is_active" class="text-sm font-medium text-gray-700">Kupon Aktif</label>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors">Simpan</button>
                            <button type="button" onclick="resetForm()" class="text-gray-700 hover:bg-gray-50 px-3 py-2 text-sm rounded-lg font-medium transition-colors hidden" id="cancel-btn">Batal</button>
                        </div>
                    </form>
                </x-ui.card>
            </div>

            <div class="md:col-span-2">
                <x-ui.card class="p-6">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium">{{ session('error') }}</div>
                    @endif

                    <div class="table-wrap overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tipe/Nilai</th>
                                    <th>Min Belanja</th>
                                    <th>Batas Pakai</th>
                                    <th>Berlaku</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                    <tr>
                                        <td class="font-bold text-gray-900 font-mono">{{ $coupon->code }}</td>
                                        <td>
                                            <span class="font-medium">
                                                @if($coupon->type === 'percentage')
                                                    {{ number_format($coupon->value, 0) }}%
                                                @else
                                                    Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                                @endif
                                            </span>
                                            <p class="text-xs text-gray-500 truncate max-w-[150px]">{{ $coupon->description }}</p>
                                        </td>
                                        <td class="text-sm text-gray-600">Rp {{ number_format($coupon->min_purchase, 0, ',', '.') }}</td>
                                        <td class="text-sm text-gray-600">{{ $coupon->used_count }} / {{ $coupon->max_uses ?: '∞' }}</td>
                                        <td class="text-sm text-gray-600">{{ $coupon->valid_until->format('d/m/Y') }}</td>
                                        <td>
                                            <x-ui.badge :variant="$coupon->is_active ? 'success' : 'default'">
                                                {{ $coupon->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </x-ui.badge>
                                        </td>
                                        <td>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editCoupon({{ json_encode($coupon) }})" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</button>
                                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Yakin hapus kupon ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <x-empty-state icon="ticket" title="Belum ada kupon" description="Tambahkan kupon belanja pertama." />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </div>

    <script>
        function editCoupon(c) {
            document.getElementById('form-title').innerText = 'Edit Kupon';
            document.getElementById('coupon-form').action = '{{ route('admin.coupons.index') }}/' + c.id;
            document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
            document.getElementById('code').value = c.code;
            document.getElementById('description').value = c.description || '';
            document.getElementById('type').value = c.type;
            document.getElementById('value').value = parseFloat(c.value);
            document.getElementById('min_purchase').value = parseFloat(c.min_purchase);
            document.getElementById('max_uses').value = c.max_uses;
            
            // Format valid_until to YYYY-MM-DD
            if (c.valid_until) {
                const date = new Date(c.valid_until);
                const formattedDate = date.toISOString().split('T')[0];
                document.getElementById('valid_until').value = formattedDate;
            }
            
            document.getElementById('is_active').checked = c.is_active;
            document.getElementById('cancel-btn').classList.remove('hidden');
        }

        function resetForm() {
            document.getElementById('form-title').innerText = 'Tambah Kupon';
            document.getElementById('coupon-form').action = "{{ route('admin.coupons.store') }}";
            document.getElementById('method-field').innerHTML = '';
            document.getElementById('code').value = '';
            document.getElementById('description').value = '';
            document.getElementById('type').value = 'percentage';
            document.getElementById('value').value = '';
            document.getElementById('min_purchase').value = '0';
            document.getElementById('max_uses').value = '0';
            document.getElementById('valid_until').value = '';
            document.getElementById('is_active').checked = true;
            document.getElementById('cancel-btn').classList.add('hidden');
        }
    </script>
@endsection
