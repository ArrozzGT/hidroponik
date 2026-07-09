<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Enums\ProductStatus;

class WelcomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        $featuredProducts = Product::where('status', ProductStatus::TERSEDIA)
            ->with('category', 'user.petaniProfile')
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('featuredProducts'));
    }
}
