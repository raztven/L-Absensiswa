<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - E-PEGAWAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen relative overflow-x-hidden">

    <!-- Background Gradients -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-indigo-200/20 rounded-full blur-3xl"></div>
        <div class="absolute top-[20%] -left-[10%] w-[40%] h-[40%] bg-blue-200/20 rounded-full blur-3xl"></div>
    </div>

    <nav class="glass-card sticky top-0 z-50 border-b border-white/50 shadow-sm bg-white/80">
        <div class="max-w-6xl mx-auto px-4 md:px-8">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 p-2.5 rounded-xl text-white shadow-lg shadow-indigo-200">
                        <i data-lucide="fingerprint" class="w-6 h-6"></i>
                    </div>
                    <div class="leading-none">
                        <span class="block text-xl font-bold text-slate-800 tracking-tight">E-PEGAWAI</span>
                        <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">Sistem Presensi</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="p-3 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-all border border-slate-200">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 md:px-8 py-10 relative z-10">
        
        <!-- Header Section -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">
                    <span class="font-light text-slate-400">Halo,</span> 
                    {{ explode(' ', Auth::user()->name)[0] }}! 👋
                </h1>
                <p class="text-slate-500 mt-2 text-lg">Siap untuk produktif hari ini?</p>
            </div>
            
            <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <div class="text-right">
                    <div class="text-xs font-bold text-slate-400 uppercase">Hari Ini</div>
                    <div class="font-bold text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl mb-8 flex items-center gap-4 shadow-lg shadow-emerald-200 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="bg-white/20 p-2 rounded-xl">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div class="font-medium">{{ session('success') }}</div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-rose-500 text-white px-6 py-4 rounded-2xl mb-8 flex items-center gap-4 shadow-lg shadow-rose-200 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="bg-white/20 p-2 rounded-xl">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
            <div class="font-medium">{{ session('error') }}</div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: Attendance Card -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Main Clock Card -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <i data-lucide="clock" class="w-32 h-32 text-indigo-600"></i>
                    </div>

                    <div class="relative z-10">
                        <div class="text-sm font-bold text-indigo-500 uppercase tracking-widest mb-2">Waktu Sekarang</div>
                        <div class="text-5xl font-extrabold text-slate-800 font-mono tracking-tight" id="realtime-clock">00:00:00</div>
                        <div class="text-slate-400 mt-2 font-medium">WIB (Indonesia Barat)</div>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4 relative z-10">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="flex items-center gap-2 mb-1 text-emerald-600">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                                <span class="text-xs font-bold uppercase">Masuk</span>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                {{ $absenToday && $absenToday->absenmasuk ? \Carbon\Carbon::parse($absenToday->absenmasuk)->format('H:i') : '--:--' }}
                            </div>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="flex items-center gap-2 mb-1 text-rose-600">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                <span class="text-xs font-bold uppercase">Keluar</span>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                {{ $absenToday && $absenToday->absenkeluar ? \Carbon\Carbon::parse($absenToday->absenkeluar)->format('H:i') : '--:--' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    @if(!$absenToday)
                        <form action="{{ route('absensi.masuk') }}" method="POST">
                            @csrf
                            <button class="w-full group bg-indigo-600 hover:bg-indigo-700 text-white p-1 rounded-[2rem] shadow-xl shadow-indigo-200 transition-all active:scale-[0.98]">
                                <div class="bg-white/10 border border-white/20 rounded-[1.8rem] px-6 py-6 flex items-center justify-between">
                                    <div class="text-left">
                                        <div class="font-bold text-xl">Presensi Masuk</div>
                                        <div class="text-indigo-200 text-sm">Klik untuk mulai bekerja</div>
                                    </div>
                                    <div class="bg-white text-indigo-600 p-4 rounded-full group-hover:scale-110 transition-transform">
                                        <i data-lucide="fingerprint" class="w-8 h-8"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    
                        <button onclick="toggleModal('modal-izin')" class="w-full bg-white hover:bg-slate-50 text-slate-600 font-bold p-6 rounded-[2rem] border-2 border-slate-100 hover:border-slate-200 transition-all flex items-center justify-center gap-3">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                            Ajukan Izin / Sakit
                        </button>
                    @elseif($absenToday && ($absenToday->status == 'hadir' || $absenToday->status == 'terlambat') && !$absenToday->absenkeluar)
                        <form action="{{ route('absensi.keluar') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="w-full group bg-rose-600 hover:bg-rose-700 text-white p-1 rounded-[2rem] shadow-xl shadow-rose-200 transition-all active:scale-[0.98]">
                                <div class="bg-white/10 border border-white/20 rounded-[1.8rem] px-6 py-6 flex items-center justify-between">
                                    <div class="text-left">
                                        <div class="font-bold text-xl">Presensi Keluar</div>
                                        <div class="text-rose-200 text-sm">Selesaikan pekerjaan hari ini</div>
                                    </div>
                                    <div class="bg-white text-rose-600 p-4 rounded-full group-hover:scale-110 transition-transform">
                                        <i data-lucide="log-out" class="w-8 h-8"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    @elseif($absenToday && $absenToday->absenkeluar)
                        <div class="bg-emerald-600 text-white p-8 rounded-[2rem] shadow-xl shadow-emerald-200 text-center relative overflow-hidden">
                             <div class="absolute -right-6 -top-6 bg-white/10 w-32 h-32 rounded-full blur-2xl"></div>
                             <div class="relative z-10">
                                <div class="bg-white/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                                    <i data-lucide="check" class="w-8 h-8 text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-1">Presensi Selesai!</h3>
                                <p class="text-emerald-100">Terima kasih atas kerja keras Anda hari ini.</p>
                             </div>
                        </div>
                    @else
                        <div class="bg-slate-100 text-slate-500 p-8 rounded-[2rem] text-center border border-slate-200">
                             <h3 class="font-bold text-lg mb-1">Status: {{ ucfirst($absenToday->status) }}</h3>
                             <p class="text-sm">Anda telah mengajukan {{ $absenToday->status }} hari ini.</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Column: History -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Riwayat Kehadiran</h3>
                            <p class="text-slate-500 text-sm">Pantau aktivitas presensi mingguan Anda.</p>
                        </div>
                        <div class="p-2 bg-slate-50 rounded-xl border border-slate-100">
                            <i data-lucide="bar-chart-2" class="w-5 h-5 text-slate-400"></i>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-4">Tanggal</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-4">Masuk</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-4">Keluar</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-4">Status</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-4">Ket</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($history as $row)
                                <tr class="group hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-5 border-b border-slate-50">
                                        <div class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($row->tanggal)->format('d') }}</div>
                                        <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('M Y') }}</div>
                                    </td>
                                    <td class="px-4 py-5 border-b border-slate-50">
                                        <div class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg inline-block font-mono text-xs font-bold">
                                            {{ $row->absenmasuk ? \Carbon\Carbon::parse($row->absenmasuk)->format('H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 border-b border-slate-50">
                                        <div class="bg-orange-50 text-orange-600 px-3 py-1 rounded-lg inline-block font-mono text-xs font-bold">
                                            {{ $row->absenkeluar ? \Carbon\Carbon::parse($row->absenkeluar)->format('H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 border-b border-slate-50">
                                        @php
                                            $statusConfig = match($row->status) {
                                                'hadir' => ['bg-emerald-100', 'text-emerald-700', 'Hadir'],
                                                'sakit' => ['bg-blue-100', 'text-blue-700', 'Sakit'],
                                                'izin' => ['bg-amber-100', 'text-amber-700', 'Izin'],
                                                'terlambat' => ['bg-rose-100', 'text-rose-700', 'Telat'],
                                                default => ['bg-slate-100', 'text-slate-700', ucfirst($row->status)]
                                            };
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusConfig[0] }} {{ $statusConfig[1] }}">
                                            {{ $statusConfig[2] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-5 border-b border-slate-50">
                                        @if($row->keterangan)
                                        <div class="text-slate-500 text-xs truncate max-w-[120px]" title="{{ $row->keterangan }}">
                                            {{ $row->keterangan }}
                                        </div>
                                        @else
                                        <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                                        <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i data-lucide="calendar-off" class="w-8 h-8 opacity-50"></i>
                                        </div>
                                        <p>Belum ada riwayat kehadiran.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Izin -->
    <div id="modal-izin" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl scale-95 animate-in zoom-in-95 duration-200">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Ajukan Izin / Sakit</h3>
                    <p class="text-slate-500 text-sm">Isi formulir berikut untuk konfirmasi ketidakhadiran.</p>
                </div>
                <button onclick="toggleModal('modal-izin')" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                    <i data-lucide="x" class="w-6 h-6 text-slate-400"></i>
                </button>
            </div>

            <form action="{{ route('absensi.izin') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-3">Pilih Jenis Pengajuan</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" name="status" value="izin" class="peer sr-only" checked>
                            <div class="p-4 rounded-2xl border-2 border-slate-100 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all hover:border-indigo-200">
                                <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
                                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                                </div>
                                <div class="font-bold text-slate-700 peer-checked:text-indigo-800">Izin Pribadi</div>
                                <div class="text-xs text-slate-400 mt-1">Keperluan keluarga, dll</div>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="status" value="sakit" class="peer sr-only">
                            <div class="p-4 rounded-2xl border-2 border-slate-100 peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all hover:border-rose-200">
                                <div class="bg-rose-100 w-10 h-10 rounded-full flex items-center justify-center text-rose-600 mb-3 group-hover:scale-110 transition-transform">
                                    <i data-lucide="thermometer" class="w-5 h-5"></i>
                                </div>
                                <div class="font-bold text-slate-700 peer-checked:text-rose-800">Sakit</div>
                                <div class="text-xs text-slate-400 mt-1">Sertakan surat dokter jika ada</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Keterangan / Alasan</label>
                    <textarea name="keterangan" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all placeholder:text-slate-300 resize-none" placeholder="Contoh: Demam tinggi sejak semalam..."></textarea>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-[0.98]">
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleModal(id) {
            const m = document.getElementById(id);
            m.classList.toggle('hidden');
        }

        // Realtime Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('realtime-clock').textContent = timeString.replace(/\./g, ':');
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>