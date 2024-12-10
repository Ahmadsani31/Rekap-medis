<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DocterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            if ($i % 2 == 0) {
                $jenis_kelamin = 'LK';
            } else {
                $jenis_kelamin = 'PR';
            }
            // insert data ke table pegawai menggunakan Faker
            DB::table('docter')->insert([
                'name' => $faker->name,
                'spesialis' => $faker->jobTitle,
                'email' => $faker->email,
                'no_handphone' => $faker->numberBetween($min = 111111111111, $max = 99999999999),
                'jenis_kelamin' => $jenis_kelamin,
                'alamat' => $faker->address,
                'profil' => 'docter/ClP1LOzE8zC0vSH6vPldNJa1zjFkclN0Tg6BhFJb.png',
            ]);
        }
    }
}
