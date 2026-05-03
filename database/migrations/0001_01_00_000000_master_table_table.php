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
            $table->integer('f_submenu')->nullable();
            $table->foreignId('f_status')->constrained(table: 'mt_status')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt_table');
        Schema::table('mt_table', function (Blueprint $table) {});
    }
};
