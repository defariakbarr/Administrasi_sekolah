<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Siswa - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
        .card { border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .btn-sm { border-radius: 8px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 pb-5">
        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow border-0">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-people-fill me-2"></i>Manajemen Data Siswa
                </h5>
                <a href="{{ route('admin.siswa.create') }}" class="btn btn-light btn-sm fw-bold px-3">
                    <i class="bi bi-person-plus-fill me-1"></i>Tambah Siswa
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 80px">No</th>
                                <th>NIS</th>
                                <th>Nama Lengkap</th>
                                <th>Kelas</th>
                                <th class="text-center" style="width: 200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold text-primary">{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                            <i class="bi bi-door-open me-1"></i>
                                            {{ $siswa->kelas->nama_kelas ?? 'Belum Ada Kelas' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm text-white px-3" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-3" title="Hapus Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-database-exclamation fs-1 d-block mb-2"></i>
                                        Belum ada data siswa di database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end bg-light py-3">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm px-4">
                    <i class="bi bi-speedometer2 me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>