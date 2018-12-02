<?php

namespace App\SisBolao;

use App\Models\Jogo as JogoModel;

class Jogo extends JogoModel
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
   * Função que define todos os atributos da classe
   * @param array $attributes -
   * @return Jogo
   */
  public function fill(array $attributes)
  {
    $this->fillFields($attributes);
    parent::fill($attributes);
    return $this;
  }

  /**
   * Preenche dinamicamente o atributos da classe;
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
   * Retorna um jogo pela chave
   * @param $id - identificador do jogo
   * @return Jogo
   */
  public function getById($id)
  {
    return $this->where('id', '=', $id)->first();
  }


}