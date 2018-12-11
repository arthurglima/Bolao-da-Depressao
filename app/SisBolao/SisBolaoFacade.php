<?php

namespace App\SisBolao;


use App\User;

class SisBolaoFacade
{

  /**
   * Cria um novo bolão
   * @param $dados
   * @return Bolao
   */
  public static function criarBolao($dados)
  {
    return (new Bolao($dados))->criar();
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