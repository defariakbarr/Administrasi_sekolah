@extends('layouts.app') {{-- Sesuaikan dengan nama layout kamu --}}

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🏫 Kelas: {{ $mapel->kelas->nama_kelas }}</h2>
            <p class="text-muted">📚 Mata Pelajaran: {{ $mapel->nama_mapel }}</p>
        </div>
        <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td class="text-center">
                                {{-- Kita akan isi tombol ini nanti --}}
                                <button class="btn btn-sm btn-primary">Input Nilai</button>
                                <button class="btn btn-sm btn-success">Absensi</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada siswa di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection