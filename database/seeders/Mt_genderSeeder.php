<?php

namespace Database\Seeders;

use App\Models\M_mt_gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_genderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_mt_gender::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Laki-Laki',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Perempuan',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
            ]
        );
    }
}
