<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar', // Pastikan ini ada agar bisa di-update
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Akses di blade nanti tinggal panggil: {{ $user->avatar_url }}
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Ini akan mengarah ke http://domain.test/storage/avatars/namafile.jpg
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Default avatar jika user belum upload
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=0d6efd&background=e3f2fd';
    }
}