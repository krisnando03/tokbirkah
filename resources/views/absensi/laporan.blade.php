@extends('layouts.utama')
@section('judul', 'Laporan Absensi Bulanan')

@section('konten')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Laporan Absensi Bulanan</h5>
        <p class="text-muted mb-0 small">Rekap kehadiran seluruh karyawan per bulan</p>
    </div>
</div>

<!-- Filter Bulan & Tahun -->
<div class="card border-0 rounded-3 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-500">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach($daftarBulan as $nomor => $nama)
                        <option value="{{ $nomor }}" {{ $bulan == $nomor ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-500">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach($daftarTahun as $thn)
                        <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-utama w-100">
                    <i class="bi bi-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Ringkasan Total -->
@php
    $totalHadir   = $laporanData->sum('hadir');
    $totalIzin    = $laporanData->sum('izin');
    $totalSakit   = $laporanData->sum('sakit');
    $totalAlpha   = $laporanData->sum('alpha');
    $totalCuti    = $laporanData->sum('cuti');
    $totalLambat  = $laporanData->sum('terlambat');
@endphp

<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'Total Hadir',     'nilai' => $totalHadir,  'warna' => '#dcfce7', 'ikon' => 'person-check-fill', 'teks' => 'success'],
        ['label' => 'Total Terlambat', 'nilai' => $totalLambat, 'warna' => '#fef9c3', 'ikon' => 'clock-fill',        'teks' => 'warning'],
        ['label' => 'Total Izin',      'nilai' => $totalIzin,   'warna' => '#dbeafe', 'ikon' => 'file-text-fill',    'teks' => 'primary'],
        ['label' => 'Total Sakit',     'nilai' => $totalSakit,  'warna' => '#f1f5f9', 'ikon' => 'bandaid-fill',      'teks' => 'secondary'],
        ['label' => 'Total Cuti',      'nilai' => $totalCuti,   'warna' => '#ede9fe', 'ikon' => 'umbrella-fill',     'teks' => 'purple'],
        ['label' => 'Total Alpha',     'nilai' => $totalAlpha,  'warna' => '#fee2e2', 'ikon' => 'x-circle-fill',    'teks' => 'danger'],
    ] as $s)
        <div class="col-6 col-md-2">
            <div class="card border-0 rounded-3 shadow-sm text-center p-3">
                <div class="d-flex justify-content-center mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:36px;height:36px;background:{{ $s['warna'] }}">
                        <i class="bi bi-{{ $s['ikon'] }} text-{{ $s['teks'] }} small"></i>
                    </div>
                </div>
                <div class="fs-4 fw-bold">{{ $s['nilai'] }}</div>
                <div class="text-muted" style="font-size:.72rem">{{ $s['label'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<!-- Tabel Laporan -->
<div class="card border-0 rounded-3 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-table me-2 text-primary"></i>
            Detail Rekap per Karyawan —
            <span class="text-primary">
                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
            </span>
        </h6>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-printer-fill me-1"></i> Cetak
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tabel-kustom mb-0" id="tabelLaporan">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Nama Karyawan</th>
                        <th>Departemen</th>
                        <th class="text-center">
                            <span class="badge badge-hadir px-2">Hadir</span>
                        </th>
                        <th class="text-center">
                            <span class="badge badge-terlambat px-2">Terlambat</span>
                        </th>
                        <th class="text-center">
                            <span class="badge badge-izin px-2">Izin</span>
                        </th>
                        <th class="text-center">
                            <span class="badge badge-sakit px-2">Sakit</span>
                        </th>
                        <th class="text-center">
                            <span class="badge" style="background:#ede9fe;color:#5b21b6">Cuti</span>
                        </th>
                        <th class="text-center">
                            <span class="badge badge-alpha px-2">Alpha</span>
                        </th>
                        <th class="text-center">Total Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanData as $i => $data)
                        @php $totalBaris = $data['hadir'] + $data['terlambat'] + $data['izin'] + $data['sakit'] + $data['cuti'] + $data['alpha']; @endphp
                        <tr>
                            <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                         style="width:32px;height:32px;font-size:.75rem;background:hsl({{ (ord($data['karyawan']->nama[0]) * 37) % 360 }},65%,50%)">
                                        {{ substr($data['karyawan']->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-500 small">{{ $data['karyawan']->nama }}</div>
                                        <div class="text-muted" style="font-size:.72rem">{{ $data['karyawan']->nip }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $data['karyawan']->departemen }}</td>
                            <td class="text-center">
                                <span class="fw-bold text-success">{{ $data['hadir'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-warning">{{ $data['terlambat'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-primary">{{ $data['izin'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-secondary">{{ $data['sakit'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color:#5b21b6">{{ $data['cuti'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-danger">{{ $data['alpha'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark px-2">{{ $totalBaris }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Tidak ada data laporan untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($laporanData->count() > 0)
                    <tfoot>
                        <tr class="table-light fw-bold">
                            <td colspan="3" class="ps-4 text-muted small">TOTAL KESELURUHAN</td>
                            <td class="text-center text-success">{{ $totalHadir }}</td>
                            <td class="text-center text-warning">{{ $totalLambat }}</td>
                            <td class="text-center text-primary">{{ $totalIzin }}</td>
                            <td class="text-center text-secondary">{{ $totalSakit }}</td>
                            <td class="text-center" style="color:#5b21b6">{{ $totalCuti }}</td>
                            <td class="text-center text-danger">{{ $totalAlpha }}</td>
                            <td class="text-center">{{ $totalHadir + $totalLambat + $totalIzin + $totalSakit + $totalCuti + $totalAlpha }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('gaya')
<style>
    @media print {
        .sidebar, .topbar, form, button, .btn { display: none !important; }
        .konten-utama { margin-left: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endpush
