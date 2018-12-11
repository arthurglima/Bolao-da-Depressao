<?php

namespace App\SisBolao\Observer;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class AbstractObserver extends Authenticatable
{
  abstract public function updateSub(AbstractSubject $subject);
}