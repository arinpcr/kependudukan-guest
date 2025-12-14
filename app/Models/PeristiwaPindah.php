<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaPindah extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_pindah';
    protected $primaryKey = 'pindah_id'; 

    protected $fillable = [
        'warga_id',
        'tgl_pindah',
        'alamat_tujuan',
        'alasan',
        'no_surat'
    ];

    // --- PERBAIKAN ADA DI SINI ---
    public function warga()
    {
        // Parameter 1: Model tujuan (Warga)
        // Parameter 2: Foreign Key di tabel peristiwa_pindah ('warga_id')
        // Parameter 3: Primary Key di tabel warga ('warga_id') <--- INI KUNCINYA
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id'); 
    }
}