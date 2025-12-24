<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Data Guru</h4>
                <a href="{{ route('admin.guru.create') }}" class="btn btn-light btn-sm fw-bold">+ Tambah Guru</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Mapel</th>
                                <th style="width: 20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurus as $guru)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $guru->nip }}</td>
                                <td>{{ $guru->nama }}</td>
                                
                                <td>
                                    @if($guru->mapels && $guru->mapels->isNotEmpty())
                                        <span class="badge bg-info text-dark">
                                            {{ $guru->mapels->first()->nama_mapel }}
                                        </span>
                                        @if($guru->mapels->count() > 1)
                                            <small class="d-block text-muted" style="font-size: 10px;">
                                                +{{ $guru->mapels->count() - 1 }} Kelas Lain
                                            </small>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary text-white">Belum Diatur</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>