<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Warga;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID'); // Indonesian locale

        // Data warga tetap (untuk testing)
        $fixedWarga = [
            [
                'no_ktp' => '3273010101010001',
                'nama' => 'Ahmad Santoso',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'PNS',
                'telp' => '081234567890',
                'email' => 'ahmad.santoso@example.com',
            ],
            [
                'no_ktp' => '3273010202020002',
                'nama' => 'Siti Rahayu',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'telp' => '081234567891',
                'email' => 'siti.rahayu@example.com',
            ],
            [
                'no_ktp' => '3273010303030003',
                'nama' => 'Budi Pratama',
                'jenis_kelamin' => 'L',
                'agama' => 'Kristen',
                'pekerjaan' => 'Wiraswasta',
                'telp' => '081234567892',
                'email' => 'budi.pratama@example.com',
            ],
        ];

        foreach ($fixedWarga as $warga) {
            Warga::create($warga);
        }

        // Generate 100 data warga random
        foreach (range(1, 100) as $index) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender == 'L' ? $faker->firstNameMale : $faker->firstNameFemale;
            
            Warga::create([
                'no_ktp' => $faker->unique()->numerify('3273###########'),
                'nama' => $firstName . ' ' . $faker->lastName,
                'jenis_kelamin' => $gender,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan' => $faker->randomElement([
                    'PNS', 'Wiraswasta', 'Karyawan Swasta', 'Petani', 'Nelayan', 
                    'Pedagang', 'Guru', 'Dokter', 'Perawat', 'Ibu Rumah Tangga',
                    'Pelajar/Mahasiswa', 'Pensiunan', 'Buruh', 'Sopir', 'TNI/Polri'
                ]),
                'telp' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
            ]);
        }

        $this->command->info('Warga Seeder berhasil dijalankan!');
        $this->command->info('Total warga created: 103');
    }
}