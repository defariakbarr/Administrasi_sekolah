<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold text-center">
                            <i class="bi bi-calendar-plus me-2"></i>Tambah Jadwal Pelajaran Baru
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.jadwal.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="guru_id" class="form-label fw-bold">Guru Pengampu</label>
                                <select name="guru_id" id="guru_id" class="form-select @error('guru_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mapel_id" class="form-label fw-bold">Mata Pelajaran</label>
                                <select name="mapel_id" id="mapel_id" class="form-select @error('mapel_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Guru Terlebih Dahulu --</option>
                                </select>
                                <small class="text-muted" id="mapel_loading" style="display:none;">
                                    <i class="bi bi-arrow-repeat spin"></i> Memuat data...
                                </small>
                                @error('mapel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kelas_id" class="form-label fw-bold">Kelas</label>
                                <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Hari</label>
                                    <select name="hari" class="form-select">
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                            <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-5 fw-bold">
                                    <i class="bi bi-save me-1"></i>Simpan Jadwal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // 1. Logika Dropdown Mapel Berdasarkan Guru
            $('#guru_id').on('change', function() {
                var guruID = $(this).val();
                var mapelSelect = $('#mapel_id');
                var loading = $('#mapel_loading');

                if(guruID) {
                    loading.show();
                    $.ajax({
                        url: '/admin/get-mapel/' + guruID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            mapelSelect.empty();
                            loading.hide();
                            if(data.length > 0) {
                                $.each(data, function(key, value) {
                                    mapelSelect.append('<option value="'+ value.id +'">'+ value.nama_mapel +'</option>');
                                });
                            } else {
                                mapelSelect.append('<option value="">Guru ini belum memiliki Mapel</option>');
                            }
                        },
                        error: function() {
                            loading.hide();
                            alert('Gagal mengambil data mata pelajaran. Pastikan route sudah ada!');
                        }
                    });
                } else {
                    mapelSelect.empty().append('<option value="">-- Pilih Guru Terlebih Dahulu --</option>');
                }
            });

            // 2. Logika Otomatis Jam Selesai (+90 Menit)
            $('#jam_mulai').on('change', function() {
                var startTime = $(this).val();
                if (startTime) {
                    var splitTime = startTime.split(':');
                    var hours = parseInt(splitTime[0]);
                    var minutes = parseInt(splitTime[1]);

                    // Tambah 90 Menit
                    var totalMinutes = (hours * 60) + minutes + 90;
                    var newHours = Math.floor(totalMinutes / 60) % 24;
                    var newMinutes = totalMinutes % 60;

                    // Format HH:mm
                    var formattedTime = 
                        (newHours < 10 ? '0' + newHours : newHours) + ":" + 
                        (newMinutes < 10 ? '0' + newMinutes : newMinutes);
                    
                    $('#jam_selesai').val(formattedTime);
                }
            });
        });
    </script>
</body>
</html>