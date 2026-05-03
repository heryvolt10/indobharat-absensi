<?php

namespace Database\Seeders;

use App\Models\M_mt_status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_statusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_mt_status::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Hapus',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Aktif',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Release',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Approve',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Draf',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Tidak Aktif',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Ditolak',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Terkirim',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Terdaftar',
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
