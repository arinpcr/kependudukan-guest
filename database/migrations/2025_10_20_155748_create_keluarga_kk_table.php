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
        Schema::create('keluarga_kk', function (Blueprint $table) {
            // kk_id (PK)
            $table->bigIncrements('kk_id'); 
            
            // kk_nomor (UNQ)
            $table->string('kk_nomor', 50)->unique(); 
            
            // kepala_keluarga_warga_id (FK)
            $table->unsignedBigInteger('kepala_keluarga_warga_id'); 
            
            // Kolom lainnya
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);

            $table->timestamps(); // Standar created_at dan updated_at

            // Definisi Foreign Key
            $table->foreign('kepala_keluarga_warga_id')
                  ->references('warga_id') // Mengacu ke kolom warga_id
                  ->on('warga') // Di tabel 'warga'
                  ->onDelete('restrict'); // Mencegah penghapusan warga jika masih jadi Kepala KK
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_kk');
    }
};
