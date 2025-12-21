<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use App\Models\PeristiwaPindah;
use Faker\Factory as Faker;

class PeristiwaPindahSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil 30 warga acak
        $wargaList = Warga::inRandomOrder()->limit(30)->get();

        foreach ($wargaList as $warga) {
            PeristiwaPindah::create([
                'warga_id'      => $warga->warga_id,
                'tgl_pindah'    => $faker->dateTimeBetween('-2 years', 'now'),
                'alamat_tujuan' => $faker->address,
                'alasan'        => $faker->randomElement(['Pekerjaan', 'Pendidikan', 'Ikut Keluarga', 'Membeli Rumah Baru']),
                'no_surat'      => $faker->bothify('SRT-PNDH/##/??/202#'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}