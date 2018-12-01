<?php

namespace App\Http\Controllers;

use App\SisBolao\Campeonato;
use App\SisBolao\Fase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaseController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return void
   */
  public function index()
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Request $request
   * @param  int $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function edit(Request $request, $id)
  {
    $campeonato = (new Campeonato())->getById($id);
    $fase = $campeonato->Fases()->where('id', '=', $request->input('fase'))->first();
    $Carbon = new Carbon();
    return view('fase.manager', compact('campeonato', 'fase', 'Carbon'));
  }


  /**
   * Realiza a criação de um novo time
   * @param Request $request - Objeto de request mandado pela VIEW
   * @return void
   */
  public function store(Request $request)
  {


  }

  /**
   * Atualiza um time
   * @param Request $request
   * @param $id - Identificador do time
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, $id)
  {
    try {
      $rodada = (new Fase())->getById($id);
      if ($rodada->update($request->all())) {
        $request->input('fase', $rodada->getId());
        return redirect()->back()
          ->with('success', 'Rodada atualizada com sucesso');
      }
    } catch (\Exception $e) {
      return redirect('campeonato')->with('error', $e->getMessage());
    }
  }

  /**
   * Remove um time do sistema
   * @param $id
   * @return void
   */
  public function destroy($id)
  {
  }
}

