<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Dashboard') — TOKBIRKAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --warna-utama: #2563EB;
            --warna-sidebar: #1e293b;
            --warna-sidebar-hover: #334155;
        }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; min-height: 100vh; }

        .sidebar { position:fixed; top:0; left:0; bottom:0; width:var(--sidebar-width); background:var(--warna-sidebar); z-index:1000; overflow-y:auto; transition:transform .3s; display:flex; flex-direction:column; }
        .sidebar-brand { padding:1.25rem; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-brand h5 { color:#fff; font-weight:700; font-size:1rem; margin:0; }
        .sidebar-brand small { color:#94a3b8; font-size:.72rem; }

        /* Info pengguna di sidebar */
        .sidebar-pengguna { padding:1rem 1.25rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.75rem; }
        .sidebar-pengguna .avatar { width:36px; height:36px; border-radius:50%; object-fit:cover; flex-shrink:0; }
        .sidebar-pengguna .nama-pengguna { color:#e2e8f0; font-size:.85rem; font-weight:500; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .sidebar-pengguna .label-peran { font-size:.68rem; color:#94a3b8; }

        .sidebar-nav .nav-link { color:#cbd5e1; padding:.6rem 1.25rem; display:flex; align-items:center; gap:.7rem; font-size:.875rem; transition:all .2s; border-left:3px solid transparent; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.aktif { background:var(--warna-sidebar-hover); color:#fff; border-left-color:var(--warna-utama); }
        .sidebar-nav .nav-section { color:#64748b; font-size:.68rem; font-weight:600; text-transform:uppercase; letter-spacing:.08em; padding:.9rem 1.25rem .35rem; }

        .sidebar-footer { margin-top:auto; padding:1rem 1.25rem; border-top:1px solid rgba(255,255,255,.08); }

        .konten-utama { margin-left:var(--sidebar-width); min-height:100vh; }
        .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:.75rem 1.5rem; position:sticky; top:0; z-index:100; display:flex; align-items:center; justify-content:space-between; }
        .halaman-konten { padding:1.75rem 1.5rem; }

        .kartu-stat { border:none; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.07); transition:transform .2s, box-shadow .2s; }
        .kartu-stat:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,.1); }
        .kartu-stat .ikon-stat { width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.4rem; }

        .tabel-kustom thead th { background:#f8fafc; color:#475569; font-size:.78rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em; border-bottom:2px solid #e2e8f0; white-space:nowrap; }
        .tabel-kustom td { vertical-align:middle; font-size:.9rem; color:#334155; }

        .badge-hadir    { background:#dcfce7; color:#166534; }
        .badge-terlambat{ background:#fef9c3; color:#854d0e; }
        .badge-izin     { background:#dbeafe; color:#1e40af; }
        .badge-sakit    { background:#f1f5f9; color:#475569; }
        .badge-alpha    { background:#fee2e2; color:#991b1b; }
        .badge-cuti     { background:#ede9fe; color:#5b21b6; }

        .btn-utama { background:var(--warna-utama); color:#fff; border:none; border-radius:8px; padding:.5rem 1.1rem; font-size:.875rem; font-weight:500; }
        .btn-utama:hover { background:#1d4ed8; color:#fff; }

        .kartu-form { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.07); border:none; }
        .form-label { font-size:.875rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
        .form-control, .form-select { border-radius:8px; border-color:#d1d5db; font-size:.9rem; }
        .form-control:focus, .form-select:focus { border-color:var(--warna-utama); box-shadow:0 0 0 3px rgba(37,99,235,.1); }

        /* Badge role di topbar */
        .badge-peran-admin { background:#fee2e2; color:#991b1b; }
        .badge-peran-user  { background:#dbeafe; color:#1e40af; }

        @media (max-width:768px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.terbuka { transform:translateX(0); }
            .konten-utama { margin-left:0; }
        }
    </style>
    @stack('gaya')
</head>
<body>

<!-- ======================== SIDEBAR ======================== -->
<nav class="sidebar" id="sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div style="width:50px;height:50px;">
                <img src="{{ asset('storage/images/logo.png') }}" 
                    alt="Logo" 
                    style="width:100%; height:100%; object-fit:contain;">
            </div>
            <div>
                <h5>TOKBIRKAH</h5>
                <small>Sistem Absensi Karyawan</small>
            </div>
        </div>
    </div>

    <!-- Info Pengguna Login -->
    <div class="sidebar-pengguna">
        <img src="{{ Auth::user()->foto_profil_url }}" alt="Avatar" class="avatar">
        <div style="min-width:0">
            <div class="nama-pengguna">{{ Auth::user()->nama }}</div>
            <div class="label-peran">
                {{ Auth::user()->label_peran }}
                @if(Auth::user()->karyawan)
                    · {{ Auth::user()->karyawan->departemen }}
                @endif
            </div>
        </div>
    </div>

    <!-- Navigasi -->
    <ul class="nav flex-column sidebar-nav mt-1">
        <li><span class="nav-section">Menu Utama</span></li>
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'aktif' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        {{-- Menu khusus Admin --}}
        @if(Auth::user()->isAdmin())
            <li><span class="nav-section">Data Master</span></li>
            <li class="nav-item">
                <a href="{{ route('karyawan.indeks') }}" class="nav-link {{ request()->routeIs('karyawan.*') ? 'aktif' : '' }}">
                    <i class="bi bi-people-fill"></i> Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pengguna.indeks') }}" class="nav-link {{ request()->routeIs('pengguna.*') ? 'aktif' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> Manajemen Pengguna
                </a>
            </li>
        @endif

        <li><span class="nav-section">Absensi</span></li>
        <li class="nav-item">
            <a href="{{ route('absensi.indeks') }}" class="nav-link {{ request()->routeIs('absensi.indeks') ? 'aktif' : '' }}">
                <i class="bi bi-calendar-check-fill"></i> Data Absensi
            </a>
        </li>

        @if(Auth::user()->isAdmin())
            <li class="nav-item">
                <a href="{{ route('absensi.tambah') }}" class="nav-link {{ request()->routeIs('absensi.tambah') ? 'aktif' : '' }}">
                    <i class="bi bi-plus-circle-fill"></i> Input Absensi
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a href="{{ route('absensi.laporan') }}" class="nav-link {{ request()->routeIs('absensi.laporan') ? 'aktif' : '' }}">
                <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan Bulanan
            </a>
        </li>

        <li><span class="nav-section">Akun Saya</span></li>
        <li class="nav-item">
            <a href="{{ route('profil.saya') }}" class="nav-link {{ request()->routeIs('profil.*') ? 'aktif' : '' }}">
                <i class="bi bi-person-circle"></i> Profil Saya
            </a>
        </li>
    </ul>

    <!-- Tombol Keluar di bawah sidebar -->
    <div class="sidebar-footer">
        <form action="{{ route('keluar') }}" method="POST">
            @csrf
            <button type="submit" class="btn w-100 d-flex align-items-center gap-2 text-start"
                    style="background:rgba(239,68,68,.1);color:#fca5a5;border:none;border-radius:8px;padding:.6rem .9rem;font-size:.875rem;"
                    onmouseover="this.style.background='rgba(239,68,68,.2)'"
                    onmouseout="this.style.background='rgba(239,68,68,.1)'">
                <i class="bi bi-box-arrow-right"></i> Keluar dari Sistem
            </button>
        </form>
    </div>
</nav>

<!-- ======================== KONTEN UTAMA ======================== -->
<main class="konten-utama">
    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" id="tombolSidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <h6 class="mb-0 fw-bold" style="font-size:.95rem">@yield('judul', 'Dashboard')</h6>
                <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Badge Role --}}
            <span class="badge rounded-pill px-3 py-2
                {{ Auth::user()->isAdmin() ? 'badge-peran-admin' : 'badge-peran-user' }}"
                style="font-size:.75rem">
                <i class="bi {{ Auth::user()->isAdmin() ? 'bi-shield-fill-check' : 'bi-person-fill' }} me-1"></i>
                {{ Auth::user()->label_peran }}
            </span>

            {{-- Dropdown profil --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-light d-flex align-items-center gap-2 rounded-pill px-3" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->foto_profil_url }}" alt="Avatar"
                         style="width:28px;height:28px;border-radius:50%;object-fit:cover">
                    <span style="font-size:.85rem;font-weight:500">{{ Str::words(Auth::user()->nama, 1, '') }}</span>
                    <i class="bi bi-chevron-down" style="font-size:.7rem"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1" style="min-width:200px">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-600" style="font-size:.875rem">{{ Auth::user()->nama }}</div>
                        <div class="text-muted" style="font-size:.78rem">{{ Auth::user()->email }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('profil.saya') }}">
                            <i class="bi bi-person-circle me-2 text-primary"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('keluar') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Notifikasi Flash -->
    <div class="px-4 pt-3">
        @if(session('sukses'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm py-2 px-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('sukses') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm py-2 px-3" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm py-2 px-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)<li style="font-size:.875rem">{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Konten -->
    <div class="halaman-konten">
        @yield('konten')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('tombolSidebar')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('terbuka');
    });
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el)?.close();
        });
    }, 4000);
</script>
@stack('skrip')
</body>
</html>
