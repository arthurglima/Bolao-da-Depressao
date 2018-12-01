<?php

namespace App\Http\Controllers;

use App\SisBolao\Jogo;
use Illuminate\Http\Request;

class JogoController extends Controller
{

  /**
   * Realiza a criação de um novo jogo em uma fase
   * @param Request $request - Objeto de request mandado pela VIEW
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    try {
      $jogo = new Jogo($request->all());
      if ($jogo->save()) {
        return redirect()->back()->with('success', 'Jogo adicionado na rodada');
      }
    } catch (\Exception $e) {
      return redirect()->back()->with('success', $e->getMessage());
    }
  }
}
