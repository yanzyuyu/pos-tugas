<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendRoutesTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    public function test_root_redirects_to_pos(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/pos');
    }

    public function test_login_page_renders_cleanly(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Kopi Senja POS');
    }

    public function test_pos_cashier_page_renders_cleanly(): void
    {
        $response = $this->get('/pos');
        $response->assertStatus(200);
        $response->assertSee('Kopi Senja POS');
        $response->assertSee('Pesanan Aktif');
        $response->assertSee('Espresso Single');
    }

    public function test_pos_history_page_renders_cleanly(): void
    {
        $response = $this->get('/pos/history');
        $response->assertStatus(200);
        $response->assertSee('Riwayat Transaksi Kasir');
    }

    public function test_admin_dashboard_renders_cleanly(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Manajemen');
    }

    public function test_admin_categories_renders_cleanly(): void
    {
        $response = $this->get('/admin/categories');
        $response->assertStatus(200);
        $response->assertSee('Master Data Kategori');
    }

    public function test_admin_products_renders_cleanly(): void
    {
        $response = $this->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Master Data Menu & Produk', false);
    }

    public function test_admin_users_renders_cleanly(): void
    {
        $response = $this->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee('Kelola Akun Pengguna');
    }

    public function test_admin_reports_renders_cleanly(): void
    {
        $response = $this->get('/admin/reports');
        $response->assertStatus(200);
        $response->assertSee('Laporan Penjualan & Omzet', false);
    }

    public function test_auth_admin_login_redirects_to_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@kopisenja.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_auth_kasir_login_redirects_to_pos(): void
    {
        $response = $this->post('/login', [
            'email' => 'kasir@kopisenja.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/pos');
        $this->assertAuthenticated();
    }

    public function test_pos_checkout_creates_transaction_and_decrements_stock(): void
    {
        $user = \App\Models\User::where('role', 'kasir')->first();
        $product = \App\Models\Product::first();
        $initialStock = $product->stock;

        $response = $this->actingAs($user)->post('/pos/checkout', [
            'cart' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                    'price' => $product->price,
                    'notes' => 'Less sugar',
                ],
            ],
            'payment_method' => 'tunai',
            'paid_amount' => 50000,
        ]);

        $response->assertRedirect('/pos');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'payment_method' => 'tunai',
        ]);

        $transaction = \App\Models\Transaction::latest()->first();
        $this->assertNotNull($transaction);
        $this->assertStringStartsWith('INV-', $transaction->invoice_number);

        $this->assertDatabaseHas('transaction_details', [
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'notes' => 'Less sugar',
        ]);

        $product->refresh();
        $this->assertEquals($initialStock - 2, $product->stock);
    }

    public function test_pos_history_displays_persisted_transaction(): void
    {
        $user = \App\Models\User::where('role', 'kasir')->first();
        $product = \App\Models\Product::first();

        $this->actingAs($user)->post('/pos/checkout', [
            'cart' => [
                [
                    'id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ],
            ],
            'payment_method' => 'qris',
            'paid_amount' => $product->price,
        ]);

        $transaction = \App\Models\Transaction::latest()->first();

        $response = $this->actingAs($user)->get('/pos/history');
        $response->assertStatus(200);
        $response->assertSee($transaction->invoice_number);
    }
}
