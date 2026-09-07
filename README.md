# POS (Point of Sale) Café

Sistem kasir digital berbasis web menggunakan Laravel 12 dan MySQL. Proyek ini memfasilitasi transaksi POS, pencatatan pendapatan harian, dan manajemen menu serta kasir oleh admin, menggantikan pencatatan manual di balai/cafe.

## Tahap 1: Perencanaan & Desain Database

### 1. Aktor dan Use Case Sistem

Sistem ini memiliki dua role utama dengan batasan otorisasi akses:

- **Admin**: Memiliki akses penuh (Master Data dan Laporan).
- **Kasir**: Akses terbatas pada modul Transaksi POS dan Riwayat Transaksi kasir tersebut.

```mermaid
flowchart LR
    Admin([Admin])
    Kasir([Kasir])

    subgraph Modul Admin
        A1(Kelola Kategori Menu)
        A2(Kelola Produk)
        A3(Kelola User)
        A4(Lihat Laporan Penjualan)
    end

    subgraph Modul Kasir
        K1(Antarmuka POS Interaktif)
        K2(Kelola Keranjang Pesanan)
        K3(Proses Pembayaran & Kembalian)
        K4(Cetak Struk/Invoice)
        K5(Lihat Riwayat Transaksi Sendiri)
    end

    Admin --> A1
    Admin --> A2
    Admin --> A3
    Admin --> A4
    Admin --> K5

    Kasir --> K1
    Kasir --> K2
    Kasir --> K3
    Kasir --> K4
    Kasir --> K5
```

### 2. Entity Relationship Diagram (ERD)

Skema database dirancang untuk mendukung manajemen menu dan relasional transaksi POS.

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email
        string password
        enum role "admin, kasir"
        datetime created_at
        datetime updated_at
    }
    categories {
        bigint id PK
        string name
        string description
        datetime created_at
        datetime updated_at
    }
    products {
        bigint id PK
        bigint category_id FK
        string name
        integer price
        integer stock "opsional"
        string image_path
        datetime created_at
        datetime updated_at
    }
    transactions {
        bigint id PK
        bigint user_id FK "Kasir pemroses transaksi"
        integer total_amount
        integer pay_amount
        integer return_amount
        datetime transaction_date
        datetime created_at
        datetime updated_at
    }
    transaction_details {
        bigint id PK
        bigint transaction_id FK
        bigint product_id FK
        integer quantity
        integer price "harga saat transaksi"
        integer subtotal
        datetime created_at
        datetime updated_at
    }

    users ||--o{ transactions : "memproses"
    categories ||--o{ products : "mempunyai"
    transactions ||--|{ transaction_details : "berisi"
    products ||--o{ transaction_details : "dicatat pada"
```

## Tahap 2 & Tahap 3
(Dalam proses implementasi codebase)
