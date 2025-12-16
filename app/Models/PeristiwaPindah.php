<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaPindah extends Model
{
    use HasFactory;

    // 1. Nama Tabel (Sesuai Screenshot HeidiSQL)
    protected $table = 'peristiwa_pindah';

    // 2. Primary Key (Sesuai Screenshot HeidiSQL)
    // Penting: Laravel defaultnya nyari 'id', jadi ini wajib ada.
    protected $primaryKey = 'pindah_id';

    // 3. Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'warga_id',
        'tgl_pindah',
        'alamat_tujuan',
        'alasan',
        'no_surat'
    ];

    /**
     * Relasi ke Model Warga
     * Relasi: BelongsTo (Satu peristiwa pindah milik satu warga)
     */
    public function warga()
    {
        // belongsTo(ModelTujuan, ForeignKeyDiTabelIni, PrimaryKeyDiTabelTujuan)
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }
}