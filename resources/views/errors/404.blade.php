<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            color: white;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            line-height: 1;
            text-shadow: 3px 3px 10px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-exclamation-triangle display-1 mb-4"></i>
        <div class="error-code">404</div>
        <h2 class="mb-3">Halaman Tidak Ditemukan</h2>
        <p class="lead mb-4">Maaf, halaman yang Anda cari tidak dapat ditemukan.</p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="javascript:history.back()" class="btn btn-light btn-lg">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('home.index') }}" class="btn btn-outline-light btn-lg">
                <i class="bi bi-house"></i> Beranda
            </a>
        </div>
    </div>
</body>
</html>
