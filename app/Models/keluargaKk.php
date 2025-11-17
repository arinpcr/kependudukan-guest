<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeluargaKk extends Model
{
    use HasFactory;

    protected $table = 'keluarga_kk';
    protected $primaryKey = 'kk_id';

    // ✅ TAMBAHKAN INI untuk Route Model Binding
    public function getRouteKeyName()
    {
        return 'kk_id';
    }

    protected $fillable = [
        'kk_nomor',
        'kepala_keluarga_warga_id', 
        'alamat',
        'rt',
        'rw',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_warga_id', 'warga_id');
    }

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'kk_id', 'kk_id');
    }

    public function anggotaWarga()
    {
        return $this->hasManyThrough(
            Warga::class,
            AnggotaKeluarga::class,
            'kk_id',
            'warga_id',  
            'kk_id',
            'warga_id'
        );
    }
}