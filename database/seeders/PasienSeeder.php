<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 100; $i++) {
            if ($i % 2 == 0) {
                $jenis_kelamin = 'LK';
            } else {
                $jenis_kelamin = 'PR';
            }
            // insert data ke table pegawai menggunakan Faker
            DB::table('pasien')->insert([
                'name' => $faker->name,
                'nik' => $faker->numberBetween($min = 1111111111111111, $max = 9999999999999999),
                'no_handphone' => $faker->numberBetween($min = 11111111111, $max = 99999999999),
                'jenis_kelamin' => $jenis_kelamin,
                'alamat' => $faker->address,
            ]);
        }
    }
}
