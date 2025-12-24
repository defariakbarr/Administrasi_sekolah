<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Mapel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow col-md-6 mx-auto">
            <div class="card-header bg-warning"><h4>Edit Mata Pelajaran</h4></div>
            <div class="card-body">
                <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" value="{{ $mapel->nama_mapel }}" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>