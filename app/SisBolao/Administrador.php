<?php

namespace App\SisBolao;


use App\User;

class Administrador extends User
{
  const ADMINISTRADOR = 1;
  protected $table = 'users';
  private static $instance = null;

  /**
   * Administrador constructor.
   * @param array $attributes
   * @throws \Exception
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
  }

  /**
   * Retorna a instancia singleton do Administrador
   * @return mixed
   */
  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = Administrador::select('*')->where('type', '=', self::ADMINISTRADOR)->first();
    }
    return self::$instance;
  }
}