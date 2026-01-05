<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan nama tabel di sini 'peristiwa_pindah' (sesuai Model)
        Schema::create('peristiwa_pindah', function (Blueprint $table) {
            
            // 1. Primary Key (Sesuai ERD Dosen)
            $table->id('pindah_id'); 
            
            // 2. Foreign Key ke tabel warga
            $table->foreignId('warga_id')
                  ->constrained('warga', 'warga_id')
                  ->onDelete('cascade'); 
            
            // 3. Kolom Data
            $table->date('tgl_pindah');
            $table->text('alamat_tujuan');
            $table->string('alasan')->nullable(); // Gabungan Jenis|Asal|Ket
            $table->string('no_surat')->nullable(); // Kolom baru
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peristiwa_pindah');
    }
};