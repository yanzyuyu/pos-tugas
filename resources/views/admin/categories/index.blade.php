<x-layouts.app>
    <x-slot:header>Master Data Kategori</x-slot:header>
    <x-slot:subtitle>Kelola kategori menu untuk pengelompokan produk kedai kopi</x-slot:subtitle>

    <div x-data="categoriesApp()" class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-xs">
            <div class="relative w-full sm:w-72">
                <input 
                    type="text" 
                    placeholder="Cari kategori..." 
                    class="w-full px-3.5 py-2 bg-stone-50 border border-stone-300 rounded-xl text-xs font-medium text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
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
                <span>Tambah Kategori Baru</span>
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-stone-500 font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-16 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Kategori</th>
                            <th class="py-3.5 px-4">Slug URL</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Produk</th>
                            <th class="py-3.5 px-4">Dibuat Pada</th>
                            <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700">
                        @foreach($categories as $index => $cat)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-stone-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-stone-900">
                                    {{ $cat['name'] }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-stone-500">
                                    {{ $cat['slug'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-700 font-mono">
                                        {{ $cat['products_count'] }} Menu
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-stone-600 font-mono">
                                    {{ $cat['created_at'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            @click="editModal(@json($cat))" 
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
                                            @click="deleteCategory({{ $cat['id'] }}, '{{ addslashes($cat['name']) }}')" 
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
                class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-stone-200 overflow-hidden"
            >
                <div class="p-5 bg-stone-900 text-white flex items-center justify-between">
                    <h3 class="font-bold text-sm" x-text="isEdit ? 'Edit Kategori Menu' : 'Tambah Kategori Baru'"></h3>
                    <button type="button" @click="isModalOpen = false" class="text-stone-400 hover:text-white font-bold">&times;</button>
                </div>

                <form :action="isEdit ? '/admin/categories/' + formData.id : '{{ route('admin.categories.store') }}'" method="POST" class="p-6 space-y-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                        <input 
                            type="text" 
                            name="name"
                            x-model="formData.name" 
                            placeholder="Contoh: Kopi Dingin, Pastry" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Slug (Otomatis)</label>
                        <input 
                            type="text" 
                            name="slug"
                            x-model="formData.slug" 
                            placeholder="kopi-dingin" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 font-mono text-xs bg-stone-50 focus:ring-2 focus:ring-amber-500 focus:outline-none"
                        >
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
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function categoriesApp() {
            return {
                isModalOpen: false,
                isEdit: false,
                formData: {
                    id: null,
                    name: '',
                    slug: ''
                },

                openModal() {
                    this.isEdit = false;
                    this.formData = { id: null, name: '', slug: '' };
                    this.isModalOpen = true;
                },

                editModal(category) {
                    this.isEdit = true;
                    this.formData = { ...category };
                    this.isModalOpen = true;
                },

                deleteCategory(id, name) {
                    if (confirm('Apakah Anda yakin ingin menghapus kategori ' + name + '?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/categories/' + id;
                        
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
