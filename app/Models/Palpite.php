<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Palpite extends Model
{
  protected $table = 'palpite';

  protected $fillable = [
    'id', 'palpite_mandante', 'palpite_visitante',
    'jogo_id', 'bolao_has_user_bolao_id', 'bolao_has_user_users_id'
  ];
}
