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
   * Retorna um jogo pela super chave
   * @return Jogo
   */
  public function getById()
  {
    return $this->where('fase_id', '=', $this->fase_id)
      ->where('fase_campeonato_id', '=', $this->fase_campeonato_id)
      ->where('time_id_mandante', '=', $this->time_id_mandante)
      ->where('time_id_visitante', '=', $this->time_id_visitante)
      ->first();
  }


}