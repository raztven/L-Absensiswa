@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-slate-500 text-sm mt-1">Ringkasan aktivitas absensi hari ini, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Hadir -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
            <i data-lucide="user-check" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Hadir Hari Ini</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $hadirCount }}</h3>
        </div>
    </div>

    <!-- Total Pegawai -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-indigo-100 text-indigo-600 rounded-xl">
            <i data-lucide="users" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Pegawai</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalSiswa }}</h3>
        </div>
    </div>

    <!-- Izin/Sakit -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-amber-100 text-amber-600 rounded-xl">
            <i data-lucide="file-text" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Izin / Sakit</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $izinCount }}</h3>
        </div>
    </div>
</div>

<!-- Recent Attendance Table -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800">Aktivitas Absensi Terbaru</h3>
        <button class="text-indigo-600 text-sm font-bold hover:underline">Lihat Semua</button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pegawai</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jam Masuk</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jam Keluar</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm">
                @forelse($todayAttendance as $row)
                <tr class="hover:bg-slate-50/50 transition-colors">
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
                        'hadir' => 'bg-emerald-100 text-emerald-700',
                        'terlambat' => 'bg-amber-100 text-amber-700',
                        'sakit' => 'bg-blue-100 text-blue-700',
                        'izin' => 'bg-purple-100 text-purple-700',
                        'alpa' => 'bg-rose-100 text-rose-700',
                        default => 'bg-slate-100 text-slate-700'
                        };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $colorClass }}">
                            {{ $row->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                        <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                        <p>Belum ada data absensi hari ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection