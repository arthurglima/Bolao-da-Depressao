<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('fase', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nome', 70);
      $table->integer('ordem');
      $table->integer('campeonato_id')->unsigned();
      $table->foreign('campeonato_id')->references('id')->on('campeonato');
      $table->date('data_inicial')->nullable();
      $table->date('data_final')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('fase');
  }
}
