<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'today_sales' => 2480000,
            'today_transactions' => 68,
            'avg_transaction' => 36470,
            'total_products' => 24,
        ];

        $topProducts = [
            ['name' => 'Iced Caramel Macchiato', 'category' => 'Kopi Dingin', 'sold' => 42, 'revenue' => 1428000],
            ['name' => 'Cold Brew Signature', 'category' => 'Kopi Dingin', 'sold' => 35, 'revenue' => 1050000],
            ['name' => 'Butter Croissant Crispy', 'category' => 'Makanan Ringan', 'sold' => 31, 'revenue' => 744000],
            ['name' => 'Cappuccino Warm', 'category' => 'Kopi Panas', 'sold' => 28, 'revenue' => 784000],
            ['name' => 'Matcha Kyoto Latte', 'category' => 'Non-Kopi', 'sold' => 22, 'revenue' => 660000],
        ];

        $recentOrders = [
            ['id' => 'INV-0012', 'time' => '10:45', 'cashier' => 'Siti Kasir', 'total' => 84000, 'status' => 'Selesai'],
            ['id' => 'INV-0011', 'time' => '10:20', 'cashier' => 'Siti Kasir', 'total' => 52000, 'status' => 'Selesai'],
            ['id' => 'INV-0010', 'time' => '09:55', 'cashier' => 'Budi Santoso', 'total' => 30000, 'status' => 'Selesai'],
            ['id' => 'INV-0009', 'time' => '09:12', 'cashier' => 'Siti Kasir', 'total' => 64000, 'status' => 'Selesai'],
        ];

        return view('admin.dashboard', compact('stats', 'topProducts', 'recentOrders'));
    }

    public function categories()
    {
        $categories = [
            ['id' => 1, 'name' => 'Kopi Panas', 'slug' => 'kopi-panas', 'products_count' => 6, 'created_at' => '01 Sep 2026'],
            ['id' => 2, 'name' => 'Kopi Dingin', 'slug' => 'kopi-dingin', 'products_count' => 8, 'created_at' => '01 Sep 2026'],
            ['id' => 3, 'name' => 'Non-Kopi', 'slug' => 'non-kopi', 'products_count' => 5, 'created_at' => '02 Sep 2026'],
            ['id' => 4, 'name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'products_count' => 5, 'created_at' => '03 Sep 2026'],
        ];

        return view('admin.categories.index', compact('categories'));
    }

    public function products()
    {
        $products = [
            ['id' => 1, 'name' => 'Espresso Single', 'category' => 'Kopi Panas', 'price' => 18000, 'stock' => 45, 'status' => 'Tersedia'],
            ['id' => 2, 'name' => 'Americano Hot', 'category' => 'Kopi Panas', 'price' => 22000, 'stock' => 50, 'status' => 'Tersedia'],
            ['id' => 3, 'name' => 'Cappuccino Warm', 'category' => 'Kopi Panas', 'price' => 28000, 'stock' => 30, 'status' => 'Tersedia'],
            ['id' => 4, 'name' => 'Iced Caramel Macchiato', 'category' => 'Kopi Dingin', 'price' => 34000, 'stock' => 28, 'status' => 'Tersedia'],
            ['id' => 5, 'name' => 'Iced Spanish Latte', 'category' => 'Kopi Dingin', 'price' => 32000, 'stock' => 40, 'status' => 'Tersedia'],
            ['id' => 6, 'name' => 'Cold Brew Signature', 'category' => 'Kopi Dingin', 'price' => 30000, 'stock' => 20, 'status' => 'Tersedia'],
            ['id' => 7, 'name' => 'Matcha Kyoto Latte', 'category' => 'Non-Kopi', 'price' => 30000, 'stock' => 35, 'status' => 'Tersedia'],
            ['id' => 8, 'name' => 'Artisan Earl Grey Tea', 'category' => 'Non-Kopi', 'price' => 22000, 'stock' => 50, 'status' => 'Tersedia'],
            ['id' => 9, 'name' => 'Butter Croissant Crispy', 'category' => 'Makanan Ringan', 'price' => 24000, 'stock' => 15, 'status' => 'Tersedia'],
            ['id' => 10, 'name' => 'Truffle Fries & Dip', 'category' => 'Makanan Ringan', 'price' => 32000, 'stock' => 18, 'status' => 'Tersedia'],
        ];

        $categories = ['Kopi Panas', 'Kopi Dingin', 'Non-Kopi', 'Makanan Ringan'];

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function users()
    {
        $users = [
            ['id' => 1, 'name' => 'Admin Utama', 'email' => 'admin@kopisenja.id', 'role' => 'Admin', 'status' => 'Aktif', 'joined' => '01 Jan 2026'],
            ['id' => 2, 'name' => 'Siti Kasir', 'email' => 'siti@kopisenja.id', 'role' => 'Kasir', 'status' => 'Aktif', 'joined' => '15 Jan 2026'],
            ['id' => 3, 'name' => 'Budi Santoso', 'email' => 'budi@kopisenja.id', 'role' => 'Kasir', 'status' => 'Aktif', 'joined' => '01 Feb 2026'],
        ];

        return view('admin.users.index', compact('users'));
    }

    public function reports()
    {
        $summary = [
            'total_gross' => 14850000,
            'total_orders' => 412,
            'cash_amount' => 6850000,
            'qris_amount' => 8000000,
        ];

        $dailySales = [
            ['date' => '07 Sep 2026', 'transactions' => 68, 'cash' => 1100000, 'qris' => 1380000, 'total' => 2480000],
            ['date' => '06 Sep 2026', 'transactions' => 82, 'cash' => 1450000, 'qris' => 1720000, 'total' => 3170000],
            ['date' => '05 Sep 2026', 'transactions' => 95, 'cash' => 1800000, 'qris' => 2100000, 'total' => 3900000],
            ['date' => '04 Sep 2026', 'transactions' => 54, 'cash' => 850000, 'qris' => 1120000, 'total' => 1970000],
            ['date' => '03 Sep 2026', 'transactions' => 61, 'cash' => 980000, 'qris' => 1150000, 'total' => 2130000],
            ['date' => '02 Sep 2026', 'transactions' => 52, 'cash' => 670000, 'qris' => 530000, 'total' => 1200000],
        ];

        return view('admin.reports.index', compact('summary', 'dailySales'));
    }
}
