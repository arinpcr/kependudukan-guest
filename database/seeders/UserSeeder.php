<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Data user tetap untuk testing
        $fixedUsers = [
            [
                'name' => 'Admin System',
                'email' => 'admin@kependudukan.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Petugas Kependudukan', 
                'email' => 'petugas@kependudukan.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Warga Contoh',
                'email' => 'warga@kependudukan.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data tetap
        foreach ($fixedUsers as $user) {
            DB::table('users')->insert($user);
        }

        // Generate 100 data user random mengikuti pattern yang diminta
        foreach (range(1, 100) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'email_verified_at' => $faker->optional(0.7)->dateTimeBetween('-1 year', 'now'), // 70% verified
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('User Seeder berhasil dijalankan!');
        $this->command->info('Total user created: 103');
        $this->command->info('Login testing:');
        $this->command->info('Email: admin@kependudukan.com / Password: password123');
        $this->command->info('Email: petugas@kependudukan.com / Password: password123');
        $this->command->info('Email: warga@kependudukan.com / Password: password123');
    }
}