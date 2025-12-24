<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel; // Pastikan Model Mapel dipanggil

class MapelController extends Controller
{
    // Tampilkan daftar mapel
    public function index() {
        $mapels = Mapel::all();
        return view('admin.mapel.index', compact('mapels'));
    }

    // Form tambah mapel
    public function create() {
        return view('admin.mapel.create');
    }

    // Simpan mapel baru
    public function store(Request $request) {
        $request->validate(['nama_mapel' => 'required']);
        Mapel::create($request->all());
        return redirect()->route('admin.mapel.index');
    }

    // Form edit mapel
    public function edit($id) {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    // Update mapel
    public function update(Request $request, $id) {
        $request->validate(['nama_mapel' => 'required']);
        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->all());
        return redirect()->route('admin.mapel.index');
    }

    // Hapus mapel
    public function destroy($id) {
        Mapel::findOrFail($id)->delete();
        return redirect()->route('admin.mapel.index');
    }
}