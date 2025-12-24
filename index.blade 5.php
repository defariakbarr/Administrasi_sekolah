<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h4 class="mb-0">Data Nilai Siswa</h4>
                <a href="{{ route('admin.nilai.create') }}" class="btn btn-light btn-sm">Input Nilai Baru</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais as $nilai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $nilai->siswa->nama }}</td>
                            <td>{{ $nilai->mapel->nama_mapel }}</td>
                            <td>{{ $nilai->angka }}</td>
                            <td>
                                <a href="{{ route('admin.nilai.edit', $nilai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.nilai.destroy', $nilai->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus nilai ini?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data nilai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
