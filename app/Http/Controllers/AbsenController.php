<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Keterangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Check if user has already clocked in today
        $absenToday = Siswa::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        // Get history for the current week
        $history = Siswa::with('keteranganData')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.index', compact('absenToday', 'history'));
    }

    public function masuk(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Check if already clocked in
        $check = Siswa::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        if ($check) {
            return redirect()->back()->with('error', 'Anda sudah absen masuk hari ini.');
        }

        // Tentukan status berdasarkan jam (Batas 07:15)
        $limit = Carbon::today()->setTime(7, 15, 0);
        $status = $now->greaterThan($limit) ? 'terlambat' : 'hadir';
        
        $keteranganDb = Keterangan::where('keterangan', ucfirst($status))->first();
        $keteranganText = $status == 'terlambat' ? 'Hadir Terlambat' : 'Hadir';

        Siswa::create([
            'user_id' => $user->id,
            'id_keterangan' => $keteranganDb ? $keteranganDb->id : null,
            'absenmasuk' => $now,
            'status' => $status,
            'keterangan' => $keteranganText,
        ]);

        return redirect()->back()->with('success', 'Berhasil absen masuk.');
    }

    public function keluar(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $absen = Siswa::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        if (!$absen) {
            return redirect()->back()->with('error', 'Anda belum absen masuk.');
        }

        $allowedStatus = ['hadir', 'terlambat'];
        if (!in_array($absen->status, $allowedStatus)) {
            return redirect()->back()->with('error', 'Anda tidak perlu absen keluar karena status anda: ' . ucfirst($absen->status));
        }

        if ($absen->absenkeluar) {
            return redirect()->back()->with('error', 'Anda sudah absen keluar hari ini.');
        }

        $absen->update([
            'absenkeluar' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Berhasil absen keluar.');
    }

    public function izin(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:sakit,izin',
            'keterangan' => 'required|string',
        ]);

        $user = Auth::user();
        $today = Carbon::today();

        // Check if already checked in or submitted permission
        $check = Siswa::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();
            
        if ($check) {
             return redirect()->back()->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        $keteranganDb = Keterangan::where('keterangan', ucfirst($request->kategori))->first();

        Siswa::create([
            'user_id' => $user->id,
            'id_keterangan' => $keteranganDb ? $keteranganDb->id : null,
            'absenmasuk' => null, // No clock in time for permissions
            'status' => $request->kategori,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }
}