<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h4 class="mb-0">Data Mata Pelajaran</h4>
                <a href="{{ route('admin.mapel.create') }}" class="btn btn-light btn-sm">Tambah Mapel</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $mapel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mapel->nama_mapel }}</td>
                            <td>
                                <a href="{{ route('admin.mapel.edit', $mapel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.mapel.destroy', $mapel->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus mapel ini?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada mata pelajaran.</td>
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