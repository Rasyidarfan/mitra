<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('target', 200);
            $table->integer('payment');
            $table->integer('nilai');
            $table->timestamps();

            $table->foreign('mitra_id')->references('mitra_id')->on('mitras')->onDelete('cascade');
            $table->foreign('survey_id')->references('survey_id')->on('surveys')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};