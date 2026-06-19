<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Panen;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PanenController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $panen = Panen::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(15);
        return view('petani.panen.index', compact('panen'));
    }

    public function create()
    {
        $products = Product::where('user_id', auth()->id())->where('status', 'tersedia')->get();
        return view('petani.panen.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id', function ($attribute, $value, $fail) {
                if (!Product::where('id', $value)->where('user_id', auth()->id())->exists()) {
                    $fail('Produk tidak ditemukan.');
                }
            }],
            'jumlah_panen_kg' => 'required|numeric|min:0.01',
            'tanggal_panen' => 'required|date',
            'kualitas' => 'required|in:A,B,C',
            'keterangan' => 'nullable|string',
        ]);

        Panen::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'jumlah_panen_kg' => $request->jumlah_panen_kg,
            'tanggal_panen' => $request->tanggal_panen,
            'kualitas' => $request->kualitas,
            'keterangan' => $request->keterangan,
        ]);

        ActivityLog::log('create_panen', 'Petani mencatat panen baru');

        return redirect()->route('petani.panen.index')->with('success', 'Data panen berhasil dicatat.');
    }

    public function edit(Panen $panen)
    {
        if ($panen->user_id !== auth()->id()) {
            abort(403);
        }
        $products = Product::where('user_id', auth()->id())->get();
        return view('petani.panen.edit', compact('panen', 'products'));
    }

    public function update(Request $request, Panen $panen)
    {
        if ($panen->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id', function ($attribute, $value, $fail) {
                if (!Product::where('id', $value)->where('user_id', auth()->id())->exists()) {
                    $fail('Produk tidak ditemukan.');
                }
            }],
            'jumlah_panen_kg' => 'required|numeric|min:0.01',
            'tanggal_panen' => 'required|date',
            'kualitas' => 'required|in:A,B,C',
            'keterangan' => 'nullable|string',
        ]);

        $panen->update($request->only(['product_id', 'jumlah_panen_kg', 'tanggal_panen', 'kualitas', 'keterangan']));

        ActivityLog::log('update_panen', 'Petani memperbarui data panen');

        return redirect()->route('petani.panen.index')->with('success', 'Data panen berhasil diperbarui.');
    }

    public function destroy(Panen $panen)
    {
        if ($panen->user_id !== auth()->id()) {
            abort(403);
        }
        $panen->delete();

        ActivityLog::log('delete_panen', 'Petani menghapus data panen');

        return back()->with('success', 'Data panen berhasil dihapus.');
    }
}
