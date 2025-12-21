<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use App\Models\PeristiwaKelahiran;
use Faker\Factory as Faker;

class PeristiwaKelahiranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Ambil ID warga yang SUDAH ada di tabel peristiwa_kelahiran
        $existingWargaIds = PeristiwaKelahiran::pluck('warga_id')->toArray();

        // 2. Ambil 30 warga acak KECUALI yang sudah ada di list di atas
        $wargaList = Warga::whereNotIn('warga_id', $existingWargaIds)
            ->inRandomOrder()
            ->limit(30)
            ->get();

        // Jika tidak ada data warga tersisa, hentikan proses agar tidak error
        if ($wargaList->isEmpty()) {
            $this->command->info('Tidak ada warga baru untuk digenerate data kelahirannya.');
            return;
        }

        foreach ($wargaList as $warga) {
            // Ambil random warga lain sebagai orang tua (bisa null)
            $ayah = Warga::inRandomOrder()->first();
            $ibu = Warga::inRandomOrder()->first();

            PeristiwaKelahiran::create([
                'warga_id'      => $warga->warga_id,
                // Gunakan tgl lahir warga jika ada, atau generate random
                'tgl_lahir'     => $warga->tanggal_lahir ?? $faker->date(),
                'tempat_lahir'  => $faker->city,
                // Pastikan no_akta unik
                'no_akta'       => $faker->unique()->numerify('AKTA-#####-####'),
                'ayah_warga_id' => $ayah ? $ayah->warga_id : null,
                'ibu_warga_id'  => $ibu ? $ibu->warga_id : null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}