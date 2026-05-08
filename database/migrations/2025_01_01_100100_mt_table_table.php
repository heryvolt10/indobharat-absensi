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
        Schema::create('mt_table', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama')->unique()->nullable();
            $table->string('set_table')->nullable();
            $table->tinyInteger('i_standar')->default(0);
            $table->foreignId('f_submenu')->nullable()->constrained(table: 'users_submenu')->onUpdate('cascade');
            $table->foreignId('f_status')->constrained(table: 'mt_status')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt_table');
        Schema::table('mt_table', function (Blueprint $table) {
            $table->dropForeign(['f_status', 'f_submenu']);
            $table->dropColumn(['f_status', 'f_submenu']);
        });
    }
};
