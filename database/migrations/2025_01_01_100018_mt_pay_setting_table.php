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
        Schema::create('mt_pay_setting', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('tot_hari_kerja')->default(0);
            $table->decimal('d_Pph21', 18, 2)->default(0);
            $table->decimal('d_PK_BPJS_TK', 18, 2)->default(0);
            $table->decimal('d_PK_BPJS_KES', 18, 2)->default(0);
            $table->decimal('d_PK_BPJS_JHT', 18, 2)->default(0);
            $table->decimal('d_BP_BPJS_TK', 18, 2)->default(0);
            $table->decimal('d_BP_BPJS_KES', 18, 2)->default(0);
            $table->decimal('d_BP_BPJS_JHT', 18, 2)->default(0);
            $table->decimal('d_BJ', 18, 2)->default(0);
            $table->decimal('d_Bruto_JKM', 18, 2)->default(0);
            $table->decimal('d_Bruto_KES', 18, 2)->default(0);
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
        Schema::dropIfExists('mt_pay_setting');
        Schema::table('mt_pay_setting', function (Blueprint $table) {});
    }
};
