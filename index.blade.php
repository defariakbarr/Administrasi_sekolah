@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📜 Riwayat Input Nilai</h5>
                <a href="{{ route('guru.nilai.create') }}" class="btn btn-light btn-sm">➕ Tambah Nilai</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Mata Pelajaran</th>
                            <th>Kategori</th>
                            <th>Nilai</th>
                            <th>Aksi</th> {{-- Kolom baru --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilais as $index => $nilai)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $nilai->siswa->nama }}</td>
                            <td>{{ $nilai->mapel->nama_mapel }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $nilai->jenis }}</span>
                            </td>
                            <td>{{ $nilai->angka }}</td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('guru.nilai.edit', $nilai->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                {{-- Tombol Hapus dengan Form --}}
                                <form action="{{ route('guru.nilai.destroy', $nilai->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection