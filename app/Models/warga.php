<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warga extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'warga';

    /**
     * Menentukan primary key dari tabel.
     *
     * @var string
     */
    protected $primaryKey = 'warga_id';

    /**
     * Atribut (kolom) yang dapat diisi secara massal (mass assignable).
     *
     * Ini adalah kolom-kolom yang boleh diisi saat menggunakan
     * Warga::create() atau $warga->update() dari data form.
     *
     * @var array
     */
    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    /**
     * Menentukan apakah model harus menggunakan timestamps (created_at & updated_at).
     *
     * Kita biarkan 'true' karena migrasi kita menggunakan $table->timestamps().
     *
     * @var bool
     */
    public $timestamps = true;
}

