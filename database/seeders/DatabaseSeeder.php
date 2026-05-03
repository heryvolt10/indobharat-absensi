<?php

namespace Database\Seeders;

use App\Models\M_mt_org;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Mt_statusSeeder::class,
            // Mt_orgSeeder::class,
            // Mt_users_roleSeeder::class,
            // Mt_users_menuSeeder::class,
            // Mt_users_submenuSeeder::class,
            // Mt_userSeeder::class,
            // Mt_users_user_access_menuSeeder::class,
            // Ssetting_appSeeder::class,
            // Mt_tableSeeder::class,
            // Mt_unitSeeder::class,
            // Mt_genderSeeder::class,
            // Mt_agamaSeeder::class,
        ]);


        // User::factory(300)->create();
        // M_mt_org::factory(300)->create();
    }
}
