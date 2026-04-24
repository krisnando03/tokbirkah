<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Daftar absensi harian
    public function index(Request $request)
    {
        $pengguna = Auth::user();
        $tanggal  = $request->get('tanggal', today()->toDateString());

        $query = Absensi::with('karyawan')->whereDate('tanggal', $tanggal);

        // Pengguna biasa hanya lihat absensi karyawannya sendiri
        if ($pengguna->isPengguna()) {
            if ($pengguna->karyawan_id) {
                $query->where('karyawan_id', $pengguna->karyawan_id);
            } else {
                $query->whereRaw('1 = 0'); // Tidak ada karyawan terhubung
            }
        } else {
            // Admin bisa filter per karyawan
            if ($request->filled('karyawan_id')) {
                $query->where('karyawan_id', $request->karyawan_id);
            }
            if ($request->filled('status')) {
                $query->where('status_kehadiran', $request->status);
            }
        }

        $daftarAbsensi = $query->latest()->paginate(15)->withQueryString();

        // Statistik hari ini
        $statistikHariIni = [
            'hadir'     => Absensi::whereDate('tanggal', $tanggal)->whereIn('status_kehadiran',['hadir','terlambat'])->count(),
            'izin'      => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran','izin')->count(),
            'sakit'     => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran','sakit')->count(),
            'alpha'     => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran','alpha')->count(),
            'terlambat' => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran','terlambat')->count(),
        ];

        $daftarKaryawan = Karyawan::aktif()->orderBy('nama')->get();

        return view('absensi.indeks', compact(
            'daftarAbsensi', 'statistikHariIni', 'daftarKaryawan', 'tanggal'
        ));
    }

    // Form tambah absensi manual
    public function tambah()
    {
        $daftarKaryawan = Karyawan::aktif()->orderBy('nama')->get();
        return view('absensi.tambah', compact('daftarKaryawan'));
    }

    // Simpan absensi baru
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id'       => 'required|exists:karyawan,id',
            'tanggal'           => 'required|date',
            'jam_masuk'         => 'nullable|date_format:H:i',
            'jam_keluar'        => 'nullable|date_format:H:i|after:jam_masuk',
            'status_kehadiran'  => 'required|in:hadir,izin,sakit,alpha,cuti,terlambat',
            'keterangan'        => 'nullable|string|max:500',
            'lokasi_masuk'      => 'nullable|string|max:255',
            'lokasi_keluar'     => 'nullable|string|max:255',
        ], [
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk.',
        ]);

        // Cek duplikasi absensi pada tanggal yang sama
        $sudahAbsen = Absensi::where('karyawan_id', $validated['karyawan_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAbsen) {
            return back()->withErrors(['tanggal' => 'Karyawan ini sudah memiliki data absensi pada tanggal tersebut.'])->withInput();
        }

        // Hitung total jam kerja
        if (!empty($validated['jam_masuk']) && !empty($validated['jam_keluar'])) {
            $validated['total_jam_kerja'] = Absensi::hitungJamKerja(
                $validated['jam_masuk'] . ':00',
                $validated['jam_keluar'] . ':00'
            );
        }

        Absensi::create($validated);

        return redirect()->route('absensi.indeks')
            ->with('sukses', 'Data absensi berhasil disimpan!');
    }

    // Form ubah absensi
    public function ubah(Absensi $absensi)
    {
        $daftarKaryawan = Karyawan::aktif()->orderBy('nama')->get();
        return view('absensi.ubah', compact('absensi', 'daftarKaryawan'));
    }

    // Perbarui data absensi
    public function perbarui(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'karyawan_id'       => 'required|exists:karyawan,id',
            'tanggal'           => 'required|date',
            'jam_masuk'         => 'nullable|date_format:H:i',
            'jam_keluar'        => 'nullable|date_format:H:i|after:jam_masuk',
            'status_kehadiran'  => 'required|in:hadir,izin,sakit,alpha,cuti,terlambat',
            'keterangan'        => 'nullable|string|max:500',
            'lokasi_masuk'      => 'nullable|string|max:255',
            'lokasi_keluar'     => 'nullable|string|max:255',
        ]);

        // Hitung ulang total jam kerja
        if (!empty($validated['jam_masuk']) && !empty($validated['jam_keluar'])) {
            $validated['total_jam_kerja'] = Absensi::hitungJamKerja(
                $validated['jam_masuk'] . ':00',
                $validated['jam_keluar'] . ':00'
            );
        } else {
            $validated['total_jam_kerja'] = null;
        }

        $absensi->update($validated);

        return redirect()->route('absensi.indeks')
            ->with('sukses', 'Data absensi berhasil diperbarui!');
    }

    // Hapus absensi
    public function hapus(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('absensi.indeks')
            ->with('sukses', 'Data absensi berhasil dihapus!');
    }

    // Proses check-in cepat
    public function checkIn(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
        ]);

        $sudahAbsen = Absensi::where('karyawan_id', $request->karyawan_id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Karyawan sudah melakukan check-in hari ini.');
        }

        $jamSekarang = now();
        $batasLambat = Carbon::today()->setTime(8, 15); // jam 08:15
        $status = $jamSekarang->gt($batasLambat) ? 'terlambat' : 'hadir';

        Absensi::create([
            'karyawan_id'      => $request->karyawan_id,
            'tanggal'          => today(),
            'jam_masuk'        => $jamSekarang->format('H:i:s'),
            'status_kehadiran' => $status,
        ]);

        return back()->with('sukses', 'Check-in berhasil pada ' . $jamSekarang->format('H:i'));
    }

    // Proses check-out
    public function checkOut(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
        ]);

        $absensi = Absensi::where('karyawan_id', $request->karyawan_id)
            ->whereDate('tanggal', today())
            ->whereNull('jam_keluar')
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Data check-in tidak ditemukan atau sudah check-out.');
        }

        $jamKeluar = now();
        $totalMenit = Absensi::hitungJamKerja($absensi->jam_masuk, $jamKeluar->format('H:i:s'));

        $absensi->update([
            'jam_keluar'      => $jamKeluar->format('H:i:s'),
            'total_jam_kerja' => $totalMenit,
        ]);

        return back()->with('sukses', 'Check-out berhasil pada ' . $jamKeluar->format('H:i'));
    }

    // Laporan absensi
    public function laporan(Request $request)
    {
        $pengguna = Auth::user();
        $bulan    = $request->get('bulan', now()->month);
        $tahun    = $request->get('tahun', now()->year);

        $queryKaryawan = Karyawan::aktif();

        // Pengguna biasa hanya lihat laporannya sendiri
        if ($pengguna->isPengguna() && $pengguna->karyawan_id) {
            $queryKaryawan->where('id', $pengguna->karyawan_id);
        }

        $laporanData = $queryKaryawan
            ->with(['absensi' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            }])
            ->get()
            ->map(function ($karyawan) {
                $absensi = $karyawan->absensi;
                return [
                    'karyawan'  => $karyawan,
                    'hadir'     => $absensi->whereIn('status_kehadiran', ['hadir','terlambat'])->count(),
                    'izin'      => $absensi->where('status_kehadiran', 'izin')->count(),
                    'sakit'     => $absensi->where('status_kehadiran', 'sakit')->count(),
                    'alpha'     => $absensi->where('status_kehadiran', 'alpha')->count(),
                    'cuti'      => $absensi->where('status_kehadiran', 'cuti')->count(),
                    'terlambat' => $absensi->where('status_kehadiran', 'terlambat')->count(),
                ];
            });

        $daftarBulan = collect(range(1, 12))->mapWithKeys(fn($b) => [$b => Carbon::create()->month($b)->translatedFormat('F')]);
        $daftarTahun = range(now()->year - 2, now()->year);

        return view('absensi.laporan', compact('laporanData', 'bulan', 'tahun', 'daftarBulan', 'daftarTahun'));
    }
}
