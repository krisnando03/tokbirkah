@extends('layouts.utama')
@section('judul', 'Manajemen Pengguna')

@section('konten')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Manajemen Pengguna</h5>
        <p class="text-muted mb-0 small">Kelola akun & hak akses seluruh pengguna sistem</p>
    </div>
    <a href="{{ route('pengguna.tambah') }}" class="btn btn-utama">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
    </a>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'Total Pengguna', 'nilai' => $statistik['total'],    'warna' => '#dbeafe', 'ikon' => 'people-fill',       'teks' => 'primary'],
        ['label' => 'Administrator',  'nilai' => $statistik['admin'],    'warna' => '#fee2e2', 'ikon' => 'shield-fill-check', 'teks' => 'danger'],
        ['label' => 'Pengguna Biasa', 'nilai' => $statistik['pengguna'], 'warna' => '#dcfce7', 'ikon' => 'person-fill',       'teks' => 'success'],
        ['label' => 'Nonaktif',       'nilai' => $statistik['nonaktif'], 'warna' => '#f1f5f9', 'ikon' => 'person-x-fill',    'teks' => 'secondary'],
    ] as $s)
        <div class="col-6 col-md-3">
            <div class="card kartu-stat h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="ikon-stat" style="background:{{ $s['warna'] }}">
                        <i class="bi bi-{{ $s['ikon'] }} text-{{ $s['teks'] }}"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $s['nilai'] }}</div>
                        <div class="text-muted small">{{ $s['label'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Filter -->
<div class="card border-0 rounded-3 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-500">Cari</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                           class="form-control border-start-0" placeholder="Nama atau email...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-500">Peran</label>
                <select name="peran" class="form-select">
                    <option value="">Semua Peran</option>
                    <option value="admin"    {{ request('peran') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="pengguna" {{ request('peran') == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-500">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-utama flex-fill">Filter</button>
                <a href="{{ route('pengguna.indeks') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="card border-0 rounded-3 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tabel-kustom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Pengguna</th>
                        <th>Peran</th>
                        <th>Karyawan Terhubung</th>
                        <th>Terakhir Login</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarPengguna as $i => $pengguna)
                        <tr class="{{ $pengguna->trashed() ? 'opacity-50' : '' }}">
                            <td class="ps-4 text-muted small">{{ $daftarPengguna->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $pengguna->foto_profil_url }}" alt="Avatar"
                                         style="width:36px;height:36px;border-radius:50%;object-fit:cover">
                                    <div>
                                        <div class="fw-500 small">
                                            {{ $pengguna->nama }}
                                            @if(Auth::id() === $pengguna->id)
                                                <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem">Anda</span>
                                            @endif
                                        </div>
                                        <div class="text-muted" style="font-size:.75rem">{{ $pengguna->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-2 py-1
                                    {{ $pengguna->peran === 'admin' ? 'badge-alpha' : 'badge-izin' }}">
                                    <i class="bi {{ $pengguna->peran === 'admin' ? 'bi-shield-fill-check' : 'bi-person-fill' }} me-1"></i>
                                    {{ $pengguna->label_peran }}
                                </span>
                            </td>
                            <td class="small">
                                @if($pengguna->karyawan)
                                    <div class="fw-500">{{ $pengguna->karyawan->nama }}</div>
                                    <div class="text-muted">{{ $pengguna->karyawan->jabatan }}</div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $pengguna->terakhir_login ? $pengguna->terakhir_login->diffForHumans() : 'Belum pernah' }}
                            </td>
                            <td>
                                @if($pengguna->trashed())
                                    <span class="badge badge-alpha px-2 py-1 rounded-pill">Dihapus</span>
                                @elseif($pengguna->status === 'aktif')
                                    <span class="badge badge-hadir px-2 py-1 rounded-pill">Aktif</span>
                                @else
                                    <span class="badge badge-sakit px-2 py-1 rounded-pill">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                @if(!$pengguna->trashed())
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('pengguna.detail', $pengguna) }}"
                                           class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('pengguna.ubah', $pengguna) }}"
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        @if(Auth::id() !== $pengguna->id)
                                            <form action="{{ route('pengguna.ubah-status', $pengguna) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $pengguna->status === 'aktif' ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                                    title="{{ $pengguna->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    onclick="return confirm('{{ $pengguna->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                                                    <i class="bi bi-{{ $pengguna->status === 'aktif' ? 'pause-fill' : 'play-fill' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('pengguna.hapus', $pengguna) }}" method="POST"
                                                  onsubmit="return confirm('Hapus akun {{ $pengguna->nama }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Tidak ada data pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($daftarPengguna->hasPages())
            <div class="px-4 py-3 border-top">{{ $daftarPengguna->links() }}</div>
        @endif
    </div>
</div>
@endsection
