<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SisBolao\Time;

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
    return view('times.index', compact('times'));
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
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $time = (new Time())->getById($id);
    if ($time->delete()) {
      return redirect('times')->with('success', 'Time removido com sucesso');
    }
  }
}
