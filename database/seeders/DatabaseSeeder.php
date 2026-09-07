<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Kopi Senja',
            'email' => 'admin@kopisenja.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir Kopi Senja',
            'email' => 'kasir@kopisenja.id',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        $kategoriKopiPanas = Category::create(['name' => 'Kopi Panas', 'slug' => Str::slug('Kopi Panas')]);
        $kategoriKopiDingin = Category::create(['name' => 'Kopi Dingin', 'slug' => Str::slug('Kopi Dingin')]);
        $kategoriNonKopi = Category::create(['name' => 'Non-Kopi', 'slug' => Str::slug('Non-Kopi')]);
        $kategoriMakanan = Category::create(['name' => 'Makanan Ringan', 'slug' => Str::slug('Makanan Ringan')]);

        Product::create([
            'category_id' => $kategoriKopiPanas->id,
            'name' => 'Espresso Single',
            'price' => 18000,
            'stock' => 50,
            'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriKopiPanas->id,
            'name' => 'Americano Hot',
            'price' => 22000,
            'stock' => 50,
            'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriKopiPanas->id,
            'name' => 'Cappuccino Warm',
            'price' => 28000,
            'stock' => 50,
            'image' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        
        Product::create([
            'category_id' => $kategoriKopiDingin->id,
            'name' => 'Es Kopi Susu Aren',
            'price' => 20000,
            'stock' => 100,
            'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriKopiDingin->id,
            'name' => 'Iced Americano',
            'price' => 18000,
            'stock' => 60,
            'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriKopiDingin->id,
            'name' => 'Iced Latte',
            'price' => 22000,
            'stock' => 80,
            'image' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);

        Product::create([
            'category_id' => $kategoriNonKopi->id,
            'name' => 'Matcha Latte Panas',
            'price' => 25000,
            'stock' => 40,
            'image' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriNonKopi->id,
            'name' => 'Es Matcha Latte',
            'price' => 26000,
            'stock' => 60,
            'image' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriNonKopi->id,
            'name' => 'Lychee Tea',
            'price' => 18000,
            'stock' => 70,
            'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        
        Product::create([
            'category_id' => $kategoriMakanan->id,
            'name' => 'Kentang Goreng',
            'price' => 15000,
            'stock' => 30,
            'image' => 'https://images.unsplash.com/photo-1576107232684-1279f3908594?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriMakanan->id,
            'name' => 'Cireng Bumbu Rujak',
            'price' => 15000,
            'stock' => 40,
            'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
        Product::create([
            'category_id' => $kategoriMakanan->id,
            'name' => 'Roti Bakar Coklat Keju',
            'price' => 20000,
            'stock' => 20,
            'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&auto=format&fit=crop&q=60',
            'status' => 'tersedia',
        ]);
    }
}
