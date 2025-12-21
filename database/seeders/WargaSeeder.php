<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use Faker\Factory as Faker;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Data warga tetap (Menggunakan updateOrCreate agar tidak duplikat)
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

        foreach ($fixedWarga as $data) {
            // updateOrCreate: Cek berdasarkan no_ktp, jika ada maka update, jika tidak ada maka buat baru
            Warga::updateOrCreate(['no_ktp' => $data['no_ktp']], $data);
        }

        // 2. Generate 100 data warga random (Menggunakan firstOrCreate)
        foreach (range(1,200) as $index) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender == 'L' ? $faker->firstNameMale : $faker->firstNameFemale;
            
            // Perbaikan NIK: numerify harus 16 digit (3273 + 12 digit random)
            $nik = $faker->unique()->numerify('3273############');

            Warga::firstOrCreate(
                ['no_ktp' => $nik], // Kunci pengecekan
                [
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
                ]
            );
        }

        $this->command->info('Warga Seeder berhasil dijalankan!');
    }
}