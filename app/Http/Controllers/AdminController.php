<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Count students present today (hadir + terlambat)
        $hadirCount = Siswa::whereDate('created_at', $today)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();
            
        // Count students with permission (sakit/izin)
        $izinCount = Siswa::whereDate('created_at', $today)
            ->whereIn('status', ['sakit', 'izin'])
            ->count();

        // Get today's attendance records with user and keterangan info
        $todayAttendance = Siswa::with(['user', 'keteranganData'])
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // Total students count
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('admin.index', compact('hadirCount', 'izinCount', 'todayAttendance', 'totalSiswa'));
    }

    public function siswa()
    {
        $siswas = User::where('role', 'siswa')->orderBy('created_at', 'desc')->get();
        return view('admin.siswa', compact('siswas'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function laporan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $attendance = Siswa::with(['user', 'keteranganData'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(), 
                Carbon::parse($endDate)->endOfDay()
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.laporan.index', compact('attendance', 'startDate', 'endDate'));
    }

    public function cetakLaporan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $attendance = Siswa::with(['user', 'keteranganData'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(), 
                Carbon::parse($endDate)->endOfDay()
            ])
            ->orderBy('created_at', 'asc') // Chronological for reports
            ->get();

        return view('admin.laporan.cetak', compact('attendance', 'startDate', 'endDate'));
    }
}