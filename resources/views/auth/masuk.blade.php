<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — TOKBIRKAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            background: #f1f5f9;
        }

        /* Panel kiri — dekoratif */
        .panel-kiri {
            width: 55%;
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 60%, #3b82f6 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .panel-kiri::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            top: -150px; right: -150px;
        }

        .panel-kiri::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            bottom: -80px; left: -80px;
        }

        .panel-kiri .konten-kiri {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
        }

        .panel-kiri .ikon-besar {
            width: 90px; height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            margin: 0 auto 1.5rem;
        }

        .panel-kiri h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .panel-kiri p {
            color: rgba(255,255,255,.75);
            font-size: .95rem;
            max-width: 320px;
            margin: 0 auto;
        }

        /* Kartu fitur di panel kiri */
        .kartu-fitur {
            background: rgba(255,255,255,.1);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-top: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.15);
            text-align: left;
            width: 100%;
            max-width: 360px;
        }

        .kartu-fitur .item-fitur {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .5rem 0;
            color: rgba(255,255,255,.9);
            font-size: .875rem;
        }

        .kartu-fitur .item-fitur i {
            width: 28px; height: 28px;
            background: rgba(255,255,255,.15);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Panel kanan — form login */
        .panel-kanan {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: #fff;
        }

        .kotak-login {
            width: 100%;
            max-width: 400px;
        }

        .kotak-login .judul-masuk {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: .4rem;
        }

        .kotak-login .sub-judul {
            color: #64748b;
            font-size: .9rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: .875rem;
            font-weight: 500;
            color: #374151;
        }

        .input-grup-kustom {
            position: relative;
        }

        .input-grup-kustom .ikon-input {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-grup-kustom input {
            padding-left: 2.75rem;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: .9rem;
            height: 46px;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-grup-kustom input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
            outline: none;
        }

        .input-grup-kustom input.is-invalid {
            border-color: #ef4444;
        }

        .tombol-masuk {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            font-size: .95rem;
            cursor: pointer;
            transition: opacity .2s, transform .1s;
        }

        .tombol-masuk:hover { opacity: .92; transform: translateY(-1px); }
        .tombol-masuk:active { transform: translateY(0); }

        .kotak-akun-demo {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: .82rem;
        }

        .kotak-akun-demo .judul-demo {
            font-weight: 600;
            color: #475569;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .akun-demo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .35rem .5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background .15s;
        }

        .akun-demo-item:hover { background: #e2e8f0; }

        .akun-demo-item .badge-peran {
            font-size: .72rem;
            padding: .2rem .5rem;
            border-radius: 4px;
            font-weight: 600;
        }

        .badge-admin  { background: #fee2e2; color: #991b1b; }
        .badge-user   { background: #dbeafe; color: #1e40af; }

        @media (max-width: 768px) {
            .panel-kiri  { display: none; }
            .panel-kanan { width: 100%; }
        }
    </style>
</head>
<body>

<!-- Panel Kiri -->
<div class="panel-kiri">
    <div class="konten-kiri">
        <div class="ikon-besar">
            <img src="{{ asset('storage/images/logo.png') }}" 
                alt="Logo" 
                style="width:150px; height:150px; object-fit:contain;">
        </div>
        <h1>Sistem Absensi</h1>
        <p>Kelola kehadiran karyawan TOKBIRKAH.</p>

        <div class="kartu-fitur">
            <div class="item-fitur">
                <i class="bi bi-calendar-check-fill"></i>
                <span>Pencatatan absensi harian real-time</span>
            </div>
            <div class="item-fitur">
                <i class="bi bi-bar-chart-line-fill"></i>
                <span>Laporan & statistik kehadiran bulanan</span>
            </div>
            <div class="item-fitur">
                <i class="bi bi-people-fill"></i>
                <span>Manajemen data karyawan lengkap</span>
            </div>
        </div>
    </div>
</div>

<!-- Panel Kanan -->
<div class="panel-kanan">
    <div class="kotak-login">
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <div style="width:100px;height:100px;">
                    <img src="{{ asset('storage/images/logo.png') }}" 
                        alt="Logo" 
                        style="width:100%; height:100%; object-fit:contain;">
                </div>
                <span style="font-weight:700;color:#0f172a;font-size:50px">TOKBIRKAH</span>
            </div>
            <h2 class="judul-masuk">Selamat Datang</h2>
            <p class="sub-judul">Masuk ke akun Anda untuk melanjutkan.</p>
        </div>

        <!-- Notifikasi -->
        @if(session('sukses'))
            <div class="alert alert-success rounded-3 border-0 py-2 px-3 mb-3" style="font-size:.875rem">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('sukses') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger rounded-3 border-0 py-2 px-3 mb-3" style="font-size:.875rem">
                <i class="bi bi-exclamation-circle-fill me-1"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('masuk.proses') }}" method="POST" id="formMasuk">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <div class="input-grup-kustom">
                    <i class="bi bi-envelope ikon-input"></i>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           placeholder="email@gmail.com"
                           autocomplete="email"
                           required>
                </div>
                @error('email')
                    <div class="text-danger mt-1" style="font-size:.8rem">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Kata Sandi -->
            <div class="mb-4">
                <label class="form-label">Kata Sandi</label>
                <div class="input-grup-kustom" style="position:relative">
                    <i class="bi bi-lock ikon-input"></i>
                    <input type="password" name="kata_sandi" id="kataSandi"
                           class="form-control {{ $errors->has('kata_sandi') ? 'is-invalid' : '' }}"
                           placeholder="Masukkan kata sandi"
                           autocomplete="current-password"
                           style="padding-right:3rem"
                           required>
                    <button type="button"
                            onclick="toggleKataSandi()"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:0">
                        <i class="bi bi-eye" id="ikonMata"></i>
                    </button>
                </div>
                @error('kata_sandi')
                    <div class="text-danger mt-1" style="font-size:.8rem">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Ingat Saya -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ingat_saya" id="ingatSaya">
                    <label class="form-check-label" for="ingatSaya" style="font-size:.875rem;color:#475569">
                        Ingat saya
                    </label>
                </div>
            </div>

            <button type="submit" class="tombol-masuk" id="tombolSubmit">
                <span id="teksSubmit">
                    <i class="bi bi-box-arrow-in-right me-1"></i> MASUK
                </span>
                <span id="loadingSubmit" style="display:none">
                    <span class="spinner-border spinner-border-sm me-1"></span> Memproses...
                </span>
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Isi otomatis akun demo
    function isiAkun(email, kataSandi) {
        document.getElementById('email').value = email;
        document.getElementById('kataSandi').value = kataSandi;
        document.getElementById('email').focus();
    }

    // Toggle tampil/sembunyikan kata sandi
    function toggleKataSandi() {
        const input = document.getElementById('kataSandi');
        const ikon  = document.getElementById('ikonMata');
        if (input.type === 'password') {
            input.type = 'text';
            ikon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            ikon.className = 'bi bi-eye';
        }
    }

    // Loading state saat submit
    document.getElementById('formMasuk').addEventListener('submit', function () {
        document.getElementById('teksSubmit').style.display = 'none';
        document.getElementById('loadingSubmit').style.display = 'inline';
        document.getElementById('tombolSubmit').disabled = true;
    });
</script>
</body>
</html>
