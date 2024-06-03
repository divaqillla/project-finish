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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_part')->unique();
            $table->string('nama_part');
            $table->string('material');
            $table->string('proses');
            $table->string('kode_customer');
            $table->string('berat_part');
            $table->string('berat_shot');
            $table->string('std_packaging');
            $table->string('customer_material');
            $table->string('jenis_material');
            $table->string('cavity');
            $table->string('cycle_time');
            $table->string('cycle_time_cmm');
            $table->string('std_hanger');
            $table->string('is_discontinued');
            $table->string('updated_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
