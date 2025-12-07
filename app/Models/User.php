<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
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

    /**
     * Scope untuk filter
     */
    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }

    /**
     * Accessor untuk avatar URL - FIXED
     */
    public function getAvatarUrlAttribute()
{
    if ($this->avatar) {
        return asset('storage/avatars/' . $this->avatar);
    }
    
    // Fallback ke default avatar atau UI Avatars
    if (file_exists(public_path('img/default-avatar.jpg'))) {
        return asset('img/default-avatar.jpg');
    }
    
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=0d6efd&background=e3f2fd';
}
    /**
     * Accessor untuk tampilan avatar di HTML
     */
    public function getAvatarHtmlAttribute()
    {
        return '<img src="' . $this->avatar_url . '" alt="' . $this->name . '" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">';
    }
}