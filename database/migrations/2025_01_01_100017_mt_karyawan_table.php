<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mt_karyawan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama')->unique()->index();
            $table->string('NIK')->unique()->index();
            $table->string('password');
            $table->string('no_npwp');
            $table->string('no_bpjs');
            $table->string('nama_bank');
            $table->string('no_rek');
            $table->string('nama_rek');
            $table->text('alamat');
            $table->date('tgl_bekerja');
            $table->foreignId('f_divisi')->constrained(table: 'mt_divisi')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_jabatan')->constrained(table: 'mt_jabatan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_role')->default('3')->constrained(table: 'users_role')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_gender')->constrained(table: 'mt_gender')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_agama')->constrained(table: 'mt_agama')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_ptkp')->constrained(table: 'mt_ptkp')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_status')->constrained(table: 'mt_status')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_org')->constrained(table: 'mt_org')->onUpdate('cascade')->onDelete('cascade');
            $table->string('create')->nullable();
            $table->string('update')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt_karyawan');
        Schema::table('mt_karyawan', function (Blueprint $table) {
            $table->dropForeign(['f_divisi', 'f_jabatan', 'f_role', 'f_gender', 'f_agama', 'f_ptkp', 'f_status', 'f_org']);
            $table->dropColumn(['f_divisi', 'f_jabatan', 'f_role', 'f_gender', 'f_agama', 'f_ptkp', 'f_status', 'f_org']);
        });
    }
};
