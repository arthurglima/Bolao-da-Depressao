<?php

namespace App\Http\Controllers;

use App\SisBolao\Bolao;
use App\SisBolao\Jogo;
use App\SisBolao\Observer\PObserver;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

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

    $boloes = Bolao::select('bolao.*', 'c.nome as campeonato_nome', 'bhu.e_dono', 'bhu.esta_aprovado', 'bhu.is_inactive')
      ->join('campeonato as c', 'c.id', '=', 'bolao.campeonato_id')
      ->leftJoin('bolao_has_user as bhu', function ($j) {
        $j->on('bhu.bolao_id', '=', 'bolao.id')
          ->where('bhu.users_id', '=', Auth::user()->id);
      })
      ->where('can_buscar', '=', 1);

    if ($query == null) {
      $boloes = $boloes->where('data_inicio', '>=', Carbon::now()->format('Y-m-d'));
    } else {
      $busca = true;
      $boloes = $boloes->where(DB::raw('lower(bolao.nome)'), 'like', '%' . strtolower($query) . '%');
    }

    $boloes = $boloes->paginate(5);

    return view('home', compact('boloes', 'busca', 'query'));
  }
}
