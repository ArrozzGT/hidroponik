<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->with('category')->latest()->paginate(10);
        return view('petani.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('petani.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'lama_tanam_hari' => 'nullable|integer|min:1',
            'tanggal_tanam' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'lama_tanam_hari' => $request->lama_tanam_hari,
            'tanggal_tanam' => $request->tanggal_tanam,
            'image' => $imagePath,
            'status' => $request->stock > 0 ? 'tersedia' : 'habis',
        ]);

        \App\Models\ActivityLog::log('create_product', 'Petani menambah produk baru: ' . $request->name);

        return redirect()->route('petani.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id()) abort(403);
        $categories = Category::all();
        return view('petani.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) abort(403);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'lama_tanam_hari' => 'nullable|integer|min:1',
            'tanggal_tanam' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['status'] = $request->stock > 0 ? 'tersedia' : 'habis';

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        \App\Models\ActivityLog::log('update_product', 'Petani memperbarui produk: ' . $product->name);

        return redirect()->route('petani.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) abort(403);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        \App\Models\ActivityLog::log('delete_product', 'Petani menghapus produk: ' . $product->name);

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
