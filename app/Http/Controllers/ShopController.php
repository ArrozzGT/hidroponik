<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'tersedia')
            ->whereHas('user', function($q) {
                $q->where('status', 'aktif');
            })
            ->with(['category', 'user.petaniProfile']);

        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        switch ($request->sort) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'termahal':
                $query->orderBy('price', 'desc');
                break;
            case 'stok':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function suggestions(Request $request)
    {
        $query = Product::where('status', 'tersedia')
            ->whereHas('user', function($q) {
                $q->where('status', 'aktif');
            });

        if ($request->q) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->latest()->take(8)->get(['id', 'name', 'slug', 'price', 'unit', 'image']);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'user.petaniProfile']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)->get();
            
        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
