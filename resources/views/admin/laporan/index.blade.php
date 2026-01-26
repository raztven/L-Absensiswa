@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Laporan Kehadiran</h1>
        <p class="text-slate-500 text-sm mt-1">Rekap data kehadiran pegawai per periode.</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:ring-4 focus:ring-indigo-100 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:ring-4 focus:ring-indigo-100 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nama Pegawai (Opsional)</label>
                <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:ring-4 focus:ring-indigo-100 outline-none transition-all">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all">
                    Filter
                </button>
                <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" class="px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl flex items-center justify-center transition-all" title="Cetak PDF">
                    <i data-lucide="printer" class="w-5 h-5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Data Kehadiran ({{ count($attendance) }} baris)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pegawai</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Masuk</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keluar</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($attendance as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $row->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600 font-mono">{{ $row->absenmasuk ? \Carbon\Carbon::parse($row->absenmasuk)->format('H:i:s') : '-' }}</td>
                        <td class="px-6 py-4 text-slate-600 font-mono">{{ $row->absenkeluar ? \Carbon\Carbon::parse($row->absenkeluar)->format('H:i:s') : '--:--:--' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColor = match($row->status) {
                                    'hadir' => 'bg-emerald-100 text-emerald-700',
                                    'sakit' => 'bg-blue-100 text-blue-700',
                                    'izin' => 'bg-amber-100 text-amber-700',
                                    'terlambat' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $row->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-400">
                            <i data-lucide="file-x" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>Tidak ada data kehadiran pada periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection