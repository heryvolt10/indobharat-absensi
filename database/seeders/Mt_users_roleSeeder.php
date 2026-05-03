<?php

namespace Database\Seeders;

use App\Models\M_users_role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_users_roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_users_role::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'ADMINISTRATOR',
                    'ket' => NULL,
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'nama' => 'ADMIN',
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
