<?php

namespace Database\Seeders;

use App\Models\M_setting_app;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Setting_appSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        M_setting_app::insert(
            [
                [
                    'name' => 'app_name',
                    'value' => 'Aplikasi Payroll',
                    'label' => 'Nama Aplikasi',
                    'type' => 'text',
                    'for_setting' => 1,
                ],
                [
                    'name' => 'app_logo',
                    'value' => ENV('DEFAULT_IMG_ORG'),
                    'label' => 'Logo Light',
                    'type' => 'file',
                    'for_setting' => 1,
                ],
                [
                    'name' => 'app_logo_dark',
                    'value' => ENV('DEFAULT_IMG_ORG'),
                    'label' => 'Logo Dark',
                    'type' => 'file',
                    'for_setting' => 1,
                ],
                [
                    'name' => 'app_website',
                    'value' => 'www.pt-indobharatrayon.com',
                    'label' => 'Website',
                    'type' => 'text',
                    'for_setting' => 1,
                ],
                [
                    'name' => 'app_year',
                    'value' => '2020',
                    'label' => 'Tahun Mulai Transaksi',
                    'type' => 'integer',
                    'for_setting' => 1,
                ],
                [
                    'name' => 'app_org',
                    'value' => 'PT. INDO BHARAT RAYON',
                    'label' => 'Perusahaan',
                    'type' => 'text',
                    'for_setting' => 1,
                ],
            ]
        );
    }
}
