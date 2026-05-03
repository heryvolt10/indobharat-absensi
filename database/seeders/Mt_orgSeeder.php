<?php

namespace Database\Seeders;

use App\Models\M_mt_org;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_orgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_mt_org::insert(
            [
                'uuid' => Str::uuid(),
                'nama' => 'ORG A',
                'Alamat' => 'Jl. Alamat',
                'email' => 'example@email.com',
                'no_tlp' => '0812-3456-7890',
                'kontak_person' => 'Direktur Utama',
                'image' => ENV('DEFAULT_IMG_ORG'),
                'i_pusat' => 1,
                'f_status' => '2',
                'create' => NULL,
                'update' => NULL,
            ],
        );
    }
}
