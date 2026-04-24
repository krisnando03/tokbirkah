<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekSudahMasuk
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('masuk')
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        // Cek status akun masih aktif
        if (Auth::user()->status === 'nonaktif') {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('masuk')
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
        }

        return $next($request);
    }
}
