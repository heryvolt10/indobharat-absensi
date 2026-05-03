<?php

namespace Database\Seeders;

use App\Models\M_users_access_menu;
use App\Models\M_users_submenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Mt_users_user_access_menuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ctSubMenu = M_users_submenu::all();

        foreach ($ctSubMenu as $ctsb) {
            $data = [
                'uuid' => Str::uuid(),
                'f_role' => 2,
                'f_submenu' => $ctsb->id,
                'ishow' => 1,
                'iadd' => 1,
                'isave' => 1,
                'iedit' => 1,
                'idelete' => 1,
                'create' => NULL,
                'update' => NULL,
            ];
            M_users_access_menu::create($data);
        }
    }
}
