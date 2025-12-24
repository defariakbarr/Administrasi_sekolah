@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        {{-- Header dengan informasi Mata Pelajaran --}}
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0">
                <i class="bi bi-journal-text me-2"></i>Rekap Absensi: {{ $mapel->nama_mapel }}
            </h4>
            <a href="{{ route('guru.dashboard') }}" class="btn btn-light btn-sm fw-bold">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <span class="badge bg-secondary p-2">Kelas: {{ $mapel->kelas->nama_kelas }}</span>
                <span class="badge bg-info p-2 text-dark">Total Pertemuan: {{ $daftar_tanggal->count() }}</span>
            </div>

            @if($daftar_tanggal->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle shadow-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th rowspan="2" class="align-middle">Nama Siswa</th>
                                {{-- Kolom Dinamis Berdasarkan Tanggal 📅 --}}
                                <th colspan="{{ $daftar_tanggal->count() }}" class="bg-primary">Rincian Pertemuan</th>
                                <th colspan="4" class="bg-secondary">Total</th>
                                <th rowspan="2" class="align-middle">Persen</th>
                            </tr>
                            <tr>
                                @foreach($daftar_tanggal as $tgl)
                                    <th style="font-size: 0.75rem; min-width: 45px;">
                                        {{ date('d/m', strtotime($tgl)) }}
                                    </th>
                                @endforeach
                                <th class="text-success" title="Hadir">H</th>
                                <th class="text-warning" title="Sakit">S</th>
                                <th class="text-info" title="Izin">I</th>
                                <th class="text-danger" title="Alpha">A</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($siswas as $siswa)
                                <tr>
                                    <td class="fw-bold text-nowrap">{{ $siswa->nama }}</td>

                                    @php 
                                        $h = 0; $s = 0; $i = 0; $a = 0; 
                                    @endphp

                                    @foreach($daftar_tanggal as $tglData)
                                        @php
                                            // Kita pastikan format tanggalnya sama persis (Y-m-d) agar 'where' bisa menemukan datanya
                                            $tglString = is_object($tglData) ? $tglData->tanggal : $tglData;

                                            $absen = $all_absensi->where('siswa_id', $siswa->id)
                                                                ->where('tanggal', $tglString)
                                                                ->first();

                                            if($absen) {
                                                if($absen->status == 'Hadir') $h++;
                                                elseif($absen->status == 'Sakit') $s++;
                                                elseif($absen->status == 'Izin') $i++;
                                                elseif($absen->status == 'Alpha') $a++;
                                            }
                                        @endphp
                                        <td class="text-center">
                                            @if($absen)
                                                <span class="fw-bold {{ $absen->status == 'Hadir' ? 'text-success' : ($absen->status == 'Alpha' ? 'text-danger' : '') }}">
                                                    {{ substr($absen->status, 0, 1) }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    {{-- Kolom Rekap Total --}}
                                    <td class="text-center bg-light text-success fw-bold">{{ $h }}</td>
                                    <td class="text-center bg-light text-warning fw-bold">{{ $s }}</td>
                                    <td class="text-center bg-light text-info fw-bold">{{ $i }}</td>
                                    <td class="text-center bg-light text-danger fw-bold">{{ $a }}</td>

                                    <td class="text-center">
                                        @php
                                            $total_pertemuan = $daftar_tanggal->count();
                                            $persen = $total_pertemuan > 0 ? ($h / $total_pertemuan) * 100 : 0;
                                        @endphp
                                        <span class="badge rounded-pill {{ $persen < 75 ? 'bg-danger' : 'bg-success' }}">
                                            {{ round($persen) }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning border-0 shadow-sm text-center py-4">
                    <i class="bi bi-exclamation-triangle fs-2 d-block mb-2"></i>
                    Belum ada data absensi yang tercatat untuk mata pelajaran ini.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection