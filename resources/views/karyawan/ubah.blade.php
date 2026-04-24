@extends('layouts.utama')
@section('judul', 'Edit Karyawan')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('karyawan.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Data Karyawan</h5>
        <p class="text-muted mb-0 small">Perbarui informasi {{ $karyawan->nama }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card kartu-form">
            <div class="card-body p-4">
                <form action="{{ route('karyawan.perbarui', $karyawan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip" value="{{ old('nip', $karyawan->nip) }}"
                                   class="form-control @error('nip') is-invalid @enderror">
                            @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $karyawan->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $karyawan->telepon) }}"
                                   class="form-control @error('telepon') is-invalid @enderror">
                            @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan) }}"
                                   class="form-control @error('jabatan') is-invalid @enderror">
                            @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Departemen <span class="text-danger">*</span></label>
                            <input type="text" name="departemen" value="{{ old('departemen', $karyawan->departemen) }}"
                                   class="form-control @error('departemen') is-invalid @enderror">
                            @error('departemen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk"
                                   value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk->format('Y-m-d')) }}"
                                   class="form-control @error('tanggal_masuk') is-invalid @enderror">
                            @error('tanggal_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif"       {{ old('status', $karyawan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status', $karyawan->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Foto Karyawan</label>
                            @if($karyawan->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $karyawan->foto) }}"
                                         alt="Foto saat ini" class="rounded"
                                         style="height:80px;object-fit:cover">
                                    <div class="form-text">Foto saat ini. Upload baru untuk mengganti.</div>
                                </div>
                            @endif
                            <input type="file" name="foto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png"
                                   onchange="pratinjauFoto(event)">
                            <img id="pratinjauGambar" src="" alt="" class="mt-2 rounded"
                                 style="max-height:120px;display:none">
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-check-lg me-1"></i> Perbarui Data
                        </button>
                        <a href="{{ route('karyawan.indeks') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
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
