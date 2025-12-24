<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Guru - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .card-menu { transition: transform 0.2s; border-radius: 15px; }
        .card-menu:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .card-wali { background: linear-gradient(45deg, #198754, #20c997); color: white; border: none; border-radius: 15px; }
        .table-schedule thead { background-color: #212529; color: white; }
        .schedule-item { font-size: 0.85rem; border-left: 4px solid #0d6efd; background-color: #f8f9fa; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-mortarboard-fill me-2"></i> Portal Guru</a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3 d-none d-md-inline">Halo, {{ Auth::user()->nama }} 👨‍🏫</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Selamat Datang di Ruang Guru</h2>
            <p class="text-muted">Kelola tugas akademik Anda di bawah ini</p>
        </div>

        {{-- Section Wali Kelas --}}
        @if($kelasWali)
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-12">
                <div class="card card-wali shadow-sm">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 p-3 rounded-3 me-3"><i class="bi bi-person-badge fs-2"></i></div>
                            <div>
                                <h4 class="fw-bold mb-0">Tugas Wali Kelas</h4>
                                <p class="mb-0 opacity-75">Wali Kelas dari <strong>{{ $kelasWali->nama_kelas }}</strong></p>
                            </div>
                        </div>
                        <a href="{{ route('guru.wali.rekap') }}" class="btn btn-light fw-bold text-success px-4 rounded-pill shadow-sm">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Rekap Nilai Satu Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Section Menu Mata Pelajaran --}}
        <h4 class="fw-bold mb-4"><i class="bi bi-book-half me-2"></i> Menu Manajemen Kelas</h4>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            @forelse ($mapels as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm card-menu">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-2">
                                <i class="bi bi-journal-text text-primary fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-0 text-primary text-truncate">{{ $item->nama_mapel }}</h5>
                            <span class="badge bg-secondary mt-2">{{ $item->kelas->nama_kelas }}</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-6"><a href="{{ route('guru.absensi.create', $item->id) }}" class="btn btn-outline-primary btn-sm w-100 py-2">Absen</a></div>
                            <div class="col-6"><a href="{{ route('guru.nilai.create', ['id' => $item->id]) }}" class="btn btn-outline-warning btn-sm w-100 py-2">Nilai</a></div>
                            <div class="col-6"><a href="{{ route('guru.absensi.rekap', $item->id) }}" class="btn btn-outline-success btn-sm w-100 py-2">Rekap Absen</a></div>
                            <div class="col-6"><a href="{{ route('guru.nilai.rapot', ['id' => $item->id]) }}" class="btn btn-outline-info btn-sm w-100 py-2">Rekap Nilai</a></div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 bg-white rounded-3 shadow-sm">
                <p class="text-muted mb-0">Anda belum memiliki jadwal mata pelajaran yang diajar.</p>
            </div>
            @endforelse
        </div>

        {{-- Section Tabel Jadwal Mingguan --}}
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-white py-3 border-0">
                <h4 class="mb-0 fw-bold"><i class="bi bi-calendar3 me-2 text-primary"></i> Jadwal Mengajar Mingguan</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 table-schedule text-center align-middle">
                        <thead>
                            <tr>
                                <th style="min-width: 120px;">Waktu</th>
                                <th style="min-width: 180px;">Senin</th>
                                <th style="min-width: 180px;">Selasa</th>
                                <th style="min-width: 180px;">Rabu</th>
                                <th style="min-width: 180px;">Kamis</th>
                                <th style="min-width: 180px;">Jumat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $slots = [
                                    ['start' => '07:30', 'end' => '09:00'],
                                    ['start' => '09:30', 'end' => '11:00']
                                ];
                                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                            @endphp

                            @foreach($slots as $slot)
                            <tr>
                                <td class="bg-light fw-bold text-muted small">
                                    {{ $slot['start'] }} - {{ $slot['end'] }}
                                </td>
                                @foreach($days as $day)
                                <td class="p-2">
                                    @php
                                        $match = collect($jadwal_saya[$day] ?? [])->filter(function($j) use ($slot) {
                                            return date('H:i', strtotime($j->jam_mulai)) == $slot['start'];
                                        })->first();
                                    @endphp

                                    @if($match)
                                    <div class="schedule-item p-2 rounded shadow-sm text-start">
                                        <div class="fw-bold text-primary mb-1">{{ $match->mapel->nama_mapel }}</div>
                                        <div class="small text-dark fw-semibold"><i class="bi bi-door-open me-1"></i>{{ $match->kelas->nama_kelas }}</div>
                                    </div>
                                    @else
                                    <span class="text-muted opacity-25">-</span>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>