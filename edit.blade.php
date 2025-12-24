@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">✏️ Edit Nilai Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.nilai.update', $nilai->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Penting: Laravel butuh ini untuk proses update --}}

                    {{-- 1. Pilih Siswa (Data Lama Terpilih) --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <select name="siswa_id" class="form-select" required>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ $nilai->siswa_id == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. Pilih Mata Pelajaran --}}
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select" required>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}" {{ $nilai->mapel_id == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. Pilih Kategori Nilai --}}
                    <div class="mb-3">
                        <label class="form-label">Kategori Nilai</label>
                        <select name="jenis" class="form-select" required>
                            <option value="Tugas" {{ $nilai->jenis == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                            <option value="UTS" {{ $nilai->jenis == 'UTS' ? 'selected' : '' }}>UTS</option>
                            <option value="UAS" {{ $nilai->jenis == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
                    </div>

                    {{-- 4. Nilai Angka --}}
                    <div class="mb-3">
                        <label class="form-label">Nilai Angka (0-100)</label>
                        <input type="number" name="angka" class="form-control" 
                               value="{{ $nilai->angka }}" min="0" max="100" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan ✅</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection