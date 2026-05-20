<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['guest'])->group(function () {
    Route::livewire('/', 'auth.login')->name('login');
    Route::livewire('/login', 'auth.login')->name('login');
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/logout', [App\Livewire\Auth\Login::class, 'logout'])->name('logout');
    // ===================================== ADMIN =====================================
    Route::livewire('/' . help_submenu(2)->url, 'pages::admin.dashboard')->name(help_submenu(2)->url . '.index');
    Route::livewire('/' . help_submenu(3)->url, 'pages::admin.role')->name(help_submenu(3)->url . '.index');
    Route::livewire('/' . help_submenu(4)->url, 'pages::admin.menu')->name(help_submenu(4)->url . '.index');
    Route::livewire('/' . help_submenu(5)->url, 'pages::admin.submenu')->name(help_submenu(5)->url . '.index');
    Route::livewire('/' . help_submenu(6)->url, 'pages::admin.settingapp')->name(help_submenu(6)->url . '.index');
    Route::livewire('/' . help_submenu(13)->url, 'pages::admin.settingapp')->name(help_submenu(13)->url . '.index');
    // ===================================== ADMIN END =====================================

    // =========================================PROFILE==================================================
    Route::livewire('/profile', 'pages::user.profile')->name('profile' . '.index');
    Route::livewire('/' . help_submenu(1)->url, 'pages::user.profile')->name(help_submenu(1)->url . '.index');
    // =========================================PROFILE END==================================================

    // ===================================== MASTER =====================================
    // MASTER STANDART
    Route::livewire('/' . help_submenu(10)->url, 'pages::master.standart')->name(help_submenu(10)->url . '.index');
    // MASTER STANDART INPUT
    Route::livewire('/tbinput', 'pages::master.standart_input')->name('tbinput.index');

    // MASTER ORG
    Route::livewire('/' . help_submenu(11)->url, 'pages::master.org')->name(help_submenu(11)->url . '.index');

    // MASTER USER
    Route::livewire('/' . help_submenu(12)->url, 'pages::master.user')->name(help_submenu(12)->url . '.index');

    // MASTER KARYAWAN
    Route::livewire('/' . help_submenu(13)->url, 'pages::master.karyawan')->name(help_submenu(13)->url . '.index');

    // MASTER DIVISI
    Route::livewire('/' . help_submenu(14)->url, 'pages::master.divisi')->name(help_submenu(14)->url . '.index');

    // MASTER JABATAN
    Route::livewire('/' . help_submenu(15)->url, 'pages::master.jabatan')->name(help_submenu(15)->url . '.index');

    // MASTER GRADE
    Route::livewire('/' . help_submenu(16)->url, 'pages::master.grade')->name(help_submenu(16)->url . '.index');

    // MASTER HR & PAYROLL SETTING
    Route::livewire('/' . help_submenu(17)->url, 'pages::master.hrsetting')->name(help_submenu(17)->url . '.index');


    Route::get('/backupdb', function () {
        try {
            // Execute the command with the --only-db option
            Artisan::call('backup:run', ['--only-db' => true]);

            // Return the output of the command for confirmation
            return 'Backup successful! <br><pre>' . Artisan::output() . '</pre>';
        } catch (\Exception $e) {
            return 'Backup failed: ' . $e->getMessage();
        }
    });

    // ===================================== MASTER END=====================================
});
