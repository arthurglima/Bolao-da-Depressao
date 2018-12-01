<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JogoController extends Controller
{

  /**
   * Realiza a criação de um novo jogo em uma fase
   * @param Request $request - Objeto de request mandado pela VIEW
   * @return void
   */
  public function store(Request $request)
  {

    print_r($request->all());die;
  }
}
