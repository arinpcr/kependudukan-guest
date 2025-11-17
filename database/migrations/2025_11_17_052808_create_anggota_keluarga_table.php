<?php
// File: database/migrations/2025_10_20_160000_create_anggota_keluarga_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id('anggota_id');
            
            // Foreign Key ke keluarga_kk
            $table->unsignedBigInteger('kk_id');
            
            // Foreign Key ke warga  
            $table->unsignedBigInteger('warga_id');
            
            // Hubungan dalam keluarga (menggunakan ENUM untuk konsistensi)
            $table->enum('hubungan', [
                'kepala_keluarga',
                'istri', 
                'anak',
                'menantu',
                'cucu',
                'orang_tua',
                'lainnya'
            ]);

            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('kk_id')
                  ->references('kk_id')
                  ->on('keluarga_kk')
                  ->onDelete('cascade'); // Jika KK dihapus, anggota juga terhapus

            $table->foreign('warga_id')
                  ->references('warga_id')
                  ->on('warga')
                  ->onDelete('cascade'); // Jika warga dihapus, keanggotaan juga terhapus

            // Satu warga hanya boleh ada di satu KK
            $table->unique(['warga_id']);
            
            // Index untuk performa
            $table->index('kk_id');
            $table->index('warga_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};