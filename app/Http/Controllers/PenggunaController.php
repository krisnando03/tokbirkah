<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    // Daftar semua pengguna (admin only)
    public function index(Request $request)
    {
        $query = Pengguna::with('karyawan')->withTrashed();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('email', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('peran')) {
            $query->where('peran', $request->peran);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $daftarPengguna = $query->latest()->paginate(10)->withQueryString();

        $statistik = [
            'total'    => Pengguna::count(),
            'admin'    => Pengguna::where('peran', 'admin')->count(),
            'pengguna' => Pengguna::where('peran', 'pengguna')->count(),
            'nonaktif' => Pengguna::where('status', 'nonaktif')->count(),
        ];

        return view('pengguna.indeks', compact('daftarPengguna', 'statistik'));
    }

    // Form tambah pengguna
    public function tambah()
    {
        // Karyawan yang belum punya akun
        $daftarKaryawan = Karyawan::aktif()
            ->whereDoesntHave('pengguna')
            ->orderBy('nama')
            ->get();

        return view('pengguna.tambah', compact('daftarKaryawan'));
    }

    // Simpan pengguna baru
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:pengguna,email',
            'kata_sandi'  => 'required|string|min:6|confirmed',
            'peran'       => 'required|in:admin,pengguna',
            'status'      => 'required|in:aktif,nonaktif',
            'karyawan_id' => 'nullable|exists:karyawan,id|unique:pengguna,karyawan_id',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'email.unique'          => 'Email sudah digunakan.',
            'kata_sandi.confirmed'  => 'Konfirmasi kata sandi tidak cocok.',
            'karyawan_id.unique'    => 'Karyawan ini sudah memiliki akun.',
        ]);

        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')
                ->store('foto-pengguna', 'public');
        }

        $validated['kata_sandi'] = Hash::make($validated['kata_sandi']);

        Pengguna::create($validated);

        return redirect()->route('pengguna.indeks')
            ->with('sukses', 'Pengguna berhasil ditambahkan!');
    }

    // Detail pengguna
    public function detail(Pengguna $pengguna)
    {
        $pengguna->load('karyawan.absensi');
        return view('pengguna.detail', compact('pengguna'));
    }

    // Form edit pengguna
    public function ubah(Pengguna $pengguna)
    {
        $daftarKaryawan = Karyawan::aktif()
            ->where(function ($q) use ($pengguna) {
                $q->whereDoesntHave('pengguna')
                  ->orWhere('id', $pengguna->karyawan_id);
            })
            ->orderBy('nama')
            ->get();

        return view('pengguna.ubah', compact('pengguna', 'daftarKaryawan'));
    }

    // Perbarui data pengguna
    public function perbarui(Request $request, Pengguna $pengguna)
    {
        // Cegah admin mengubah perannya sendiri
        if (Auth::id() === $pengguna->id && $request->peran !== 'admin') {
            return back()->withErrors(['peran' => 'Anda tidak dapat mengubah peran akun Anda sendiri.']);
        }

        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'email'       => ['required', 'email', 'max:100', Rule::unique('pengguna', 'email')->ignore($pengguna->id)],
            'peran'       => 'required|in:admin,pengguna',
            'status'      => 'required|in:aktif,nonaktif',
            'karyawan_id' => ['nullable', 'exists:karyawan,id',
                              Rule::unique('pengguna', 'karyawan_id')->ignore($pengguna->id)],
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($pengguna->foto_profil) {
                Storage::disk('public')->delete($pengguna->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')
                ->store('foto-pengguna', 'public');
        }

        $pengguna->update($validated);

        return redirect()->route('pengguna.indeks')
            ->with('sukses', 'Data pengguna berhasil diperbarui!');
    }

    // Reset kata sandi oleh admin
    public function resetKataSandi(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'kata_sandi_baru'              => 'required|string|min:6|confirmed',
            'kata_sandi_baru_confirmation' => 'required',
        ], [
            'kata_sandi_baru.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $pengguna->update([
            'kata_sandi' => Hash::make($request->kata_sandi_baru),
        ]);

        return redirect()->route('pengguna.detail', $pengguna)
            ->with('sukses', 'Kata sandi berhasil direset!');
    }

    // Nonaktifkan / aktifkan akun
    public function ubahStatus(Pengguna $pengguna)
    {
        // Cegah admin menonaktifkan akunnya sendiri
        if (Auth::id() === $pengguna->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $statusBaru = $pengguna->status === 'aktif' ? 'nonaktif' : 'aktif';
        $pengguna->update(['status' => $statusBaru]);

        $pesan = $statusBaru === 'aktif' ? 'Akun berhasil diaktifkan!' : 'Akun berhasil dinonaktifkan!';
        return back()->with('sukses', $pesan);
    }

    // Hapus permanen
    public function hapus(Pengguna $pengguna)
    {
        if (Auth::id() === $pengguna->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($pengguna->foto_profil) {
            Storage::disk('public')->delete($pengguna->foto_profil);
        }

        $pengguna->delete();

        return redirect()->route('pengguna.indeks')
            ->with('sukses', 'Pengguna berhasil dihapus!');
    }

    // ──────────────────────────────────────────
    // Profil diri sendiri (semua role)
    // ──────────────────────────────────────────
    public function profilSaya()
    {
        $pengguna = Auth::user();
        return view('pengguna.profil-saya', compact('pengguna'));
    }

    public function perbaruiProfilSaya(Request $request)
    {
        $pengguna = Auth::user();

        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($pengguna->foto_profil) {
                Storage::disk('public')->delete($pengguna->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')
                ->store('foto-pengguna', 'public');
        }

        $pengguna->update($validated);

        return back()->with('sukses', 'Profil berhasil diperbarui!');
    }

    public function ubahKataSandiSaya(Request $request)
    {
        $pengguna = Auth::user();

        $request->validate([
            'kata_sandi_lama'  => 'required',
            'kata_sandi_baru'  => 'required|string|min:6|confirmed',
        ], [
            'kata_sandi_baru.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        if (!Hash::check($request->kata_sandi_lama, $pengguna->kata_sandi)) {
            return back()->withErrors(['kata_sandi_lama' => 'Kata sandi lama tidak sesuai.']);
        }

        $pengguna->update([
            'kata_sandi' => Hash::make($request->kata_sandi_baru),
        ]);

        return back()->with('sukses', 'Kata sandi berhasil diubah!');
    }
}
