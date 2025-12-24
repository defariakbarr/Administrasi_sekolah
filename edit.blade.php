<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <div class="card shadow" style="max-width: 600px; margin: auto;">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Data Guru</h4>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
                    @csrf 
                    @method('PUT') <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $guru->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran yang Diampu</label>
                        <input type="text" name="mapel" class="form-control" value="{{ $guru->mapel ?? '' }}" placeholder="Contoh: Matematika" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>