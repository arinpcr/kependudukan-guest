<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peristiwa_kematian', function (Blueprint $table) {
            $table->id('kematian_id'); // PK

            $table->unsignedBigInteger('warga_id'); // Relasi ke warga

            // Cukup tulis di bawah warga_id, otomatis urutannya setelah warga_id
            $table->string('nik');

            $table->date('tgl_meninggal');
            $table->string('sebab_kematian')->nullable();
            $table->string('tempat_kematian')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kematian');
    }
};
