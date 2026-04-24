<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status_kehadiran',
        'keterangan',
        'lokasi_masuk',
        'lokasi_keluar',
        'total_jam_kerja',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke karyawan
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    // Hitung total jam kerja dalam format jam:menit
    public function getTotalJamKerjaFormatAttribute(): string
    {
        if (!$this->total_jam_kerja) return '-';
        $jam = intdiv($this->total_jam_kerja, 60);
        $menit = $this->total_jam_kerja % 60;
        return sprintf('%d jam %d menit', $jam, $menit);
    }

    // Badge warna status
    public function getBadgeStatusAttribute(): string
    {
        return match($this->status_kehadiran) {
            'hadir'     => 'success',
            'terlambat' => 'warning',
            'izin'      => 'info',
            'sakit'     => 'secondary',
            'cuti'      => 'primary',
            'alpha'     => 'danger',
            default     => 'light',
        };
    }

    // Label status Indonesia
    public function getLabelStatusAttribute(): string
    {
        return match($this->status_kehadiran) {
            'hadir'     => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin'      => 'Izin',
            'sakit'     => 'Sakit',
            'cuti'      => 'Cuti',
            'alpha'     => 'Alpha',
            default     => '-',
        };
    }

    // Hitung total jam kerja saat checkout
    public static function hitungJamKerja(string $jamMasuk, string $jamKeluar): int
    {
        $masuk  = \Carbon\Carbon::createFromFormat('H:i:s', $jamMasuk);
        $keluar = \Carbon\Carbon::createFromFormat('H:i:s', $jamKeluar);
        return (int) $masuk->diffInMinutes($keluar);
    }

    // Scope filter bulan & tahun
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                     ->whereYear('tanggal', now()->year);
    }

    public function scopeTanggal($query, $dari, $sampai)
    {
        return $query->whereBetween('tanggal', [$dari, $sampai]);
    }
}
