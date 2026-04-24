@extends('layouts.utama')
@section('judul', 'Edit Absensi')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('absensi.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Data Absensi</h5>
        <p class="text-muted mb-0 small">Perbarui data kehadiran karyawan</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card kartu-form">
            <div class="card-body p-4">
                <form action="{{ route('absensi.perbarui', $absensi) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($daftarKaryawan as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('karyawan_id', $absensi->karyawan_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }}) — {{ $k->departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal"
                                   value="{{ old('tanggal', $absensi->tanggal->format('Y-m-d')) }}"
                                   class="form-control @error('tanggal') is-invalid @enderror">
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Kehadiran <span class="text-danger">*</span></label>
                            <select name="status_kehadiran" id="statusKehadiran"
                                    class="form-select @error('status_kehadiran') is-invalid @enderror"
                                    onchange="toggleJamKerja()">
                                @foreach(['hadir' => '✅ Hadir', 'terlambat' => '⏰ Terlambat', 'izin' => '📋 Izin', 'sakit' => '🤒 Sakit', 'cuti' => '🏖️ Cuti', 'alpha' => '❌ Alpha'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('status_kehadiran', $absensi->status_kehadiran) == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_kehadiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6" id="grupJamMasuk">
                            <label class="form-label">Jam Masuk</label>
                            <input type="time" name="jam_masuk"
                                   value="{{ old('jam_masuk', $absensi->jam_masuk ? substr($absensi->jam_masuk, 0, 5) : '') }}"
                                   class="form-control @error('jam_masuk') is-invalid @enderror">
                            @error('jam_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6" id="grupJamKeluar">
                            <label class="form-label">Jam Keluar</label>
                            <input type="time" name="jam_keluar"
                                   value="{{ old('jam_keluar', $absensi->jam_keluar ? substr($absensi->jam_keluar, 0, 5) : '') }}"
                                   class="form-control @error('jam_keluar') is-invalid @enderror">
                            @error('jam_keluar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Catatan tambahan (opsional)...">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lokasi Masuk</label>
                            <input type="text" name="lokasi_masuk"
                                   value="{{ old('lokasi_masuk', $absensi->lokasi_masuk) }}"
                                   class="form-control" placeholder="Kantor Pusat / WFH">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lokasi Keluar</label>
                            <input type="text" name="lokasi_keluar"
                                   value="{{ old('lokasi_keluar', $absensi->lokasi_keluar) }}"
                                   class="form-control" placeholder="Kantor Pusat / WFH">
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-check-lg me-1"></i> Perbarui Absensi
                        </button>
                        <a href="{{ route('absensi.indeks') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Data Saat Ini -->
    <div class="col-lg-5">
        <div class="card border-0 rounded-3 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i>
                    Data Absensi Saat Ini
                </h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted small" width="120">Karyawan</td>
                        <td class="fw-500 small">{{ $absensi->karyawan->nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Tanggal</td>
                        <td class="small">{{ $absensi->tanggal->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Jam Masuk</td>
                        <td class="small text-success fw-500">
                            {{ $absensi->jam_masuk ? substr($absensi->jam_masuk, 0, 5) : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Jam Keluar</td>
                        <td class="small text-danger fw-500">
                            {{ $absensi->jam_keluar ? substr($absensi->jam_keluar, 0, 5) : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Total Kerja</td>
                        <td class="small">{{ $absensi->total_jam_kerja_format }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Status</td>
                        <td>
                            <span class="badge badge-{{ $absensi->badge_status }} px-2 py-1 rounded-pill small">
                                {{ $absensi->label_status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('skrip')
<script>
    function toggleJamKerja() {
        const status = document.getElementById('statusKehadiran').value;
        const tampilJam = ['hadir', 'terlambat'].includes(status);
        document.getElementById('grupJamMasuk').style.opacity  = tampilJam ? '1' : '.4';
        document.getElementById('grupJamKeluar').style.opacity = tampilJam ? '1' : '.4';
    }
    toggleJamKerja();
</script>
@endpush
