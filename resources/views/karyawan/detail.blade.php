@extends('layouts.utama')
@section('judul', 'Detail Karyawan')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('karyawan.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Profil Karyawan</h5>
</div>

<div class="row g-4">
    <!-- Info Utama -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-3 shadow-sm text-center p-4">
            <div class="mb-3">
                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:80px;height:80px;font-size:2rem;background:hsl({{ (ord($karyawan->nama[0]) * 37) % 360 }},65%,50%)">
                    {{ substr($karyawan->nama, 0, 1) }}
                </div>
            </div>
            <h5 class="fw-bold mb-1">{{ $karyawan->nama }}</h5>
            <p class="text-muted mb-1">{{ $karyawan->jabatan }}</p>
            <span class="badge {{ $karyawan->status === 'aktif' ? 'badge-hadir' : 'badge-alpha' }} px-3 py-1 rounded-pill">
                {{ $karyawan->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
            </span>

            <hr>

            <ul class="list-unstyled text-start">
                <li class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-credit-card-2-front text-primary"></i>
                    <span class="text-muted small">NIP:</span>
                    <code>{{ $karyawan->nip }}</code>
                </li>
                <li class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-envelope text-primary"></i>
                    <span class="text-muted small">Email:</span>
                    <span class="small">{{ $karyawan->email }}</span>
                </li>
                <li class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-telephone text-primary"></i>
                    <span class="text-muted small">Telepon:</span>
                    <span>{{ $karyawan->telepon ?? '-' }}</span>
                </li>
                <li class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-building text-primary"></i>
                    <span class="text-muted small">Departemen:</span>
                    <span>{{ $karyawan->departemen }}</span>
                </li>
                <li class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-date text-primary"></i>
                    <span class="text-muted small">Masuk:</span>
                    <span>{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</span>
                </li>
            </ul>

            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('karyawan.ubah', $karyawan) }}" class="btn btn-utama btn-sm">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Statistik Bulan Ini -->
        <div class="row g-3 mb-4">
            @foreach([
                ['label' => 'Hadir', 'nilai' => $statistik['total_hadir'],  'warna' => '#dcfce7', 'ikon' => 'check-circle-fill', 'teks' => 'success'],
                ['label' => 'Izin',  'nilai' => $statistik['total_izin'],   'warna' => '#dbeafe', 'ikon' => 'info-circle-fill',  'teks' => 'primary'],
                ['label' => 'Sakit', 'nilai' => $statistik['total_sakit'],  'warna' => '#f1f5f9', 'ikon' => 'bandaid-fill',      'teks' => 'secondary'],
                ['label' => 'Alpha', 'nilai' => $statistik['total_alpha'],  'warna' => '#fee2e2', 'ikon' => 'x-circle-fill',    'teks' => 'danger'],
            ] as $stat)
                <div class="col-6 col-md-3">
                    <div class="card border-0 rounded-3 shadow-sm text-center p-3">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:{{ $stat['warna'] }}">
                            <i class="bi bi-{{ $stat['ikon'] }} text-{{ $stat['teks'] }}"></i>
                        </div>
                        <div class="fs-4 fw-bold">{{ $stat['nilai'] }}</div>
                        <div class="text-muted small">{{ $stat['label'] }} Bulan Ini</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Riwayat Absensi -->
        <div class="card border-0 rounded-3 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-info"></i>
                    Riwayat Absensi (30 Terakhir)
                </h6>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatAbsensi as $absensi)
                                <tr>
                                    <td class="ps-4">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $absensi->jam_masuk ? substr($absensi->jam_masuk, 0, 5) : '-' }}</td>
                                    <td>{{ $absensi->jam_keluar ? substr($absensi->jam_keluar, 0, 5) : '-' }}</td>
                                    <td class="text-muted small">{{ $absensi->total_jam_kerja_format }}</td>
                                    <td>
                                        <span class="badge badge-{{ $absensi->badge_status }} px-2 py-1 rounded-pill">
                                            {{ $absensi->label_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
