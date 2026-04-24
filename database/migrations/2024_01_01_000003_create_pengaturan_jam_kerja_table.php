<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_jam_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift', 50);
            $table->time('jam_masuk_normal');
            $table->time('jam_keluar_normal');
            $table->integer('toleransi_keterlambatan')->default(15)->comment('dalam menit');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_jam_kerja');
    }
};
