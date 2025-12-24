<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow col-md-6 mx-auto">
            <div class="card-header bg-warning"><h4>Edit Nilai Siswa</h4></div>
            <div class="card-body">
                <form action="{{ route('admin.nilai.update', $nilai->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label>Nama Siswa</label>
                        <select name="siswa_id" class="form-control" required>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ $nilai->siswa_id == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" required>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}" {{ $nilai->mapel_id == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nilai</label>
                        <input type="number" name="angka" value="{{ $nilai->angka }}" class="form-control" min="0" max="100" required>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>