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

      ['nome' => 'Em andamento'],
      ['nome' => 'Mandante ganhou'],
      ['nome' => 'Visitante ganhou'],
      ['nome' => 'Empate'],
      ['nome' => 'Aguardando dia/hora']

    ]);
  }
}
