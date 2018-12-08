<?php
/**
 * Created by PhpStorm.
 * User: victorious
 * Date: 07/12/18
 * Time: 22:58
 */

namespace App\SisBolao;

use App\Models\Palpite as PalpiteModel;

class Palpite extends PalpiteModel
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
   * @return Palpite
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
   * Atualiza ou cria um palpite no bolão
   * @param $palpite
   */
  public function updateOrCreate($palpite)
  {
    if (isset($this->id)) {
      self::where('id', '=', $this->id)->update($palpite);
    } else {
      self::create($palpite);
    }
  }


}