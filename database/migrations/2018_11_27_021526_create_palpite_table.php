<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalpiteTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('palpite', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('palpite_mandante');
      $table->integer('palpite_visitante');
      $table->integer('jogo_fase_id')->unsigned();
      $table->foreign('jogo_fase_id')->references('fase_id')->on('jogo');
      $table->integer('jogo_fase_campeonato_id')->unsigned();
      $table->foreign('jogo_fase_campeonato_id')->references('fase_campeonato_id')->on('jogo');
      $table->integer('bolao_has_user_bolao_id')->unsigned();
      $table->foreign('bolao_has_user_bolao_id')->references('bolao_id')->on('bolao_has_user');
      $table->integer('bolao_has_user_users_id')->unsigned();
      $table->foreign('bolao_has_user_users_id')->references('users_id')->on('bolao_has_user');
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
    Schema::dropIfExists('palpite');
  }
}
