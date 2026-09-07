<x-layouts.app>
    <x-slot:header>Dashboard Manajemen</x-slot:header>
    <x-slot:subtitle>Ringkasan operasional dan penjualan Kopi Senja</x-slot:subtitle>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Pendapatan Hari Ini</span>
                    <span class="text-xl font-bold font-mono text-stone-900 tabular-nums">Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-700">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Transaksi Hari Ini</span>
                    <span class="text-xl font-bold font-mono text-stone-900 tabular-nums">{{ $stats['today_transactions'] }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Rata-rata Keranjang</span>
                    <span class="text-xl font-bold font-mono text-stone-900 tabular-nums">Rp {{ number_format($stats['avg_transaction'], 0, ',', '.') }}</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-700">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Total Menu Aktif</span>
                    <span class="text-xl font-bold font-mono text-stone-900 tabular-nums">{{ $stats['total_products'] }} Menu</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-700">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                        <line x1="6" y1="1" x2="6" y2="4"></line>
                        <line x1="10" y1="1" x2="10" y2="4"></line>
                        <line x1="14" y1="1" x2="14" y2="4"></line>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-stone-200 shadow-xs p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-stone-900 text-sm">Produk Terlaris Hari Ini</h3>
                        <p class="text-xs text-stone-500">Menu dengan volume penjualan tertinggi</p>
                    </div>
                    <a href="{{ route('admin.products') }}" class="text-xs font-semibold text-amber-700 hover:text-amber-800 transition">Lihat Semua Menu &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-stone-200 text-stone-500 font-semibold uppercase tracking-wider">
                                <th class="pb-3">Nama Menu</th>
                                <th class="pb-3">Kategori</th>
                                <th class="pb-3 text-right">Terjual</th>
                                <th class="pb-3 text-right">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 text-stone-700">
                            @foreach($topProducts as $item)
                                <tr class="hover:bg-stone-50 transition">
                                    <td class="py-3 font-semibold text-stone-900">{{ $item['name'] }}</td>
                                    <td class="py-3">
                                        <span class="inline-flex px-2 py-0.5 rounded-md text-[11px] font-medium bg-stone-100 text-stone-700">
                                            {{ $item['category'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right font-mono font-medium tabular-nums">{{ $item['sold'] }} cup</td>
                                    <td class="py-3 text-right font-mono font-bold text-stone-900 tabular-nums">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-stone-200 shadow-xs p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-stone-900 text-sm mb-1">Aksi Cepat Manajemen</h3>
                    <p class="text-xs text-stone-500 mb-4">Shortcut tugas operasional kafe</p>

                    <div class="space-y-2.5">
                        <a href="{{ route('pos.index') }}" class="w-full p-3.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs flex items-center justify-between shadow-xs transition">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                                <span>Buka Layar Kasir</span>
                            </div>
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>

                        <a href="{{ route('admin.products') }}" class="w-full p-3 rounded-xl bg-stone-50 hover:bg-stone-100 border border-stone-200 text-stone-800 font-semibold text-xs flex items-center justify-between transition">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-stone-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Tambah Menu / Produk Baru</span>
                            </div>
                            <span class="text-stone-400">&rarr;</span>
                        </a>

                        <a href="{{ route('admin.categories') }}" class="w-full p-3 rounded-xl bg-stone-50 hover:bg-stone-100 border border-stone-200 text-stone-800 font-semibold text-xs flex items-center justify-between transition">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-stone-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <span>Kelola Kategori Menu</span>
                            </div>
                            <span class="text-stone-400">&rarr;</span>
                        </a>

                        <a href="{{ route('admin.reports') }}" class="w-full p-3 rounded-xl bg-stone-50 hover:bg-stone-100 border border-stone-200 text-stone-800 font-semibold text-xs flex items-center justify-between transition">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-stone-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                                <span>Lihat Laporan Penjualan</span>
                            </div>
                            <span class="text-stone-400">&rarr;</span>
                        </a>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-stone-100 text-center">
                    <p class="text-[11px] text-stone-400">Status Server: Normal &middot; Database: MySQL Connected</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
