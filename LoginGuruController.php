<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Mengimpor pengatur keamanan 🛡️

class LoginGuruController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input agar NIP dan password wajib diisi 📝
        $credentials = $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        // 2. Mencoba proses login menggunakan guard 'guru' 💂‍♂️
        if (Auth::guard('guru')->attempt($credentials)) {
            // Jika sukses, buat ulang session untuk keamanan
            $request->session()->regenerate();
            
            // Arahkan ke dashboard guru
            return redirect()->intended('/guru/dashboard');
        }

        // 3. Jika gagal, kembali ke halaman sebelumnya dengan pesan error ❌
        return back()->withErrors([
            'nip' => 'NIP atau Password yang Anda masukkan salah.',
        ])->onlyInput('nip');
    }
}