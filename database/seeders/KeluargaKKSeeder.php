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
        
        // ✅ HAPUS DATA KK YANG SUDAH ADA DULU
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        KeluargaKk::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        echo "Data KK lama berhasil dihapus.\n";
        
        // Ambil warga yang ada untuk dijadikan kepala keluarga
        $availableWargas = Warga::all();
        
        if ($availableWargas->count() == 0) {
            echo "Tidak ada data warga! Jalankan WargaSeeder dulu.\n";
            return;
        }

        echo "Total warga tersedia: " . $availableWargas->count() . "\n";

        // Data KK tetap - GUNAKAN ID YANG BENAR-BENAR ADA
        $fixedKK = [
            [
                'kk_nomor' => '3273010101010001',
                'kepala_keluarga_warga_id' => $availableWargas[0]->warga_id, // Warga pertama yang ada
                'alamat' => 'Jl. Merdeka No. 123',
                'rt' => '01',
                'rw' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kk_nomor' => '3273010202020002', 
                'kepala_keluarga_warga_id' => $availableWargas[1]->warga_id, // Warga kedua yang ada
                'alamat' => 'Jl. Sudirman No. 45',
                'rt' => '02',
                'rw' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($fixedKK as $kk) {
            KeluargaKk::create($kk);
            echo "Created KK: " . $kk['kk_nomor'] . " dengan kepala keluarga ID: " . $kk['kepala_keluarga_warga_id'] . "\n";
        }

        // Ambil warga laki-laki untuk KK random (skip yang sudah dipakai)
        $usedWargaIds = [$availableWargas[0]->warga_id, $availableWargas[1]->warga_id];
        $kepalaKeluarga = Warga::where('jenis_kelamin', 'L')
                              ->whereNotIn('warga_id', $usedWargaIds)
                              ->take(100)
                              ->get();

        echo "Warga laki-laki tersedia untuk KK random: " . $kepalaKeluarga->count() . "\n";

        // Generate KK random DENGAN LOOP range(1, 100)
        foreach (range(1, 100) as $index) {
            // Jika masih ada warga laki-laki yang tersedia
            if (isset($kepalaKeluarga[$index])) {
                $warga = $kepalaKeluarga[$index];
            } else {
                // Jika sudah habis, ambil warga random lainnya
                $warga = Warga::whereNotIn('warga_id', $usedWargaIds)
                             ->inRandomOrder()
                             ->first();
                
                if (!$warga) {
                    echo "Tidak ada warga tersisa untuk KK!\n";
                    break;
                }
            }

            KeluargaKk::create([
                'kk_nomor' => $faker->unique()->numerify('3273###########'),
                'kepala_keluarga_warga_id' => $warga->warga_id,
                'alamat' => $faker->streetAddress,
                'rt' => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 5), 2, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $usedWargaIds[] = $warga->warga_id;
            echo "Created random KK " . $index . " untuk: " . $warga->nama . " (ID: " . $warga->warga_id . ")\n";
        }

        echo "Total KK created: " . KeluargaKk::count() . "\n";
    }
}