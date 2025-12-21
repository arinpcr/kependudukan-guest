<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use App\Models\PeristiwaKematian;
use Faker\Factory as Faker;

class PeristiwaKematianSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil 30 warga acak
        $wargaList = Warga::inRandomOrder()->limit(30)->get();

        foreach ($wargaList as $warga) {
            PeristiwaKematian::create([
                'warga_id'        => $warga->warga_id,
                
                // PERBAIKAN DI SINI:
                // Jika $warga->nik kosong, kita generate NIK dummy 16 digit
                'nik'             => $warga->nik ?? $faker->numerify('16##############'),
                
                'tgl_meninggal'   => $faker->dateTimeBetween('-5 years', 'now'),
                'sebab_kematian'  => $faker->randomElement(['Sakit', 'Kecelakaan', 'Faktor Usia', 'Wabah']),
                'tempat_kematian' => $faker->randomElement(['Rumah', 'Rumah Sakit', 'Puskesmas', 'Luar Kota']),
                'keterangan'      => $faker->sentence(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}