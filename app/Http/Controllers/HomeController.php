<?php

namespace App\Http\Controllers;

use App\SisBolao\Bolao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
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
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $query = $request->input('query', null);
    $busca = false;

    $boloes = Bolao::select('bolao.*', 'c.nome as campeonato_nome')
      ->join('campeonato as c', 'c.id', '=', 'bolao.campeonato_id')
      ->where('can_buscar', '=', 1);

    if ($query == null) {
      $boloes = $boloes->where('data_inicio', '>', Carbon::now()->format('Y-m-d'));
      $boloes = $boloes->limit(5)->get();
    } else {
      $busca = true;
      $boloes = $boloes->where(DB::raw('lower(bolao.nome)'), 'like', '%' . strtolower($query) . '%');
      $boloes = $boloes->get();
    }

    return view('home', compact('boloes', 'busca', 'query'));
  }
}
