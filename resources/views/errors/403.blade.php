<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Inter',sans-serif; background:#f1f5f9; display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .kotak-error { background:#fff; border-radius:16px; padding:3rem 2.5rem; text-align:center; max-width:440px; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .ikon-error { width:80px; height:80px; background:#fee2e2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem; font-size:2.2rem; }
    </style>
</head>
<body>
    <div class="kotak-error">
        <div class="ikon-error">
            <i class="bi bi-shield-lock-fill text-danger"></i>
        </div>
        <h3 class="fw-bold mb-2">Akses Ditolak</h3>
        <p class="text-muted mb-1">Kode Error: <strong>403</strong></p>
        <p class="text-muted mb-4">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Halaman ini hanya tersedia untuk <strong>Administrator</strong>.
        </p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                <i class="bi bi-house-fill me-1"></i> Ke Dashboard
            </a>
            <a href="javascript:history.back()" class="btn btn-outline-secondary px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <hr class="my-4">
        <p class="text-muted small mb-0">
            Login sebagai:
            <strong>{{ Auth::check() ? Auth::user()->nama : 'Tidak diketahui' }}</strong>
            ({{ Auth::check() ? Auth::user()->label_peran : '-' }})
        </p>
    </div>
</body>
</html>
