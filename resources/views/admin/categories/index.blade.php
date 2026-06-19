@extends('layouts.admin')
@section('page', 'Kategori')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <i data-lucide="tag" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Manajemen Kategori') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola kategori produk</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Kategori']]" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <x-ui.card class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5" id="form-title">Tambah Kategori</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST" id="category-form">
                        @csrf
                        <div id="method-field"></div>
                        <div class="mb-4">
                            <x-ui.input id="name" name="name" label="Nama Kategori" :error="$errors->first('name')" required />
                        </div>
                        <div class="mb-4">
                            <x-ui.input id="icon" name="icon" label="Icon (Emoji)" placeholder="🥬" :error="$errors->first('icon')" />
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
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium">{{ session('error') }}</div>
                    @endif

                    <div class="table-wrap overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Produk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td class="text-2xl">{{ $cat->icon ?? '🥬' }}</td>
                                        <td class="font-medium text-gray-900">{{ $cat->name }}</td>
                                        <td class="text-gray-400 text-sm">{{ $cat->slug }}</td>
                                        <td class="text-sm text-gray-500">{{ $cat->products_count ?? $cat->products->count() }}</td>
                                        <td>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editCategory({{ json_encode($cat) }})" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</button>
                                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <x-empty-state icon="tag" title="Belum ada kategori" description="Tambahkan kategori produk pertama." />
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
        function editCategory(cat) {
            document.getElementById('form-title').innerText = 'Edit Kategori';
            document.getElementById('category-form').action = '/admin/categories/' + cat.id;
            document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
            document.getElementById('name').value = cat.name;
            document.getElementById('icon').value = cat.icon || '';
            document.getElementById('cancel-btn').classList.remove('hidden');
        }

        function resetForm() {
            document.getElementById('form-title').innerText = 'Tambah Kategori';
            document.getElementById('category-form').action = "{{ route('admin.categories.store') }}";
            document.getElementById('method-field').innerHTML = '';
            document.getElementById('name').value = '';
            document.getElementById('icon').value = '';
            document.getElementById('cancel-btn').classList.add('hidden');
        }
    </script>
@endsection
