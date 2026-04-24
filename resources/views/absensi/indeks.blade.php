@extends('layouts.utama')
@section('judul', 'Data Absensi')

@section('konten')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Data Absensi Karyawan</h5>
        <p class="text-muted mb-0 small">Rekap kehadiran harian seluruh karyawan</p>
    </div>
    <a href="{{ route('absensi.tambah') }}" class="btn btn-utama">
        <i class="bi bi-plus-lg me-1"></i> Input Absensi
    </a>
</div>

<!-- Statistik Hari Ini -->
<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'Hadir',     'nilai' => $statistikHariIni['hadir'],     'warna' => '#dcfce7', 'ikon' => 'person-check-fill', 'teks' => 'success'],
        ['label' => 'Terlambat', 'nilai' => $statistikHariIni['terlambat'], 'warna' => '#fef9c3', 'ikon' => 'clock-fill',         'teks' => 'warning'],
        ['label' => 'Izin',      'nilai' => $statistikHariIni['izin'],      'warna' => '#dbeafe', 'ikon' => 'file-earmark-text', 'teks' => 'primary'],
        ['label' => 'Sakit',     'nilai' => $statistikHariIni['sakit'],     'warna' => '#f1f5f9', 'ikon' => 'bandaid',           'teks' => 'secondary'],
        ['label' => 'Alpha',     'nilai' => $statistikHariIni['alpha'],     'warna' => '#fee2e2', 'ikon' => 'person-x-fill',     'teks' => 'danger'],
    ] as $s)
        <div class="col">
            <div class="card border-0 rounded-3 shadow-sm text-center py-3 px-2">
                <div class="d-flex justify-content-center mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:36px;height:36px;background:{{ $s['warna'] }}">
                        <i class="bi bi-{{ $s['ikon'] }} text-{{ $s['teks'] }} small"></i>
                    </div>
                </div>
                <div class="fs-4 fw-bold">{{ $s['nilai'] }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ $s['label'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<!-- Filter -->
<div class="card border-0 rounded-3 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-500">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-500">Karyawan</label>
                <select name="karyawan_id" class="form-select">
                    <option value="">Semua Karyawan</option>
                    @foreach($daftarKaryawan as $k)
                        <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-500">Status Kehadiran</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['hadir','terlambat','izin','sakit','cuti','alpha'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                            {{ ucfirst($st) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-utama flex-fill">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('absensi.indeks') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Absensi -->
<div class="card border-0 rounded-3 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tabel-kustom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Total Jam</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarAbsensi as $i => $absensi)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $daftarAbsensi->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                         style="width:32px;height:32px;font-size:.75rem;background:hsl({{ (ord($absensi->karyawan->nama[0]) * 37) % 360 }},65%,50%)">
                                        {{ substr($absensi->karyawan->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-500 small">{{ $absensi->karyawan->nama }}</div>
                                        <div class="text-muted" style="font-size:.72rem">{{ $absensi->karyawan->departemen }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td>
                                @if($absensi->jam_masuk)
                                    <span class="text-success fw-500">{{ substr($absensi->jam_masuk, 0, 5) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($absensi->jam_keluar)
                                    <span class="text-danger fw-500">{{ substr($absensi->jam_keluar, 0, 5) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $absensi->total_jam_kerja_format }}</td>
                            <td>
                                <span class="badge badge-{{ $absensi->badge_status }} px-2 py-1 rounded-pill small">
                                    {{ $absensi->label_status }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ Str::limit($absensi->keterangan, 30) ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('absensi.ubah', $absensi) }}"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('absensi.hapus', $absensi) }}" method="POST"
                                          onsubmit="return confirm('Hapus data absensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                Tidak ada data absensi untuk filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($daftarAbsensi->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $daftarAbsensi->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
