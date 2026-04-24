<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    // Tampilkan daftar karyawan
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Filter pencarian
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('nip', 'like', '%' . $request->cari . '%')
                  ->orWhere('email', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('departemen')) {
            $query->where('departemen', $request->departemen);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawanList = $query->latest()->paginate(10)->withQueryString();

        $daftarDepartemen = Karyawan::select('departemen')
            ->distinct()->pluck('departemen');

        return view('karyawan.indeks', compact('karyawanList', 'daftarDepartemen'));
    }

    // Form tambah karyawan
    public function tambah()
    {
        return view('karyawan.tambah');
    }

    // Simpan karyawan baru
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'nip'           => 'required|string|max:20|unique:karyawan,nip',
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|max:100|unique:karyawan,email',
            'telepon'       => 'nullable|string|max:20',
            'jabatan'       => 'required|string|max:100',
            'departemen'    => 'required|string|max:100',
            'status'        => 'required|in:aktif,tidak_aktif',
            'tanggal_masuk' => 'required|date',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nip.unique'   => 'NIP sudah digunakan oleh karyawan lain.',
            'email.unique' => 'Email sudah terdaftar.',
            'foto.image'   => 'File harus berupa gambar.',
            'foto.max'     => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('foto-karyawan', 'public');
        }

        Karyawan::create($validated);

        return redirect()->route('karyawan.indeks')
            ->with('sukses', 'Karyawan berhasil ditambahkan!');
    }

    // Detail karyawan
    public function detail(Karyawan $karyawan)
    {
        $riwayatAbsensi = $karyawan->absensi()
            ->latest('tanggal')
            ->limit(30)
            ->get();

        $statistik = [
            'total_hadir' => $karyawan->absensi()->bulanIni()
                ->whereIn('status_kehadiran', ['hadir', 'terlambat'])->count(),
            'total_izin'  => $karyawan->absensi()->bulanIni()
                ->where('status_kehadiran', 'izin')->count(),
            'total_sakit' => $karyawan->absensi()->bulanIni()
                ->where('status_kehadiran', 'sakit')->count(),
            'total_alpha' => $karyawan->absensi()->bulanIni()
                ->where('status_kehadiran', 'alpha')->count(),
        ];

        return view('karyawan.detail', compact('karyawan', 'riwayatAbsensi', 'statistik'));
    }

    // Form edit karyawan
    public function ubah(Karyawan $karyawan)
    {
        return view('karyawan.ubah', compact('karyawan'));
    }

    // Perbarui data karyawan
    public function perbarui(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nip'           => ['required','string','max:20', Rule::unique('karyawan','nip')->ignore($karyawan->id)],
            'nama'          => 'required|string|max:100',
            'email'         => ['required','email','max:100', Rule::unique('karyawan','email')->ignore($karyawan->id)],
            'telepon'       => 'nullable|string|max:20',
            'jabatan'       => 'required|string|max:100',
            'departemen'    => 'required|string|max:100',
            'status'        => 'required|in:aktif,tidak_aktif',
            'tanggal_masuk' => 'required|date',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validated['foto'] = $request->file('foto')
                ->store('foto-karyawan', 'public');
        }

        $karyawan->update($validated);

        return redirect()->route('karyawan.indeks')
            ->with('sukses', 'Data karyawan berhasil diperbarui!');
    }

    // Hapus karyawan (soft delete)
    public function hapus(Karyawan $karyawan)
    {
        if ($karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('karyawan.indeks')
            ->with('sukses', 'Karyawan berhasil dihapus!');
    }
}
