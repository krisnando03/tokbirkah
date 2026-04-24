@extends('layouts.utama')
@section('judul', 'Dashboard')

@section('konten')
<!-- Selamat Datang -->
<div class="card border-0 rounded-3 mb-4"
     style="background:linear-gradient(135deg,#1e3a5f,#2563eb);color:#fff">
    <div class="card-body p-4 d-flex align-items-center gap-4">
        <img src="{{ $pengguna->foto_profil_url }}" alt="Avatar"
             class="rounded-circle flex-shrink-0"
             style="width:64px;height:64px;object-fit:cover;border:3px solid rgba(255,255,255,.3)">
        <div>
            <h5 class="fw-bold mb-1">Selamat Datang, {{ Str::words($pengguna->nama, 2) }}! 👋</h5>
            @if($karyawan)
                <p class="mb-0" style="color:rgba(255,255,255,.8);font-size:.9rem">
                    <i class="bi bi-building me-1"></i>{{ $karyawan->jabatan }} · {{ $karyawan->departemen }}
                    &nbsp;|&nbsp;
                    <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d F Y') }}
                </p>
            @else
                <p class="mb-0" style="color:rgba(255,255,255,.8);font-size:.9rem">
                    Akun belum terhubung ke data karyawan. Hubungi administrator.
                </p>
            @endif
        </div>
        <div class="ms-auto text-end d-none d-md-block">
            <div style="font-size:2rem;font-weight:700">{{ now()->format('H:i') }}</div>
            <div style="color:rgba(255,255,255,.7);font-size:.8rem">WIB</div>
        </div>
    </div>
</div>

