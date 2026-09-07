<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categoryList = collect([['id' => 0, 'name' => 'Semua Menu']])->concat($categories);

        $products = Product::with('category')
            ->where('status', 'tersedia')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'category_id' => $p->category_id,
                    'name' => $p->name,
                    'category' => optional($p->category)->name ?? '',
                    'price' => (float) $p->price,
                    'stock' => (int) $p->stock,
                    'image' => $p->image ?? 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=500&auto=format&fit=crop&q=60',
                    'status' => $p->status,
                ];
            });

        return view('pos.index', [
            'products' => $products,
            'categories' => $categoryList,
        ]);
    }

    public function history()
    {
        $transactions = Transaction::with(['details.product', 'user'])
            ->latest()
            ->get()
            ->map(function ($tx) {
                $items = $tx->details->map(function ($d) {
                    return [
                        'name' => optional($d->product)->name ?? 'Menu',
                        'qty' => (int) $d->quantity,
                        'price' => (float) $d->price,
                        'subtotal' => (float) $d->subtotal,
                        'notes' => $d->notes,
                    ];
                });

                $subtotal = $items->sum('subtotal');
                $tax = max(0, (float) $tx->total_amount - $subtotal);

                return [
                    'id' => $tx->id,
                    'invoice' => $tx->invoice_number,
                    'date' => $tx->created_at ? $tx->created_at->format('d M Y') : now()->format('d M Y'),
                    'time' => $tx->created_at ? $tx->created_at->format('H:i:s') : now()->format('H:i:s'),
                    'cashier' => optional($tx->user)->name ?? 'Kasir',
                    'payment_method' => strtoupper($tx->payment_method) === 'QRIS' ? 'QRIS' : 'Tunai',
                    'items_count' => (int) $tx->details->sum('quantity'),
                    'total' => (float) $tx->total_amount,
                    'paid' => (float) $tx->paid_amount,
                    'change' => (float) $tx->change_amount,
                    'status' => 'Selesai',
                    'items' => $items->values()->toArray(),
                    'subtotal' => (float) $subtotal,
                    'tax' => (float) $tax,
                ];
            });

        return view('pos.history', compact('transactions'));
    }

    public function checkout(Request $request)
    {
        $cart = is_string($request->cart) ? json_decode($request->cart, true) : $request->cart;
        $request->merge(['cart' => $cart]);

        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric',
            'payment_method' => 'required|in:tunai,qris,Tunai,QRIS',
            'paid_amount' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            foreach ($request->cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            $paidAmount = (float) $request->paid_amount;
            $paymentMethod = strtolower($request->payment_method);
            if ($paymentMethod === 'qris') {
                $paidAmount = $totalAmount;
            }
            $changeAmount = max(0, $paidAmount - $totalAmount);

            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id() ?? 1,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $paymentMethod,
            ]);

            foreach ($request->cart as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                    'notes' => $item['notes'] ?? null,
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                    if ($product->stock < 0) {
                        $product->update(['stock' => 0]);
                    }
                }
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil disimpan!',
                    'invoice_number' => $invoiceNumber,
                    'transaction_id' => $transaction->id,
                ]);
            }

            return redirect()->route('pos.index')->with('success', 'Transaksi berhasil disimpan!');
        });
    }
}
