<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi - E-Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">

    <!-- Navbar Sederhana -->
    <nav class="bg-white border-b border-slate-200 px-6 py-4 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">E-Absensi</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <div class="w-10 h-10 bg-slate-200 rounded-full border-2 border-white shadow-sm flex items-center justify-center">
                    <i data-lucide="user" class="w-5 h-5 text-slate-500"></i>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-full transition-colors" title="Keluar">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 pb-12">
        
        @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Kolom Kiri: Kontrol Absensi -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Card Jam -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 text-center">
                    <h3 id="current-date" class="text-slate-400 text-sm font-semibold mb-2"></h3>
                    <div id="clock" class="text-5xl font-bold text-slate-800 tracking-tight mb-6">00:00:00</div>

                    <!-- Status Ringkas -->
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl mb-8">
                        <div class="text-left">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">Masuk</span>
                            <span class="text-sm font-bold text-emerald-600">
                                {{ $absenToday && $absenToday->absenmasuk ? \Carbon\Carbon::parse($absenToday->absenmasuk)->format('H:i:s') : '--:--:--' }}
                            </span>
                        </div>
                        <div class="h-8 w-px bg-slate-200"></div>
                        <div class="text-right">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">Keluar</span>
                            <span class="text-sm font-bold text-slate-300">
                                {{ $absenToday && $absenToday->absenkeluar ? \Carbon\Carbon::parse($absenToday->absenkeluar)->format('H:i:s') : '--:--:--' }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Aksi dalam Form -->
                    <div class="grid grid-cols-1 gap-3">

                        <!-- Form Absen Masuk -->
                        @if(!$absenToday)
                        <form action="{{ route('absensi.masuk') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-100 transition-all active:scale-95">
                                <i data-lucide="log-in" class="w-5 h-5"></i>
                                Absen Masuk
                            </button>
                        </form>
                        @endif

                        <!-- Form Absen Keluar -->
                        @if($absenToday && ($absenToday->status == 'hadir' || $absenToday->status == 'terlambat') && !$absenToday->absenkeluar)
                        <form action="{{ route('absensi.keluar') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rose-500 hover:bg-rose-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-rose-100 transition-all active:scale-95">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                Absen Keluar
                            </button>
                        </form>
                        @endif
                        
                        @if($absenToday && $absenToday->absenkeluar)
                            <div class="p-4 bg-blue-50 text-blue-700 rounded-2xl font-semibold">
                                Anda sudah menyelesaikan absensi hari ini.
                            </div>
                        @endif

                        @if($absenToday && $absenToday->status != 'hadir')
                            <div class="p-4 bg-amber-50 text-amber-700 rounded-2xl font-semibold">
                                Status anda hari ini: {{ ucfirst($absenToday->status) }}
                            </div>
                        @endif

                        <!-- Tombol Pemicu Modal Izin -->
                        @if(!$absenToday)
                        <button onclick="toggleModal('modal-izin')" class="flex items-center justify-center gap-2 bg-white border-2 border-slate-100 hover:bg-slate-50 text-slate-600 font-bold py-4 rounded-2xl transition-all">
                            <i data-lucide="file-edit" class="w-5 h-5"></i>
                            Ajukan Izin
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Riwayat Absensi -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Absensi Minggu Ini</h3>
                        <button class="text-blue-600 text-sm font-bold hover:underline">Lihat Semua</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jam Masuk</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jam Keluar</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm">
                                @forelse($history as $row)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5 font-semibold text-slate-700">{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d M Y') }}</td>
                                    <td class="px-8 py-5 text-slate-600">
                                        {{ $row->absenmasuk ? \Carbon\Carbon::parse($row->absenmasuk)->format('H:i:s') : '-' }}
                                    </td>
                                    <td class="px-8 py-5 text-slate-400 italic font-medium">
                                        {{ $row->absenkeluar ? \Carbon\Carbon::parse($row->absenkeluar)->format('H:i:s') : '--:--:--' }}
                                    </td>
                                    <td class="px-8 py-5 text-slate-600">
                                        {{ $row->keteranganData ? $row->keteranganData->keterangan : '-' }}
                                        @if($row->status == 'sakit' || $row->status == 'izin')
                                            <br><span class="text-xs text-slate-400 italic">"{{ $row->keterangan }}"</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 font-bold 
                                        @if($row->status == 'hadir') text-emerald-600 
                                        @elseif($row->status == 'terlambat') text-rose-600
                                        @else text-amber-600 @endif">
                                        {{ ucfirst($row->status) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-5 text-center text-slate-400">Belum ada riwayat absensi minggu ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Izin (Floating) -->
    <div id="modal-izin" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl scale-95 animate-in zoom-in-95 duration-200">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Form Izin</h3>
                <button onclick="toggleModal('modal-izin')" class="p-2 hover:bg-slate-100 rounded-full">
                    <i data-lucide="x" class="w-6 h-6 text-slate-400"></i>
                </button>
            </div>

            <!-- Form Pengajuan Izin -->
            <form action="{{ route('absensi.izin') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-3">Pilih Kategori</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="kategori" value="sakit" class="peer sr-only" checked>
                            <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-blue-500 peer-checked:bg-blue-50 text-center transition-all">
                                <span class="text-sm font-bold text-slate-600 peer-checked:text-blue-600">Sakit</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="kategori" value="izin" class="peer sr-only">
                            <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-blue-500 peer-checked:bg-blue-50 text-center transition-all">
                                <span class="text-sm font-bold text-slate-600 peer-checked:text-blue-600">Izin</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-3">Alasan / Keterangan</label>
                    <textarea name="keterangan" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-4 focus:ring-blue-100 outline-none transition-all" placeholder="Tulis alasan singkat anda..."></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-5 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-100 transition-all active:scale-95">
                    Kirim Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Real-time Clock
        function updateClock() {
            const now = new Date();
            
            // Format time for Asia/Jakarta
            const timeString = now.toLocaleTimeString('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).replace(/\./g, ':');
            
            document.getElementById('clock').textContent = timeString;

            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'Asia/Jakarta'
            };
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
        }

        // Modal Handler
        function toggleModal(id) {
            const m = document.getElementById(id);
            m.classList.toggle('hidden');
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>

</html>