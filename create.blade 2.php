@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📊 Input Nilai: {{ $mapel->nama_mapel }}</h4>
            <span class="badge bg-light text-primary">{{ $mapel->kelas->nama_kelas }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.nilai.store') }}" method="POST">
                @csrf
                {{-- 1. Hidden Input untuk Mapel ID --}}
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">

                <div class="row mb-4">
                    {{-- 2. Pilih Jenis Nilai --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">🏷️ Jenis Nilai</label>
                        <select name="jenis" class="form-select border-primary" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Tugas">Tugas</option>
                            <option value="UTS">UTS</option>
                            <option value="UAS">UAS</option>
                        </select>
                    </div>
                </div>

                {{-- 3. Tabel Input Nilai --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Siswa</th>
                                <th width="200">Angka Nilai (0-100)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $siswa)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $siswa->nama }}</td>
                                <td>
                                    {{-- Nama input menggunakan array nilai[siswa_id] --}}
                                    <input type="number" 
                                           name="nilai[{{ $siswa->id }}]" 
                                           class="form-control text-center border-primary" 
                                           placeholder="0" 
                                           min="0" max="100">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">🔙 Kembali</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold">💾 Simpan Semua Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection