<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Izin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-900 pb-24" x-data="{ activeTab: 'form', showSuccess: false }">

    <!-- Header -->
    <div class="bg-indigo-700 pt-8 pb-12 px-6 rounded-b-[40px] shadow-lg relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-600 rounded-full opacity-50"></div>
        <div class="relative flex items-center gap-4 text-white">
            <a href="user_attendance.blade.php" class="h-10 w-10 flex items-center justify-center bg-white/20 rounded-xl backdrop-blur-md">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1 class="text-xl font-bold">Pengajuan Izin</h1>
        </div>
    </div>

    <div class="px-6 -mt-6 relative z-10">
        <!-- Tabs Switcher -->
        <div class="bg-white p-2 rounded-2xl shadow-md flex gap-2 mb-6">
            <button 
                @click="activeTab = 'form'"
                :class="activeTab === 'form' ? 'bg-indigo-600 text-white' : 'text-gray-500'"
                class="flex-1 py-3 text-sm font-bold rounded-xl transition-all duration-300">
                Form Izin
            </button>
            <button 
                @click="activeTab = 'history'"
                :class="activeTab === 'history' ? 'bg-indigo-600 text-white' : 'text-gray-500'"
                class="flex-1 py-3 text-sm font-bold rounded-xl transition-all duration-300">
                Riwayat
            </button>
        </div>

        <!-- Form Tab -->
        <div x-show="activeTab === 'form'" x-transition>
            <form class="space-y-4" @submit.prevent="showSuccess = true">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="space-y-5">
                        <!-- Jenis Izin -->
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Jenis Pengajuan</label>
                            <select class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition appearance-none">
                                <option>Sakit (Dengan Surat Dokter)</option>
                                <option>Izin Keperluan Mendesak</option>
                                <option>Cuti Tahunan</option>
                                <option>Lain-lain</option>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Mulai</label>
                                <input type="date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Sampai</label>
                                <input type="date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Alasan / Keterangan</label>
                            <textarea rows="4" placeholder="Jelaskan alasan pengajuan Anda..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                        </div>

                        <!-- Upload Lampiran -->
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Lampiran (Opsional)</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-indigo-400 transition cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-300 mb-2"></i>
                                <p class="text-xs text-gray-500">Klik untuk unggah foto atau dokumen (Maks. 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 active:scale-95 transition-all">
                    Kirim Pengajuan
                </button>
            </form>
        </div>

        <!-- History Tab -->
        <div x-show="activeTab === 'history'" x-transition class="space-y-4">
            <!-- Pending Item -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-lg">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Sakit</p>
                        <p class="text-[10px] text-gray-400">10 Jan - 12 Jan (3 Hari)</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-bold rounded-lg border border-orange-100">Menunggu</span>
            </div>

            <!-- Approved Item -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-lg">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Cuti Tahunan</p>
                        <p class="text-[10px] text-gray-400">01 Jan - 02 Jan (2 Hari)</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg border border-green-100">Disetujui</span>
            </div>

            <!-- Rejected Item -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between opacity-70">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center text-lg">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Izin Mendesak</p>
                        <p class="text-[10px] text-gray-400">20 Des 2025 (1 Hari)</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded-lg border border-red-100">Ditolak</span>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation (Consistent) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-8 py-3 flex justify-between items-center z-50">
        <a href="user_attendance.blade.php" class="flex flex-col items-center gap-1 text-gray-400 hover:text-indigo-600 transition">
            <i class="fas fa-home text-xl"></i>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-gray-400 hover:text-indigo-600 transition">
            <i class="fas fa-history text-xl"></i>
            <span class="text-[10px] font-bold">Riwayat</span>
        </a>
        <div class="relative -top-8">
            <a href="user_attendance.blade.php" class="h-14 w-14 bg-indigo-600 text-white rounded-full shadow-lg shadow-indigo-200 flex items-center justify-center text-xl border-4 border-white active:scale-90 transition">
                <i class="fas fa-fingerprint"></i>
            </a>
        </div>
        <a href="#" class="flex flex-col items-center gap-1 bottom-nav-active">
            <i class="fas fa-file-alt text-xl"></i>
            <span class="text-[10px] font-bold">Izin</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-gray-400 hover:text-indigo-600 transition">
            <i class="fas fa-user-circle text-xl"></i>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </div>

    <!-- Success Modal -->
    <div x-show="showSuccess" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/50 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-[32px] p-8 w-full max-w-xs text-center">
            <div class="h-20 w-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Terkirim!</h2>
            <p class="text-sm text-gray-500 mt-2">Pengajuan izin Anda telah berhasil dikirim dan menunggu verifikasi admin.</p>
            <button @click="showSuccess = false; activeTab = 'history'" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-2xl mt-6 hover:bg-indigo-700 transition">
                Lihat Riwayat
            </button>
        </div>
    </div>

</body>
</html>