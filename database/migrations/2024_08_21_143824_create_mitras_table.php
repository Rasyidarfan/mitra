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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 200);
            $table->string('email', 100);
            $table->enum('jenis_kelamin', ['Laki-laki','Perempuan']);
            $table->date('tanggal_lahir');
            $table->timestamps();
        });

        Schema::create('survey_mitra', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('pj_id');
            $table->enum('posisi', ['Pencacah', 'Pengawas', 'Pengolah']);
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
            $table->foreign('pj_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
        Schema::dropIfExists('survey_mitra');
    }
};
