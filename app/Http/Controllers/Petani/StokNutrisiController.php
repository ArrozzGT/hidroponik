<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\StokNutrisi;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class StokNutrisiController extends Controller
{
    public function index()
    {
        $stok = StokNutrisi::where('user_id', auth()->id())->latest()->paginate(15);
        return view('petani.stok-nutrisi.index', compact('stok'));
    }

    public function create()
    {
        return view('petani.stok-nutrisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_nutrisi' => 'required|string|max:255',
            'stok_tersedia_liter' => 'required|numeric|min:0',
            'stok_minimum_liter' => 'required|numeric|min:0',
        ]);

        StokNutrisi::create([
            'user_id' => auth()->id(),
            'nama_nutrisi' => $request->nama_nutrisi,
            'stok_tersedia_liter' => $request->stok_tersedia_liter,
            'stok_minimum_liter' => $request->stok_minimum_liter,
        ]);

        ActivityLog::log('create_stok_nutrisi', 'Petani menambahkan stok nutrisi baru');

        return redirect()->route('petani.stok-nutrisi.index')->with('success', 'Stok nutrisi berhasil ditambahkan.');
    }

    public function edit(StokNutrisi $stokNutrisi)
    {
        if ($stokNutrisi->user_id !== auth()->id()) {
            abort(403);
        }
        return view('petani.stok-nutrisi.edit', compact('stokNutrisi'));
    }

    public function update(Request $request, StokNutrisi $stokNutrisi)
    {
        if ($stokNutrisi->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nama_nutrisi' => 'required|string|max:255',
            'stok_tersedia_liter' => 'required|numeric|min:0',
            'stok_minimum_liter' => 'required|numeric|min:0',
        ]);

        $stokNutrisi->update($request->only(['nama_nutrisi', 'stok_tersedia_liter', 'stok_minimum_liter']));

        ActivityLog::log('update_stok_nutrisi', 'Petani memperbarui stok nutrisi');

        return redirect()->route('petani.stok-nutrisi.index')->with('success', 'Stok nutrisi berhasil diperbarui.');
    }

    public function destroy(StokNutrisi $stokNutrisi)
    {
        if ($stokNutrisi->user_id !== auth()->id()) {
            abort(403);
        }
        $stokNutrisi->delete();

        ActivityLog::log('delete_stok_nutrisi', 'Petani menghapus stok nutrisi');

        return back()->with('success', 'Stok nutrisi berhasil dihapus.');
    }
}
