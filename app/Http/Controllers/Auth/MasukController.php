<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MasukController extends Controller
{
    // Tampilkan halaman login
    public function tampilFormMasuk()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.masuk');
    }

    // Proses login
    public function prosesMasuk(Request $request)
    {
        $request->validate([
            'email'      => 'required|email',
            'kata_sandi' => 'required|string|min:6',
        ], [
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
            'kata_sandi.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        // Cari pengguna berdasarkan email
        $pengguna = Pengguna::where('email', $request->email)->first();

        // Validasi pengguna
        if (!$pengguna || !Hash::check($request->kata_sandi, $pengguna->kata_sandi)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.']);
        }

        // Cek status akun
        if ($pengguna->status === 'nonaktif') {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
        }

        // Login pengguna
        Auth::login($pengguna, $request->boolean('ingat_saya'));

        // Perbarui waktu login terakhir
        $pengguna->update(['terakhir_login' => now()]);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('sukses', 'Selamat datang, ' . $pengguna->nama . '!');
    }

    // Proses logout
    public function prosesKeluar(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('masuk')
            ->with('sukses', 'Anda berhasil keluar dari sistem.');
    }
}
