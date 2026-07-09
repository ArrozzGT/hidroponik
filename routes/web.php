<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');
Route::get('/api/products/search', [\App\Http\Controllers\ShopController::class, 'suggestions'])->name('api.products.search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/coupon', [\App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon');
    Route::delete('/cart/coupon', [\App\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
    
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/callback', [\App\Http\Controllers\OrderController::class, 'callback'])->name('orders.callback');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('petani')) {
        return redirect()->route('petani.dashboard');
    } else {
        return redirect()->route('pembeli.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->except(['show', 'create', 'edit']);


    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'admin'])->name('dashboard');

    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/petani-pending', [\App\Http\Controllers\Admin\UserController::class, 'petaniPending'])->name('users.petani-pending');
    Route::post('/users/{user}/verify', [\App\Http\Controllers\Admin\UserController::class, 'verify'])->name('users.verify');
    Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Category Management
    // Category Management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['create', 'show', 'edit']);

    // Order Management
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Activity Logs
    Route::get('/logs', [\App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('logs.index');

    // Transactions
    Route::get('/transaksi', [\App\Http\Controllers\Admin\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [\App\Http\Controllers\Admin\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/{transaksi}/confirm', [\App\Http\Controllers\Admin\TransaksiController::class, 'confirm'])->name('transaksi.confirm');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('/reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.pdf');
});

Route::middleware(['auth', 'verified', 'role:petani'])->prefix('petani')->name('petani.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'petani'])->name('dashboard');

    // Product Management
    Route::resource('products', \App\Http\Controllers\Petani\ProductController::class)->except(['show']);

    // Order Management
    Route::get('/orders', [\App\Http\Controllers\Petani\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Petani\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Harvest (Panen) Management
    Route::get('/panen', [\App\Http\Controllers\Petani\PanenController::class, 'index'])->name('panen.index');
    Route::get('/panen/create', [\App\Http\Controllers\Petani\PanenController::class, 'create'])->name('panen.create');
    Route::post('/panen', [\App\Http\Controllers\Petani\PanenController::class, 'store'])->name('panen.store');
    Route::get('/panen/{panen}/edit', [\App\Http\Controllers\Petani\PanenController::class, 'edit'])->name('panen.edit');
    Route::put('/panen/{panen}', [\App\Http\Controllers\Petani\PanenController::class, 'update'])->name('panen.update');
    Route::delete('/panen/{panen}', [\App\Http\Controllers\Petani\PanenController::class, 'destroy'])->name('panen.destroy');

    // Nutrition Stock (Stok Nutrisi) Management
    Route::get('/stok-nutrisi', [\App\Http\Controllers\Petani\StokNutrisiController::class, 'index'])->name('stok-nutrisi.index');
    Route::get('/stok-nutrisi/create', [\App\Http\Controllers\Petani\StokNutrisiController::class, 'create'])->name('stok-nutrisi.create');
    Route::post('/stok-nutrisi', [\App\Http\Controllers\Petani\StokNutrisiController::class, 'store'])->name('stok-nutrisi.store');
    Route::get('/stok-nutrisi/{stokNutrisi}/edit', [\App\Http\Controllers\Petani\StokNutrisiController::class, 'edit'])->name('stok-nutrisi.edit');
    Route::put('/stok-nutrisi/{stokNutrisi}', [\App\Http\Controllers\Petani\StokNutrisiController::class, 'update'])->name('stok-nutrisi.update');
    Route::delete('/stok-nutrisi/{stokNutrisi}', [\App\Http\Controllers\Petani\StokNutrisiController::class, 'destroy'])->name('stok-nutrisi.destroy');
});

Route::middleware(['auth', 'verified', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'pembeli'])->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notifikasi}/read', [\App\Http\Controllers\NotifikasiController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// Halaman Terms & Ketentuan
Route::get('/terms', function () {
    return view('auth.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('auth.privacy');
})->name('privacy');

Route::post('/terms/accept', function () {
    session(['terms_accepted' => true]);
    return redirect()->route('register');
})->name('terms.accept');

require __DIR__.'/auth.php';
