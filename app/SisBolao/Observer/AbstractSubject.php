<?php
/**
 * Created by PhpStorm.
 * User: victorious
 * Date: 11/12/18
 * Time: 00:36
 */

namespace App\SisBolao\Observer;

use Illuminate\Database\Eloquent\Model;


abstract class AbstractSubject extends Model
{
  abstract public function attach(AbstractObserver $observer_in);

  abstract public function detach(AbstractObserver $observer_in);

  abstract public function notify();
}