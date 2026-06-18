<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Cart;
use App\Models\Panen;
use App\Models\StokNutrisi;
use App\Models\Notifikasi;
use App\Models\Rekomendasi;
use App\Models\Transaksi;
use App\Models\LogTransaksi;
use App\Models\PetaniProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([RolePermissionSeeder::class]);

        // Skip if already seeded
        if (Order::count() > 0) {
            return;
        }

        $this->seedCategories();
        $this->seedPetani();
        $this->seedPembeli();
        $this->seedOrders();
        $this->seedTransaksi();
        $this->seedPanen();
        $this->seedStokNutrisi();
        $this->seedNotifications();
        $this->seedRekomendasi();
        $this->seedActivityLogs();
        $this->seedCarts();
    }

    private function seedCategories(): void
    {
        $categories = [
            ['name' => 'Sayuran Daun', 'slug' => 'sayuran-daun', 'icon' => '🥬'],
            ['name' => 'Sayuran Buah', 'slug' => 'sayuran-buah', 'icon' => '🍅'],
            ['name' => 'Sayuran Umbi', 'slug' => 'sayuran-umbi', 'icon' => '🥕'],
            ['name' => 'Sayuran Hijau', 'slug' => 'sayuran-hijau', 'icon' => '🌿'],
            ['name' => 'Sayuran Bunga', 'slug' => 'sayuran-bunga', 'icon' => '🥦'],
            ['name' => 'Sayuran Polong', 'slug' => 'sayuran-polong', 'icon' => '🫘'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }

    private function seedPetani(): void
    {
        $petanis = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@sipsh.com',
                'no_hp' => '081234567890',
                'nama_kebun' => 'Kebun Hidroponik Sari Alam',
                'lokasi_kebun' => 'Jl. Raya Sambas No. 45, Kec. Sambas',
                'deskripsi_kebun' => 'Kebun hidroponik keluarga dengan sistem NFT dan DFT. Menanam berbagai sayuran segar setiap hari tanpa pestisida kimia.',
                'products' => [
                    ['name' => 'Selada Hijau', 'price' => 8000, 'stock' => 50, 'unit' => 'gram', 'category_slug' => 'sayuran-daun', 'description' => 'Selada hijau segar hasil panen hari ini. Renyah dan kaya serat. Cocok untuk lalapan atau salad.'],
                    ['name' => 'Selada Merah', 'price' => 10000, 'stock' => 40, 'unit' => 'gram', 'category_slug' => 'sayuran-daun', 'description' => 'Selada merah dengan warna cantik dan rasa renyah. Kaya antioksidan alami.'],
                    ['name' => 'Pakcoy', 'price' => 7000, 'stock' => 60, 'unit' => 'gram', 'category_slug' => 'sayuran-hijau', 'description' => 'Pakcoy hidroponik segar, batok putih daun hijau tua. Cocok untuk tumis atau capcay.'],
                    ['name' => 'Kangkung', 'price' => 5000, 'stock' => 80, 'unit' => 'ikat', 'category_slug' => 'sayuran-hijau', 'description' => 'Kangkung hidroponik bebas ulat. Batok renyah dan daun lebar. Siap santap.'],
                    ['name' => 'Bayam Hijau', 'price' => 6000, 'stock' => 70, 'unit' => 'gram', 'category_slug' => 'sayuran-daun', 'description' => 'Bayam hijau segar kaya zat besi. Dipanen pagi hari untuk kesegaran maksimal.'],
                    ['name' => 'Sawi Hijau', 'price' => 5500, 'stock' => 55, 'unit' => 'gram', 'category_slug' => 'sayuran-daun', 'description' => 'Sawi hijau segar dengan daun lebar dan batok renyah. Cocok untuk tumisan.'],
                ],
            ],
            [
                'name' => 'Sri Wahyuni',
                'email' => 'sri@sipsh.com',
                'no_hp' => '082345678901',
                'nama_kebun' => 'Green Farm Hidroponik',
                'lokasi_kebun' => 'Dusun Melati, Desa Sebayan, Sambas',
                'deskripsi_kebun' => 'Green Farm berdiri sejak 2020 dengan fokus pada sayuran buah hidroponik. Menggunakan sistem hidroponik tetes dan DFT modern.',
                'products' => [
                    ['name' => 'Tomat Cherry', 'price' => 15000, 'stock' => 30, 'unit' => 'gram', 'category_slug' => 'sayuran-buah', 'description' => 'Tomat cherry merah manis dengan rasa segar. Cocok untuk salad atau camilan sehat.'],
                    ['name' => 'Tomat Beef', 'price' => 12000, 'stock' => 25, 'unit' => 'gram', 'category_slug' => 'sayuran-buah', 'description' => 'Tomat beef besar dengan daging tebal. Ideal untuk jus atau saus.'],
                    ['name' => 'Mentimun', 'price' => 8000, 'stock' => 35, 'unit' => 'gram', 'category_slug' => 'sayuran-buah', 'description' => 'Mentimun hidroponik segar tanpa biji. Renyah dan cocok untuk lalapan.'],
                    ['name' => 'Paprika Merah', 'price' => 25000, 'stock' => 20, 'unit' => 'gram', 'category_slug' => 'sayuran-buah', 'description' => 'Paprika merah manis dengan daging tebal. Kaya vitamin C.'],
                    ['name' => 'Paprika Hijau', 'price' => 22000, 'stock' => 20, 'unit' => 'gram', 'category_slug' => 'sayuran-buah', 'description' => 'Paprika hijau segar dengan rasa khas. Cocok untuk tumisan atau salad.'],
                    ['name' => 'Terong Ungu', 'price' => 10000, 'stock' => 30, 'unit' => 'gram', 'category_slug' => 'sayuran-buah', 'description' => 'Terong ungu hidroponik berkualitas. Daging padat dan tidak pahit.'],
                ],
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad@sipsh.com',
                'no_hp' => '083456789012',
                'nama_kebun' => 'Kebun Berkah Hidroponik',
                'lokasi_kebun' => 'Jl. Khatulistiwa No. 12, Sambas',
                'deskripsi_kebun' => 'Kebun Berkah fokus pada sayuran bunga dan polong hidroponik. Mengutamakan kualitas dan kebersihan produk.',
                'products' => [
                    ['name' => 'Brokoli', 'price' => 20000, 'stock' => 25, 'unit' => 'gram', 'category_slug' => 'sayuran-bunga', 'description' => 'Brokoli hidroponik segar dengan bunga rapat. Kaya serat dan antioksidan.'],
                    ['name' => 'Kembang Kol', 'price' => 18000, 'stock' => 20, 'unit' => 'gram', 'category_slug' => 'sayuran-bunga', 'description' => 'Kembang kol putih bersih dengan tekstur renyah. Cocok untuk sup atau tumis.'],
                    ['name' => 'Buncis', 'price' => 12000, 'stock' => 40, 'unit' => 'gram', 'category_slug' => 'sayuran-polong', 'description' => 'Buncis segar dengan polong renyah. Kaya protein nabati dan serat.'],
                    ['name' => 'Kacang Panjang', 'price' => 8000, 'stock' => 45, 'unit' => 'ikat', 'category_slug' => 'sayuran-polong', 'description' => 'Kacang panjang hidroponik segar. Panjang dan renyah tanpa ulat.'],
                    ['name' => 'Kapri', 'price' => 15000, 'stock' => 30, 'unit' => 'gram', 'category_slug' => 'sayuran-polong', 'description' => 'Kapri manis segar dengan polong muda. Cocok untuk sup atau tumis.'],
                    ['name' => 'Wortel Mini', 'price' => 12000, 'stock' => 35, 'unit' => 'gram', 'category_slug' => 'sayuran-umbi', 'description' => 'Wortel mini hidroponik manis dan renyah. Cocok untuk camilan sehat anak.'],
                ],
            ],
        ];

        foreach ($petanis as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'petani',
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['lokasi_kebun'],
                    'status' => 'aktif',
                ]
            );
            if (!$user->hasRole('petani')) {
                $user->assignRole('petani');
            }

                    PetaniProfile::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'nama_kebun' => $data['nama_kebun'],
                            'lokasi_kebun' => $data['lokasi_kebun'],
                            'deskripsi_kebun' => $data['deskripsi_kebun'],
                        ]
                    );

            foreach ($data['products'] as $product) {
                $category = Category::where('slug', $product['category_slug'])->first();
                Product::firstOrCreate(
                    ['name' => $product['name'], 'user_id' => $user->id],
                    [
                        'category_id' => $category->id,
                        'slug' => Str::slug($product['name']) . '-' . $user->id . '-' . Str::random(4),
                        'description' => $product['description'],
                        'price' => $product['price'],
                        'stock' => $product['stock'],
                        'unit' => $product['unit'],
                        'status' => 'tersedia',
                    ]
                );
            }
        }
    }

    private function seedPembeli(): void
    {
        $pembelis = [
            [
                'name' => 'Rina Wijaya',
                'email' => 'rina@sipsh.com',
                'no_hp' => '085678901234',
                'alamat' => 'Jl. Merdeka No. 10, Kec. Sambas, Kab. Sambas',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@sipsh.com',
                'no_hp' => '087890123456',
                'alamat' => 'Jl. Diponegoro No. 25, Kec. Sambas, Kab. Sambas',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@sipsh.com',
                'no_hp' => '089012345678',
                'alamat' => 'Jl. Pahlawan No. 8, Kec. Teluk Keramat, Sambas',
            ],
        ];

        foreach ($pembelis as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'pembeli',
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                    'status' => 'aktif',
                ]
            );
            if (!$user->hasRole('pembeli')) {
                $user->assignRole('pembeli');
            }
        }
    }

    private function seedOrders(): void
    {
        $pembelis = User::where('role', 'pembeli')->get();
        $products = Product::all();
        $statuses = ['pending', 'processing', 'shipping', 'completed', 'cancelled'];
        $paymentStatuses = ['unpaid', 'paid'];

        // Order 1: Rina - completed & paid
        $order1 = Order::create([
            'user_id' => $pembelis[0]->id,
            'order_number' => 'SIPSH-' . date('Ymd') . '-0001',
            'total_price' => 32000,
            'status' => 'completed',
            'shipping_address' => $pembelis[0]->alamat,
            'payment_status' => 'paid',
            'note' => 'Titip di satpam kompleks',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(3),
        ]);
        $order1->items()->createMany([
            ['product_id' => $products[0]->id, 'quantity' => 2, 'price' => $products[0]->price],
            ['product_id' => $products[3]->id, 'quantity' => 1, 'price' => $products[3]->price],
            ['product_id' => $products[14]->id, 'quantity' => 1, 'price' => $products[14]->price],
        ]);

        // Order 2: Andi - processing & paid
        $order2 = Order::create([
            'user_id' => $pembelis[1]->id,
            'order_number' => 'SIPSH-' . date('Ymd') . '-0002',
            'total_price' => 47000,
            'status' => 'processing',
            'shipping_address' => $pembelis[1]->alamat,
            'payment_status' => 'paid',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(1),
        ]);
        $order2->items()->createMany([
            ['product_id' => $products[6]->id, 'quantity' => 1, 'price' => $products[6]->price],
            ['product_id' => $products[9]->id, 'quantity' => 1, 'price' => $products[9]->price],
            ['product_id' => $products[12]->id, 'quantity' => 1, 'price' => $products[12]->price],
        ]);

        // Order 3: Rina - pending & unpaid
        $order3 = Order::create([
            'user_id' => $pembelis[0]->id,
            'order_number' => 'SIPSH-' . date('Ymd') . '-0003',
            'total_price' => 25000,
            'status' => 'pending',
            'shipping_address' => $pembelis[0]->alamat,
            'payment_status' => 'unpaid',
            'created_at' => now()->subHours(6),
        ]);
        $order3->items()->createMany([
            ['product_id' => $products[4]->id, 'quantity' => 2, 'price' => $products[4]->price],
            ['product_id' => $products[7]->id, 'quantity' => 1, 'price' => $products[7]->price],
        ]);

        // Order 4: Dewi - shipping & paid
        $order4 = Order::create([
            'user_id' => $pembelis[2]->id,
            'order_number' => 'SIPSH-' . date('Ymd') . '-0004',
            'total_price' => 55000,
            'status' => 'shipping',
            'shipping_address' => $pembelis[2]->alamat,
            'payment_status' => 'paid',
            'note' => 'Tolong dibungkus rapi',
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subHours(3),
        ]);
        $order4->items()->createMany([
            ['product_id' => $products[2]->id, 'quantity' => 3, 'price' => $products[2]->price],
            ['product_id' => $products[8]->id, 'quantity' => 1, 'price' => $products[8]->price],
        ]);

        // Order 5: Andi - cancelled & paid (refund)
        $order5 = Order::create([
            'user_id' => $pembelis[1]->id,
            'order_number' => 'SIPSH-' . date('Ymd') . '-0005',
            'total_price' => 38000,
            'status' => 'cancelled',
            'shipping_address' => $pembelis[1]->alamat,
            'payment_status' => 'paid',
            'note' => 'Tidak jadi pesan',
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(6),
        ]);
        $order5->items()->createMany([
            ['product_id' => $products[1]->id, 'quantity' => 2, 'price' => $products[1]->price],
            ['product_id' => $products[10]->id, 'quantity' => 1, 'price' => $products[10]->price],
        ]);

        // Order 6: Dewi - completed & paid
        $order6 = Order::create([
            'user_id' => $pembelis[2]->id,
            'order_number' => 'SIPSH-' . date('Ymd') . '-0006',
            'total_price' => 19500,
            'status' => 'completed',
            'shipping_address' => $pembelis[2]->alamat,
            'payment_status' => 'paid',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(8),
        ]);
        $order6->items()->createMany([
            ['product_id' => $products[5]->id, 'quantity' => 1, 'price' => $products[5]->price],
            ['product_id' => $products[13]->id, 'quantity' => 1, 'price' => $products[13]->price],
            ['product_id' => $products[16]->id, 'quantity' => 1, 'price' => $products[16]->price],
        ]);
    }

    private function seedActivityLogs(): void
    {
        $users = User::all();

        $actions = ['login', 'register', 'checkout', 'create_product', 'update_order_status'];
        $descriptions = [
            'login' => 'User berhasil login ke sistem',
            'register' => 'User baru mendaftar ke SIPSH',
            'checkout' => 'User melakukan checkout pesanan',
            'create_product' => 'Petani menambahkan produk baru',
            'update_order_status' => 'Admin memperbarui status pesanan',
        ];

        foreach (range(1, 20) as $i) {
            $action = $actions[array_rand($actions)];
            ActivityLog::create([
                'user_id' => $users->random()->id,
                'action' => $action,
                'description' => $descriptions[$action],
                'ip_address' => '192.168.1.' . rand(10, 200),
                'created_at' => now()->subHours(rand(1, 240)),
            ]);
        }
    }

    private function seedCarts(): void
    {
        $pembeli = User::where('role', 'pembeli')->first();
        $products = Product::whereIn('id', [3, 7])->get();

        foreach ($products as $product) {
            Cart::create([
                'user_id' => $pembeli->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
            ]);
        }
    }

    private function seedPanen(): void
    {
        $petani = User::where('role', 'petani')->get();

        foreach ($petani as $p) {
            $products = Product::where('user_id', $p->id)->get();
            foreach ($products->take(3) as $product) {
                Panen::create([
                    'product_id' => $product->id,
                    'user_id' => $p->id,
                    'jumlah_panen_kg' => rand(5, 50) / 10,
                    'tanggal_panen' => now()->subDays(rand(1, 30)),
                    'kualitas' => ['A', 'B', 'C'][array_rand(['A', 'B', 'C'])],
                    'keterangan' => 'Panen rutin ' . $product->name,
                ]);
            }
        }
    }

    private function seedStokNutrisi(): void
    {
        $petani = User::where('role', 'petani')->get();
        $nutrisi = ['AB Mix Sayur', 'AB Mix Buah', 'Nutrisi Hidroponik Cair', 'Pupuk Daun'];

        foreach ($petani as $p) {
            foreach ($nutrisi as $i => $n) {
                StokNutrisi::create([
                    'user_id' => $p->id,
                    'nama_nutrisi' => $n . ' (' . $p->name . ')',
                    'stok_tersedia_liter' => rand(1, 50),
                    'stok_minimum_liter' => 5,
                ]);
            }
        }
    }

    private function seedNotifications(): void
    {
        $users = User::all();

        foreach ($users->take(5) as $user) {
            Notifikasi::create([
                'user_id' => $user->id,
                'from_user_id' => User::where('role', 'admin')->first()?->id,
                'type' => 'verification',
                'title' => 'Selamat Datang di SIPSH',
                'message' => 'Akun Anda telah berhasil terdaftar. Silakan lengkapi profil Anda.',
                'is_read' => (bool) rand(0, 1),
            ]);
        }

        $pembeli = User::where('role', 'pembeli')->first();
        if ($pembeli) {
            Notifikasi::create([
                'user_id' => $pembeli->id,
                'type' => 'order',
                'title' => 'Pesanan Dikirim',
                'message' => 'Pesanan Anda sedang dalam proses pengiriman.',
                'is_read' => false,
            ]);
        }
    }

    private function seedRekomendasi(): void
    {
        $petani = User::where('role', 'petani')->get();

        foreach ($petani->take(2) as $p) {
            Rekomendasi::create([
                'user_id' => $p->id,
                'jenis_rekomendasi' => 'stok_nutrisi',
                'deskripsi' => 'Stok nutrisi Anda menipis. Segera lakukan restok untuk menjaga kualitas tanaman.',
                'status_diterapkan' => false,
            ]);
        }
    }

    private function seedTransaksi(): void
    {
        $orders = Order::all();
        $admin = User::where('role', 'admin')->first();

        foreach ($orders as $order) {
            $transaksi = Transaksi::create([
                'order_id' => $order->id,
                'metode_pembayaran' => ['Transfer Bank', 'QRIS', 'COD'][array_rand(['Transfer Bank', 'QRIS', 'COD'])],
                'status_pembayaran' => $order->payment_status,
                'tanggal_konfirmasi' => $order->payment_status === 'paid' ? $order->updated_at : null,
                'confirmed_by' => $order->payment_status === 'paid' ? ($admin?->id ?? null) : null,
            ]);

            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'aksi' => $order->payment_status === 'paid' ? 'payment_confirmed' : 'payment_pending',
                'detail_perubahan' => $order->payment_status === 'paid' ? 'Pembayaran dikonfirmasi oleh sistem' : 'Menunggu pembayaran',
                'user_id' => $admin?->id,
            ]);
        }
    }
}
