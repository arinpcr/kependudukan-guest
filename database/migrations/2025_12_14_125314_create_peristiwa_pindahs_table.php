<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peristiwa_pindah', function (Blueprint $table) {
            // Primary Key sesuai gambar
            $table->id('pindah_id'); 
            
            // Foreign Key ke tabel warga
            $table->foreignId('warga_id')
                  ->constrained('warga', 'warga_id')
                  ->onDelete('cascade'); 
            
            // Kolom Data sesuai gambar
            $table->date('tgl_pindah');
            $table->text('alamat_tujuan');
            $table->string('alasan')->nullable();
            $table->string('no_surat')->nullable(); // Kolom baru sesuai gambar
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peristiwa_pindah');
    }
};