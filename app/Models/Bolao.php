<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bolao extends Model
{
  protected $table = 'bolao';


  protected $fillable = [
    'nome', 'data_inicio', 'is_moderado', 'can_buscar', 'campeonato_id', 'valor_premiacao'
  ];
}
