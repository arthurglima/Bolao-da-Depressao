<?php

namespace App\SisBolao;


use App\User;

class Administrador extends User
{
  const ADMINISTRADOR = 1;
  protected $table = 'users';

  public function __construct(array $attributes = [])
  {
    $admin = Administrador::where('type', '=', self::ADMINISTRADOR)->first();
    parent::__construct($admin->toArray());
  }

  /**
   * Retorna a instancia singleton do Administrador
   * @return mixed
   */
  public static function getInstance(): Administrador
  {
    return new Administrador();
  }

  public function updateSubjects()
  {
    // TODO: Implement updateSubjects() method.
  }
}