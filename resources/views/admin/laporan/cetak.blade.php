<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Times New Roman', serif; /* Standard for formal reports */
            background: white;
            color: black;
        }
        @media print {
            @page { margin: 1cm; size: A4 landscape; }
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="p-8">

    <div class="text-center border-b-2 border-black pb-4 mb-6">
        <h1 class="text-2xl font-bold uppercase tracking-wide">Laporan Absensi Siswa</h1>
        <p class="text-sm mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    <table class="w-full text-left border-collapse border border-black text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-black px-4 py-2 font-bold uppercase text-center w-12">No</th>
                <th class="border border-black px-4 py-2 font-bold uppercase">Tanggal</th>
                <th class="border border-black px-4 py-2 font-bold uppercase">Nama Siswa</th>
                <th class="border border-black px-4 py-2 font-bold uppercase text-center">Masuk</th>
                <th class="border border-black px-4 py-2 font-bold uppercase text-center">Keluar</th>
                <th class="border border-black px-4 py-2 font-bold uppercase">Keterangan</th>
                <th class="border border-black px-4 py-2 font-bold uppercase text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendance as $index => $row)
            <tr>
                <td class="border border-black px-4 py-2 text-center">{{ $index + 1 }}</td>
                <td class="border border-black px-4 py-2">{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d/m/Y') }}</td>
                <td class="border border-black px-4 py-2">
                    <div class="font-bold">{{ $row->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $row->user->email }}</div>
                </td>
                <td class="border border-black px-4 py-2 text-center">
                    {{ $row->absenmasuk ? \Carbon\Carbon::parse($row->absenmasuk)->format('H:i') : '-' }}
                </td>
                <td class="border border-black px-4 py-2 text-center">
                    {{ $row->absenkeluar ? \Carbon\Carbon::parse($row->absenkeluar)->format('H:i') : '-' }}
                </td>
                <td class="border border-black px-4 py-2">
                    {{ $row->keteranganData ? $row->keteranganData->keterangan : '-' }}
                    @if(in_array($row->status, ['sakit', 'izin', 'terlambat']))
                        <br><span class="text-xs italic">"{{ $row->keterangan }}"</span>
                    @endif
                </td>
                <td class="border border-black px-4 py-2 text-center font-bold uppercase text-xs">
                    {{ $row->status }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border border-black px-4 py-8 text-center text-gray-500 italic">
                    Tidak ada data absensi pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-8 flex justify-end">
        <div class="text-center pr-12">
            <p class="mb-16">Mengetahui,</p>
            <p class="font-bold border-b border-black inline-block min-w-[200px]"></p>
            <p class="mt-1">Administrator</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
