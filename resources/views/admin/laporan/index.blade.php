@extends('layouts.admin')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Absensi</h1>
            <p class="text-slate-500 text-sm mt-1">Rekap data absensi siswa per periode.</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('admin.laporan.cetak', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all active:scale-95">
                <i data-lucide="printer" class="w-5 h-5"></i>
                Cetak PDF
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:ring-4 focus:ring-blue-100 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:ring-4 focus:ring-blue-100 outline-none transition-all">
            </div>
            <div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-100 transition-all active:scale-95">
                    <i data-lucide="filter" class="w-5 h-5"></i>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Data Absensi ({{ count($attendance) }} baris)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jam Keluar</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($attendance as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 font-semibold text-slate-700">{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d M Y') }}</td>
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-700">{{ $row->user->name }}</div>
                            <div class="text-xs text-slate-400">{{ $row->user->email }}</div>
                        </td>
                        <td class="px-8 py-5 text-slate-600">
                            {{ $row->absenmasuk ? \Carbon\Carbon::parse($row->absenmasuk)->format('H:i:s') : '-' }}
                        </td>
                        <td class="px-8 py-5 text-slate-400 italic font-medium">
                            {{ $row->absenkeluar ? \Carbon\Carbon::parse($row->absenkeluar)->format('H:i:s') : '--:--:--' }}
                        </td>
                        <td class="px-8 py-5 text-slate-600">
                             {{ $row->keteranganData ? $row->keteranganData->keterangan : '-' }}
                            @if(in_array($row->status, ['sakit', 'izin', 'terlambat']))
                                <br><span class="text-xs text-slate-400 italic">"{{ $row->keterangan }}"</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            @php
                                $colorClass = match($row->status) {
                                    'hadir' => 'text-emerald-600',
                                    'terlambat' => 'text-amber-600',
                                    'sakit' => 'text-blue-600',
                                    'izin' => 'text-purple-600',
                                    'alpa' => 'text-rose-600',
                                    default => 'text-slate-600'
                                };
                            @endphp
                            <span class="font-bold {{ $colorClass }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-400">
                            <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>Tidak ada data absensi pada periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
