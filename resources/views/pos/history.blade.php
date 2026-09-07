<x-layouts.app>
    <x-slot:header>Riwayat Transaksi Kasir</x-slot:header>
    <x-slot:subtitle>Daftar transaksi yang diproses pada shift aktif</x-slot:subtitle>

    <div x-data="historyApp()" class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-xs">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input 
                    type="date" 
                    value="2026-09-07" 
                    class="px-3 py-2 bg-stone-50 border border-stone-300 rounded-xl text-xs font-mono font-medium text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
                <select class="px-3 py-2 bg-stone-50 border border-stone-300 rounded-xl text-xs font-medium text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua Metode</option>
                    <option value="Tunai">Tunai</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('pos.index') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Buat Transaksi Baru</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-stone-500 font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4">No. Invoice</th>
                            <th class="py-3.5 px-4">Waktu</th>
                            <th class="py-3.5 px-4">Kasir</th>
                            <th class="py-3.5 px-4 text-center">Metode</th>
                            <th class="py-3.5 px-4 text-center">Item</th>
                            <th class="py-3.5 px-4 text-right">Total Tagihan</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700">
                        @foreach($transactions as $tx)
                            <tr class="hover:bg-stone-50/80 transition">
                                <td class="py-3.5 px-4 font-mono font-bold text-stone-900">
                                    {{ $tx['invoice'] }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-stone-600">
                                    {{ $tx['date'] }} <span class="text-stone-400">&middot;</span> {{ $tx['time'] }}
                                </td>
                                <td class="py-3.5 px-4 font-medium text-stone-800">
                                    {{ $tx['cashier'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-md text-[11px] font-semibold {{ $tx['payment_method'] === 'QRIS' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                        {{ $tx['payment_method'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono">
                                    {{ $tx['items_count'] }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-mono font-bold text-stone-900 tabular-nums">
                                    Rp {{ number_format($tx['total'], 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $tx['status'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button 
                                        type="button" 
                                        @click="showDetail(@json($tx))" 
                                        class="px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1"
                                    >
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span>Struk</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div 
            x-show="isDetailModalOpen" 
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/70 backdrop-blur-xs"
            x-cloak
        >
            <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl border border-stone-200 overflow-hidden flex flex-col">
                <div class="p-4 bg-stone-900 text-white flex items-center justify-between">
                    <span class="text-xs font-bold">Detail Struk Transaksi</span>
                    <button type="button" @click="isDetailModalOpen = false" class="text-stone-400 hover:text-white font-bold">&times;</button>
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
                                <span class="font-semibold" x-text="selectedTx.invoice"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal</span>
                                <span x-text="selectedTx.date + ' ' + selectedTx.time"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kasir</span>
                                <span x-text="selectedTx.cashier"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Metode</span>
                                <span x-text="selectedTx.payment_method"></span>
                            </div>
                        </div>

                        <div class="py-2.5 border-b border-dashed border-stone-400 space-y-1.5">
                            <template x-for="item in selectedTx.items" :key="item.name">
                                <div>
                                    <div class="flex justify-between font-semibold">
                                        <span x-text="item.name"></span>
                                        <span x-text="formatRupiah(item.subtotal)"></span>
                                    </div>
                                    <div class="flex justify-between text-[10px] text-stone-500">
                                        <span><span x-text="item.qty"></span> x <span x-text="formatRupiah(item.price)"></span></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="py-2.5 border-b border-dashed border-stone-400 text-[11px] space-y-0.5">
                            <div class="flex justify-between font-bold text-xs pt-1">
                                <span>TOTAL</span>
                                <span x-text="formatRupiah(selectedTx.total)"></span>
                            </div>
                            <div class="flex justify-between pt-1">
                                <span>Bayar</span>
                                <span x-text="formatRupiah(selectedTx.paid)"></span>
                            </div>
                            <div class="flex justify-between font-bold">
                                <span>Kembali</span>
                                <span x-text="formatRupiah(selectedTx.change)"></span>
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
                        @click="isDetailModalOpen = false" 
                        class="px-4 py-2 text-xs font-semibold text-stone-600 hover:text-stone-900 rounded-lg transition"
                    >
                        Tutup
                    </button>
                    <button 
                        type="button" 
                        onclick="window.print()" 
                        class="px-5 py-2 bg-stone-900 hover:bg-stone-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span>Cetak Ulang Struk</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function historyApp() {
            return {
                isDetailModalOpen: false,
                selectedTx: {},
                showDetail(tx) {
                    this.selectedTx = tx;
                    this.isDetailModalOpen = true;
                },
                formatRupiah(val) {
                    return 'Rp ' + Number(val || 0).toLocaleString('id-ID');
                }
            };
        }
    </script>
</x-layouts.app>
