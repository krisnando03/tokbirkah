<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pengguna';

    // Override kolom bawaan Laravel Auth
    protected $authPasswordName = 'kata_sandi';

    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran',
        'status',
        'karyawan_id',
        'foto_profil',
        'terakhir_login',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    protected $casts = [
        'terakhir_login' => 'datetime',
    ];

    // ──────────────────────────────────────────
    // Override password field untuk Auth
    // ──────────────────────────────────────────
    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    // ──────────────────────────────────────────
    // Relasi
    // ──────────────────────────────────────────
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    // ──────────────────────────────────────────
    // Helper Role
    // ──────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function isPengguna(): bool
    {
        return $this->peran === 'pengguna';
    }

    // ──────────────────────────────────────────
    // Accessor
    // ──────────────────────────────────────────
    public function getFotoProfilUrlAttribute(): string
    {
        if ($this->foto_profil) {
            return asset('storage/' . $this->foto_profil);
        }
        // Avatar inisial via UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama)
            . '&background=2563EB&color=fff&size=80';
    }

    public function getLabelPeranAttribute(): string
    {
        return match($this->peran) {
            'admin'     => 'Administrator',
            'pengguna'  => 'Pengguna',
            default     => '-',
        };
    }

    public function getBadgePeranAttribute(): string
    {
        return match($this->peran) {
            'admin'    => 'danger',
            'pengguna' => 'primary',
            default    => 'secondary',
        };
    }

    // ──────────────────────────────────────────
    // Scope
    // ──────────────────────────────────────────
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeAdmin($query)
    {
        return $query->where('peran', 'admin');
    }
}
