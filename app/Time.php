<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
  protected $table = 'time';

  protected $fillable = [
    'nome', 'alias', 'escudo'
  ];
}
