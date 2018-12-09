<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BolaoHasUser extends Model
{
  protected $table = 'bolao_has_user';

  protected $fillable = [
    'users_id', 'bolao_id', 'esta_aprovado', 'e_dono'
  ];
}
