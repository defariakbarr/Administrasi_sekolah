@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📜 Rekap Nilai Rapot: {{ $mapel->nama_mapel }}</h4>
            <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-light btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Rata-rata Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $siswaId => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $data['nama_siswa'] }}</td>
                                <td>{{ $data['rata_tugas'] }}</td>
                                <td>{{ $data['uts'] }}</td>
                                <td>{{ $data['uas'] }}</td>
                                <td class="fw-bold">{{ $data['akhir'] }}</td>
                                {{-- Kolom aksi sudah dihapus di sini --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection