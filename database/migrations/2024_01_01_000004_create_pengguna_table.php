<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('kata_sandi');
            $table->enum('peran', ['admin', 'pengguna'])->default('pengguna')
                  ->comment('admin = akses penuh | pengguna = hanya absensi diri sendiri');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->foreignId('karyawan_id')->nullable()
                  ->constrained('karyawan')->nullOnDelete()
                  ->comment('Jika peran = pengguna, terhubung ke data karyawan');
            $table->string('foto_profil')->nullable();
            $table->timestamp('terakhir_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sesi_pengguna', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_pengguna');
        Schema::dropIfExists('pengguna');
    }
};
