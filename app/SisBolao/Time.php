<?php

namespace App\SisBolao;

use App\Models\Time as TimeModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Time extends TimeModel
{

  /**
   * Time constructor.
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
   * @return Time
   */
  public function fill(array $attributes)
  {
    $this->fillFields($attributes);
    parent::fill($attributes);
    return $this;
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getNome()
  {
    return $this->nome;
  }

  /**
   * @param mixed $nome
   */
  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  /**
   * @return mixed
   */
  public function getAlias()
  {
    return $this->alias;
  }

  /**
   * @param mixed $alias
   */
  public function setAlias($alias)
  {
    $this->alias = $alias;
  }

  /**
   * @return mixed
   */
  public function getEscudo()
  {
    return $this->escudo;
  }

  /**
   * @param mixed $escudo
   */
  public function setEscudo(UploadedFile $escudo = null)
  {
    if ($this->escudo !== null) {
      $this->removeEscudo();
    }

    $this->escudo = $escudo;
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
   * Retorna o time pelo ID;
   * @param int $id - Identificador do Time
   * @return Time
   */
  public function getById(int $id)
  {
    $time = $this->where('id', '=', $id)->first();
    $this->fillFields($time->toArray());
    return $time;
  }

  /**
   * Remove o arquivo de escudo do sistema
   */
  private function removeEscudo()
  {
    Storage::delete('public/' . $this->getEscudo());
  }

  /**
   * @return bool|null
   * @throws \Exception
   */
  public function delete()
  {
    $this->removeEscudo();
    return parent::delete(); // TODO: Change the autogenerated stub
  }

  /**
   * Salva o time em banco de dados;
   * @param array $options
   * @return bool
   */
  public function save(array $options = [])
  {
    $file = $this->getEscudo();
    if ($file !== null) {
      Storage::makeDirectory('times');
      $file_path = Storage::put('public/times', $file);
      $explodedPath = explode('/', $file_path);
      $this->escudo = 'times/' . $explodedPath[count($explodedPath) - 1];
    }

    return parent::save($options); // TODO: Change the autogenerated stub
  }

}