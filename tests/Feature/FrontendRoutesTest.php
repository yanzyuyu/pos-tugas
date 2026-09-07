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
}
