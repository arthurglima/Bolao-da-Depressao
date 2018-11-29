<?php

namespace App\Http\Controllers;

use App\SisBolao\Campeonato;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class CampeonatoController extends Controller
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $campeonatos = Campeonato::all();
    $Carbon = new Carbon();
    return view('campeonato.index', compact('campeonatos', 'Carbon'));
  }

  /**
   * Adiciona um novo campeonato
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $campeonato = (new Campeonato())->fill($request->all());
      if ($campeonato->save()) {
        return redirect('campeonato')->with('success', 'Campeonato criado com sucesso');
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return redirect('campeonato')->with('error', 'Campeonato criado com sucesso');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $time = (new Campeonato())->getById($id);

    if ($time->update($request->all())) {
      return redirect('campeonato')->with('success', 'Campeonato atualizado com sucesso');
    }
  }


  /**
   * Remove um campeonato do sistema
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $campeonato = (new Campeonato())->getById($id);
    if ($campeonato->delete()) {
      return redirect('times')->with('success', 'Time removido com sucesso');
    }
  }
}
