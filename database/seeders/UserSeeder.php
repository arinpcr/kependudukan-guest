<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
{
    // 1. Buat User Tetap (Agar login tidak berubah-ubah)
    $fixedUsers = [
        [
            'name' => 'Arin Super',
            'email' => 'super@admin.com',
            'role' => 'Super Admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ],
        [
            'name' => 'Arin Admin',
            'email' => 'admin@admin.com',
            'role' => 'Admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ],
        [
            'name' => 'Arin User',
            'email' => 'user@user.com',
            'role' => 'User',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ],
    ];

    foreach ($fixedUsers as $user) {
        \App\Models\User::updateOrCreate(
            ['email' => $user['email']], // Cek email
            $user // Update/Create data
        );
    }

    // 2. Buat Dummy Data Tambahan (Opsional)
    // \App\Models\User::factory(20)->create(); 

    $this->command->info('User Seeder Selesai.');
}
}
