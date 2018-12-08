<?php

namespace App\SisBolao;


use App\User;

class Administrador extends User
{
  public $instance = null;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
  }

  /**
   * Retorna a instancia singleton do Administrador
   * @return mixed
   */
  public function getInstance()
  {
    return $this->instance;
  }

  public function updateSubjects()
  {
    // TODO: Implement updateSubjects() method.
  }
}