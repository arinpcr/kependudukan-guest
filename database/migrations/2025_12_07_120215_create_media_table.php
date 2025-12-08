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
    Schema::create('media', function (Blueprint $table) {
        $table->id('media_id');
        $table->string('ref_table', 100); // Penanda Tabel (misal: 'peristiwa_kematian')
        $table->unsignedBigInteger('ref_id'); // Penanda ID (misal: 5)
        $table->string('file_name');
        $table->string('caption')->nullable();
        $table->string('mime_type')->nullable();
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
