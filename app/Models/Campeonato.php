<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{
  protected $table = 'campeonato';

  protected $fillable = [
    'nome', 'fase_qtd'
  ];
}
