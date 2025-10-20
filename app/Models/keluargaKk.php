<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class keluargaKk extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara manual
    protected $table = 'keluarga_kk';

    // Tentukan Primary Key secara manual
    protected $primaryKey = 'kk_id';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'kk_nomor',
        'kepala_keluarga_warga_id',
        'alamat',
        'rt',
        'rw',
    ];

    public function kepalaKeluarga()
    {
        // Parameter: (Model Tujuan, Foreign Key, Primary Key di tabel Warga)
        return $this->belongsTo(Warga::class, 'kepala_keluarga_warga_id', 'warga_id');
    }
}
