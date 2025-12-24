<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Harian - {{ $mapel->nama_mapel }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Absensi Pertemuan</h5>
                    <a href="{{ route('guru.dashboard', $mapel->id) }}" class="btn btn-light btn-sm fw-bold">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('guru.absensi.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Mata Pelajaran & Kelas</label>
                                <p class="form-control-plaintext border-bottom pb-2">
                                    <i class="bi bi-book me-2"></i>{{ $mapel->nama_mapel }} 
                                    <span class="badge bg-secondary ms-2">{{ $mapel->kelas->nama_kelas }}</span>
                                </p>
                                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Tanggal Pertemuan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">Hadir</th>
                                        <th class="text-center">Sakit</th>
                                        <th class="text-center">Izin</th>
                                        <th class="text-center">Alpha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswas as $index => $siswa)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $siswa->nama }}</td>
                                        
                                        <td class="text-center">
                                            <input type="radio" name="status[{{ $siswa->id }}]" value="Hadir" class="form-check-input border-primary" checked>
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" name="status[{{ $siswa->id }}]" value="Sakit" class="form-check-input border-warning">
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" name="status[{{ $siswa->id }}]" value="Izin" class="form-check-input border-info">
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" name="status[{{ $siswa->id }}]" value="Alpha" class="form-check-input border-danger">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data siswa di kelas ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                <i class="bi bi-save me-2"></i>Simpan Data Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>