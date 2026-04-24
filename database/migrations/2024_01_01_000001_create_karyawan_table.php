<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique()->comment('Nomor Induk Pegawai');
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('telepon', 20)->nullable();
            $table->string('jabatan', 100);
            $table->string('departemen', 100);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->date('tanggal_masuk');
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
