<!DOCTYPE html>
<html lang="id">
<head>
    <title>Input Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow col-md-6 mx-auto">
            <div class="card-header bg-primary text-white"><h4>Input Nilai Siswa</h4></div>
            <div class="card-body">
                <form action="{{ route('admin.nilai.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label>Nama Siswa</label>
                        <select name="siswa_id" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nilai (0-100)</label>
                        <input type="number" name="angka" class="form-control" min="0" max="100" required>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>