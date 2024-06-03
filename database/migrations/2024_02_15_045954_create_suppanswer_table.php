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
        Schema::create('suppanswer', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('question_id');
            // $table->integer('remark')->nullable(); // Jika tipe data di tabel questions adalah integer
            // $table->string('note')->nullable();
            $table->string('image')->nullable();
            $table->integer('mark')->nullable();
            $table->longText('notes')->nullable();
            $table->string('line')->nullable();
            $table->string('vendor')->nullable();
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('question_id');

            $table->foreign('auditor_id')->references('id')->on('auditors')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppanswer');
    }
};
