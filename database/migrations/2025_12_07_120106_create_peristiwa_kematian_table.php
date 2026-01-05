<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peristiwa_kematian', function (Blueprint $table) {
            // 1. Primary Key
            $table->id('kematian_id');

            // 2. Foreign Key
            $table->unsignedBigInteger('warga_id');

            // 3. Kolom Data (Sesuai ERD Dosen)
            $table->date('tgl_meninggal');
            $table->string('sebab');   // Dulu: sebab_kematian
            $table->string('lokasi');  // Dulu: tempat_kematian
            $table->string('no_surat')->nullable(); // BARU

            $table->timestamps();

            // Relasi
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kematian');
    }
};