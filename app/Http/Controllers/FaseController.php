<?php

namespace App\Http\Controllers;

use App\SisBolao\Campeonato;
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
    return view('fase.manager', compact('campeonato', 'fase'));
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
   * @return void
   */
  public function update(Request $request, $id)
  {
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
