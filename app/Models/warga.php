<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';
    protected $primaryKey = 'warga_id';

    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin', 
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    public $timestamps = true;

    public function anggotaKeluarga()
    {
        return $this->hasOne(AnggotaKeluarga::class, 'warga_id', 'warga_id');
    }

    // Relasi ke KK dimana warga menjadi kepala keluarga
    public function kepalaKeluargaDi()
    {
        return $this->hasOne(KeluargaKk::class, 'kepala_keluarga_warga_id', 'warga_id');
    }

    // ✅ TAMBAHKAN RELASI DOKUMEN
    public function documents()
    {
        return $this->hasMany(WargaDocument::class, 'warga_id', 'warga_id');
    }

    // ✅ ACCESSOR UNTUK DOKUMEN KK
    public function getKkDocumentAttribute()
    {
        return $this->documents->where('document_type', 'kk')->first();
    }
}