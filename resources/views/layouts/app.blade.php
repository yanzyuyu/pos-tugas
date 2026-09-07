<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'POS Café' }} - Kopi Senja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-stone-800 antialiased flex flex-col md:flex-row">
    <aside class="w-full md:w-64 bg-stone-900 text-stone-100 flex flex-col shrink-0 border-r border-stone-800">
        <div class="p-5 flex items-center gap-3 border-b border-stone-800">
            <div class="w-10 h-10 rounded-xl bg-amber-600 flex items-center justify-center font-bold text-white shadow-sm">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-base tracking-tight text-white leading-tight">Kopi Senja</h1>
                <p class="text-xs text-stone-400 font-mono">POS & Management</p>
            </div>
        </div>

        <nav class="p-3 flex-1 space-y-1 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-stone-800 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800/60 hover:text-white' }}">
                <svg class="w-5 h-5 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 transition font-semibold">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
                <span>Kasir (POS)</span>
            </a>

            <div class="pt-4 pb-1 px-3">
                <p class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider">Master Data</p>
            </div>

            <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.categories*') ? 'bg-stone-800 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800/60 hover:text-white' }}">
                <svg class="w-5 h-5 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
                <span>Kategori Menu</span>
            </a>

            <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.products*') ? 'bg-stone-800 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800/60 hover:text-white' }}">
                <svg class="w-5 h-5 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span>Menu / Produk</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.users*') ? 'bg-stone-800 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800/60 hover:text-white' }}">
                <svg class="w-5 h-5 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Kelola Pengguna</span>
            </a>

            <div class="pt-4 pb-1 px-3">
                <p class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider">Laporan & Riwayat</p>
            </div>

            <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.reports*') ? 'bg-stone-800 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800/60 hover:text-white' }}">
                <svg class="w-5 h-5 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>Laporan Penjualan</span>
            </a>

            <a href="{{ route('pos.history') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pos.history*') ? 'bg-stone-800 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800/60 hover:text-white' }}">
                <svg class="w-5 h-5 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Riwayat Transaksi</span>
            </a>
        </nav>

        <div class="p-4 border-t border-stone-800 bg-stone-950/40">
            <div class="flex items-center justify-between text-xs text-stone-400">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                    <span class="font-medium text-stone-200">Admin Utama</span>
                </div>
                <a href="{{ route('login') }}" class="text-stone-400 hover:text-white text-xs underline underline-offset-2">Keluar</a>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <header class="bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-lg font-bold text-stone-900 leading-tight">{{ $header ?? 'Sistem POS' }}</h2>
                <p class="text-xs text-stone-500 font-medium">{{ $subtitle ?? 'Kedai Kopi Senja' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                    <span>Buka POS Kasir</span>
                </a>
            </div>
        </header>

        <main class="p-6 flex-1">
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900 font-bold">&times;</button>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
