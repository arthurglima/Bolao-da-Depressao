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
    $bolao = $this->select('bolao.*', 'c.nome as campeonato_nome')->where('bolao.id', '=', $id)
      ->join('campeonato as c', 'c.id', '=', 'bolao.campeonato_id')->first();
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
      ->orderBy('placar', 'DESC')
      ->orderBy('gols_vencedor', 'DESC')
      ->orderBy('gols_perdedor', 'DESC')
      ->get();

    return $list;
  }

  /**
   * Retorna os palpites do bolao
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
      ->join('jogo as j', 'j.id', 'p.jogo_id')
      ->join('time as mandante', 'mandante.id', 'j.time_id_mandante')
      ->join('time as visitante', 'visitante.id', 'j.time_id_visitante')
      ->join('jogo_status as js', 'js.id', 'j.jogo_status_id')
      ->orderBy('data_jogo', 'desc')
      ->orderBy('hora_jogo', 'desc')
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
    BolaoHasUser::create(['bolao_id' => $this->id, 'user_id' => Auth::user()->id, 'esta_aprovado' => 1]);
    return parent::save($options); // TODO: Change the autogenerated stub
  }

}