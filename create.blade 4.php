<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Mapel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow col-md-6 mx-auto">
            <div class="card-header bg-primary text-white"><h4>Tambah Mata Pelajaran</h4></div>
            <div class="card-body">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.mapel.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control" value="{{ old('nama_mapel') }}" required placeholder="Contoh: Matematika Wajib">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>