<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKk;
use App\Models\Warga;
use Faker\Factory as Faker;

class AnggotaKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // 1. Ambil ID warga yang SUDAH terdaftar di anggota_keluarga (agar tidak duplikat)
        $wargaSudahMenjadiAnggota = AnggotaKeluarga::pluck('warga_id')->toArray();
        $wargaSudahMenjadiAnggota = collect($wargaSudahMenjadiAnggota);
        
        $keluargas = KeluargaKk::all();
        
        foreach ($keluargas as $keluarga) {
            // 2. Kepala keluarga otomatis jadi anggota (cek dulu apakah sudah ada di tabel)
            if (!$wargaSudahMenjadiAnggota->contains($keluarga->kepala_keluarga_warga_id)) {
                AnggotaKeluarga::create([
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $keluarga->kepala_keluarga_warga_id,
                    'hubungan' => 'kepala_keluarga',
                ]);
                $wargaSudahMenjadiAnggota->push($keluarga->kepala_keluarga_warga_id);
            }

            // 3. Cari istri (wanita, belum jadi anggota manapun)
            $istri = Warga::where('jenis_kelamin', 'P')
                         ->whereNotIn('warga_id', $wargaSudahMenjadiAnggota)
                         ->inRandomOrder()
                         ->first();
            
            if ($istri) {
                AnggotaKeluarga::create([
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $istri->warga_id,
                    'hubungan' => 'istri',
                ]);
                $wargaSudahMenjadiAnggota->push($istri->warga_id);
            }

            // 4. Tambahkan anggota lain (anak, dll)
            $jumlahAnggotaLain = $faker->numberBetween(1, 4); 
            $wargaBelumAnggota = Warga::whereNotIn('warga_id', $wargaSudahMenjadiAnggota)
                                    ->inRandomOrder()
                                    ->take($jumlahAnggotaLain)
                                    ->get();

            $hubunganOptions = ['anak', 'anak', 'orang_tua', 'cucu'];
            
            foreach ($wargaBelumAnggota as $warga) {
                AnggotaKeluarga::create([
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $warga->warga_id,
                    'hubungan' => $faker->randomElement($hubunganOptions),
                ]);
                $wargaSudahMenjadiAnggota->push($warga->warga_id);
            }
        }

        $this->command->info('Seeding Anggota Keluarga selesai!');
    }
}