<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4>Dashboard Siswa</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Halo, Semangat Belajarnya ya!
                </div>
                <p>Ini adalah halaman khusus Siswa. Kamu bisa melihat nilai di sini.</p>

                <hr>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>