@extends('layouts.utama')
@section('judul', 'Edit Pengguna')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('pengguna.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Data Pengguna</h5>
        <p class="text-muted mb-0 small">Perbarui informasi akun {{ $pengguna->nama }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card kartu-form">
            <div class="card-body p-4">
                <form action="{{ route('pengguna.perbarui', $pengguna) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $pengguna->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $pengguna->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Peran <span class="text-danger">*</span></label>
                            <select name="peran" class="form-select @error('peran') is-invalid @enderror"
                                    {{ Auth::id() === $pengguna->id ? 'disabled' : '' }}>
                                <option value="admin"    {{ old('peran', $pengguna->peran) == 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                                <option value="pengguna" {{ old('peran', $pengguna->peran) == 'pengguna' ? 'selected' : '' }}>
                                    Pengguna
                                </option>
                            </select>
                            @if(Auth::id() === $pengguna->id)
                                <input type="hidden" name="peran" value="{{ $pengguna->peran }}">
                                <div class="form-text text-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Anda tidak dapat mengubah peran akun sendiri.
                                </div>
                            @endif
                            @error('peran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Hubungkan ke Karyawan</label>
                            <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror">
                                <option value="">— Tidak dihubungkan —</option>
                                @foreach($daftarKaryawan as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('karyawan_id', $pengguna->karyawan_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }}) — {{ $k->departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror"
                                    {{ Auth::id() === $pengguna->id ? 'disabled' : '' }}>
                                <option value="aktif"    {{ old('status', $pengguna->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $pengguna->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @if(Auth::id() === $pengguna->id)
                                <input type="hidden" name="status" value="{{ $pengguna->status }}">
                            @endif
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Foto Profil</label>
                            @if($pengguna->foto_profil)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $pengguna->foto_profil) }}"
                                         class="rounded-circle" style="width:48px;height:48px;object-fit:cover">
                                    <span class="text-muted small ms-2">Foto saat ini</span>
                                </div>
                            @endif
                            <input type="file" name="foto_profil"
                                   class="form-control @error('foto_profil') is-invalid @enderror"
                                   accept="image/*" onchange="pratinjauFoto(event)">
                            <img id="pratinjauGambar" src="" class="mt-2 rounded"
                                 style="max-height:80px;display:none">
                            @error('foto_profil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-check-lg me-1"></i> Perbarui Data
                        </button>
                        <a href="{{ route('pengguna.indeks') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info akun saat ini -->
    <div class="col-lg-5">
        <div class="card border-0 rounded-3 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-person-circle text-primary me-2"></i>
                    Info Akun Saat Ini
                </h6>
                <div class="text-center mb-3">
                    <img src="{{ $pengguna->foto_profil_url }}" alt="Avatar"
                         class="rounded-circle" style="width:72px;height:72px;object-fit:cover">
                    <div class="fw-bold mt-2">{{ $pengguna->nama }}</div>
                    <div class="text-muted small">{{ $pengguna->email }}</div>
                </div>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted small" width="110">Peran</td>
                        <td>
                            <span class="badge rounded-pill px-2 py-1
                                {{ $pengguna->peran === 'admin' ? 'badge-alpha' : 'badge-izin' }}">
                                {{ $pengguna->label_peran }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Status</td>
                        <td>
                            <span class="badge rounded-pill px-2 py-1
                                {{ $pengguna->status === 'aktif' ? 'badge-hadir' : 'badge-sakit' }}">
                                {{ ucfirst($pengguna->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Terakhir Login</td>
                        <td class="small">{{ $pengguna->terakhir_login ? $pengguna->terakhir_login->diffForHumans() : 'Belum pernah' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Dibuat</td>
                        <td class="small">{{ $pengguna->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('skrip')
<script>
    function pratinjauFoto(event) {
        const gambar = document.getElementById('pratinjauGambar');
        if (event.target.files[0]) {
            gambar.src = URL.createObjectURL(event.target.files[0]);
            gambar.style.display = 'block';
        }
    }
</script>
@endpush
