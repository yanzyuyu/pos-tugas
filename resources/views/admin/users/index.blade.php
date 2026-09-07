<x-layouts.app>
    <x-slot:header>Kelola Akun Pengguna</x-slot:header>
    <x-slot:subtitle>Manajemen hak akses untuk kasir dan administrator sistem</x-slot:subtitle>

    <div x-data="usersApp()" class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-xs">
            <div class="relative w-full sm:w-72">
                <input 
                    type="text" 
                    placeholder="Cari nama atau email..." 
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
                <span>Tambah Pengguna Baru</span>
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-stone-500 font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Lengkap</th>
                            <th class="py-3.5 px-4">Email Login</th>
                            <th class="py-3.5 px-4 text-center">Hak Akses (Role)</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4">Terdaftar Sejak</th>
                            <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700">
                        @foreach($users as $index => $u)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-stone-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-stone-900">
                                    {{ $u['name'] }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-stone-600">
                                    {{ $u['email'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $u['role'] === 'Admin' ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-stone-100 text-stone-800 border border-stone-200' }}">
                                        {{ $u['role'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex px-2 py-0.5 rounded-md text-[11px] font-medium bg-emerald-50 text-emerald-700">
                                        {{ $u['status'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-stone-600 font-mono">
                                    {{ $u['joined'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            @click="editModal(@json($u))" 
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
                                            @click="deleteUser('{{ $u['name'] }}')" 
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
                    <h3 class="font-bold text-sm" x-text="isEdit ? 'Edit Akun Pengguna' : 'Tambah Pengguna Baru'"></h3>
                    <button type="button" @click="isModalOpen = false" class="text-stone-400 hover:text-white font-bold">&times;</button>
                </div>

                <form @submit.prevent="saveUser()" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input 
                            type="text" 
                            x-model="formData.name" 
                            placeholder="Contoh: Rian Pratama" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input 
                            type="email" 
                            x-model="formData.email" 
                            placeholder="kasir2@kopisenja.id" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Role / Hak Akses</label>
                            <select 
                                x-model="formData.role" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none"
                            >
                                <option value="Kasir">Kasir</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1.5">Password</label>
                            <input 
                                type="password" 
                                x-model="formData.password" 
                                placeholder="******" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                            >
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
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function usersApp() {
            return {
                isModalOpen: false,
                isEdit: false,
                formData: {
                    id: null,
                    name: '',
                    email: '',
                    role: 'Kasir',
                    password: ''
                },

                openModal() {
                    this.isEdit = false;
                    this.formData = { id: null, name: '', email: '', role: 'Kasir', password: '' };
                    this.isModalOpen = true;
                },

                editModal(user) {
                    this.isEdit = true;
                    this.formData = { ...user, password: '' };
                    this.isModalOpen = true;
                },

                saveUser() {
                    alert('Akun ' + this.formData.name + ' berhasil disimpan!');
                    this.isModalOpen = false;
                },

                deleteUser(name) {
                    if (confirm('Hapus akun ' + name + '?')) {
                        alert('Akun ' + name + ' berhasil dihapus.');
                    }
                }
            };
        }
    </script>
</x-layouts.app>
