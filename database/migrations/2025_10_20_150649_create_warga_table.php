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
        Schema::create('warga', function (Blueprint $table) {
            
            // Kolom warga_id (PK, Auto-Increment)
            // 'id()' adalah shortcut untuk bigInteger, unsigned, auto-increment, primary key.
            $table->id('warga_id'); 
            
            // Kolom no_ktp (PK), (UNQ)
            // Sesuai gambar, no_ktp adalah UNQ (Unique)
            $table->string('no_ktp', 20)->unique();
            
            // Kolom nama
            $table->string('nama', 100);
            
            // Kolom jenis_kelamin
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            
            // Kolom agama
            // Kita buat nullable() agar tidak wajib diisi
            $table->string('agama', 30)->nullable();
            
            // Kolom pekerjaan
            $table->string('pekerjaan', 50)->nullable();
            
            // Kolom telp
            $table->string('telp', 20)->nullable();
            
            // Kolom email
            $table->string('email', 100)->nullable();

            // Kolom 'created_at' dan 'updated_at' (TIMESTAMPS)
            // Ini adalah standar Laravel untuk melacak kapan data dibuat/diubah
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
