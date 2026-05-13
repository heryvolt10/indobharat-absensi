<?php

namespace Database\Seeders;

use App\Models\M_mt_warga_negara;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_warga_negaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_mt_warga_negara::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'WNI',
                    'ket' => 'Warga Negara Indonesia',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'WNA',
                    'ket' => 'Warga Negara Asing',
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
            ]
        );
    }
}
