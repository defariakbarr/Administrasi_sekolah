<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow col-md-6 mx-auto">
            <div class="card-header bg-warning"><h4>Edit Kelas</h4></div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>