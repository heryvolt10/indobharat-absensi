<?php

namespace Database\Seeders;

use App\Models\M_mt_table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_tableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_mt_table::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Status',
                    'set_table' => 'mt_status',
                    'i_standar' => 1,
                    'f_submenu' => NULL,
                    'f_status' => 2,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Unit',
                    'set_table' => 'mt_unit',
                    'i_standar' => 1,
                    'f_submenu' => NULL,
                    'f_status' => 2,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'Gender',
                    'set_table' => 'mt_gender',
                    'i_standar' => 1,
                    'f_submenu' => NULL,
                    'f_status' => 2,
                ],
            ]
        );
    }
}
