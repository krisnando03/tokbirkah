<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();
        $hariIni  = today();

        if ($pengguna->isAdmin()) {
            return $this->dashboardAdmin($hariIni);
        }

        return $this->dashboardPengguna($pengguna, $hariIni);
    }

    // ──────────────────────────────────────────
    // Dashboard Admin — statistik semua karyawan
    // ──────────────────────────────────────────
    private function dashboardAdmin($hariIni)
    {
        $totalKaryawan     = Karyawan::aktif()->count();
        $karyawanHadir     = Absensi::whereDate('tanggal', $hariIni)->whereIn('status_kehadiran', ['hadir','terlambat'])->count();
        $karyawanAbsen     = $totalKaryawan - $karyawanHadir;
        $karyawanTerlambat = Absensi::whereDate('tanggal', $hariIni)->where('status_kehadiran', 'terlambat')->count();

        $absensiTerbaru = Absensi::with('karyawan')
            ->whereDate('tanggal', $hariIni)
            ->latest()->limit(10)->get();

        $grafikKehadiran = collect(range(6, 0))->map(function ($offset) {
            $tgl = Carbon::today()->subDays($offset);
            return [
                'tanggal' => $tgl->format('d/m'),
                'hadir'   => Absensi::whereDate('tanggal', $tgl)->whereIn('status_kehadiran', ['hadir','terlambat'])->count(),
                'alpha'   => Absensi::whereDate('tanggal', $tgl)->where('status_kehadiran', 'alpha')->count(),
            ];
        });

        return view('dashboard', compact(
            'totalKaryawan', 'karyawanHadir', 'karyawanAbsen',
            'karyawanTerlambat', 'absensiTerbaru', 'grafikKehadiran'
        ));
    }

    // ──────────────────────────────────────────
    // Dashboard Pengguna — hanya data diri sendiri
    // ──────────────────────────────────────────
    private function dashboardPengguna($pengguna, $hariIni)
    {
        $karyawan = $pengguna->karyawan;
        $absensiHariIni = null;
        $riwayatAbsensi = collect();
        $statistikBulanIni = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0, 'terlambat' => 0];

        if ($karyawan) {
            $absensiHariIni = $karyawan->absensiHariIni();
            $riwayatAbsensi = $karyawan->absensi()->latest('tanggal')->limit(10)->get();
            $statistikBulanIni = [
                'hadir'     => $karyawan->absensi()->bulanIni()->whereIn('status_kehadiran', ['hadir','terlambat'])->count(),
                'izin'      => $karyawan->absensi()->bulanIni()->where('status_kehadiran', 'izin')->count(),
                'sakit'     => $karyawan->absensi()->bulanIni()->where('status_kehadiran', 'sakit')->count(),
                'alpha'     => $karyawan->absensi()->bulanIni()->where('status_kehadiran', 'alpha')->count(),
                'terlambat' => $karyawan->absensi()->bulanIni()->where('status_kehadiran', 'terlambat')->count(),
            ];
        }

        return view('dashboard-pengguna', compact(
            'pengguna', 'karyawan', 'absensiHariIni',
            'riwayatAbsensi', 'statistikBulanIni'
        ));
    }
}
