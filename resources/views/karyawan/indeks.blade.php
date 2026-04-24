@extends('layouts.utama')
@section('judul', 'Daftar Karyawan')

@section('konten')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Manajemen Karyawan</h5>
        <p class="text-muted mb-0 small">Kelola data seluruh karyawan perusahaan</p>
    </div>
    <a href="{{ route('karyawan.tambah') }}" class="btn btn-utama">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Karyawan
    </a>
</div>

<!-- Filter & Pencarian -->
<div class="card border-0 rounded-3 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-500">Cari Karyawan</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                           class="form-control border-start-0"
                           placeholder="Nama, NIP, atau email...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-500">Departemen</label>
                <select name="departemen" class="form-select">
                    <option value="">Semua Departemen</option>
                    @foreach($daftarDepartemen as $dept)
                        <option value="{{ $dept }}" {{ request('departemen') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-500">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif"       {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-utama flex-fill">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                <a href="{{ route('karyawan.indeks') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Karyawan -->
<div class="card border-0 rounded-3 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tabel-kustom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="40">#</th>
                        <th>Karyawan</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>Tgl. Masuk</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawanList as $index => $karyawan)
                        <tr>
                            <td class="ps-4 text-muted small">
                                {{ $karyawanList->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                         style="width:38px;height:38px;font-size:.85rem;background:hsl({{ (ord($karyawan->nama[0]) * 37) % 360 }},65%,50%)">
                                        {{ substr($karyawan->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-500">{{ $karyawan->nama }}</div>
                                        <div class="text-muted" style="font-size:.78rem">{{ $karyawan->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-primary">{{ $karyawan->nip }}</code></td>
                            <td>{{ $karyawan->jabatan }}</td>
                            <td>
                                <span class="badge bg-light text-secondary px-2 py-1">
                                    {{ $karyawan->departemen }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $karyawan->tanggal_masuk->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($karyawan->status === 'aktif')
                                    <span class="badge badge-hadir px-2 py-1 rounded-pill">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge-alpha px-2 py-1 rounded-pill">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('karyawan.detail', $karyawan) }}"
                                       class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('karyawan.ubah', $karyawan) }}"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('karyawan.hapus', $karyawan) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus karyawan {{ $karyawan->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Tidak ada data karyawan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($karyawanList->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $karyawanList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
