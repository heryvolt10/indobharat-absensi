<?php

namespace Database\Seeders;

use App\Models\M_mt_ptkp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_ptkpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_mt_ptkp::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'K/0',
                    'nilai' => 58500000,
                    'ter_grup' => '1',
                    'ket' => 'Kawin 0 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'K/1',
                    'nilai' => 63000000,
                    'ter_grup' => '2',
                    'ket' => 'Kawin 1 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'K/2',
                    'nilai' => 67500000,
                    'ter_grup' => '2',
                    'ket' => 'Kawin 2 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'K/3',
                    'nilai' => 72000000,
                    'ter_grup' => '3',
                    'ket' => 'Kawin 3 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'TK/0',
                    'nilai' => 54000000,
                    'ter_grup' => '1',
                    'ket' => 'Tidak Kawin 0 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'TK/1',
                    'nilai' => 58500000,
                    'ter_grup' => '1',
                    'ket' => 'Tidak Kawin 1 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'TK/2',
                    'nilai' => 63000000,
                    'ter_grup' => '2',
                    'ket' => 'Tidak Kawin 2 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'TK/3',
                    'nilai' => 67500000,
                    'ter_grup' => '2',
                    'ket' => 'Tidak Kawin 3 Tanggungan',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],

            ]
        );
    }
}
