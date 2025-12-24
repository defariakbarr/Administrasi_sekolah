<!DOCTYPE html>
<html>
<head>
    <title>Cetak Massal Rapor Lengkap</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        .page-break { page-break-after: always; padding-top: 20px; border-bottom: 1px dashed #ccc; } 
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .text-left { text-align: left !important; }

        @media print {
            .no-print { display: none; }
            .page-break { border-bottom: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Cetak Semua Rapor (PDF)
        </button>
    </div>

    @foreach($siswas as $siswa)
        <div class="page-break">
            <div class="header">
                <h2>RAPOR DIGITAL SISWA</h2>
                <h3>KELAS: {{ $kelas->nama_kelas }}</h3>
            </div>

            <table class="info-table">
                <tr>
                    <td width="15%">Nama Siswa</td><td width="2%">:</td><td>{{ $siswa->nama }}</td>
                    <td width="15%">NIS</td><td width="2%">:</td><td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <td>Kelas</td><td>:</td><td>{{ $kelas->nama_kelas }}</td>
                    <td>Tahun Ajaran</td><td>:</td><td>2024/2025</td>
                </tr>
            </table>

            <h4>A. Nilai Akademik</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Tugas (30%)</th>
                        <th>UTS (30%)</th>
                        <th>UAS (40%)</th>
                        <th>Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaMapel as $mapel)
                        @php
                            // Mengambil data nilai siswa untuk mapel spesifik ini
                            $nilaiMapel = $siswa->nilais->where('mapel_id', $mapel->id);
                            
                            $avgTugas = $nilaiMapel->where('jenis', 'Tugas')->avg('angka') ?? 0;
                            $uts = $nilaiMapel->where('jenis', 'UTS')->first()->angka ?? 0;
                            $uas = $nilaiMapel->where('jenis', 'UAS')->first()->angka ?? 0;
                            
                            // Rumus Nilai Akhir
                            $akhir = (0.3 * $avgTugas) + (0.3 * $uts) + (0.4 * $uas);
                        @endphp
                        <tr>
                            <td class="text-left">{{ $mapel->nama_mapel }}</td>
                            <td>{{ round($avgTugas, 1) }}</td>
                            <td>{{ $uts }}</td>
                            <td>{{ $uas }}</td>
                            <td><strong>{{ round($akhir, 1) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>B. Kehadiran</h4>
            <table class="data-table" style="width: 50%;">
                <tr><td>Hadir</td><td>{{ $siswa->absensis->where('status', 'Hadir')->count() }} hari</td></tr>
                <tr><td>Sakit/Izin</td><td>{{ $siswa->absensis->whereIn('status', ['Sakit', 'Izin'])->count() }} hari</td></tr>
                <tr><td>Tanpa Keterangan</td><td>{{ $siswa->absensis->where('status', 'Alpha')->count() }} hari</td></tr>
            </table>
        </div>
    @endforeach

</body>
</html>