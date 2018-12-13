<?php

namespace App\Http\Controllers;

use App\SisBolao\Campeonato;
use App\SisBolao\SisBolaoFacade;
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
      $created = SisBolaoFacade::criarCampeonato($request->all());
      $campeonato = $created->getById($created->id);

      if ($created !== null) {
        $campeonato->criarFases();
        DB::commit();
        return redirect('campeonato')->with('success', 'Campeonato criado com sucesso');
      }

    } catch (\Exception $e) {
      DB::rollback();
      return redirect('campeonato')->with('error', $e->getMessage());
    }
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
    try {
      $campeonato = (new Campeonato())->getById($id);
      if ($campeonato->update($request->all())) {
        return redirect('campeonato')->with('success', 'Campeonato atualizado com sucesso');
      }
    } catch (\Exception $e) {
      return redirect('campeonato')->with('error', $e->getMessage());
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
    try {
      $campeonato = (new Campeonato())->getById($id);
      /** Verifica a existencia de jogos, caso exista não é possível remover o campeonato */
      if (!$campeonato->hasJogosEmFases() || !$campeonato->hasBolaoAssociado()) {
        if ($campeonato->delete()) {
          return redirect('campeonato')->with('success', 'Campeonato removido com sucesso');
        }

      } else {
        return redirect('campeonato')->with('error', 'Campeonato tem jogos ou bolões associados, não é possível remover');
      }
    } catch (\Exception $e) {
      return redirect('campeonato')->with('error', $e->getMessage());
    }
  }
}
