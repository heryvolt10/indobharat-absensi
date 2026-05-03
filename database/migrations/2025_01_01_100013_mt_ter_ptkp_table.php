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
        Schema::create('mt_ter_ptkp', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('grup');
            $table->decimal('nilai', 18, 2)->default(0);
            $table->decimal('persen', 18, 2)->default(0);
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
        Schema::dropIfExists('mt_ter_ptkp');
        Schema::table('mt_ter_ptkp', function (Blueprint $table) {
            $table->dropForeign(['f_status', 'f_org']);
            $table->dropColumn(['f_status', 'f_org']);
        });
    }
};
