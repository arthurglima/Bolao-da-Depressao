<?php

namespace App\SisBolao;

use App\Models\Fase as FaseModel;

class Fase extends FaseModel
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
   * Retorna o Identificador da fase
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Define o identificador da fase
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * Retorna o nome da fase
   * @return mixed
   */
  public function getNome()
  {
    return $this->nome;
  }

  /**
   * Define o nome da fase
   * @param mixed $nome
   */
  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  /**
   * Retorna a ordem da fase
   * @return mixed
   */
  public function getOrdem()
  {
    return $this->ordem;
  }

  /**
   * Define a ordem da fase
   * @param $ordem
   */
  public function setOrdem($ordem)
  {
    $this->ordem = $ordem;
  }

  /**
   * Retorna o nome do campeonato
   * @return mixed
   */
  public function getCampeonatoId()
  {
    return $this->campeonato_id;
  }

  /**
   * Define o nome do campeonato
   * @param $campeonato_id
   */
  public function setCampeonatoId($campeonato_id)
  {
    $this->campeonato_id = $campeonato_id;
  }

  /**
   * Função que define todos os atributos da classe
   * @param array $attributes -
   * @return Fase
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


}