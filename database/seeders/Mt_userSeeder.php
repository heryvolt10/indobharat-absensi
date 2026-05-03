<?php

namespace Database\Seeders;

use App\Models\M_users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Mt_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_users::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Superadmin',
                    'email' => 'superadmin@mail.com',
                    'password' => Hash::make('pa$$w0rd'),
                    'f_role' => 1,
                    'image' => ENV('DEFAULT_IMG_USER'),
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Admin',
                    'email' => 'admin@mail.com',
                    'password' => Hash::make('password'),
                    'f_role' => 2,
                    'image' => ENV('DEFAULT_IMG_USER'),
                    'f_status' => '2',
                    'f_org' => '1',
                    'create' => NULL,
                    'update' => NULL,
                ],
            ]
        );
    }
}
