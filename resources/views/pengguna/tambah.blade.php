@extends('layouts.utama')
@section('judul', 'Tambah Pengguna')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('pengguna.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Tambah Pengguna Baru</h5>
        <p class="text-muted mb-0 small">Buat akun untuk karyawan atau administrator</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card kartu-form">
            <div class="card-body p-4">
                <form action="{{ route('pengguna.simpan') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   placeholder="Nama pengguna">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="email@perusahaan.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Peran <span class="text-danger">*</span></label>
                            <select name="peran" id="selectPeran"
                                    class="form-select @error('peran') is-invalid @enderror"
                                    onchange="ubahInfoPeran()">
                                <option value="">-- Pilih Peran --</option>
                                <option value="admin"    {{ old('peran') == 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                                <option value="pengguna" {{ old('peran') == 'pengguna' ? 'selected' : '' }}>
                                    Pengguna
                                </option>
                            </select>
                            @error('peran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div id="infoPeran" class="form-text mt-1"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Hubungkan ke Karyawan</label>
                            <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror">
                                <option value="">— Tidak dihubungkan —</option>
                                @foreach($daftarKaryawan as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }}) — {{ $k->departemen }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Opsional. Jika peran = Pengguna, disarankan dihubungkan ke data karyawan.</div>
                            @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="kata_sandi" id="inputKataSandi"
                                       class="form-control @error('kata_sandi') is-invalid @enderror"
                                       placeholder="Min. 6 karakter">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('inputKataSandi', 'ikonKataSandi')">
                                    <i class="bi bi-eye" id="ikonKataSandi"></i>
                                </button>
                            </div>
                            @error('kata_sandi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="kata_sandi_confirmation" id="inputKonfirmasi"
                                       class="form-control" placeholder="Ulangi kata sandi">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('inputKonfirmasi', 'ikonKonfirmasi')">
                                    <i class="bi bi-eye" id="ikonKonfirmasi"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif"    {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto_profil"
                                   class="form-control @error('foto_profil') is-invalid @enderror"
                                   accept="image/*" onchange="pratinjauFoto(event)">
                            <img id="pratinjauGambar" src="" class="mt-2 rounded" style="max-height:80px;display:none">
                            @error('foto_profil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan Pengguna
                        </button>
                        <a href="{{ route('pengguna.indeks') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel Info Peran -->
    <div class="col-lg-5">
        <div class="card border-0 rounded-3 shadow-sm mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Hak Akses per Peran</h6>

                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge badge-alpha rounded-pill px-2 py-1">
                            <i class="bi bi-shield-fill-check me-1"></i>Administrator
                        </span>
                    </div>
                    <ul class="list-unstyled mb-0 ps-2" style="font-size:.83rem;color:#475569">
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Akses penuh semua fitur</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Kelola karyawan & pengguna</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Input & edit absensi semua karyawan</li>
                        <li><i class="bi bi-check2 text-success me-1"></i>Lihat laporan bulanan</li>
                    </ul>
                </div>

                <hr>

                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge badge-izin rounded-pill px-2 py-1">
                            <i class="bi bi-person-fill me-1"></i>Pengguna
                        </span>
                    </div>
                    <ul class="list-unstyled mb-0 ps-2" style="font-size:.83rem;color:#475569">
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Lihat data absensi diri sendiri</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Check-in & check-out</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Lihat laporan kehadiran</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>Edit profil sendiri</li>
                        <li><i class="bi bi-x text-danger me-1"></i>Tidak bisa kelola data karyawan/pengguna</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('skrip')
<script>
    function ubahInfoPeran() {
        const peran = document.getElementById('selectPeran').value;
        const info  = document.getElementById('infoPeran');
        if (peran === 'admin') {
            info.innerHTML = '<span class="text-danger"><i class="bi bi-info-circle me-1"></i>Administrator memiliki akses penuh ke semua fitur.</span>';
        } else if (peran === 'pengguna') {
            info.innerHTML = '<span class="text-primary"><i class="bi bi-info-circle me-1"></i>Pengguna hanya dapat mengakses absensi diri sendiri.</span>';
        } else {
            info.innerHTML = '';
        }
    }
    function togglePassword(id, ikonId) {
        const input = document.getElementById(id);
        const ikon  = document.getElementById(ikonId);
        input.type = input.type === 'password' ? 'text' : 'password';
        ikon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }
    function pratinjauFoto(event) {
        const gambar = document.getElementById('pratinjauGambar');
        if (event.target.files[0]) {
            gambar.src = URL.createObjectURL(event.target.files[0]);
            gambar.style.display = 'block';
        }
    }
</script>
@endpush
