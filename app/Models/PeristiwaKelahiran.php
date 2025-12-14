<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaKelahiran extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kelahiran';
    protected $primaryKey = 'kelahiran_id';

    protected $fillable = [
        'warga_id',
        'tgl_lahir',
        'tempat_lahir',
        'no_akta',
        'ayah_warga_id',
        'ibu_warga_id',
    ];

    // Relasi ke Bayi
    public function bayi()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // Relasi ke Ayah
    public function ayah()
    {
        return $this->belongsTo(Warga::class, 'ayah_warga_id', 'warga_id');
    }

    // Relasi ke Ibu
    public function ibu()
    {
        return $this->belongsTo(Warga::class, 'ibu_warga_id', 'warga_id');
    }

    // Relasi ke Dokumen Bukti (Media)
    public function dokumen()
    {
        return $this->hasMany(Media::class, 'ref_id', 'kelahiran_id')
                    ->where('ref_table', 'peristiwa_kelahiran');
    }
}