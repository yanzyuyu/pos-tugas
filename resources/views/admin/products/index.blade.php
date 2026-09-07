<x-layouts.app>
    <x-slot:header>Master Data Menu & Produk</x-slot:header>
    <x-slot:subtitle>Kelola katalog menu kopi, minuman non-kopi, dan camilan</x-slot:subtitle>

    <div x-data="productsApp()" class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-xs">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input 
                    type="text" 
                    placeholder="Cari nama menu..." 
                    class="px-3.5 py-2 bg-stone-50 border border-stone-300 rounded-xl text-xs font-medium text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500 w-full sm:w-64"
                >
                <select class="px-3 py-2 bg-stone-50 border border-stone-300 rounded-xl text-xs font-medium text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <button 
                type="button" 
                @click="openModal()" 
                class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Menu Baru</span>
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-stone-500 font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Menu</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4 text-right">Harga Jual</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700">
                        @foreach($products as $index => $item)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-stone-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-stone-100 border border-stone-200 flex items-center justify-center font-bold text-amber-700 shrink-0">
                                            {{ substr($item['name'], 0, 1) }}
                                        </div>
                                        <span class="font-bold text-stone-900">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-md text-[11px] font-medium bg-stone-100 text-stone-700">
                                        {{ $item['category'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right font-mono font-bold text-stone-900 tabular-nums">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-medium text-stone-800">
                                    {{ $item['stock'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            @click="editModal(@json($item))" 
                                            class="p-1.5 text-stone-600 hover:text-amber-700 hover:bg-stone-100 rounded-lg transition" 
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="deleteProduct({{ $item['id'] }}, '{{ addslashes($item['name']) }}')" 
                                            class="p-1.5 text-stone-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition" 
                                            title="Hapus"
                                        >
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div 
            x-show="isModalOpen" 
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-xs"
            x-cloak
        >
            <div 
                @click.away="isModalOpen = false" 
                class="bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-stone-200 overflow-hidden"
            >
                <div class="p-5 bg-stone-900 text-white flex items-center justify-between">
                    <h3 class="font-bold text-sm" x-text="isEdit ? 'Edit Data Menu' : 'Tambah Menu Baru'"></h3>
                    <button type="button" @click="isModalOpen = false" class="text-stone-400 hover:text-white font-bold">&times;</button>
                </div>

                <form :action="isEdit ? '/admin/products/' + formData.id : '{{ route('admin.products.store') }}'" method="POST" class="p-6 space-y-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Nama Menu</label>
                        <input 
                            type="text" 
                            name="name"
                            x-model="formData.name" 
                            placeholder="Contoh: Iced Spanish Latte" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Kategori</label>
                            <select 
                                name="category"
                                x-model="formData.category" 
                                required 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none"
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Harga Jual (Rp)</label>
                            <input 
                                type="number" 
                                name="price"
                                x-model.number="formData.price" 
                                placeholder="28000" 
                                required 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 font-mono text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Stok Awal</label>
                            <input 
                                type="number" 
                                name="stock"
                                x-model.number="formData.stock" 
                                placeholder="30" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 font-mono text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Status Produk</label>
                            <select 
                                name="status"
                                x-model="formData.status" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none"
                            >
                                <option value="Tersedia">Tersedia</option>
                                <option value="Habis">Habis</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-2 border-t border-stone-100">
                        <button 
                            type="button" 
                            @click="isModalOpen = false" 
                            class="px-4 py-2 text-xs font-semibold text-stone-600 hover:text-stone-900 rounded-lg transition"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition shadow-sm"
                        >
                            Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function productsApp() {
            return {
                isModalOpen: false,
                isEdit: false,
                formData: {
                    id: null,
                    name: '',
                    category: '',
                    price: null,
                    stock: 0,
                    status: 'Tersedia'
                },

                openModal() {
                    this.isEdit = false;
                    this.formData = { id: null, name: '', category: '', price: null, stock: 20, status: 'Tersedia' };
                    this.isModalOpen = true;
                },

                editModal(product) {
                    this.isEdit = true;
                    this.formData = { ...product };
                    this.isModalOpen = true;
                },

                deleteProduct(id, name) {
                    if (confirm('Hapus menu ' + name + ' dari katalog?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/products/' + id;
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        form.appendChild(csrf);

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            };
        }
    </script>
</x-layouts.app>
