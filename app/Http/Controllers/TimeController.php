<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SisBolao\Time;
use DB;
use Response;

class TimeController extends Controller
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
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $times = Time::all();
    $Carbon = new Carbon();
    return view('times.index', compact('times', 'Carbon'));
  }

  /**
   * Realiza a criação de um novo time
   * @param Request $request - Objeto de request mandado pela VIEW
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function store(Request $request)
  {
    $file = $request->file('escudo', null);
    $time = (new Time())->fill($request->all());
    $time->setEscudo($file);

    if ($time->save()) {
      return redirect('times')->with('success', 'Time criado com sucesso');
    }
  }

  /**
   * Atualiza um time
   * @param Request $request
   * @param $id - Identificador do time
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, $id)
  {
    $file = $request->file('escudo', null);
    $time = (new Time())->getById($id);
    $time->setEscudo($file);

    if ($time->update($request->all())) {
      return redirect('times')->with('success', 'Time atualizado com sucesso');
    }

  }

  /**
   * Remove um time do sistema
   * @param $id - identificador do time
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    try {

      $time = (new Time())->getById($id);

      /** Caso o time em questão esteja associado a um jogo, não é possível remove-lo */
      if ($time->isInGame()) {
        throw new \Exception("Time associado a algum jogo em um campeonato não pode ser removido");
      }

      if ($time->delete()) {
        return redirect('times')->with('success', 'Time removido com sucesso');
      }
    } catch (\Exception $e) {
      return redirect('times')->with('error', $e->getMessage());
    }
  }

  /**
   * Retorna uma lista JSON de times
   * @param Request $request - Objeto da view
   * @return JSON
   */
  public function getTimesByName(Request $request)
  {
    $query = $request->input('term');
    $times = Time::select('nome as value', 'id')
      ->where(DB::raw('lower(nome)'), 'like', '%' . strtolower($query) . '%')->get();

    return Response::json($times);
  }
}
