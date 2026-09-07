<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    private function getProducts()
    {
        return [
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Espresso Single',
                'category' => 'Kopi Panas',
                'price' => 18000,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'name' => 'Americano Hot',
                'category' => 'Kopi Panas',
                'price' => 22000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'name' => 'Cappuccino Warm',
                'category' => 'Kopi Panas',
                'price' => 28000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'name' => 'Iced Caramel Macchiato',
                'category' => 'Kopi Dingin',
                'price' => 34000,
                'stock' => 28,
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 5,
                'category_id' => 2,
                'name' => 'Iced Spanish Latte',
                'category' => 'Kopi Dingin',
                'price' => 32000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 6,
                'category_id' => 2,
                'name' => 'Cold Brew Signature',
                'category' => 'Kopi Dingin',
                'price' => 30000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 7,
                'category_id' => 3,
                'name' => 'Matcha Kyoto Latte',
                'category' => 'Non-Kopi',
                'price' => 30000,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 8,
                'category_id' => 3,
                'name' => 'Artisan Earl Grey Tea',
                'category' => 'Non-Kopi',
                'price' => 22000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 9,
                'category_id' => 3,
                'name' => 'Chocolate Truffle Iced',
                'category' => 'Non-Kopi',
                'price' => 28000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 10,
                'category_id' => 4,
                'name' => 'Butter Croissant Crispy',
                'category' => 'Makanan Ringan',
                'price' => 24000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 11,
                'category_id' => 4,
                'name' => 'Almond Pain Au Chocolat',
                'category' => 'Makanan Ringan',
                'price' => 28000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 12,
                'category_id' => 4,
                'name' => 'Truffle Fries & Dip',
                'category' => 'Makanan Ringan',
                'price' => 32000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1576107232684-1279f3908594?w=500&auto=format&fit=crop&q=60',
            ],
        ];
    }

    private function getCategories()
    {
        return [
            ['id' => 0, 'name' => 'Semua Menu'],
            ['id' => 1, 'name' => 'Kopi Panas'],
            ['id' => 2, 'name' => 'Kopi Dingin'],
            ['id' => 3, 'name' => 'Non-Kopi'],
            ['id' => 4, 'name' => 'Makanan Ringan'],
        ];
    }

    public function index()
    {
        $products = $this->getProducts();
        $categories = $this->getCategories();

        return view('pos.index', compact('products', 'categories'));
    }

    public function history()
    {
        $transactions = [
            [
                'invoice' => 'INV-20260907-0012',
                'time' => '10:45:12',
                'date' => '07 Sep 2026',
                'cashier' => 'Siti Kasir',
                'payment_method' => 'Tunai',
                'total' => 84000,
                'paid' => 100000,
                'change' => 16000,
                'items_count' => 3,
                'status' => 'Selesai',
                'items' => [
                    ['name' => 'Iced Caramel Macchiato', 'qty' => 2, 'price' => 34000, 'subtotal' => 68000],
                    ['name' => 'Espresso Single', 'qty' => 1, 'price' => 18000, 'subtotal' => 18000],
                ]
            ],
            [
                'invoice' => 'INV-20260907-0011',
                'time' => '10:20:05',
                'date' => '07 Sep 2026',
                'cashier' => 'Siti Kasir',
                'payment_method' => 'QRIS',
                'total' => 52000,
                'paid' => 52000,
                'change' => 0,
                'items_count' => 2,
                'status' => 'Selesai',
                'items' => [
                    ['name' => 'Butter Croissant Crispy', 'qty' => 1, 'price' => 24000, 'subtotal' => 24000],
                    ['name' => 'Cappuccino Warm', 'qty' => 1, 'price' => 28000, 'subtotal' => 28000],
                ]
            ],
            [
                'invoice' => 'INV-20260907-0010',
                'time' => '09:55:40',
                'date' => '07 Sep 2026',
                'cashier' => 'Siti Kasir',
                'payment_method' => 'Tunai',
                'total' => 30000,
                'paid' => 50000,
                'change' => 20000,
                'items_count' => 1,
                'status' => 'Selesai',
                'items' => [
                    ['name' => 'Matcha Kyoto Latte', 'qty' => 1, 'price' => 30000, 'subtotal' => 30000],
                ]
            ],
            [
                'invoice' => 'INV-20260907-0009',
                'time' => '09:12:18',
                'date' => '07 Sep 2026',
                'cashier' => 'Siti Kasir',
                'payment_method' => 'QRIS',
                'total' => 64000,
                'paid' => 64000,
                'change' => 0,
                'items_count' => 2,
                'status' => 'Selesai',
                'items' => [
                    ['name' => 'Truffle Fries & Dip', 'qty' => 1, 'price' => 32000, 'subtotal' => 32000],
                    ['name' => 'Iced Spanish Latte', 'qty' => 1, 'price' => 32000, 'subtotal' => 32000],
                ]
            ],
        ];

        return view('pos.history', compact('transactions'));
    }

    public function checkout(Request $request)
    {
        return redirect()->route('pos.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}
