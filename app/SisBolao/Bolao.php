<?php

namespace App\SisBolao;

use App\Models\Bolao as BolaoModel;
use App\Models\BolaoHasUser;
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
   * @param bool $general
   * @return Bolao
   */
  public function getById(int $id, $general = false)
  {
    $bolao = $this->select('bolao.*', 'c.nome as campeonato_nome', 'bhu.e_dono as is_owner')
      ->join('campeonato as c', 'c.id', '=', 'bolao.campeonato_id')
      ->leftJoin('bolao_has_user as bhu', function ($j) use ($general) {
        $j->on('bhu.bolao_id', '=', 'bolao.id');
        if (!$general) {
          $j->where('bhu.users_id', '=', Auth::user()->id);
        }
      })
      ->where('bolao.id', '=', $id)
      ->first();
    if ($bolao !== null) {
      $this->fillFields($bolao->toArray());
    }
    return $this;
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
      ->where('p.bolao_has_user_bolao_id', '=', $this->id)
      ->orderBy('data_jogo', 'desc')
      ->orderBy('hora_jogo', 'desc')
      ->get();
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
      'bhu.esta_aprovado',
      'bhu.bolao_id'
    )
      ->join('bolao_has_user as bhu', 'bhu.bolao_id', '=', 'bolao.id')
      ->join('users as u', 'u.id', '=', 'bhu.users_id')
      ->where('bhu.bolao_id', '=', $this->id)
      ->where('esta_aprovado', '=', 0)
      ->get();
  }

  /**
   * @param $decisao - 1 para confirmar, 0 - para recusar
   * @param $user_id - identificador do usuário
   * @return mixed
   */
  public function decidirModeracao($decisao, $user_id)
  {
    $confirmacao = BolaoHasUser::where('bolao_id', '=', $this->id)->where('users_id', '=', $user_id);
    $confirmacao->update(['esta_aprovado' => $decisao]);
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

  /**
   * Cria um novo bolão
   * @return Bolao
   */
  public function criar(): Bolao
  {
    $vars = get_object_vars($this);
    $b = (new BolaoModel())->fill(array_merge($vars, $vars['attributes']))->toArray();
    $bolao = BolaoModel::create($b);
    BolaoHasUser::create(['bolao_id' => $bolao->id, 'users_id' => Auth::user()->id, 'esta_aprovado' => 1, 'e_dono' => 1]);
    return $bolao;
  }

  /**
   * Entra em um bolão
   * @param $user_id - Identificador do usuário que pediu entrada
   * @return bool
   */
  public function entrarNoBolao($user_id): bool
  {
    return BolaoHasUser::updateOrCreate(
      [
        'bolao_id' => $this->id,
        'users_id' => $user_id,
        'esta_aprovado' => $this->is_moderado == 1 ? 0 : 1,
        'e_dono' => 0
      ]);
  }

}