<?php

namespace App\Http\Controllers;

use App\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
   * @param Request $request
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function store(Request $request)
  {
    $file = $request->file('escudo', null);
    $path = 'public/times';
    $time = (new Time())->fill($request->all());

    if ($file !== null) {
      Storage::makeDirectory('times');
      $file_path = Storage::put($path, $file, 'public');
      $time->escudo = $file_path;
    }

    if ($time->save()) {
      return redirect('times')->with('success', 'Time criado com sucesso');
    }
  }
}