@if($karyawan)
<!-- Status Absensi Hari Ini -->
<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card border-0 rounded-3 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-calendar-check-fill text-primary me-2"></i>
                    Status Absensi Hari Ini
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                @if($absensiHariIni)
                    <div class="text-center py-2">
                        <span class="badge badge-{{ $absensiHariIni->badge_status }} px-3 py-2 rounded-pill fs-6 mb-3">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            {{ $absensiHariIni->label_status }}
                        </span>
                        <div class="row g-3 mt-1">
                            <div class="col-6">
                                <div class="rounded-3 p-3" style="background:#f0fdf4">
                                    <div class="fw-bold text-success fs-4">
                                        {{ $absensiHariIni->jam_masuk ? substr($absensiHariIni->jam_masuk, 0, 5) : '—' }}
                                    </div>
                                    <div class="text-muted small">Jam Masuk</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rounded-3 p-3" style="background:#fff7ed">
                                    <div class="fw-bold text-warning fs-4">
                                        {{ $absensiHariIni->jam_keluar ? substr($absensiHariIni->jam_keluar, 0, 5) : '—' }}
                                    </div>
                                    <div class="text-muted small">Jam Keluar</div>
                                </div>
                            </div>
                        </div>
                        @if($absensiHariIni->total_jam_kerja)
                            <div class="mt-3 text-muted small">
                                <i class="bi bi-clock me-1"></i>
                                Total kerja: <strong>{{ $absensiHariIni->total_jam_kerja_format }}</strong>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-3">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;background:#fef9c3">
                            <i class="bi bi-clock-history fs-3 text-warning"></i>
                        </div>
                        <p class="text-muted mb-3 small">Anda belum melakukan absensi hari ini.</p>
                    </div>
                @endif

                <!-- Aksi Check-In / Check-Out -->
                <div class="mt-3">
                    @if(!$absensiHariIni)
                        <form action="{{ route('absensi.check-in') }}" method="POST">
                            @csrf
                            <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                            <button type="submit" class="btn btn-success w-100 rounded-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Check-In Sekarang
                            </button>
                        </form>
                    @elseif(!$absensiHariIni->jam_keluar)
                        <form action="{{ route('absensi.check-out') }}" method="POST">
                            @csrf
                            <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                            <button type="submit" class="btn btn-danger w-100 rounded-3">
                                <i class="bi bi-box-arrow-right me-2"></i> Check-Out Sekarang
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success rounded-3 py-2 text-center mb-0" style="font-size:.875rem">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Absensi hari ini sudah selesai.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Bulan Ini -->
    <div class="col-lg-7">
        <div class="card border-0 rounded-3 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart-fill text-info me-2"></i>
                    Rekap Kehadiran — {{ now()->translatedFormat('F Y') }}
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    @foreach([
                        ['label' => 'Hadir',     'nilai' => $statistikBulanIni['hadir'],     'warna' => '#dcfce7', 'ikon' => 'person-check-fill', 'teks' => 'success'],
                        ['label' => 'Terlambat', 'nilai' => $statistikBulanIni['terlambat'], 'warna' => '#fef9c3', 'ikon' => 'clock-fill',        'teks' => 'warning'],
                        ['label' => 'Izin',      'nilai' => $statistikBulanIni['izin'],      'warna' => '#dbeafe', 'ikon' => 'file-text-fill',    'teks' => 'primary'],
                        ['label' => 'Sakit',     'nilai' => $statistikBulanIni['sakit'],     'warna' => '#f1f5f9', 'ikon' => 'bandaid-fill',      'teks' => 'secondary'],
                        ['label' => 'Alpha',     'nilai' => $statistikBulanIni['alpha'],     'warna' => '#fee2e2', 'ikon' => 'x-circle-fill',    'teks' => 'danger'],
                    ] as $s)
                        <div class="col-6 col-md-4">
                            <div class="rounded-3 p-3 text-center" style="background:{{ $s['warna'] }}">
                                <div class="d-flex justify-content-center mb-1">
                                    <i class="bi bi-{{ $s['ikon'] }} text-{{ $s['teks'] }} fs-5"></i>
                                </div>
                                <div class="fs-3 fw-bold text-{{ $s['teks'] }}">{{ $s['nilai'] }}</div>
                                <div class="text-muted small">{{ $s['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('absensi.indeks') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-calendar-check me-1"></i> Lihat Semua Absensi
                    </a>
                    <a href="{{ route('absensi.laporan') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-earmark-bar-graph me-1"></i> Laporan Bulanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Absensi Terbaru -->
<div class="card border-0 rounded-3 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-clock-history text-secondary me-2"></i>
            Riwayat Absensi Saya
        </h6>
        <a href="{{ route('absensi.indeks') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tabel-kustom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Total Kerja</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatAbsensi as $abs)
                        <tr>
                            <td class="ps-4 small">{{ $abs->tanggal->format('d/m/Y') }}</td>
                            <td class="small text-success fw-500">{{ $abs->jam_masuk ? substr($abs->jam_masuk,0,5) : '—' }}</td>
                            <td class="small text-danger fw-500">{{ $abs->jam_keluar ? substr($abs->jam_keluar,0,5) : '—' }}</td>
                            <td class="small text-muted">{{ $abs->total_jam_kerja_format }}</td>
                            <td>
                                <span class="badge badge-{{ $abs->badge_status }} px-2 py-1 rounded-pill small">
                                    {{ $abs->label_status }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $abs->keterangan ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                Belum ada riwayat absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@else
<!-- Akun belum terhubung karyawan -->
<div class="card border-0 rounded-3 shadow-sm text-center py-5">
    <div class="card-body">
        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
             style="width:72px;height:72px;background:#fef9c3">
            <i class="bi bi-exclamation-triangle-fill fs-2 text-warning"></i>
        </div>
        <h5 class="fw-bold mb-2">Akun Belum Dikonfigurasi</h5>
        <p class="text-muted mb-4">
            Akun Anda belum dihubungkan ke data karyawan.<br>
            Silakan hubungi Administrator untuk mengonfigurasi akun Anda.
        </p>
        <a href="{{ route('profil.saya') }}" class="btn btn-utama px-4">
            <i class="bi bi-person-circle me-1"></i> Lihat Profil Saya
        </a>
    </div>
</div>
@endif
@endsection
