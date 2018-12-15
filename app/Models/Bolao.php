<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Bolao extends Model
{
  protected $table = 'bolao';


  protected $fillable = [
    'nome', 'data_inicio', 'is_moderado', 'can_buscar', 'campeonato_id', 'valor_premiacao'
  ];

  /**
   * Retorna a classificação de usuários de um bolão
   * @return mixed
   */
  public function getClassificacao()
  {

    $placar = Palpite::select(DB::raw('count(palpite.id)'))
      ->join('jogo as j', function ($join) {
        $join->on('palpite.jogo_id', '=', 'j.id')
          ->on('palpite.palpite_mandante', '=', 'j.resultado_mandante')
          ->on('palpite.palpite_visitante', '=', 'j.resultado_visitante');
      })
      ->where('palpite.bolao_has_user_bolao_id', '=', $this->id)
      ->where('palpite.bolao_has_user_users_id', '=', DB::raw('users.id'));

    $golsvencedor = Palpite::select(DB::raw('count(palpite.id)'))
      ->join('jogo as j', function ($j) {
        $j->on('palpite.jogo_id', '=', 'j.id')
          ->on([
            ['palpite.palpite_mandante', '=', 'j.resultado_mandante'],
            ['palpite.palpite_mandante', '>', 'j.resultado_visitante']
          ])->orOn([
            ['palpite.palpite_visitante', '=', 'j.resultado_visitante'],
            ['palpite.palpite_visitante', '>', 'j.resultado_mandante']
          ]);
      })
      ->where('palpite.bolao_has_user_bolao_id', '=', $this->id)
      ->where('palpite.bolao_has_user_users_id', '=', DB::raw('users.id'));

    $golsperdedor = Palpite::select(DB::raw('count(palpite.id)'))
      ->join('jogo as j', function ($j) {
        $j->on('palpite.jogo_id', '=', 'j.id')
          ->on([
            ['palpite.palpite_mandante', '=', 'j.resultado_mandante'],
            ['palpite.palpite_mandante', '<', 'j.resultado_visitante']
          ])->orOn([
            ['palpite.palpite_visitante', '=', 'j.resultado_visitante'],
            ['palpite.palpite_visitante', '<', 'j.resultado_mandante']
          ]);
      })
      ->where('palpite.bolao_has_user_bolao_id', '=', $this->id)
      ->where('palpite.bolao_has_user_users_id', '=', DB::raw('users.id'));

    $list = User::select(
      'users.id',
      'users.name',
      'users.email',
      DB::raw('(' . $placar->toSql() . ') as placar'),
      DB::raw('(' . $golsvencedor->toSql() . ') as gols_vencedor'),
      DB::raw('(' . $golsperdedor->toSql() . ') as gols_perdedor')
    )
      ->setBindings(array_merge($placar->getBindings(), $golsvencedor->getBindings(), $golsperdedor->getBindings()))
      ->join('bolao_has_user as bhu', function ($join) {
        $join->on('users.id', '=', 'bhu.users_id')
          ->where('bhu.bolao_id', '=', $this->id);
      })
      ->where('bhu.esta_aprovado', '=', 1)
      ->orderBy('placar', 'DESC')
      ->orderBy('gols_vencedor', 'DESC')
      ->orderBy('gols_perdedor', 'DESC')
      ->paginate(10);

    return $list;
  }


  /**
   * Retorna todos os possiveis jogo para a rodada corrente
   */
  public function getPossiveisJogosDaRodada(): array
  {
    $query = [];
    if (isset($this->id) && isset(Auth::user()->id)) {
      $query = DB::select(DB::raw("
          SELECT
            p.id,
            p.palpite_mandante,
            p.palpite_visitante,
            j.resultado_mandante,
            j.resultado_visitante,
            j.id as jogo_id,
            j.data_jogo,
            j.hora_jogo,
            js.nome          AS status_nome,
            mandante.nome    AS mandante_nome,
            mandante.alias   AS mandante_alias,
            mandante.escudo  AS mandante_escudo,
            visitante.nome   AS visitante_nome,
            visitante.alias  AS visitante_alias,
            visitante.escudo AS visitante_escudo,
            f.nome as rodada
          FROM jogo AS j
            LEFT JOIN palpite AS p 
                ON p.jogo_id = j.id AND p.bolao_has_user_users_id = " . Auth::user()->id . " 
                                    AND p.bolao_has_user_bolao_id = {$this->id}
            INNER JOIN time AS mandante ON mandante.id = j.time_id_mandante
            INNER JOIN time AS visitante ON visitante.id = j.time_id_visitante
            INNER JOIN jogo_status AS js ON js.id = j.jogo_status_id
            INNER JOIN fase f ON
                                (j.fase_campeonato_id = f.campeonato_id
                                 AND curdate() BETWEEN f.data_inicial AND f.data_final)
          where (curdate() < j.data_jogo or (curdate() = j.data_jogo and curtime() < j.hora_jogo))
          ORDER BY data_jogo DESC, hora_jogo DESC
    "));
    }
    return $query;
  }
}
