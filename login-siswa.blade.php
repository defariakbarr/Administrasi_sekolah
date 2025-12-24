<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Portal Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin-top: 100px; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow border-0">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold mb-4">Masuk Siswa 👨‍🎓</h3>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nis" class="form-label">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill">Masuk Sekarang</button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none small text-muted">Bukan Siswa? Login Admin/Guru</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>