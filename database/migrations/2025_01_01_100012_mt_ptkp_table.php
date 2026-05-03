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
        Schema::create('mt_ptkp', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama')->unique();
            $table->decimal('nilai', 18, 2)->default(0);
            $table->integer('ter_grup')->default(0);
            $table->string('ket', length: 500)->nullable();
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
        Schema::dropIfExists('mt_ptkp');
        Schema::table('mt_ptkp', function (Blueprint $table) {
            $table->dropForeign(['f_status', 'f_org']);
            $table->dropColumn(['f_status', 'f_org']);
        });
    }
};
