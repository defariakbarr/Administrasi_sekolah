<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kelas {{ $kelas->nama_kelas }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <style>
        .table-rekap thead th { vertical-align: middle; text-align: center; font-size: 0.85rem; }
        .sticky-col { position: sticky; left: 0; background-color: white !important; z-index: 2; border-right: 2px solid #dee2e6 !important; }
        .table-primary { background-color: #cfe2ff !important; }
        .bg-akhir { background-color: #f0f7ff; font-weight: bold; }
        .small-text { font-size: 0.7rem; }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-start mb-4 px-3">
            <div>
                <h2 class="fw-bold text-dark">Rekap Nilai & Absensi: {{ $kelas->nama_kelas }} 🏛️</h2>
                <p class="text-muted mb-0">
                    Rumus Nilai Akhir: \( Akhir = (0.3 \times Tugas) + (0.3 \times UTS) + (0.4 \times UAS) \)
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('guru.nilai.cetak_massal') }}" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="bi bi-printer me-1"></i> Cetak Rapor Satu Kelas (PDF)
                </a>
                <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-primary rounded-pill shadow-sm">
                    <i class="bi bi-house-door me-1"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 mx-3">
            <div class="card-body">
                <form action="{{ route('guru.wali.rekap') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Pilih Mata Pelajaran:</label>
                        <select name="mapel_id" class="form-select rounded-pill" onchange="this.form.submit()">
                            <option value="">-- Tampilkan Semua Mapel --</option>
                            @foreach($pilihanMapel as $pm)
                                <option value="{{ $pm->id }}" {{ $filterMapelId == $pm->id ? 'selected' : '' }}>
                                    {{ $pm->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('guru.wali.rekap') }}" class="btn btn-outline-secondary rounded-pill w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        @php
            $mapelsTabel = $filterMapelId ? $pilihanMapel->where('id', $filterMapelId) : $pilihanMapel;
        @endphp

        <div class="card border-0 shadow-sm mx-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-primary border-white">
                            <tr>
                                <th rowspan="3">No</th>
                                <th rowspan="3" class="sticky-col">Nama Siswa</th>
                                <th colspan="{{ $mapelsTabel->count() * 4 }}">Mata Pelajaran</th>
                                <th rowspan="3" class="bg-dark text-white">Rata-rata</th>
                                <th colspan="4">Rekap Absensi</th>
                            </tr>
                            <tr>
                                @foreach($mapelsTabel as $mapel)
                                    <th colspan="4">{{ $mapel->nama_mapel }}</th>
                                @endforeach
                                <th rowspan="2" class="bg-info text-white small">H</th>
                                <th rowspan="2" class="bg-success text-white small">S</th>
                                <th rowspan="2" class="bg-warning small">I</th>
                                <th rowspan="2" class="bg-danger text-white small">A</th>
                            </tr>
                            <tr>
                                @foreach($mapelsTabel as $mapel)
                                    <th class="small-text">Tgs</th>
                                    <th class="small-text">UTS</th>
                                    <th class="small-text">UAS</th>
                                    <th class="small-text bg-akhir">Akhir</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $index => $siswa)
                                @php $totalNilaiAkhirSiswa = 0; $jumlahMapelSiswa = 0; @endphp
                                <tr class="text-center align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold sticky-col text-start">{{ $siswa->nama }}</td>
                                    
                                    @foreach($mapelsTabel as $mapel)
                                        @php
                                            $nilaiSiswa = $siswa->nilais->where('mapel_id', $mapel->id);
                                            $tugas = $nilaiSiswa->where('jenis', 'Tugas')->avg('angka') ?? 0;
                                            $uts = $nilaiSiswa->where('jenis', 'UTS')->first()->angka ?? 0;
                                            $uas = $nilaiSiswa->where('jenis', 'UAS')->first()->angka ?? 0;
                                            $akhir = (0.3 * $tugas) + (0.3 * $uts) + (0.4 * $uas);
                                            
                                            if($akhir > 0) {
                                                $totalNilaiAkhirSiswa += $akhir;
                                                $jumlahMapelSiswa++;
                                            }
                                        @endphp
                                        <td class="small-text">{{ $tugas > 0 ? round($tugas) : '-' }}</td>
                                        <td class="small-text">{{ $uts > 0 ? round($uts) : '-' }}</td>
                                        <td class="small-text">{{ $uas > 0 ? round($uas) : '-' }}</td>
                                        <td class="bg-akhir {{ $akhir < 75 && $akhir > 0 ? 'text-danger' : '' }}">
                                            {{ $akhir > 0 ? round($akhir, 1) : '-' }}
                                        </td>
                                    @endforeach

                                    <td class="fw-bold bg-light">
                                        @php $rata = $jumlahMapelSiswa > 0 ? $totalNilaiAkhirSiswa / $jumlahMapelSiswa : 0; @endphp
                                        <span class="badge {{ $rata >= 75 ? 'bg-success' : ($rata > 0 ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                            {{ $rata > 0 ? round($rata, 1) : '-' }}
                                        </span>
                                    </td>

                                    <td class="fw-bold">{{ $siswa->absensis->where('status', 'Hadir')->count() }}</td>
                                    <td class="fw-bold">{{ $siswa->absensis->where('status', 'Sakit')->count() }}</td>
                                    <td class="fw-bold">{{ $siswa->absensis->where('status', 'Izin')->count() }}</td>
                                    <td class="fw-bold text-danger">{{ $siswa->absensis->where('status', 'Alpha')->count() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="100" class="py-5 text-muted">Belum ada data siswa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>