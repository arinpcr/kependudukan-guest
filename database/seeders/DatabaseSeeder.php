<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WargaSeeder::class,
            KeluargaKKSeeder::class,
            AnggotaKeluargaSeeder::class,
            UserSeeder::class,
            // Tambahkan seeder lain jika ada
        ]);
    }
}