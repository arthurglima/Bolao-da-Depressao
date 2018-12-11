<?php

namespace App\SisBolao;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class IObserver
{

  abstract public function updateSubjects();

}