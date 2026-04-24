@extends('layouts.utama')
@section('judul', 'Detail Pengguna')

@section('konten')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('pengguna.indeks') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Detail Pengguna</h5>
</div>

<div class="row g-4">
    <!-- Kartu Profil -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-3 shadow-sm text-center p-4">
            <img src="{{ $pengguna->foto_profil_url }}" alt="Avatar"
                 class="rounded-circle mx-auto mb-3 d-block"
                 style="width:80px;height:80px;object-fit:cover">
            <h5 class="fw-bold mb-1">{{ $pengguna->nama }}</h5>
            <p class="text-muted small mb-2">{{ $pengguna->email }}</p>

            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge rounded-pill px-3 py-1
                    {{ $pengguna->peran === 'admin' ? 'badge-alpha' : 'badge-izin' }}">
                    <i class="bi {{ $pengguna->peran === 'admin' ? 'bi-shield-fill-check' : 'bi-person-fill' }} me-1"></i>
                    {{ $pengguna->label_peran }}
                </span>
                <span class="badge rounded-pill px-3 py-1 {{ $pengguna->status === 'aktif' ? 'badge-hadir' : 'badge-sakit' }}">
                    {{ ucfirst($pengguna->status) }}
                </span>
            </div>

            <hr>
            <ul class="list-unstyled text-start small">
                @if($pengguna->karyawan)
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-person-badge text-primary mt-1"></i>
                        <div>
                            <div class="fw-500">{{ $pengguna->karyawan->nama }}</div>
                            <div class="text-muted">{{ $pengguna->karyawan->jabatan }} · {{ $pengguna->karyawan->departemen }}</div>
                        </div>
                    </li>
                @else
                    <li class="mb-2 d-flex gap-2 text-muted">
                        <i class="bi bi-person-badge mt-1"></i>
                        <span>Tidak terhubung ke karyawan</span>
                    </li>
                @endif
                <li class="mb-2 d-flex gap-2">
                    <i class="bi bi-clock-history text-primary mt-1"></i>
                    <div>
                        <div class="text-muted">Terakhir login</div>
                        <div>{{ $pengguna->terakhir_login ? $pengguna->terakhir_login->format('d/m/Y H:i') : 'Belum pernah' }}</div>
                    </div>
                </li>
                <li class="d-flex gap-2">
                    <i class="bi bi-calendar3 text-primary mt-1"></i>
                    <div>
                        <div class="text-muted">Dibuat pada</div>
                        <div>{{ $pengguna->created_at->format('d/m/Y') }}</div>
                    </div>
                </li>
            </ul>

            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('pengguna.ubah', $pengguna) }}" class="btn btn-utama btn-sm">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Data
                </a>
                @if(Auth::id() !== $pengguna->id)
                    <form action="{{ route('pengguna.ubah-status', $pengguna) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="btn btn-sm w-100 {{ $pengguna->status === 'aktif' ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                onclick="return confirm('{{ $pengguna->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                            <i class="bi bi-{{ $pengguna->status === 'aktif' ? 'pause-circle' : 'play-circle' }} me-1"></i>
                            {{ $pengguna->status === 'aktif' ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Reset Kata Sandi -->
        <div class="card border-0 rounded-3 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-key-fill text-warning me-2"></i>
                    Reset Kata Sandi
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('pengguna.reset-kata-sandi', $pengguna) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="kata_sandi_baru"
                                   class="form-control @error('kata_sandi_baru') is-invalid @enderror"
                                   placeholder="Min. 6 karakter">
                            @error('kata_sandi_baru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="kata_sandi_baru_confirmation"
                                   class="form-control" placeholder="Ulangi kata sandi baru">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning btn-sm px-4"
                                    onclick="return confirm('Reset kata sandi pengguna {{ $pengguna->nama }}?')">
                                <i class="bi bi-key-fill me-1"></i> Reset Kata Sandi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Absensi jika terhubung ke karyawan -->
        @if($pengguna->karyawan)
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-calendar-check text-info me-2"></i>
                        Riwayat Absensi Terkait
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengguna->karyawan->absensi()->latest('tanggal')->limit(10)->get() as $abs)
                                    <tr>
                                        <td class="ps-4 small">{{ $abs->tanggal->format('d/m/Y') }}</td>
                                        <td class="small">{{ $abs->jam_masuk ? substr($abs->jam_masuk,0,5) : '-' }}</td>
                                        <td class="small">{{ $abs->jam_keluar ? substr($abs->jam_keluar,0,5) : '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $abs->badge_status }} px-2 py-1 rounded-pill small">
                                                {{ $abs->label_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-3 text-muted small">Belum ada absensi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
