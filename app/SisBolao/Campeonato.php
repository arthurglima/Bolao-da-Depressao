<?php

namespace App\SisBolao;

use App\Models\Campeonato as CampeonatoModel;
use Mockery\Exception;

class Campeonato extends CampeonatoModel
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
   * Verifica se existe jogos em alguma fase do campeonato
   */
  public function hasJogosEmFases()
  {
    $hasFases = $this->Fases()->join('jogo', function ($join) {
      $join->on('jogo.fase_id', '=', 'fase.id')
        ->on('jogo.fase_campeonato_id', '=', 'fase.campeonato_id');
    })->count();

    return $hasFases > 0;
  }

  /**
   * Remove todas as fases de um campeonato, se não houver jogos
   */
  private function removeFases()
  {
    Fase::where('campeonato_id', '=', $this->id)->delete();
  }

  /**
   * Retorna o Identificador do campeonato
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Define o identificador do campeonato
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * Retorna o nome do campeonato
   * @return mixed
   */
  public function getNome()
  {
    return $this->nome;
  }

  /**
   * Define o nome do campeonato
   * @param mixed $nome
   */
  public function setNome($nome)
  {
    $this->nome = $nome;
  }


  /**
   * Função que define todos os atributos da classe
   * @param array $attributes -
   * @return Campeonato
   */
  public function fill(array $attributes)
  {
    $this->fillFields($attributes);
    parent::fill($attributes);
    return $this;
  }

  /**
   * Retorna as fases de um campeonato
   */
  public function Fases()
  {
    return $this->hasMany(Fase::class, 'campeonato_id', 'id');
  }

  /**
   * Verifica se existem fases criadas no campeonato
   */
  public function hasFases()
  {
    return $this->Fases->count() > 0;
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
   * Criação de fases de um campeonato;
   */
  public function criarFases()
  {
    for ($i = 0; $i < $this->fase_qtd; $i++) {
      $fase = new Fase(['nome' => ($i + 1) . 'ª Rodada', 'campeonato_id' => $this->id, 'ordem' => $i + 1]);
      $fase->save();
    }
  }

  /**
   * Retorna o campeonato pelo ID;
   * @param int $id - Identificador do Time
   * @return Campeonato
   */
  public function getById(int $id)
  {
    $campeonato = $this->where('id', '=', $id)->first();
    $this->fillFields($campeonato->toArray());
    return $campeonato;
  }

  /**
   * Criação do Campeonato, ao cria o campeonato todas as fase devem ser criadas
   * @param array $options
   * @return bool
   */
  public function save(array $options = [])
  {
    if ($this->fase_qtd === null || $this->fase_qtd <= 0) {
      throw new Exception("Quantidade de Rodadas deve ser maior que 0");
    }
    return parent::save($options);
  }

  /**
   * Remove um campeonato
   * @return bool|null
   * @throws \Exception
   */
  public function delete()
  {
    if ($this->hasJogosEmFases()) {
      throw new \Exception("Existem jogos associados a esse campeonato, não pode ser removido");
    } else {
      $this->removeFases();
    };
    return parent::delete();
  }

  /**
   * Verifica se o campeonato tem bolão associado
   */
  public function hasBolaoAssociado()
  {
    return Bolao::where('campeonato_id', '=', $this->id)->get() > 0;
  }

}