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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="card p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5" id="form-title">Tambah Kategori</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST" id="category-form">
                        @csrf
                        <div id="method-field"></div>
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Kategori')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="icon" :value="__('Icon (Emoji)')" />
                            <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full" placeholder="🥬" />
                            <x-input-error class="mt-2" :messages="$errors->get('icon')" />
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="submit" class="btn-primary">Simpan</button>
                            <button type="button" onclick="resetForm()" class="btn-ghost text-sm hidden transition-colors" id="cancel-btn">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="card p-6">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-2xl mb-4 text-sm font-medium">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-2xl mb-4 text-sm font-medium">{{ session('error') }}</div>
                    @endif

                    <div class="table-wrap overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $cat)
                                    <tr>
                                        <td class="text-2xl">{{ $cat->icon ?? '🥬' }}</td>
                                        <td class="font-medium text-gray-900">{{ $cat->name }}</td>
                                        <td class="text-gray-400 text-sm">{{ $cat->slug }}</td>
                                        <td>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editCategory({{ json_encode($cat) }})" class="btn-ghost text-xs px-3 py-1.5">Edit</button>
                                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-danger text-xs px-3 py-1.5">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editCategory(cat) {
            document.getElementById('form-title').innerText = 'Edit Kategori';
            document.getElementById('category-form').action = '/admin/categories/' + cat.id;
            document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
            document.getElementById('name').value = cat.name;
            document.getElementById('icon').value = cat.icon;
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
