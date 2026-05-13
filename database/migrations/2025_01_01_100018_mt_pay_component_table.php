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
        Schema::create('mt_pay_component', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('kode')->unique()->index();
            $table->string('pay_tipe')->index()->nullable();
            $table->string('pay_grup')->index()->nullable();
            $table->string('pay_set')->index()->nullable();
            $table->string('pay_tax')->index()->nullable();
            $table->decimal('nilai', 18, 2)->default(0.00);
            $table->text('ket_rumusan')->nullable();
            $table->text('ket')->nullable();
            $table->text('ket2')->nullable();
            $table->text('ket3')->nullable();
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
        Schema::dropIfExists('mt_pay_component');
        Schema::table('mt_pay_component', function (Blueprint $table) {
            $table->dropForeign(['f_status', 'f_org']);
            $table->dropColumn(['f_status', 'f_org']);
        });
    }
};
