@extends('layouts.utama')
@section('judul', 'Input Absensi')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('absensi.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Input Absensi Manual</h5>
        <p class="text-muted mb-0 small">Tambahkan data kehadiran karyawan secara manual</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card kartu-form">
            <div class="card-body p-4">
                <form action="{{ route('absensi.simpan') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($daftarKaryawan as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }}) — {{ $k->departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal"
                                   value="{{ old('tanggal', today()->toDateString()) }}"
                                   class="form-control @error('tanggal') is-invalid @enderror">
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Kehadiran <span class="text-danger">*</span></label>
                            <select name="status_kehadiran" id="statusKehadiran"
                                    class="form-select @error('status_kehadiran') is-invalid @enderror"
                                    onchange="toggleJamKerja()">
                                <option value="">-- Pilih Status --</option>
                                <option value="hadir"     {{ old('status_kehadiran') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="terlambat" {{ old('status_kehadiran') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="izin"      {{ old('status_kehadiran') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit"     {{ old('status_kehadiran') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="cuti"      {{ old('status_kehadiran') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="alpha"     {{ old('status_kehadiran') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                            @error('status_kehadiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Jam Kerja (tampil kondisional) -->
                        <div class="col-md-6" id="grupJamMasuk">
                            <label class="form-label">Jam Masuk</label>
                            <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}"
                                   class="form-control @error('jam_masuk') is-invalid @enderror">
                            @error('jam_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6" id="grupJamKeluar">
                            <label class="form-label">Jam Keluar</label>
                            <input type="time" name="jam_keluar" value="{{ old('jam_keluar') }}"
                                   class="form-control @error('jam_keluar') is-invalid @enderror">
                            @error('jam_keluar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Catatan tambahan (opsional)...">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lokasi Masuk</label>
                            <input type="text" name="lokasi_masuk" value="{{ old('lokasi_masuk') }}"
                                   class="form-control" placeholder="Kantor Pusat / WFH">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lokasi Keluar</label>
                            <input type="text" name="lokasi_keluar" value="{{ old('lokasi_keluar') }}"
                                   class="form-control" placeholder="Kantor Pusat / WFH">
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-save-fill me-1"></i> Simpan Absensi
                        </button>
                        <a href="{{ route('absensi.indeks') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
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
