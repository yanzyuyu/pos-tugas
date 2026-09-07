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

        Product::create(['category_id' => $kategoriKopiPanas->id, 'name' => 'Espresso', 'price' => 15000, 'stock' => 50, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriKopiPanas->id, 'name' => 'Americano Panas', 'price' => 18000, 'stock' => 50, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriKopiPanas->id, 'name' => 'Cappuccino Panas', 'price' => 22000, 'stock' => 50, 'status' => 'tersedia']);
        
        Product::create(['category_id' => $kategoriKopiDingin->id, 'name' => 'Es Kopi Susu Aren', 'price' => 20000, 'stock' => 100, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriKopiDingin->id, 'name' => 'Iced Americano', 'price' => 18000, 'stock' => 60, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriKopiDingin->id, 'name' => 'Iced Latte', 'price' => 22000, 'stock' => 80, 'status' => 'tersedia']);

        Product::create(['category_id' => $kategoriNonKopi->id, 'name' => 'Matcha Latte Panas', 'price' => 25000, 'stock' => 40, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriNonKopi->id, 'name' => 'Es Matcha Latte', 'price' => 26000, 'stock' => 60, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriNonKopi->id, 'name' => 'Lychee Tea', 'price' => 18000, 'stock' => 70, 'status' => 'tersedia']);
        
        Product::create(['category_id' => $kategoriMakanan->id, 'name' => 'Kentang Goreng', 'price' => 15000, 'stock' => 30, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriMakanan->id, 'name' => 'Cireng Bumbu Rujak', 'price' => 15000, 'stock' => 40, 'status' => 'tersedia']);
        Product::create(['category_id' => $kategoriMakanan->id, 'name' => 'Roti Bakar Coklat Keju', 'price' => 20000, 'stock' => 20, 'status' => 'tersedia']);
    }
}
