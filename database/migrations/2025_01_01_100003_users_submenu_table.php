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
        Schema::create('users_submenu', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama')->unique();
            $table->string('ket', length: 500)->nullable();
            $table->string('icon');
            $table->tinyInteger('seq')->default(1);
            $table->string('url')->unique();
            $table->foreignId('f_menu')->constrained(table: 'users_menu')->onUpdate('cascade');
            $table->foreignId('f_status')->constrained(table: 'mt_status')->onUpdate('cascade');
            $table->foreignId('f_org')->constrained(table: 'mt_org')->onUpdate('cascade');
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
        Schema::dropIfExists('users_submenu');
        Schema::table('users_submenu', function (Blueprint $table) {
            $table->dropForeign(['f_status', 'f_org', 'f_menu']);
            $table->dropColumn(['f_status', 'f_org', 'f_menu']);
        });
    }
};
