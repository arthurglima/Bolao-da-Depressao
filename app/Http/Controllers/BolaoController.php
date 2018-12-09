<?php

namespace App\Http\Controllers;

use App\SisBolao\Bolao;
use App\SisBolao\Campeonato;
use App\SisBolao\Palpite;
use Illuminate\Http\Request;

class BolaoController extends Controller
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
    $boloes = (new Bolao())->getAll();
    return view('bolao.index', compact('campeonatos', 'boloes'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $saved = (new Bolao($request->all()))->save();
      if ($saved) {
        return redirect('boloes')->with('success', 'Bolão criado com sucesso');
      }
    } catch (\Exception $e) {
      return redirect('boloes')->with('error', $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param $bolao_id - identificador do bolao
   * @return void
   */
  public function show($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
  }

  /**
   * Retorna a classificação do bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getClassificacao($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    $classificacao = $bolao->getClassificacao();
    return view('bolao.manage-classificacao', compact('bolao', 'classificacao'));
  }

  /**
   * Retorna os palpites do usuário no bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getPalpites($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    $palpites = $bolao->getPalpites();
    $possibles = $bolao->getPossiveisJogosDaRodada();
    return view('bolao.manage-palpites', compact('bolao', 'palpites', 'possibles'));
  }

  /**
   * Retorna os palpites do usuário no bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getModeracao($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    $moderacao = $bolao->getModeracao();
    return view('bolao.manage-moderacao', compact('bolao', 'moderacao'));
  }


  /**
   * Retorna os palpites do usuário no bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getInvites($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    $seached = [];
    return view('bolao.manage-invite', compact('bolao', 'seached'));
  }

  /**
   * Atualiza e salva os palpites de um usuário no bolão
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function salvarPalpites(Request $request)
  {
    try {
      $palpites = $request->input('palpites');
      foreach ($palpites as $palpite) {
        $p = new Palpite($palpite);
        $p->updateOrCreate($palpite);
      }
      return redirect()->back()->with('success', 'Palpite atualizado com sucesso');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  /**
   * Decide a recusa ou confirmação de um usuário no bolão
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function decisaoDeModeracao(Request $request)
  {
    try {
      $bolao_id = $request->input('bolao_id');
      $esta_aprovado = $request->input('esta_aprovado');
      $users_id = $request->input('users_id');

      $bolao = (new Bolao())->getById($bolao_id);
      $bolao->decidirModeracao($esta_aprovado, $users_id);

      return redirect()->back()->with('success', 'Confirmação realizada');

    } catch (\Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

}
