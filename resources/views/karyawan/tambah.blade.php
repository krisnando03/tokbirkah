@extends('layouts.utama')
@section('judul', 'Tambah Karyawan')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('karyawan.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Tambah Karyawan Baru</h5>
        <p class="text-muted mb-0 small">Isi formulir berikut untuk menambahkan karyawan</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card kartu-form">
            <div class="card-body p-4">
                <form action="{{ route('karyawan.simpan') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip" value="{{ old('nip') }}"
                                   class="form-control @error('nip') is-invalid @enderror"
                                   placeholder="Contoh: KRY-009">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   placeholder="Nama karyawan">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="email@perusahaan.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                   class="form-control @error('telepon') is-invalid @enderror"
                                   placeholder="08xxxxxxxxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                                   class="form-control @error('jabatan') is-invalid @enderror"
                                   placeholder="Contoh: Staff IT">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Departemen <span class="text-danger">*</span></label>
                            <input type="text" name="departemen" value="{{ old('departemen') }}"
                                   class="form-control @error('departemen') is-invalid @enderror"
                                   placeholder="Contoh: IT, Keuangan, HRD">
                            @error('departemen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                                   class="form-control @error('tanggal_masuk') is-invalid @enderror">
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif"       {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Foto Karyawan</label>
                            <input type="file" name="foto" id="inputFoto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png"
                                   onchange="pratinjauFoto(event)">
                            <div class="form-text">Format: JPG, JPEG, PNG. Maks: 2MB</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="pratinjauGambar" src="" alt="Pratinjau" class="mt-2 rounded"
                                 style="max-height:120px;display:none">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan Karyawan
                        </button>
                        <a href="{{ route('karyawan.indeks') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel Info -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-3 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i>
                    Petunjuk Pengisian
                </h6>
                <ul class="list-unstyled mb-0" style="font-size:.875rem;color:#475569">
                    <li class="mb-2"><i class="bi bi-dot text-primary"></i> NIP harus unik untuk setiap karyawan</li>
                    <li class="mb-2"><i class="bi bi-dot text-primary"></i> Email tidak boleh sama dengan karyawan lain</li>
                    <li class="mb-2"><i class="bi bi-dot text-primary"></i> Jabatan dan departemen diisi sesuai struktur organisasi</li>
                    <li class="mb-2"><i class="bi bi-dot text-primary"></i> Foto bersifat opsional, ukuran maksimal 2MB</li>
                    <li><i class="bi bi-dot text-primary"></i> Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('skrip')
<script>
    function pratinjauFoto(event) {
        const gambar = document.getElementById('pratinjauGambar');
        const file = event.target.files[0];
        if (file) {
            gambar.src = URL.createObjectURL(file);
            gambar.style.display = 'block';
        }
    }
</script>
@endpush
