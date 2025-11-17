<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'anggota_id';

    // ✅ TAMBAHKAN INI untuk Route Model Binding
    public function getRouteKeyName()
    {
        return 'anggota_id';
    }

    protected $fillable = [
        'kk_id',
        'warga_id', 
        'hubungan'
    ];

    // Relasi ke KeluargaKk
    public function keluarga()
    {
        return $this->belongsTo(KeluargaKk::class, 'kk_id', 'kk_id');
    }

    // Relasi ke Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // Accessor untuk label hubungan
    public function getHubunganLabelAttribute()
    {
        $labels = [
            'kepala_keluarga' => 'Kepala Keluarga',
            'istri' => 'Istri',
            'anak' => 'Anak',
            'menantu' => 'Menantu', 
            'cucu' => 'Cucu',
            'orang_tua' => 'Orang Tua',
            'lainnya' => 'Lainnya'
        ];

        return $labels[$this->hubungan] ?? $this->hubungan;
    }
}