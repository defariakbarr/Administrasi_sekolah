<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardGuruController extends Controller
{
  public function index()
    {
    $guru = Auth::guard('guru')->user();
    
    // Ambil mapel
    $mapels = Mapel::with('kelas')->where('guru_id', $guru->id)->get();

    $kelasWali = $guru->kelasWali;

    return view('guru.dashboard', compact('mapels', 'kelasWali'));
    }
}