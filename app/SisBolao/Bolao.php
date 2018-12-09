<?php

namespace App\SisBolao;

use App\Models\Bolao as BolaoModel;
use App\Models\BolaoHasUser;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;

class Bolao extends BolaoModel
{
  /**
   * Campeonato constructor.
   * @param array $attributes
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->fillFields($attributes);
  }

  /**
   * Retorna todos os bolões
   */
  public function getAll()
  {
    return $this->select('bolao.*', 'c.nome as campeonato_nome')
      ->join('bolao_has_user as bhu', function ($query) {
        $query->on('bolao.id', '=', 'bhu.bolao_id')
          ->where('bhu.esta_aprovado', '=', 1)
          ->where('bhu.users_id', '=', Auth::user()->id);
      })
      ->join('campeonato as c', 'c.id', 'bolao.campeonato_id')
      ->get();
  }

  /**
   * Retorna o bolão pelo ID;
   * @param int $id - Identificador do Time
   * @return Campeonato
   */
  public function getById(int $id)
  {
    $bolao = $this->select(
      'bolao.*',
      'c.nome as campeonato_nome',
      'bhu.e_dono as is_owner'
    )
      ->join('campeonato as c', 'c.id', '=', 'bolao.campeonato_id')
      ->join('bolao_has_user as bhu', function ($j) {
        $j->on('bhu.bolao_id', '=', 'bolao.id')
          ->where('bhu.users_id', '=', Auth::user()->id);
      })
      ->where('bolao.id', '=', $id)
      ->first();
    $this->fillFields($bolao->toArray());
    return $bolao;
  }

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
        $join->on('users.id', '=', 'bhu.users_id');
      })
      ->where('bhu.esta_aprovado', '=', 1)
      ->orderBy('placar', 'DESC')
      ->orderBy('gols_vencedor', 'DESC')
      ->orderBy('gols_perdedor', 'DESC')
      ->get();

    return $list;
  }

  /**
   * Retorna os palpites do bolao de acordo com a data da rodada
   */
  public function getPalpites()
  {
    return $this->select(
      'p.palpite_mandante',
      'p.palpite_visitante',
      'j.resultado_mandante',
      'j.resultado_visitante',
      'j.data_jogo',
      'j.hora_jogo',
      'js.nome as status_nome',
      'mandante.nome as mandante_nome',
      'mandante.alias as mandante_alias',
      'mandante.escudo as mandante_escudo',
      'visitante.nome as visitante_nome',
      'visitante.alias as visitante_alias',
      'visitante.escudo as visitante_escudo'
    )
      ->join('palpite as p', function ($join) {
        $join->on('p.bolao_has_user_bolao_id', '=', 'bolao.id')
          ->where('p.bolao_has_user_users_id', '=', Auth::user()->id);
      })
      ->join('jogo as j', 'j.id', '=', 'p.jogo_id')
      ->join('time as mandante', 'mandante.id', '=', 'j.time_id_mandante')
      ->join('time as visitante', 'visitante.id', '=', 'j.time_id_visitante')
      ->join('jogo_status as js', 'js.id', '=', 'j.jogo_status_id')
      ->join('fase as f', function ($join) {
        $join->on('f.campeonato_id', '=', 'j.fase_campeonato_id')
          ->whereRaw('curdate() BETWEEN f.data_inicial AND f.data_final');
      })
      ->orderBy('data_jogo', 'desc')
      ->orderBy('hora_jogo', 'desc')
      ->get();
  }

  /**
   * Retorna todos os possiveis jogo para a rodada corrente
   */
  public function getPossiveisJogosDaRodada()
  {
    return DB::select(DB::raw("
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
            LEFT JOIN palpite AS p ON p.jogo_id = j.id AND p.bolao_has_user_users_id = " . Auth::user()->id . "
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

  /**
   * Retorna pessoas para confirmação de participação no bolão
   */
  public function getModeracao()
  {
    return $this->select(
      'u.id',
      'u.email',
      'u.name as nome',
      'bhu.esta_aprovado'
    )
      ->join('bolao_has_user as bhu', 'bhu.bolao_id', '=', 'bolao.id')
      ->join('users as u', 'u.id', '=', 'bhu.users_id')
      ->where('esta_aprovado', '=', 0)
      ->get();
  }

  /**
   * Função que define todos os atributos da classe
   * @param array $attributes -
   * @return Bolao
   */
  public function fill(array $attributes)
  {
    $this->fillFields($attributes);
    parent::fill($attributes);
    return $this;
  }


  /**
   * @param array $attributes
   */
  private function fillFields(array $attributes = [])
  {
    foreach ($attributes as $key => $value) {
      if (in_array($key, $this->fillable)) {
        $this->{$key} = $value;
      }
    }
  }

  public function save(array $options = [])
  {
    BolaoHasUser::create(['bolao_id' => $this->id, 'user_id' => Auth::user()->id, 'esta_aprovado' => 1, 'e_dono' => 1]);
    return parent::save($options); // TODO: Change the autogenerated stub
  }

}