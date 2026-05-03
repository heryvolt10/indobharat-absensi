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
        Schema::create('users_access_menu', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('f_role')->constrained(table: 'users_role')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('f_submenu')->constrained(table: 'users_submenu')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('ishow')->default(0);
            $table->tinyInteger('iadd')->default(0);
            $table->tinyInteger('isave')->default(0);
            $table->tinyInteger('iedit')->default(0);
            $table->tinyInteger('idelete')->default(0);
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
        Schema::dropIfExists('users_access_menu');
        Schema::table('users_access_menu', function (Blueprint $table) {
            $table->dropForeign(['f_role', 'f_submenu']);
            $table->dropColumn(['f_role', 'f_submenu']);
        });
    }
};
