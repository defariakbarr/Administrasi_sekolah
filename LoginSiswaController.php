<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginSiswaController extends Controller
{
    /**
     * Menampilkan formulir login untuk siswa 📄
     */
    public function showLoginForm()
    {
        return view('auth.login-siswa');
    }

    /**
     * Memproses permintaan login siswa 🚀
     */
    public function login(Request $request)
    {
        // 1. Validasi input agar NIS dan Password tidak kosong
        $credentials = $request->validate([
            'nis'      => ['required'],
            'password' => ['required'],
        ]);

        // 2. Coba proses login menggunakan guard 'siswa'
        // Laravel akan mencari di tabel 'siswas' berdasarkan NIS
        if (Auth::guard('siswa')->attempt($credentials)) {
            
            // Jika berhasil, buat sesi baru
            $request->session()->regenerate();

            // Arahkan ke dashboard siswa
            return redirect()->intended(route('siswa.dashboard'));
        }

        // 3. Jika gagal, kirim pesan error kembali ke halaman login
        return back()->withErrors([
            'nis' => 'Nomor Induk Siswa atau Password tidak cocok dengan data kami.',
        ])->onlyInput('nis');
    }

    /**
     * Mengeluarkan siswa dari sistem 🚪
     */
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('siswa.login');
    }
}