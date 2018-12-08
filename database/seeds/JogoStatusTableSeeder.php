<?php

use Illuminate\Database\Seeder;

class JogoStatusTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('jogo_status')->insert([

      ['id' => 0, 'nome' => 'Em andamento'],
      ['id' => 1, 'nome' => 'Mandante ganhou'],
      ['id' => 2, 'nome' => 'Visitante ganhou'],
      ['id' => 3, 'nome' => 'Empate'],

    ]);
  }
}
