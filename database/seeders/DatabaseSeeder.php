<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Setting_appSeeder::class,
            // Mt_statusSeeder::class,
            // Mt_orgSeeder::class,
            // Mt_users_roleSeeder::class,
            // Mt_users_menuSeeder::class,
            // Mt_users_submenuSeeder::class,
            // Mt_users_user_access_menuSeeder::class,
            // Mt_userSeeder::class,
            // Mt_unitSeeder::class,
            // Mt_genderSeeder::class,
            // Mt_agamaSeeder::class,
            // Mt_tableSeeder::class,
            // Mt_ter_ptkpSeeder::class,
            // Mt_ptkpSeeder::class,
            Mt_warga_negaraSeeder::class,
        ]);


        // User::factory(300)->create();
        // M_mt_org::factory(300)->create();
    }
}
