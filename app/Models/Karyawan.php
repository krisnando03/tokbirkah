<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karyawan';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'telepon',
        'jabatan',
        'departemen',
        'status',
        'tanggal_masuk',
        'foto',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    // Relasi ke pengguna (akun login)
    public function pengguna(): HasOne
    {
        return $this->hasOne(Pengguna::class, 'karyawan_id');
    }

    // Relasi ke absensi
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'karyawan_id');
    }

    // Absensi hari ini
    public function absensiHariIni()
    {
        return $this->absensi()->whereDate('tanggal', today())->first();
    }

    // Hitung total hadir bulan ini
    public function totalHadirBulanIni(): int
    {
        return $this->absensi()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->whereIn('status_kehadiran', ['hadir', 'terlambat'])
            ->count();
    }

    // Accessor foto
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/avatar-default.png');
    }

    // Scope karyawan aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
