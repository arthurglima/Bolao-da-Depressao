<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jogo extends Model
{

  protected $table = 'jogo';

  protected $fillable = [
    'fase_id', 'fase_campeonato_id',
    'time_id_mandante', 'time_id_visitante',
    'data_jogo', 'hora_jogo', 'resultado_mandante', 'resultado_visitante'];
}
