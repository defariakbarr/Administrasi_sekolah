@extends('layouts.app')

@section('content')
@php
    // 1. Logika Sapaan Waktu ⏰
    $hour = date('H');
    if ($hour < 11) $greeting = "Selamat Pagi";
    elseif ($hour < 15) $greeting = "Selamat Siang";
    elseif ($hour < 18) $greeting = "Selamat Sore";
    else $greeting = "Selamat Malam";

    // 2. Menghitung Rata-rata Nilai Akhir untuk Motivasi 📊
    $totalAkhir = 0;
    $countMapel = $nilais->groupBy('mapel_id')->count();
    
    foreach($nilais->groupBy('mapel_id') as $nilaiMapel) {
        $avgTugas = $nilaiMapel->where('jenis', 'Tugas')->avg('angka') ?? 0;
        $uts = $nilaiMapel->where('jenis', 'UTS')->first()->angka ?? 0;
        $uas = $nilaiMapel->where('jenis', 'UAS')->first()->angka ?? 0;
        $totalAkhir += (0.3 * $avgTugas) + (0.3 * $uts) + (0.4 * $uas);
    }

    $rataRataGelar = $countMapel > 0 ? $totalAkhir / $countMapel : 0;
    
    // Tentukan pesan berdasarkan performa
    if($rataRataGelar >= 85) {
        $motivasi = "Luar biasa! Prestasimu sangat membanggakan. Pertahankan! 🌟";
        $color = "primary";
    } elseif($rataRataGelar >= 75) {
        $motivasi = "Kerja bagus! Kamu sudah berada di jalur yang benar. 🔥";
        $color = "success";
    } else {
        $motivasi = "Jangan berkecil hati. Ayo lebih giat lagi belajarnya! 💪";
        $color = "warning";
    }
@endphp

<div class="container py-4">
    {{-- Header & Motivasi --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">{{ $greeting }}, {{ $siswa->nama }}! 👋</h2>
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body border-start border-4 border-{{ $color }}">
                    <p class="mb-1 text-muted"><strong>Info Profil:</strong> NIS {{ $siswa->nis }} | Kelas {{ $siswa->kelas->nama_kelas ?? 'Umum' }}</p>
                    <hr class="my-2">
                    <p class="mb-0 font-italic text-dark">"{{ $motivasi }}"</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Absensi --}}
    <div class="row mb-4">
        @php
            $stats = [
                ['label' => 'Hadir', 'count' => $absensis->where('status', 'Hadir')->count(), 'bg' => 'info', 'icon' => 'bi-check-circle'],
                ['label' => 'Sakit', 'count' => $absensis->where('status', 'Sakit')->count(), 'bg' => 'success', 'icon' => 'bi-bandaid'],
                ['label' => 'Izin', 'count' => $absensis->where('status', 'Izin')->count(), 'bg' => 'warning', 'icon' => 'bi-envelope'],
                ['label' => 'Alpha', 'count' => $absensis->where('status', 'Alpha')->count(), 'bg' => 'danger', 'icon' => 'bi-x-circle'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="col-md-3 col-6 mb-3">
            <div class="card bg-{{ $stat['bg'] }} text-{{ $stat['bg'] == 'warning' ? 'dark' : 'white' }} shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="mb-1 opacity-75">{{ $stat['label'] }}</h6>
                    <h3 class="fw-bold mb-0">{{ $stat['count'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Jadwal Mingguan Horizontal --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-calendar3 me-2"></i>Jadwal Pelajaran Mingguan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="min-width: 100px;">Waktu</th>
                            <th style="min-width: 150px;">Senin</th>
                            <th style="min-width: 150px;">Selasa</th>
                            <th style="min-width: 150px;">Rabu</th>
                            <th style="min-width: 150px;">Kamis</th>
                            <th style="min-width: 150px;">Jumat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $slots = [
                                ['start' => '07:30', 'end' => '09:00'],
                                ['start' => '09:30', 'end' => '11:00']
                            ];
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                            $data_jadwal = $jadwal_saya ?? $jadwal_kelas;
                        @endphp

                        @foreach($slots as $slot)
                        <tr>
                            <td class="bg-light fw-bold small text-muted">{{ $slot['start'] }} - {{ $slot['end'] }}</td>
                            @foreach($days as $day)
                            <td class="p-2">
                                @php
                                    $match = collect($data_jadwal[$day] ?? [])->filter(function($j) use ($slot) {
                                        return date('H:i', strtotime($j->jam_mulai)) == $slot['start'];
                                    })->first();
                                @endphp

                                @if($match)
                                <div class="p-2 rounded shadow-sm text-start" style="border-left: 4px solid #0d6efd; background-color: #f8f9fa;">
                                    <div class="fw-bold text-primary mb-1" style="font-size: 0.85rem;">{{ $match->mapel->nama_mapel }}</div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-person-badge me-1"></i>{{ $match->guru->nama }}
                                    </div>
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

    {{-- Daftar Nilai --}}
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-award me-2"></i>Daftar Nilai Akademik</h5>
            <div class="d-flex align-items-center">
                <span class="badge bg-white text-primary me-2 py-2">Rata-rata: {{ round($rataRataGelar, 1) }}</span>
                <a href="{{ route('siswa.cetak') }}" class="btn btn-sm btn-light fw-bold">
                    🖨️ Cetak Raport
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center">
                    <thead class="table-light text-uppercase small fw-bold">
                        <tr>
                            <th class="text-start ps-4">Mata Pelajaran</th>
                            <th>Tugas (Avg)</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais->groupBy('mapel_id') as $nilaiMapel)
                            @php
                                $mapelNama = $nilaiMapel->first()->mapel->nama_mapel;
                                $avgTugas = $nilaiMapel->where('jenis', 'Tugas')->avg('angka') ?? 0;
                                $uts = $nilaiMapel->where('jenis', 'UTS')->first()->angka ?? 0;
                                $uas = $nilaiMapel->where('jenis', 'UAS')->first()->angka ?? 0;
                                $akhir = (0.3 * $avgTugas) + (0.3 * $uts) + (0.4 * $uas);
                            @endphp
                            <tr>
                                <td class="text-start ps-4 fw-bold text-dark">{{ $mapelNama }}</td>
                                <td>{{ round($avgTugas, 1) }}</td>
                                <td>{{ $uts }}</td>
                                <td>{{ $uas }}</td>
                                <td class="fw-bold {{ $akhir < 75 ? 'text-danger' : 'text-success' }}">
                                    {{ round($akhir, 1) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-muted italic">Belum ada data nilai yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection