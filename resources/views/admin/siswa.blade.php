@extends('layouts.admin')

@section('content')
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pegawai</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data pegawai yang terdaftar dalam sistem.</p>
        </div>
        <button onclick="toggleModal('modal-tambah-siswa')" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Pegawai
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Error!</strong>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bergabung</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($siswas as $index => $siswa)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 text-slate-500 font-medium">{{ $index + 1 }}</td>
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-700">{{ $siswa->name }}</div>
                        </td>
                        <td class="px-8 py-5 text-slate-600">{{ $siswa->email }}</td>
                        <td class="px-8 py-5 text-slate-500">{{ $siswa->created_at->translatedFormat('d F Y') }}</td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openEditModal('{{ $siswa->id }}', '{{ $siswa->name }}', '{{ $siswa->email }}')" class="text-slate-400 hover:text-indigo-600 transition-colors p-2 rounded-lg hover:bg-indigo-50" title="Edit Data">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors p-2 rounded-lg hover:bg-rose-50" title="Hapus Data">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                            <i data-lucide="users" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>Belum ada data pegawai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pegawai -->
    <div id="modal-tambah-siswa" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl scale-95 animate-in zoom-in-95 duration-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Tambah Pegawai Baru</h3>
                <button onclick="toggleModal('modal-tambah-siswa')" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                    <i data-lucide="x" class="w-6 h-6 text-slate-400"></i>
                </button>
            </div>

            <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all" placeholder="Contoh: Ahmad Fauzi">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Alamat Email</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all" placeholder="Contoh: ahmad@perusahaan.com">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Password</label>
                    <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all" placeholder="Minimal 8 karakter">
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-95">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pegawai -->
    <div id="modal-edit-siswa" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl scale-95 animate-in zoom-in-95 duration-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Edit Data Pegawai</h3>
                <button onclick="toggleModal('modal-edit-siswa')" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                    <i data-lucide="x" class="w-6 h-6 text-slate-400"></i>
                </button>
            </div>

            <form id="form-edit-siswa" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="edit-name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Alamat Email</label>
                    <input type="email" name="email" id="edit-email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Password (Opsional)</label>
                    <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all" placeholder="Kosongkan jika tidak diubah">
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const m = document.getElementById(id);
            m.classList.toggle('hidden');
        }

        function openEditModal(id, name, email) {
            // Set values
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            
            // Set action route
            const form = document.getElementById('form-edit-siswa');
            form.action = `/admin/siswa/${id}`;
            
            // Open modal
            toggleModal('modal-edit-siswa');
        }
    </script>
@endsection
