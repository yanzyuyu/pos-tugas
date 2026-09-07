<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $todayTransactions = Transaction::whereDate('created_at', today());
        
        $stats = [
            'today_sales' => (clone $todayTransactions)->sum('total_amount'),
            'today_transactions' => (clone $todayTransactions)->count(),
            'avg_transaction' => (clone $todayTransactions)->avg('total_amount') ?? 0,
            'total_products' => Product::count(),
        ];

        $topProducts = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.name', 'categories.name as category', DB::raw('SUM(transaction_details.quantity) as sold'), DB::raw('SUM(transaction_details.subtotal) as revenue'))
            ->groupBy('products.id', 'products.name', 'categories.name')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();
            
        $topProducts = json_decode(json_encode($topProducts), true);

        $recentOrders = Transaction::with('user')
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->invoice_number,
                    'time' => $t->created_at->format('H:i'),
                    'cashier' => optional($t->user)->name ?? 'Unknown',
                    'total' => $t->total_amount,
                    'status' => 'Selesai'
                ];
            })->toArray();

        return view('admin.dashboard', compact('stats', 'topProducts', 'recentOrders'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get()->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'products_count' => $c->products_count,
                'created_at' => $c->created_at->format('d M Y')
            ];
        })->toArray();

        return view('admin.categories.index', compact('categories'));
    }

    public function products()
    {
        $products = Product::with('category')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'category' => optional($p->category)->name,
                'price' => $p->price,
                'stock' => $p->stock,
                'status' => ucfirst($p->status),
            ];
        })->toArray();

        $categories = Category::pluck('name')->toArray();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function users()
    {
        $users = User::all()->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => ucfirst($u->role),
                'status' => 'Aktif',
                'joined' => $u->created_at->format('d M Y')
            ];
        })->toArray();

        return view('admin.users.index', compact('users'));
    }

    public function reports()
    {
        $summary = [
            'total_gross' => Transaction::sum('total_amount'),
            'total_orders' => Transaction::count(),
            'cash_amount' => Transaction::where('payment_method', 'tunai')->sum('total_amount'),
            'qris_amount' => Transaction::where('payment_method', 'qris')->sum('total_amount'),
        ];

        $dailySales = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(id) as transactions'),
            DB::raw('SUM(CASE WHEN payment_method = "tunai" THEN total_amount ELSE 0 END) as cash'),
            DB::raw('SUM(CASE WHEN payment_method = "qris" THEN total_amount ELSE 0 END) as qris'),
            DB::raw('SUM(total_amount) as total')
        )
        ->groupByRaw('DATE(created_at)')
        ->orderByDesc('date')
        ->get()
        ->map(function ($s) {
            return [
                'date' => Carbon::parse($s->date)->format('d M Y'),
                'transactions' => $s->transactions,
                'cash' => $s->cash,
                'qris' => $s->qris,
                'total' => $s->total,
            ];
        })->toArray();

        return view('admin.reports.index', compact('summary', 'dailySales'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus.');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|string',
            'image' => 'nullable|string|max:1000',
        ]);

        $category = Category::where('name', $request->category)->first()
            ?? Category::firstOrCreate(['name' => $request->category], ['slug' => Str::slug($request->category)]);

        Product::create([
            'category_id' => $category->id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => strtolower($request->status) === 'habis' ? 'habis' : 'tersedia',
            'image' => $request->image ?? 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=500&auto=format&fit=crop&q=60',
        ]);

        return redirect()->route('admin.products')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|string',
            'image' => 'nullable|string|max:1000',
        ]);

        $category = Category::where('name', $request->category)->first()
            ?? Category::firstOrCreate(['name' => $request->category], ['slug' => Str::slug($request->category)]);

        $product->update([
            'category_id' => $category->id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => strtolower($request->status) === 'habis' ? 'habis' : 'tersedia',
            'image' => $request->image ?? $product->image,
        ]);

        return redirect()->route('admin.products')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Menu berhasil dihapus.');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => strtolower($request->role) === 'admin' ? 'admin' : 'kasir',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => strtolower($request->role) === 'admin' ? 'admin' : 'kasir',
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Akun berhasil dihapus.');
    }
}
