<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login 📄
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses logika login Multi-Auth 🔐
    public function login(Request $request)
    {

        $request->validate([
            'login_as' => 'required', 
            'email'    => 'required', 
            'password' => 'required',
        ]);

        $login_type = $request->login_as;
        $input_value = $request->email;
        $password = $request->password;

        // --- LOGIN ADMIN ---
        if ($login_type == 'admin') {
            $credentials = ['email' => $input_value, 'password' => $password];
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }
        } 
        
        // --- LOGIN GURU ---
        elseif ($login_type == 'guru') {
            $credentials = ['nip' => $input_value, 'password' => $password];
            if (Auth::guard('guru')->attempt($credentials)) {
                $request->session()->regenerate(); // Menghidupkan sesi login 🔑
                return redirect('/guru/dashboard'); // Langsung ke dashboard guru
            }
        } 
        
        // --- LOGIN SISWA ---
        elseif ($login_type == 'siswa') {
            $credentials = ['nis' => $input_value, 'password' => $password];
            if (Auth::guard('siswa')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('/siswa/dashboard');
            }
        }

        // Jika data tidak cocok ❌
        return back()->withErrors([
            'email' => 'Login gagal! Periksa kembali ID dan Password Anda.',
        ])->onlyInput('email');
    }

    // Keluar dari sistem 🚪
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) Auth::guard('web')->logout();
        if (Auth::guard('guru')->check()) Auth::guard('guru')->logout();
        if (Auth::guard('siswa')->check()) Auth::guard('siswa')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}