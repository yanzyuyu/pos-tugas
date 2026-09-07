# Panduan Pengerjaan Backend - Sistem POS Cafe

Dokumen ini adalah instruksi langkah demi langkah bagi tim backend untuk mengimplementasikan database, model, dan logika controller pada sistem POS Cafe (Laravel 12 & MySQL).

Frontend, tampilan blade, interaksi keranjang belanja, cetak struk thermal, dan rute navigasi sudah selesai dibuat. Tugas backend adalah menghubungkan sistem ini ke database MySQL asli.

---

## Ringkasan Progres Frontend yang Sudah Jadi
- Seluruh antarmuka Blade telah tersedia di folder `resources/views/`.
- Frontend saat ini menggunakan mock data di dalam 3 Controller:
  - `app/Http/Controllers/PosController.php`
  - `app/Http/Controllers/AdminController.php`
  - `app/Http/Controllers/AuthController.php`
- Anda tidak perlu mengubah kode HTML/Blade kecuali jika ada variabel data yang perlu disesuaikan.

---

## Langkah 1: Persiapan Environment & Database

1. Tarik pembaruan repositori di laptop Anda:
   ```bash
   git pull origin main
   ```

2. Pastikan file `.env` sudah terkonfigurasi ke database MySQL lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pos_cafe
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Buat database baru bernama `pos_cafe` di MySQL (lewat phpMyAdmin, DBeaver, atau MySQL CLI):
   ```sql
   CREATE DATABASE pos_cafe;
   ```

---

## Langkah 2: Pembuatan Migration (Sesuai ERD)

Ikuti skema tabel yang ada pada dokumen `README.md`.

1. **Tabel `users` (Edit migration bawaan):**
   Tambahkan kolom `role` pada file migration `database/migrations/0001_01_01_000000_create_users_table.php`:
   ```php
   $table->enum('role', ['admin', 'kasir'])->default('kasir');
   ```

2. **Buat Migration Kategori:**
   ```bash
   php artisan make:migration create_categories_table
   ```
   Isi kolom:
   - `id` (bigIncrements)
   - `name` (string)
   - `slug` (string, unique)
   - `timestamps()`

3. **Buat Migration Produk:**
   ```bash
   php artisan make:migration create_products_table
   ```
   Isi kolom:
   - `id` (bigIncrements)
   - `category_id` (foreignId constrained onDelete cascade)
   - `name` (string)
   - `price` (decimal, total 12, 2)
   - `stock` (integer, default 0)
   - `image` (string, nullable)
   - `status` (enum: 'tersedia', 'habis', default 'tersedia')
   - `timestamps()`

4. **Buat Migration Transaksi:**
   ```bash
   php artisan make:migration create_transactions_table
   ```
   Isi kolom:
   - `id` (bigIncrements)
   - `invoice_number` (string, unique)
   - `user_id` (foreignId constrained ke tabel users)
   - `total_amount` (decimal 12, 2)
   - `paid_amount` (decimal 12, 2)
   - `change_amount` (decimal 12, 2)
   - `payment_method` (enum: 'tunai', 'qris')
   - `timestamps()`

5. **Buat Migration Detail Transaksi:**
   ```bash
   php artisan make:migration create_transaction_details_table
   ```
   Isi kolom:
   - `id` (bigIncrements)
   - `transaction_id` (foreignId constrained onDelete cascade)
   - `product_id` (foreignId constrained)
   - `quantity` (integer)
   - `price` (decimal 12, 2)
   - `subtotal` (decimal 12, 2)
   - `notes` (string, nullable)
   - `timestamps()`

---

## Langkah 3: Pembuatan Model Eloquent & Relasi

Buat model-model berikut:
```bash
php artisan make:model Category
php artisan make:model Product
php artisan make:model Transaction
php artisan make:model TransactionDetail
```

Tentukan relasi antar model:
- `Category` `hasMany` `Product`
- `Product` `belongsTo` `Category`
- `User` `hasMany` `Transaction`
- `Transaction` `belongsTo` `User`
- `Transaction` `hasMany` `TransactionDetail`
- `TransactionDetail` `belongsTo` `Transaction`
- `TransactionDetail` `belongsTo` `Product`

Pastikan `$guarded = ['id'];` atau `$fillable` sudah diatur pada setiap model.

---

## Langkah 4: Database Seeder

Buat seeder untuk data awal agar aplikasi langsung memiliki akun admin, kasir, kategori, dan menu contoh:
```bash
php artisan make:seeder DatabaseSeeder
```

Data yang wajib ada:
1. Akun default Admin:
   - Email: `admin@kopisenja.id`
   - Password: `password` (disimpan via `Hash::make('password')`)
   - Role: `admin`
2. Akun default Kasir:
   - Email: `kasir@kopisenja.id`
   - Password: `password`
   - Role: `kasir`
3. Kategori: Kopi Panas, Kopi Dingin, Non-Kopi, Makanan Ringan.
4. Minimal 8-12 produk contoh dengan harga dan stok.

Jalankan migration & seeder:
```bash
php artisan migrate:fresh --seed
```

---

## Langkah 5: Integrasi Logika ke Controller

Ganti logika array tiruan (*mock array*) di file controller berikut dengan query database Eloquent asli:

### 1. `app/Http/Controllers/PosController.php`
- `index()`: Ambil kategori dari `Category::all()` dan produk dari `Product::with('category')->where('status', 'tersedia')->get()`.
- `history()`: Ambil transaksi kasir dari `Transaction::with(['details.product', 'user'])->latest()->get()`.
- `checkout(Request $request)`:
  - Validasi request data keranjang belanja dan pembayaran.
  - Generate nomor invoice: `INV-YYYYMMDD-XXXX`.
  - Simpan record ke tabel `transactions` menggunakan database transaction (`DB::transaction(...)`).
  - Simpan item pesanan ke tabel `transaction_details`.
  - Kurangi stok produk di tabel `products`.

### 2. `app/Http/Controllers/AdminController.php`
- `dashboard()`: Hitung omzet hari ini (`Transaction::whereDate('created_at', today())->sum('total_amount')`), jumlah transaksi, dan menu terlaris.
- `categories()`: Hubungkan ke CRUD tabel `categories`.
- `products()`: Hubungkan ke CRUD tabel `products` (termasuk upload gambar jika diperlukan).
- `users()`: Hubungkan ke CRUD tabel `users` (tambah/edit kasir dan admin).
- `reports()`: Buat rekapitulasi data penjualan harian dan bulanan menggunakan agregasi SQL (`groupByRaw('DATE(created_at)')`).

### 3. `app/Http/Controllers/AuthController.php`
- Hubungkan proses login ke `Auth::attempt(['email' => $request->email, 'password' => $request->password])`.
- Lakukan pengecekan role setelah login:
  - Jika role admin: redirect ke route `admin.dashboard`.
  - Jika role kasir: redirect ke route `pos.index`.
- Implementasikan logout dengan `Auth::logout()`.

---

## Langkah 6: Verifikasi Akhir

Jalankan test suite untuk memastikan seluruh rute dan view tetap berjalan normal:
```bash
php artisan test
```

Setelah selesai, lakukan commit dan push:
```bash
git add .
git commit -m "implement database migrations, models, and controllers"
git push origin main
```
