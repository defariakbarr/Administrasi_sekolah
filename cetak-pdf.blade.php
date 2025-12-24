<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Belajar - {{ $siswa->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .text-left { text-align: left !important; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>RAPOR DIGITAL SISWA</h2>
        <h3>SMK NEGERI CONTOH</h3>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Nama Siswa</td><td width="2%">:</td><td>{{ $siswa->nama }}</td>
            <td width="15%">Kelas</td><td width="2%">:</td><td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS</td><td>:</td><td>{{ $siswa->nis }}</td>
            <td>Semester</td><td>:</td><td>Ganjil / 2024</td>
        </tr>
    </table>

    <h4>A. Nilai Akademik</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilais->groupBy('mapel_id') as $nilaiMapel)
                @php
                    $avgTugas = $nilaiMapel->where('jenis', 'Tugas')->avg('angka') ?? 0;
                    $uts = $nilaiMapel->where('jenis', 'UTS')->first()->angka ?? 0;
                    $uas = $nilaiMapel->where('jenis', 'UAS')->first()->angka ?? 0;
                    $akhir = (0.3 * $avgTugas) + (0.3 * $uts) + (0.4 * $uas);
                @endphp
                <tr>
                    <td class="text-left">{{ $nilaiMapel->first()->mapel->nama_mapel }}</td>
                    <td>{{ round($avgTugas, 1) }}</td>
                    <td>{{ $uts }}</td>
                    <td>{{ $uas }}</td>
                    <td>{{ round($akhir, 1) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>B. Ketidakhadiran</h4>
    <table class="data-table" style="width: 50%;">
        <tr><td>Hadir</td><td>{{ $absensis->where('status', 'Hadir')->count() }} hari</td></tr>
        <tr><td>Sakit/Izin</td><td>{{ $absensis->whereIn('status', ['Sakit', 'Izin'])->count() }} hari</td></tr>
        <tr><td>Tanpa Keterangan</td><td>{{ $absensis->where('status', 'Alpha')->count() }} hari</td></tr>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y') }}</p>
        <br><br>
        <p>( ____________________ )</p>
        <p>Wali Kelas</p>
    </div>
</body>
</html>