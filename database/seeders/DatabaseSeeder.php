<?php

namespace Database\Seeders;

use App\Models\PeristiwaKelahiran;
use App\Models\PeristiwaKematian;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WargaSeeder::class,
            KeluargaKKSeeder::class,
            AnggotaKeluargaSeeder::class,
            PeristiwaKelahiranSeeder::class,
            PeristiwaKematianSeeder::class,
            PeristiwaPindahSeeder::class,
            
        ]);
    }
}
