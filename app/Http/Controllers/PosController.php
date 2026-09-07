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
        $products = Product::with('category')->where('status', 'tersedia')->get();

        return view('pos.index', compact('products', 'categories'));
    }

    public function history()
    {
        $transactions = Transaction::with(['details.product', 'user'])->latest()->get();

        return view('pos.history', compact('transactions'));
    }

    public function checkout(Request $request)
    {
        // Decode cart if it's sent as JSON string
        $cart = is_string($request->cart) ? json_decode($request->cart, true) : $request->cart;

        $request->merge(['cart' => $cart]);

        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric',
            'payment_method' => 'required|in:tunai,qris',
            'paid_amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($request->cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }
            
            $paidAmount = $request->paid_amount;
            $changeAmount = $paidAmount - $totalAmount;

            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id() ?? 1,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => $changeAmount > 0 ? $changeAmount : 0,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($request->cart as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    if ($product->stock < 0) {
                        $product->stock = 0;
                    }
                    $product->save();
                }
            }

            DB::commit();

            return redirect()->route('pos.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }
}
