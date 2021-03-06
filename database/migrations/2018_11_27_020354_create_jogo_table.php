<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('jogo', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('fase_id')->unsigned();
      $table->foreign('fase_id')->references('id')->on('fase');
      $table->integer('fase_campeonato_id')->unsigned();
      $table->foreign('fase_campeonato_id')->references('campeonato_id')->on('fase');
      $table->integer('time_id_mandante')->unsigned();
      $table->foreign('time_id_mandante')->references('id')->on('time');
      $table->integer('time_id_visitante')->unsigned();
      $table->foreign('time_id_visitante')->references('id')->on('time');
      $table->date('data_jogo');
      $table->time('hora_jogo');
      $table->integer('resultado_mandante')->default(0);
      $table->integer('resultado_visitante')->default(0);
      $table->integer('jogo_status_id')->unsigned()->default(0);
      $table->foreign('jogo_status_id')->references('id')->on('jogo_status');
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
    Schema::dropIfExists('jogo');
  }
}
