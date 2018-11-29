<?php

namespace App\SisBolao;

use App\Models\Campeonato as CampeonatoModel;

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
   * Retorna o campeonato pelo ID;
   * @param int $id - Identificador do Time
   * @return Time
   */
  public function getById(int $id)
  {
    $time = $this->where('id', '=', $id)->first();
    $this->fillFields($time->toArray());
    return $time;
  }

}