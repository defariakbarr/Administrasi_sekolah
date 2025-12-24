<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa - Portal Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 500px;">
            <div class="card-header bg-warning text-dark fw-bold py-3">
                <i class="bi bi-pencil-square me-2"></i>Edit Data Siswa
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ganti">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary px-4 btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 btn-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>