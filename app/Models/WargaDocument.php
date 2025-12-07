<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WargaDocument extends Model
{
    use HasFactory;

    protected $table = 'warga_documents';
    protected $primaryKey = 'document_id';

    protected $fillable = [
        'warga_id',
        'file_name',
        'file_path', 
        'file_type',
        'original_name',
        'file_size',
        'document_type',
        'description'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    /**
     * Accessor untuk file URL
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/documents/' . $this->file_name);
    }

    /**
     * Accessor untuk icon berdasarkan tipe file
     */
    public function getFileIconAttribute()
    {
        $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        
        switch(strtolower($extension)) {
            case 'pdf':
                return 'fas fa-file-pdf text-danger';
            case 'doc':
            case 'docx':
                return 'fas fa-file-word text-primary';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'fas fa-file-image text-success';
            default:
                return 'fas fa-file text-secondary';
        }
    }
}