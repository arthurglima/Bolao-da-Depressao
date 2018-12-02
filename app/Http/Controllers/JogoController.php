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

      if ($request->input('time_id_mandante') == null || $request->input('time_id_visitante') == null) {
        throw new \Exception('Time mandante e visitante são obrigatórios.');
      }

      $jogo = new Jogo($request->all());
      if ($jogo->save()) {
        return redirect()->back()->with('success', 'Jogo adicionado na rodada');
      }
    } catch (\Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  /**
   * Executa a atualizaçao de um jogo
   * @param Request $request - Objeto de request com dados POST
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    try {
      $jogo = (new Jogo($request->all()))->getById();

      if ($jogo->update($request->all())) {
        return redirect()->back()->with('success', 'Placar do jogo atualizado');
      }

    } catch (\Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }


  }
}
