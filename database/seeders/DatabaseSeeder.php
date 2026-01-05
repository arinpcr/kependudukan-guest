<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // (Opsional, biarkan dikomentari jika tidak dipakai)
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Tambahkan ini di paling atas agar User dibuat duluan
            UserSeeder::class, 

            // Seeder lainnya biarkan urutannya
            WargaSeeder::class,
            KeluargaKKSeeder::class,
            AnggotaKeluargaSeeder::class,
            PeristiwaKelahiranSeeder::class,
            PeristiwaKematianSeeder::class,
            PeristiwaPindahSeeder::class,
        ]);
    }
}