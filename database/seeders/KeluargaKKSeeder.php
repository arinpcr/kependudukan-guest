<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KeluargaKk;
use App\Models\Warga;

class KeluargaKKSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        
        // Ambil beberapa warga untuk dijadikan kepala keluarga
        $kepalaKeluarga = Warga::where('jenis_kelamin', 'L')->take(10)->get();
        
        // Data KK tetap
        $fixedKK = [
            [
                'kk_nomor' => '3273010101010001',
                'kepala_keluarga_warga_id' => 1, // Ahmad Santoso
                'alamat' => 'Jl. Merdeka No. 123',
                'rt' => '01',
                'rw' => '05',
            ],
            [
                'kk_nomor' => '3273010202020002', 
                'kepala_keluarga_warga_id' => 3, // Budi Pratama
                'alamat' => 'Jl. Sudirman No. 45',
                'rt' => '02',
                'rw' => '05',
            ],
        ];

        foreach ($fixedKK as $kk) {
            KeluargaKk::create($kk);
        }

        // Generate 8 KK random
        foreach ($kepalaKeluarga as $index => $warga) {
            if ($warga->warga_id > 3) { // Skip yang sudah dipakai di fixed data
                KeluargaKk::create([
                    'kk_nomor' => $faker->unique()->numerify('3273###########'),
                    'kepala_keluarga_warga_id' => $warga->warga_id,
                    'alamat' => $faker->streetAddress,
                    'rt' => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                    'rw' => str_pad($faker->numberBetween(1, 5), 2, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}