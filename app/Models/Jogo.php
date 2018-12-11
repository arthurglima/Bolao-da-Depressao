<?php

namespace App\Models;

use App\SisBolao\Observer\AbstractObserver;
use App\SisBolao\Observer\AbstractSubject;

class Jogo extends AbstractSubject
{

  protected $table = 'jogo';

  protected $observers = [];

  protected $fillable = [
    'fase_id', 'fase_campeonato_id', 'time_id_mandante', 'time_id_visitante',
    'data_jogo', 'hora_jogo', 'resultado_mandante', 'resultado_visitante', 'jogo_status_id'];

  public function attach(AbstractObserver $observer_in)
  {
    $this->observers[] = $observer_in;
  }

  public function detach(AbstractObserver $observer_in)
  {
    foreach ($this->observers as $key => $val) {
      if ($val == $observer_in) {
        unset($this->observers[$key]);
      }
    }
  }

  public function notify()
  {
    /** @var AbstractObserver $obs */
    foreach ($this->observers as $obs) {
      $obs->updateSub($this);
    }
  }
}
