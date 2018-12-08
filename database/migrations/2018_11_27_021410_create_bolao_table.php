<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBolaoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bolao', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nome', 200);
      $table->date('data_inicio');
      $table->boolean('is_moderado')->default(0);
      $table->boolean('can_buscar')->default(1);
      $table->integer('campeonato_id')->unsigned();
      $table->foreign('campeonato_id')->references('id')->on('campeonato');
      $table->double('valor_premiacao', 15, 2);
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
    Schema::dropIfExists('bolao');
  }
}
