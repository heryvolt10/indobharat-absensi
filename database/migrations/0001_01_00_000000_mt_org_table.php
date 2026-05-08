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
        Schema::create('mt_org', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama')->unique();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('kontak_person')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('i_pusat')->nullable()->default(0);
            $table->foreignId('f_status')->constrained(table: 'mt_status')->onUpdate('cascade');
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
        Schema::dropIfExists('mt_org');

        Schema::table('mt_org', function (Blueprint $table) {
            $table->dropForeign(['f_status']);
            $table->dropColumn(['f_status']);
        });
    }
};
