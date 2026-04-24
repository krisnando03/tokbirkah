@extends('layouts.utama')
@section('judul', 'Dashboard')

@section('konten')
<!-- Kartu Statistik -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card kartu-stat h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="ikon-stat" style="background:#dbeafe">
                    <i class="bi bi-people-fill text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $totalKaryawan }}</div>
                    <div class="text-muted small">Total Karyawan</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card kartu-stat h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="ikon-stat" style="background:#dcfce7">
                    <i class="bi bi-person-check-fill text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $karyawanHadir }}</div>
                    <div class="text-muted small">Hadir Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card kartu-stat h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="ikon-stat" style="background:#fee2e2">
                    <i class="bi bi-person-x-fill text-danger"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $karyawanAbsen }}</div>
                    <div class="text-muted small">Tidak Hadir</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card kartu-stat h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="ikon-stat" style="background:#fef9c3">
                    <i class="bi bi-clock-fill text-warning"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $karyawanTerlambat }}</div>
                    <div class="text-muted small">Terlambat</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Grafik Kehadiran -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-3 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i>
                    Grafik Kehadiran 7 Hari Terakhir
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas id="grafikKehadiran" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-3 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-lightning-charge-fill me-2 text-warning"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body px-4">
                <!-- Check-In -->
                <form action="{{ route('absensi.check-in') }}" method="POST" class="mb-3">
                    @csrf
                    <label class="form-label fw-500">Check-In Karyawan</label>
                    <div class="input-group">
                        <select name="karyawan_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach(\App\Models\Karyawan::aktif()->orderBy('nama')->get() as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success btn-sm" type="submit">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </button>
                    </div>
                </form>

                <!-- Check-Out -->
                <form action="{{ route('absensi.check-out') }}" method="POST">
                    @csrf
                    <label class="form-label fw-500">Check-Out Karyawan</label>
                    <div class="input-group">
                        <select name="karyawan_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach(\App\Models\Karyawan::aktif()->orderBy('nama')->get() as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-danger btn-sm" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </div>
                </form>

                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('karyawan.tambah') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah Karyawan Baru
                    </a>
                    <a href="{{ route('absensi.laporan') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Laporan Bulanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Absensi Terbaru -->
<div class="card border-0 rounded-3 shadow-sm mt-4">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2 text-info"></i>
            Aktivitas Absensi Hari Ini
        </h6>
        <a href="{{ route('absensi.indeks') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tabel-kustom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Karyawan</th>
                        <th>Departemen</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensiTerbaru as $absensi)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white"
                                         style="width:34px;height:34px;font-size:.8rem;font-weight:600">
                                        {{ substr($absensi->karyawan->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-500">{{ $absensi->karyawan->nama }}</div>
                                        <div class="text-muted" style="font-size:.78rem">{{ $absensi->karyawan->nip }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $absensi->karyawan->departemen }}</td>
                            <td>{{ $absensi->jam_masuk ? substr($absensi->jam_masuk, 0, 5) : '-' }}</td>
                            <td>{{ $absensi->jam_keluar ? substr($absensi->jam_keluar, 0, 5) : '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $absensi->badge_status }} px-2 py-1 rounded-pill">
                                    {{ $absensi->label_status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                Belum ada data absensi hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('skrip')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labelGrafik  = @json($grafikKehadiran->pluck('tanggal'));
    const dataHadir    = @json($grafikKehadiran->pluck('hadir'));
    const dataAlpha    = @json($grafikKehadiran->pluck('alpha'));

    new Chart(document.getElementById('grafikKehadiran'), {
        type: 'bar',
        data: {
            labels: labelGrafik,
            datasets: [
                {
                    label: 'Hadir',
                    data: dataHadir,
                    backgroundColor: 'rgba(37,99,235,.8)',
                    borderRadius: 6,
                },
                {
                    label: 'Alpha',
                    data: dataAlpha,
                    backgroundColor: 'rgba(239,68,68,.7)',
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush
