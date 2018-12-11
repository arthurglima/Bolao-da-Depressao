<?php

namespace App;

use App\Models\Notification;
use App\SisBolao\Observer\AbstractObserver;
use App\SisBolao\Observer\AbstractSubject;
use Illuminate\Notifications\Notifiable;


class User extends AbstractObserver
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'type'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function getType()
  {
    return $this->type;
  }

  /**
   * Update do Observer
   * @param AbstractSubject $subject
   */
  public function updateSub(AbstractSubject $subject)
  {
    $notificacao = 'Jogo ' . $subject->mandante->alias . ' X ' . $subject->visitante->alias . ' teve uma atualização';
    Notification::create(['users_id' => $this->id, 'notificacao' => $notificacao]);
  }

  /**
   * Retorna usuário pelo identificador
   * @param $id
   * @return mixed
   */
  public function getById($id)
  {
    return $this->where('id', '=', $id)->first();
  }
}
