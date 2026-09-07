<x-layouts.app>
    <x-slot:header>Laporan Penjualan & Omzet</x-slot:header>
    <x-slot:subtitle>Rekapitulasi pendapatan kotor harian dan bulanan Kopi Senja</x-slot:subtitle>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-xs">
            <div class="flex flex-wrap items-center gap-3">
                <select class="px-3.5 py-2 bg-stone-50 border border-stone-300 rounded-xl text-xs font-semibold text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="september-2026">September 2026 (Bulan Ini)</option>
                    <option value="agustus-2026">Agustus 2026</option>
                    <option value="juli-2026">Juli 2026</option>
                </select>

                <div class="flex items-center gap-2 text-xs text-stone-500">
                    <input type="date" value="2026-09-01" class="px-3 py-1.5 bg-stone-50 border border-stone-300 rounded-lg font-mono text-stone-800">
                    <span>s/d</span>
                    <input type="date" value="2026-09-07" class="px-3 py-1.5 bg-stone-50 border border-stone-300 rounded-lg font-mono text-stone-800">
                </div>
            </div>

            <button 
                type="button" 
                onclick="window.print()" 
                class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Cetak Rekap Laporan</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Total Omzet Kotor</span>
                <span class="text-xl font-bold font-mono text-stone-900 tabular-nums">Rp {{ number_format($summary['total_gross'], 0, ',', '.') }}</span>
                <span class="text-[11px] text-stone-400 block mt-1">Periode 1 - 7 Sep 2026</span>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Total Transaksi</span>
                <span class="text-xl font-bold font-mono text-stone-900 tabular-nums">{{ $summary['total_orders'] }} Order</span>
                <span class="text-[11px] text-stone-400 block mt-1">Selesai diproses</span>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Pemasukan Tunai</span>
                <span class="text-xl font-bold font-mono text-amber-700 tabular-nums">Rp {{ number_format($summary['cash_amount'], 0, ',', '.') }}</span>
                <span class="text-[11px] text-stone-400 block mt-1">Kasir Shift Pagi & Sore</span>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-xs">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">Pemasukan QRIS</span>
                <span class="text-xl font-bold font-mono text-sky-700 tabular-nums">Rp {{ number_format($summary['qris_amount'], 0, ',', '.') }}</span>
                <span class="text-[11px] text-stone-400 block mt-1">Rekening Bank / e-Wallet</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-stone-200 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-stone-900 text-sm">Rekapitulasi Penjualan Harian</h3>
                    <p class="text-xs text-stone-500">Rincian pendapatan per tanggal operasional</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-stone-500 font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4">Tanggal</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Transaksi</th>
                            <th class="py-3.5 px-4 text-right">Pembayaran Tunai</th>
                            <th class="py-3.5 px-4 text-right">Pembayaran QRIS</th>
                            <th class="py-3.5 px-4 text-right font-bold text-stone-900">Total Omzet</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700">
                        @foreach($dailySales as $row)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3.5 px-4 font-mono font-medium text-stone-900">
                                    {{ $row['date'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-medium">
                                    {{ $row['transactions'] }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-mono text-stone-700 tabular-nums">
                                    Rp {{ number_format($row['cash'], 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-mono text-stone-700 tabular-nums">
                                    Rp {{ number_format($row['qris'], 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-mono font-bold text-amber-700 tabular-nums text-sm">
                                    Rp {{ number_format($row['total'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-stone-50 border-t-2 border-stone-200 font-bold text-stone-900">
                        <tr>
                            <td class="py-3.5 px-4 uppercase">Total Keseluruhan</td>
                            <td class="py-3.5 px-4 text-center font-mono">{{ $summary['total_orders'] }} Transaksi</td>
                            <td class="py-3.5 px-4 text-right font-mono tabular-nums">Rp {{ number_format($summary['cash_amount'], 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-right font-mono tabular-nums">Rp {{ number_format($summary['qris_amount'], 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-right font-mono text-amber-700 tabular-nums text-sm">Rp {{ number_format($summary['total_gross'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
