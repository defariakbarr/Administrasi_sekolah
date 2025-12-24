<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h4 class="mb-0">Data Kelas</h4>
                <a href="{{ route('admin.kelas.create') }}" class="btn btn-light btn-sm">Tambah Kelas</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>
                                <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>