<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peristiwa_kelahiran', function (Blueprint $table) {
            $table->bigIncrements('kelahiran_id'); // PK
            
            // FK: Bayi (Link ke data warga yang baru dibuat)
            $table->unsignedBigInteger('warga_id')->unique(); // Unique biar 1 warga cuma bisa dicatat 1x lahirnya
            
            // Data Kelahiran
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('no_akta')->unique()->nullable();
            
            // FK: Orang Tua (Bisa null)
            $table->unsignedBigInteger('ayah_warga_id')->nullable();
            $table->unsignedBigInteger('ibu_warga_id')->nullable();
            
            $table->timestamps();

            // Constraint
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
            $table->foreign('ayah_warga_id')->references('warga_id')->on('warga')->onDelete('set null');
            $table->foreign('ibu_warga_id')->references('warga_id')->on('warga')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kelahiran');
    }
};