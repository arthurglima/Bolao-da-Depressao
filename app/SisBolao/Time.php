<?php

namespace App\SisBolao;

use App\Models\Time as TimeModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use DB;

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
   * Verifica se o time está associado a algum jogo
   */
  public function isInGame()
  {
    return $this->hasMany(Jogo::class, 'time_id_mandante', 'id')
        ->orWhere('jogo.time_id_visitante', '=', $this->getId())
        ->count() > 0;
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
    if (!is_null($escudo)) {
      $this->removeEscudo();
      $this->escudo = $escudo;
    } else {
      $this->escudo = is_string($this->escudo) ? $this->escudo : null;
    }
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
    return parent::delete();
  }

  /**
   * Salva o time em banco de dados;
   * @param array $options
   * @return bool
   */
  public function save(array $options = [])
  {
    $file = $this->getEscudo();
    if ($file !== null && !is_string($file)) {
      Storage::makeDirectory('times');
      $file_path = Storage::put('public/times', $file);
      $explodedPath = explode('/', $file_path);
      $this->escudo = 'times/' . $explodedPath[count($explodedPath) - 1];
    }

    return parent::save($options);
  }

  /**
   * Realiza a atualização do time
   * @param array $attributes
   * @param array $options
   * @return bool
   */
  public function update(array $attributes = [], array $options = [])
  {
    $file = $this->getEscudo();
    if ($file !== null && !is_string($file)) {
      Storage::makeDirectory('times');
      $file_path = Storage::put('public/times', $file);
      $explodedPath = explode('/', $file_path);
      $this->escudo = 'times/' . $explodedPath[count($explodedPath) - 1];
    }
    return parent::update($attributes, $options);
  }

}