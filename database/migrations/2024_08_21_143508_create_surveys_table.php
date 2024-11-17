<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('surveys', function (Blueprint $table) {
        $table->id('id');
        $table->string('name', 50);
        $table->string('alias', 50);
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('mitra');
        $table->unsignedBigInteger('team_id');
        $table->timestamps();

        $table->foreign('team_id')->references('id')->on('roles')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
