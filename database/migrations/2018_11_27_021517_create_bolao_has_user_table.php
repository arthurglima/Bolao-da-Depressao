<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBolaoHasUserTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bolao_has_user', function (Blueprint $table) {
      $table->integer('bolao_id')->unsigned();
      $table->foreign('bolao_id')->references('id')->on('bolao');
      $table->integer('users_id')->unsigned();
      $table->foreign('users_id')->references('id')->on('users');
      $table->smallInteger('esta_aprovado')->default(1);
      $table->smallInteger('e_dono')->default(0);
      $table->primary(['bolao_id', 'users_id']);
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
    Schema::dropIfExists('bolao_has_user');
  }
}
