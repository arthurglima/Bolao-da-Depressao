<?php

namespace App\SisBolao;


use App\User;

class SisBolaoFacade
{

  /**
   * Cria um novo bolão
   * @param $dados - Array de dados do bolão
   * @return Bolao
   */
  public static function criarBolao($dados)
  {
    return (new Bolao($dados))->criar();
  }

  /**
   * Cria um novo jogo
   * @param $dados - array de dados do jogo
   * @return bool
   */
  public static function criarJogo($dados)
  {
    return (new Jogo($dados))->save();
  }

  /**
   * Cria um novo campeonato
   * @param $dados - array de dados do campeonato
   * @return Campeonato
   */
  public static function criarCampeonato($dados)
  {
    $campeonato = (new Campeonato())->fill($dados);
    return $campeonato->create($dados);
  }

  /**
   * Criação de um novo time
   * @param $dados - dados do time
   * @param null $file - arquivo de escudo do time
   * @return bool
   */
  public static function criarTime($dados, $file = null)
  {
    $time = (new Time())->fill($dados);
    $time->setEscudo($file);
    return $time->save();
  }

  /**
   * Busca pessoas no sistema
   * @param $query - String de busca
   * @param $bolao_id - Identificador do bolão
   * @return array
   */
  public static function buscarParticipantes($query, $bolao_id)
  {
    return User::select('users.*', 'bhu.bolao_id as bolao_id')
      ->leftJoin('bolao_has_user as bhu', function ($join) use ($bolao_id) {
        $join->on('bhu.users_id', '=', 'users.id')
          ->where('bhu.bolao_id', '=', $bolao_id);
      })
      ->where(DB::raw('lower(name)'), 'like', '%' . strtolower($query) . '%')
      ->orWhere(DB::raw('lower(email)'), 'like', '%' . strtolower($query) . '%')
      ->whereNull('bhu.bolao_id')
      ->get();
  }

}