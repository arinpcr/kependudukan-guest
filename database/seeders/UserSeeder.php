<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Data user tetap sesuai permintaanmu
        $fixedUsers = [
            [
                'name' => 'Arin Super',
                'email' => 'super@admin.com',
                'role' => 'Super Admin', // Role tertinggi
                'password' => Hash::make('password'), // Password: password
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Arin Admin',
                'email' => 'admin@admin.com',
                'role' => 'Admin', // Role menengah
                'password' => Hash::make('password'), // Password: password
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Arin User',
                'email' => 'user@user.com',
                'role' => 'User', // Role standar
                'password' => Hash::make('password'), // Password: password
                'email_verified_at' => now(),
            ],
        ];

        // Loop untuk membuat user
        foreach ($fixedUsers as $userData) {
            // updateOrCreate: Cek apakah email sudah ada?
            // Jika ada -> Update datanya
            // Jika tidak -> Buat baru
            User::updateOrCreate(
                ['email' => $userData['email']], // Kunci pencarian
                $userData // Data yang disimpan
            );
        }

        // Opsional: Generate dummy user tambahan jika butuh data banyak
        // \App\Models\User::factory(10)->create();

        $this->command->info('User tetap berhasil dibuat!');
        $this->command->info('---------------------------------------');
        $this->command->info('Login Super Admin: super@admin.com | password');
        $this->command->info('Login Admin      : admin@admin.com | password');
        $this->command->info('Login User       : user@user.com   | password');
    }
}
