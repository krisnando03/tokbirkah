@extends('layouts.utama')
@section('judul', 'Profil Saya')

@section('konten')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Profil Saya</h5>
    <p class="text-muted mb-0 small">Kelola informasi akun dan kata sandi Anda</p>
</div>

<div class="row g-4">
    <!-- Kartu Profil -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-3 shadow-sm text-center p-4">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <img src="{{ $pengguna->foto_profil_url }}" alt="Avatar"
                     class="rounded-circle"
                     style="width:90px;height:90px;object-fit:cover;border:3px solid #e2e8f0"
                     id="pratinjauAvatarProfil">
            </div>
            <h5 class="fw-bold mb-1">{{ $pengguna->nama }}</h5>
            <p class="text-muted small mb-2">{{ $pengguna->email }}</p>
            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge rounded-pill px-3 py-1
                    {{ $pengguna->peran === 'admin' ? 'badge-alpha' : 'badge-izin' }}">
                    <i class="bi {{ $pengguna->peran === 'admin' ? 'bi-shield-fill-check' : 'bi-person-fill' }} me-1"></i>
                    {{ $pengguna->label_peran }}
                </span>
                <span class="badge badge-hadir rounded-pill px-3 py-1">Aktif</span>
            </div>
            <hr>
            <ul class="list-unstyled text-start small">
                @if($pengguna->karyawan)
                    <li class="mb-2 d-flex gap-2 align-items-start">
                        <i class="bi bi-person-badge text-primary mt-1 flex-shrink-0"></i>
                        <div>
                            <div class="fw-500">{{ $pengguna->karyawan->nama }}</div>
                            <div class="text-muted">{{ $pengguna->karyawan->jabatan }}</div>
                            <div class="text-muted">{{ $pengguna->karyawan->departemen }}</div>
                        </div>
                    </li>
                @endif
                <li class="mb-2 d-flex gap-2 align-items-center">
                    <i class="bi bi-envelope text-primary flex-shrink-0"></i>
                    <span class="text-muted">{{ $pengguna->email }}</span>
                </li>
                <li class="d-flex gap-2 align-items-center">
                    <i class="bi bi-clock-history text-primary flex-shrink-0"></i>
                    <span class="text-muted">
                        Login: {{ $pengguna->terakhir_login ? $pengguna->terakhir_login->format('d/m/Y H:i') : '-' }}
                    </span>
                </li>
            </ul>
        </div>

        {{-- Statistik absensi bulan ini (jika terhubung ke karyawan) --}}
        @if($pengguna->karyawan)
            @php
                $karyawan = $pengguna->karyawan;
                $statAbsensi = [
                    'hadir'     => $karyawan->absensi()->bulanIni()->whereIn('status_kehadiran', ['hadir','terlambat'])->count(),
                    'izin'      => $karyawan->absensi()->bulanIni()->where('status_kehadiran','izin')->count(),
                    'sakit'     => $karyawan->absensi()->bulanIni()->where('status_kehadiran','sakit')->count(),
                    'alpha'     => $karyawan->absensi()->bulanIni()->where('status_kehadiran','alpha')->count(),
                ];
            @endphp
            <div class="card border-0 rounded-3 shadow-sm mt-3 p-3">
                <h6 class="fw-bold mb-3 text-center small text-muted text-uppercase">
                    Kehadiran Bulan Ini
                </h6>
                <div class="row g-2 text-center">
                    @foreach([
                        ['label' => 'Hadir',  'nilai' => $statAbsensi['hadir'],  'warna' => '#dcfce7', 'teks' => 'success'],
                        ['label' => 'Izin',   'nilai' => $statAbsensi['izin'],   'warna' => '#dbeafe', 'teks' => 'primary'],
                        ['label' => 'Sakit',  'nilai' => $statAbsensi['sakit'],  'warna' => '#f1f5f9', 'teks' => 'secondary'],
                        ['label' => 'Alpha',  'nilai' => $statAbsensi['alpha'],  'warna' => '#fee2e2', 'teks' => 'danger'],
                    ] as $s)
                        <div class="col-6">
                            <div class="rounded-3 p-2" style="background:{{ $s['warna'] }}">
                                <div class="fw-bold text-{{ $s['teks'] }} fs-4">{{ $s['nilai'] }}</div>
                                <div class="text-muted" style="font-size:.72rem">{{ $s['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-8">
        <!-- Form Edit Profil -->
        <div class="card kartu-form mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-pencil-square text-primary me-2"></i>
                    Edit Informasi Profil
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('profil.perbarui') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $pengguna->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto_profil"
                                   class="form-control @error('foto_profil') is-invalid @enderror"
                                   accept="image/*"
                                   onchange="pratinjauAvatarBaru(event)">
                            <div class="form-text">JPG/PNG, maks 2MB</div>
                            @error('foto_profil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted small">Email</label>
                            <input type="email" value="{{ $pengguna->email }}"
                                   class="form-control bg-light" readonly disabled>
                            <div class="form-text">Email tidak dapat diubah sendiri. Hubungi administrator.</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-utama px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form Ubah Kata Sandi -->
        <div class="card kartu-form">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-lock-fill text-warning me-2"></i>
                    Ubah Kata Sandi
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('profil.ubah-kata-sandi') }}" method="POST" id="formKataSandi">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Kata Sandi Lama <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="kata_sandi_lama" id="kataSandiLama"
                                       class="form-control @error('kata_sandi_lama') is-invalid @enderror"
                                       placeholder="Masukkan kata sandi saat ini">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('kataSandiLama', 'ikonLama')">
                                    <i class="bi bi-eye" id="ikonLama"></i>
                                </button>
                            </div>
                            @error('kata_sandi_lama')
                                <div class="text-danger small mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kata Sandi Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="kata_sandi_baru" id="kataSandiBaru"
                                       class="form-control @error('kata_sandi_baru') is-invalid @enderror"
                                       placeholder="Min. 6 karakter"
                                       oninput="cekKekuatanKataSandi(this.value)">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('kataSandiBaru', 'ikonBaru')">
                                    <i class="bi bi-eye" id="ikonBaru"></i>
                                </button>
                            </div>
                            <!-- Indikator kekuatan -->
                            <div class="mt-1" id="kekuatanKataSandi" style="display:none">
                                <div class="progress" style="height:4px">
                                    <div class="progress-bar" id="barKekuatan" style="width:0%"></div>
                                </div>
                                <small id="labelKekuatan" class="text-muted"></small>
                            </div>
                            @error('kata_sandi_baru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="kata_sandi_baru_confirmation" id="konfirmasiBaru"
                                       class="form-control" placeholder="Ulangi kata sandi baru">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('konfirmasiBaru', 'ikonKonfirmasi')">
                                    <i class="bi bi-eye" id="ikonKonfirmasi"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-lock-fill me-1"></i> Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Riwayat absensi terbaru (jika ada karyawan terhubung) --}}
        @if($pengguna->karyawan)
            <div class="card border-0 rounded-3 shadow-sm mt-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-clock-history text-info me-2"></i>
                        Absensi Terbaru Saya
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
                                @forelse($pengguna->karyawan->absensi()->latest('tanggal')->limit(7)->get() as $abs)
                                    <tr>
                                        <td class="ps-4 small">{{ $abs->tanggal->format('d/m/Y') }}</td>
                                        <td class="small text-success fw-500">{{ $abs->jam_masuk ? substr($abs->jam_masuk,0,5) : '-' }}</td>
                                        <td class="small text-danger fw-500">{{ $abs->jam_keluar ? substr($abs->jam_keluar,0,5) : '-' }}</td>
                                        <td class="small text-muted">{{ $abs->total_jam_kerja_format }}</td>
                                        <td>
                                            <span class="badge badge-{{ $abs->badge_status }} px-2 py-1 rounded-pill small">
                                                {{ $abs->label_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-muted small">
                                            Belum ada data absensi.
                                        </td>
                                    </tr>
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

@push('skrip')
<script>
    function togglePassword(id, ikonId) {
        const input = document.getElementById(id);
        const ikon  = document.getElementById(ikonId);
        input.type  = input.type === 'password' ? 'text' : 'password';
        ikon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }

    function pratinjauAvatarBaru(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('pratinjauAvatarProfil').src = URL.createObjectURL(file);
        }
    }

    function cekKekuatanKataSandi(nilai) {
        const wadah = document.getElementById('kekuatanKataSandi');
        const bar   = document.getElementById('barKekuatan');
        const label = document.getElementById('labelKekuatan');
        wadah.style.display = nilai.length > 0 ? 'block' : 'none';
        let skor = 0;
        if (nilai.length >= 6)  skor++;
        if (nilai.length >= 10) skor++;
        if (/[A-Z]/.test(nilai)) skor++;
        if (/[0-9]/.test(nilai)) skor++;
        if (/[^A-Za-z0-9]/.test(nilai)) skor++;

        const konfigKekuatan = [
            { persen: '20%',  warna: 'bg-danger',  teks: 'Sangat Lemah' },
            { persen: '40%',  warna: 'bg-danger',  teks: 'Lemah'        },
            { persen: '60%',  warna: 'bg-warning',  teks: 'Sedang'      },
            { persen: '80%',  warna: 'bg-info',    teks: 'Kuat'         },
            { persen: '100%', warna: 'bg-success', teks: 'Sangat Kuat'  },
        ];
        const kfg = konfigKekuatan[Math.max(0, skor - 1)];
        bar.style.width = kfg.persen;
        bar.className   = 'progress-bar ' + kfg.warna;
        label.textContent = 'Kekuatan: ' + kfg.teks;
    }
</script>
@endpush
