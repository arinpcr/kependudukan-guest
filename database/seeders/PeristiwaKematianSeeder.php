<?php

namespace Database\Seeders;

use App\Models\PeristiwaKematian;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PeristiwaKematianSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil 10 warga secara acak untuk dijadikan data simulasi kematian
        // Pastikan ada data di tabel warga dulu sebelum menjalankan ini
        $listWarga = Warga::inRandomOrder()->limit(30)->get();

        foreach ($listWarga as $warga) {
            PeristiwaKematian::create([
                'warga_id'      => $warga->warga_id,
                
                // Kolom Baru (Sesuai ERD Dosen)
                'tgl_meninggal' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'sebab'         => $faker->randomElement(['Sakit Tua', 'Serangan Jantung', 'Kecelakaan', 'Demam Berdarah', 'Sakit']),
                'lokasi'        => $faker->randomElement(['Rumah Duka', 'RSUD Arifin Achmad', 'Puskesmas Desa', 'RS Awal Bros']),
                'no_surat'      => 'SKM/' . $faker->numerify('202#/###/DESA'),
                
                // Kolom Lama (HAPUS atau KOMENTARI bagian ini agar tidak error)
                // 'nik' => ..., 
                // 'sebab_kematian' => ...,
                // 'tempat_kematian' => ...,
                // 'keterangan' => ...,
            ]);
        }
    }
}