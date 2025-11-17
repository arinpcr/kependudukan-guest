<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKk;
use App\Models\Warga;

class AnggotaKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        
        // Ambil semua KK
        $keluargas = KeluargaKk::all();
        
        // Kumpulkan semua warga yang sudah menjadi anggota
        $wargaSudahMenjadiAnggota = collect();
        
        foreach ($keluargas as $keluarga) {
            // 1. Kepala keluarga otomatis jadi anggota
            if (!$wargaSudahMenjadiAnggota->contains($keluarga->kepala_keluarga_warga_id)) {
                AnggotaKeluarga::create([
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $keluarga->kepala_keluarga_warga_id,
                    'hubungan' => 'kepala_keluarga',
                ]);
                $wargaSudahMenjadiAnggota->push($keluarga->kepala_keluarga_warga_id);
            }

            // 2. Cari istri untuk kepala keluarga (wanita, belum jadi anggota)
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

            // 3. Tambahkan anggota lain (anak, orang tua, dll)
            $jumlahAnggotaLain = $faker->numberBetween(1, 3);
            $wargaBelumAnggota = Warga::whereNotIn('warga_id', $wargaSudahMenjadiAnggota)
                                    ->inRandomOrder()
                                    ->take($jumlahAnggotaLain)
                                    ->get();

            $hubunganOptions = ['anak', 'anak', 'anak', 'orang_tua', 'cucu', 'lainnya'];
            
            foreach ($wargaBelumAnggota as $warga) {
                AnggotaKeluarga::create([
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $warga->warga_id,
                    'hubungan' => $faker->randomElement($hubunganOptions),
                ]);
                $wargaSudahMenjadiAnggota->push($warga->warga_id);
            }
        }

        // 4. Pastikan masih ada warga yang tidak menjadi anggota (untuk testing)
        $this->command->info('Total warga yang menjadi anggota: ' . $wargaSudahMenjadiAnggota->count());
        $totalWarga = Warga::count();
        $this->command->info('Total warga tersedia: ' . $totalWarga);
        $this->command->info('Warga belum menjadi anggota: ' . ($totalWarga - $wargaSudahMenjadiAnggota->count()));
    }
}