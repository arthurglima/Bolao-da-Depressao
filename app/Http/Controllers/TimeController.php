<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
   */
  public function update(Request $request, $id)
  {

  }
}
