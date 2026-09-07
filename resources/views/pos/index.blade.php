<x-layouts.pos>
    <div x-data="posApp()" class="flex-1 flex overflow-hidden w-full">
        <section class="flex-1 flex flex-col min-w-0 bg-stone-100 overflow-hidden border-r border-stone-200">
            <div class="p-4 bg-white border-b border-stone-200 space-y-3 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            placeholder="Cari menu kopi, minuman, atau makanan..." 
                            class="w-full pl-10 pr-4 py-2 bg-stone-50 rounded-xl border border-stone-200 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition"
                        >
                    </div>

                    <button 
                        type="button" 
                        x-show="searchQuery" 
                        @click="searchQuery = ''" 
                        class="px-3 py-2 text-xs font-semibold text-stone-600 hover:text-stone-900 transition"
                    >
                        Reset
                    </button>
                </div>

                <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                    <template x-for="cat in categories" :key="cat.id">
                        <button 
                            type="button" 
                            @click="activeCategory = cat.id"
                            :class="activeCategory === cat.id ? 'bg-stone-900 text-white font-semibold shadow-sm' : 'bg-stone-100 text-stone-600 hover:bg-stone-200 font-medium'"
                            class="px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition"
                            x-text="cat.name"
                        ></button>
                    </template>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-5">
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                    <template x-for="item in filteredProducts()" :key="item.id">
                        <div 
                            @click="addToCart(item)"
                            class="group bg-white rounded-xl border border-stone-200 hover:border-amber-500 hover:shadow-md transition cursor-pointer flex flex-col overflow-hidden select-none active:scale-[0.98]"
                        >
                            <div class="aspect-[4/3] bg-stone-200 overflow-hidden relative">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                                <div class="absolute top-2 right-2 bg-stone-900/80 backdrop-blur text-white text-[11px] font-mono px-2 py-0.5 rounded-md">
                                    Stok: <span x-text="item.stock"></span>
                                </div>
                            </div>
                            <div class="p-3.5 flex-1 flex flex-col justify-between">
                                <div>
                                    <span class="text-[11px] font-medium text-amber-700 tracking-wide uppercase" x-text="item.category"></span>
                                    <h3 class="font-bold text-stone-900 text-sm leading-snug mt-0.5 group-hover:text-amber-700 transition" x-text="item.name"></h3>
                                </div>
                                <div class="mt-3 flex items-center justify-between pt-2 border-t border-stone-100">
                                    <span class="font-mono font-bold text-stone-900 text-sm" x-text="formatRupiah(item.price)"></span>
                                    <div class="w-7 h-7 rounded-lg bg-stone-100 group-hover:bg-amber-600 group-hover:text-white text-stone-600 flex items-center justify-center transition">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="filteredProducts().length === 0" class="h-64 flex flex-col items-center justify-center text-center p-6">
                    <div class="w-12 h-12 rounded-full bg-stone-200 flex items-center justify-center text-stone-400 mb-3">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-stone-800">Menu tidak ditemukan</p>
                    <p class="text-xs text-stone-500 mt-1">Coba kata kunci lain atau pilih kategori lain.</p>
                </div>
            </div>
        </section>

        <aside class="w-96 xl:w-[420px] bg-white flex flex-col shrink-0 border-l border-stone-200 z-10">
            <div class="p-4 border-b border-stone-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-stone-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <h2 class="font-bold text-stone-900 text-sm">Pesanan Aktif</h2>
                    <span class="bg-stone-100 text-stone-700 text-xs font-mono font-semibold px-2 py-0.5 rounded-full" x-text="cart.reduce((a, b) => a + b.qty, 0)"></span>
                </div>

                <button 
                    type="button" 
                    x-show="cart.length > 0" 
                    @click="clearCart()" 
                    class="text-xs font-medium text-red-600 hover:text-red-700 transition"
                >
                    Kosongkan
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200 flex flex-col gap-2">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-stone-900 text-xs truncate" x-text="item.name"></h4>
                                <span class="text-[11px] font-mono text-stone-500" x-text="formatRupiah(item.price)"></span>
                            </div>
                            <span class="font-mono font-bold text-stone-900 text-xs" x-text="formatRupiah(item.price * item.qty)"></span>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <input 
                                type="text" 
                                x-model="item.notes" 
                                placeholder="Catatan (opsional)..." 
                                class="text-[11px] bg-white border border-stone-200 rounded-md px-2 py-1 flex-1 mr-3 focus:outline-none focus:ring-1 focus:ring-amber-500"
                            >

                            <div class="flex items-center gap-1">
                                <button 
                                    type="button" 
                                    @click="updateQty(index, -1)" 
                                    class="w-6 h-6 rounded-md bg-white border border-stone-300 hover:bg-stone-100 flex items-center justify-center text-stone-700 font-bold text-xs"
                                >
                                    -
                                </button>
                                <span class="w-6 text-center font-mono font-bold text-xs" x-text="item.qty"></span>
                                <button 
                                    type="button" 
                                    @click="updateQty(index, 1)" 
                                    class="w-6 h-6 rounded-md bg-white border border-stone-300 hover:bg-stone-100 flex items-center justify-center text-stone-700 font-bold text-xs"
                                >
                                    +
                                </button>
                                <button 
                                    type="button" 
                                    @click="removeFromCart(index)" 
                                    class="w-6 h-6 rounded-md text-stone-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center ml-1 transition"
                                >
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="cart.length === 0" class="h-64 flex flex-col items-center justify-center text-center p-6">
                    <div class="w-12 h-12 rounded-full bg-stone-100 flex items-center justify-center text-stone-400 mb-3">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-stone-700">Keranjang masih kosong</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">Pilih menu di sebelah kiri untuk menambahkan pesanan.</p>
                </div>
            </div>

            <div class="p-4 border-t border-stone-200 bg-stone-50 space-y-3">
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center justify-between text-stone-600">
                        <span>Subtotal</span>
                        <span class="font-mono font-medium text-stone-900" x-text="formatRupiah(subtotal())"></span>
                    </div>
                    <div class="flex items-center justify-between text-stone-600">
                        <span>Pajak Resto (10%)</span>
                        <span class="font-mono font-medium text-stone-900" x-text="formatRupiah(tax())"></span>
                    </div>
                    <div class="pt-2 border-t border-stone-200 flex items-center justify-between text-sm font-bold text-stone-900">
                        <span>Total Akhir</span>
                        <span class="font-mono text-base text-amber-700" x-text="formatRupiah(total())"></span>
                    </div>
                </div>

                <button 
                    type="button" 
                    :disabled="cart.length === 0" 
                    @click="openCheckoutModal()" 
                    :class="cart.length > 0 ? 'bg-amber-600 hover:bg-amber-700 active:scale-[0.99] text-white shadow-md' : 'bg-stone-300 text-stone-500 cursor-not-allowed'"
                    class="w-full py-3 px-4 rounded-xl font-bold text-sm transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    <span>Bayar Sekarang (<span x-text="formatRupiah(total())"></span>)</span>
                </button>
            </div>
        </aside>

        <div 
            x-show="isCheckoutModalOpen" 
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-xs"
            x-cloak
        >
            <div 
                @click.away="isCheckoutModalOpen = false" 
                class="bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-stone-200 overflow-hidden flex flex-col"
            >
                <div class="p-5 bg-stone-900 text-white flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-base">Pembayaran Transaksi</h3>
                        <p class="text-xs text-stone-400 font-mono">Invoice Kasir #INV-{{ date('Ymd') }}-NEW</p>
                    </div>
                    <button type="button" @click="isCheckoutModalOpen = false" class="text-stone-400 hover:text-white font-bold text-lg">&times;</button>
                </div>

                <div class="p-6 space-y-5">
                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 flex items-center justify-between">
                        <span class="text-xs font-semibold text-amber-900 uppercase tracking-wider">Total Tagihan</span>
                        <span class="font-mono text-xl font-bold text-amber-950" x-text="formatRupiah(total())"></span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button 
                                type="button" 
                                @click="paymentMethod = 'Tunai'" 
                                :class="paymentMethod === 'Tunai' ? 'border-amber-600 bg-amber-50/50 text-amber-900 font-bold ring-2 ring-amber-600/20' : 'border-stone-200 text-stone-700 hover:bg-stone-50 font-medium'"
                                class="p-3 rounded-xl border text-xs flex items-center justify-center gap-2 transition"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Tunai (Cash)</span>
                            </button>

                            <button 
                                type="button" 
                                @click="paymentMethod = 'QRIS'; cashReceived = total()" 
                                :class="paymentMethod === 'QRIS' ? 'border-amber-600 bg-amber-50/50 text-amber-900 font-bold ring-2 ring-amber-600/20' : 'border-stone-200 text-stone-700 hover:bg-stone-50 font-medium'"
                                class="p-3 rounded-xl border text-xs flex items-center justify-center gap-2 transition"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                                <span>QRIS / Non-Tunai</span>
                            </button>
                        </div>
                    </div>

                    <div x-show="paymentMethod === 'Tunai'" class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Uang Diterima (Rp)</label>
                            <input 
                                type="number" 
                                x-model.number="cashReceived" 
                                class="w-full px-4 py-2.5 rounded-xl border border-stone-300 font-mono text-lg font-bold text-stone-900 focus:ring-2 focus:ring-amber-500 focus:outline-none"
                                placeholder="0"
                            >
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold text-stone-500 block mb-1.5">Pilihan Cepat Uang Pas & Nominal:</span>
                            <div class="grid grid-cols-4 gap-2">
                                <button 
                                    type="button" 
                                    @click="cashReceived = total()" 
                                    class="px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg text-xs font-semibold transition"
                                >
                                    Uang Pas
                                </button>
                                <button 
                                    type="button" 
                                    @click="cashReceived = 20000" 
                                    class="px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg text-xs font-mono font-medium transition"
                                >
                                    20.000
                                </button>
                                <button 
                                    type="button" 
                                    @click="cashReceived = 50000" 
                                    class="px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg text-xs font-mono font-medium transition"
                                >
                                    50.000
                                </button>
                                <button 
                                    type="button" 
                                    @click="cashReceived = 100000" 
                                    class="px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg text-xs font-mono font-medium transition"
                                >
                                    100.000
                                </button>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-between">
                            <span class="text-xs font-semibold text-stone-600">Kembalian:</span>
                            <span 
                                class="font-mono text-lg font-bold" 
                                :class="change() >= 0 ? 'text-emerald-700' : 'text-red-600'" 
                                x-text="formatRupiah(change())"
                            ></span>
                        </div>
                    </div>

                    <div x-show="paymentMethod === 'QRIS'" class="p-6 bg-stone-50 rounded-xl border border-stone-200 flex flex-col items-center justify-center text-center">
                        <div class="w-36 h-36 bg-white p-2 border border-stone-300 rounded-xl shadow-xs mb-3 flex items-center justify-center">
                            <svg class="w-28 h-28 text-stone-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                <line x1="17" y1="7" x2="17.01" y2="7"></line>
                                <line x1="7" y1="17" x2="7.01" y2="17"></line>
                                <line x1="17" y1="17" x2="17.01" y2="17"></line>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-stone-800">Scan QRIS Kopi Senja</span>
                        <span class="text-[11px] text-stone-500 mt-0.5">BCA, Mandiri, GoPay, OVO, ShopeePay</span>
                    </div>
                </div>

                <div class="p-4 bg-stone-50 border-t border-stone-200 flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        @click="isCheckoutModalOpen = false" 
                        class="px-4 py-2 text-xs font-semibold text-stone-600 hover:text-stone-900 rounded-lg transition"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        :disabled="paymentMethod === 'Tunai' && cashReceived < total()" 
                        @click="confirmPayment()" 
                        :class="paymentMethod === 'Tunai' && cashReceived < total() ? 'bg-stone-300 text-stone-500 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm'"
                        class="px-5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Selesaikan Transaksi</span>
                    </button>
                </div>
            </div>
        </div>

        <div 
            x-show="isReceiptModalOpen" 
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/70 backdrop-blur-xs"
            x-cloak
        >
            <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl border border-stone-200 overflow-hidden flex flex-col">
                <div class="p-4 bg-stone-900 text-white flex items-center justify-between">
                    <span class="text-xs font-bold">Struk Transaksi Selesai</span>
                    <button type="button" @click="isReceiptModalOpen = false" class="text-stone-400 hover:text-white font-bold">&times;</button>
                </div>

                <div class="p-6 bg-stone-100 overflow-y-auto max-h-[70vh] flex justify-center">
                    <div id="thermal-receipt" class="bg-white p-5 border border-stone-300 shadow-sm w-full font-mono text-xs text-stone-900 leading-relaxed">
                        <div class="text-center pb-3 border-b border-dashed border-stone-400">
                            <h2 class="font-bold text-sm tracking-wider uppercase">KOPI SENJA CAFÉ</h2>
                            <p class="text-[10px] text-stone-600">Jl. Malioboro No. 45, Yogyakarta</p>
                            <p class="text-[10px] text-stone-600">Telp: 0812-3456-7890</p>
                        </div>

                        <div class="py-2.5 border-b border-dashed border-stone-400 text-[11px] space-y-0.5">
                            <div class="flex justify-between">
                                <span>No. Struk</span>
                                <span class="font-semibold" x-text="receiptData.invoice"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal</span>
                                <span x-text="receiptData.date"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kasir</span>
                                <span>Siti Kasir</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Metode</span>
                                <span x-text="receiptData.paymentMethod"></span>
                            </div>
                        </div>

                        <div class="py-2.5 border-b border-dashed border-stone-400 space-y-1.5">
                            <template x-for="item in receiptData.items" :key="item.id">
                                <div>
                                    <div class="flex justify-between font-semibold">
                                        <span x-text="item.name"></span>
                                        <span x-text="formatRupiah(item.price * item.qty)"></span>
                                    </div>
                                    <div class="flex justify-between text-[10px] text-stone-500">
                                        <span><span x-text="item.qty"></span> x <span x-text="formatRupiah(item.price)"></span></span>
                                        <span x-show="item.notes" class="italic" x-text="'(' + item.notes + ')'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="py-2.5 border-b border-dashed border-stone-400 text-[11px] space-y-0.5">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span x-text="formatRupiah(receiptData.subtotal)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pajak (10%)</span>
                                <span x-text="formatRupiah(receiptData.tax)"></span>
                            </div>
                            <div class="flex justify-between font-bold text-xs pt-1">
                                <span>TOTAL</span>
                                <span x-text="formatRupiah(receiptData.total)"></span>
                            </div>
                            <div class="flex justify-between pt-1">
                                <span>Bayar</span>
                                <span x-text="formatRupiah(receiptData.paid)"></span>
                            </div>
                            <div class="flex justify-between font-bold">
                                <span>Kembali</span>
                                <span x-text="formatRupiah(receiptData.change)"></span>
                            </div>
                        </div>

                        <div class="text-center pt-3 text-[10px] text-stone-600">
                            <p class="font-semibold">TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
                            <p>Instagram: @kopisenja.id</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white border-t border-stone-200 flex items-center justify-between gap-2">
                    <button 
                        type="button" 
                        @click="isReceiptModalOpen = false" 
                        class="px-4 py-2 text-xs font-semibold text-stone-600 hover:text-stone-900 rounded-lg transition"
                    >
                        Tutup
                    </button>
                    <button 
                        type="button" 
                        @click="printThermalReceipt()" 
                        class="px-5 py-2 bg-stone-900 hover:bg-stone-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span>Cetak Struk Thermal</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function posApp() {
            return {
                products: @json($products),
                categories: @json($categories),
                activeCategory: 0,
                searchQuery: '',
                cart: [],
                isCheckoutModalOpen: false,
                isReceiptModalOpen: false,
                paymentMethod: 'Tunai',
                cashReceived: 0,
                receiptData: {
                    invoice: '',
                    date: '',
                    items: [],
                    subtotal: 0,
                    tax: 0,
                    total: 0,
                    paid: 0,
                    change: 0,
                    paymentMethod: 'Tunai'
                },

                filteredProducts() {
                    return this.products.filter(item => {
                        const matchCat = this.activeCategory === 0 || item.category_id === this.activeCategory;
                        const matchSearch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchCat && matchSearch;
                    });
                },

                addToCart(product) {
                    const existing = this.cart.find(c => c.id === product.id);
                    if (existing) {
                        existing.qty++;
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            qty: 1,
                            notes: ''
                        });
                    }
                },

                updateQty(index, delta) {
                    this.cart[index].qty += delta;
                    if (this.cart[index].qty <= 0) {
                        this.cart.splice(index, 1);
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                clearCart() {
                    this.cart = [];
                },

                subtotal() {
                    return this.cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
                },

                tax() {
                    return Math.round(this.subtotal() * 0.1);
                },

                total() {
                    return this.subtotal() + this.tax();
                },

                change() {
                    if (this.paymentMethod === 'QRIS') return 0;
                    return Math.max(0, this.cashReceived - this.total());
                },

                openCheckoutModal() {
                    this.cashReceived = this.total();
                    this.isCheckoutModalOpen = true;
                },

                async confirmPayment() {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const paidAmount = this.paymentMethod === 'QRIS' ? this.total() : this.cashReceived;
                    const payload = {
                        cart: this.cart.map(c => ({
                            id: c.id,
                            quantity: c.qty,
                            price: c.price,
                            notes: c.notes || null
                        })),
                        payment_method: this.paymentMethod.toLowerCase(),
                        paid_amount: paidAmount
                    };

                    const cartCopy = JSON.parse(JSON.stringify(this.cart));
                    const now = new Date();
                    let invoiceNum = 'INV-' + now.getFullYear() + String(now.getMonth() + 1).padStart(2, '0') + String(now.getDate()).padStart(2, '0') + '-' + Math.floor(1000 + Math.random() * 9000);

                    try {
                        const response = await fetch('/pos/checkout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(payload)
                        });

                        if (response.ok) {
                            const result = await response.json();
                            if (result.invoice_number) {
                                invoiceNum = result.invoice_number;
                            }
                        }
                    } catch (e) {}

                    this.receiptData = {
                        invoice: invoiceNum,
                        date: now.toLocaleDateString('id-ID') + ' ' + now.toLocaleTimeString('id-ID', { hour12: false }),
                        items: cartCopy,
                        subtotal: this.subtotal(),
                        tax: this.tax(),
                        total: this.total(),
                        paid: paidAmount,
                        change: this.change(),
                        paymentMethod: this.paymentMethod
                    };

                    this.isCheckoutModalOpen = false;
                    this.cart = [];
                    this.isReceiptModalOpen = true;
                },

                printThermalReceipt() {
                    window.print();
                },

                formatRupiah(amount) {
                    return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
                }
            };
        }
    </script>
</x-layouts.pos>
