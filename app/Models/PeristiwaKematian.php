<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaKematian extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kematian';
    protected $primaryKey = 'kematian_id';
    protected $guarded = [];
    protected $fillable = [
        'warga_id',
        'nik', // <--- DITAMBAHKAN
        'tgl_meninggal',
        'sebab_kematian',
        'tempat_kematian',
        'keterangan'
    ];

    // Relasi ke Warga (Untuk ambil nama Almarhum)
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }
}
