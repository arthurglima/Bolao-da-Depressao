<?php

namespace App\SisBolao;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class IObserver extends Authenticatable
{

  abstract public function updateSubjects();

}