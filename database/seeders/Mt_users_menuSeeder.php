<?php

namespace Database\Seeders;

use App\Models\M_users_menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_users_menuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_users_menu::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'USER',
                    'ket' => NULL,
                    'icon' => 'solar:user-hand-up-line-duotone',
                    'seq' => 1,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'HRIS',
                    'ket' => NULL,
                    'icon' => 'solar:checklist-minimalistic-line-duotone',
                    'seq' => 2,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'AKUNTANSI',
                    'ket' => NULL,
                    'icon' => 'solar:money-bag-line-duotone',
                    'seq' => 3,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'REPORT',
                    'ket' => NULL,
                    'icon' => 'solar:clipboard-line-duotone',
                    'seq' => 100,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'MASTER',
                    'ket' => NULL,
                    'icon' => 'solar:tuning-square-2-line-duotone',
                    'seq' => 101,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'ADMIN',
                    'ket' => NULL,
                    'icon' => 'eos-icons:admin-outlined',
                    'seq' => 102,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
            ]
        );
    }
}
