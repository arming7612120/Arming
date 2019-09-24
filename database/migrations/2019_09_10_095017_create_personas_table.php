<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('paterno', 80)->nullable();
            $table->string('materno', 80)->nullable();
            $table->string('nombre', 10)->nullable();
            $table->string('ci', 11)->unique();
            $table->string('expedido', 6)->nullable();
            $table->integer('idtipo')->unsigned();
            $table->timestamps();

            $table->foreign('idtipo')->references('id')->on('tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
