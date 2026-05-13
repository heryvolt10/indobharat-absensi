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
        Schema::table('mt_karyawan', function (Blueprint $table) {
            $table->foreignId('f_warga_negara')->after('tgl_bekerja')->nullable()->constrained(table: 'mt_warga_negara')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mt_karyawan', function (Blueprint $table) {
            $table->dropForeign(['f_warga_negara']);
            $table->dropColumn(['f_warga_negara']);
        });
    }
};
