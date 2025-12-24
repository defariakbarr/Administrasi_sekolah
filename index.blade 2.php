<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>Manajemen Jadwal</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-calendar3 me-2"></i>Daftar Jadwal Pelajaran</h5>
                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary btn-sm">+ Tambah Jadwal</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $j)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $j->hari }}</span></td>
                                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                <td class="fw-bold">{{ $j->mapel->nama_mapel }}</td>
                                <td>{{ $j->guru->nama }}</td>
                                <td><span class="badge bg-info text-dark">{{ $j->kelas->nama_kelas }}</span></td>
                                <td>
                                    <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data jadwal pelajaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-link mt-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
</body>
</html>