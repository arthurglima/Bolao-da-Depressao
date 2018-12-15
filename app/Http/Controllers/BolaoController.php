<?php

namespace App\Http\Controllers;

use App\SisBolao\Bolao;
use App\SisBolao\Campeonato;
use App\SisBolao\Palpite;
use App\SisBolao\SisBolaoFacade;
use Illuminate\Http\Request;
use DB;

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
      DB::beginTransaction();
      $saved = SisBolaoFacade::criarBolao($request->all());
      if ($saved !== null) {
        DB::commit();
        return redirect('boloes')->with('success', 'Bolão criado com sucesso');
      }
    } catch (\Exception $e) {
      DB::rollback();
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
//    $bolao = (new Bolao())->getById($bolao_id);
  }

  /**
   * Retorna a classificação do bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getClassificacao($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    if ($bolao !== null) {
      $classificacao = $bolao->getClassificacao();
    } else {
      abort(404);
    }
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
    if ($bolao !== null) {
      $palpites = $bolao->getPalpites();
      $possibles = $bolao->getPossiveisJogosDaRodada();
    } else {
      abort(404);
    }
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
    if ($bolao !== null) {
      $moderacao = $bolao->getModeracao();
    } else {
      abort(404);
    }
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

  /**
   * Retorna uma lista de pessoas para convidar de acordo com a busca
   * @param Request $request
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function buscarPessoas(Request $request)
  {
    $query = $request->input('query', null);
    $bolao_id = $request->input('bolao_id');

    if ($query == null || $query == '') {
      $seached = [];
    } else {
      $seached = SisBolaoFacade::buscarParticipantes($query, $bolao_id);
    }
    $bolao = (new Bolao())->getById($bolao_id);
    return view('bolao.manage-invite', compact('bolao', 'seached'));
  }

  /**
   * Pedir entrada no bolão
   * @param $bolao_id - Identificador do bolão
   * @return \Illuminate\Http\RedirectResponse
   */
  public function enterInBolao($bolao_id)
  {
    try {
      $bolao = (new Bolao())->getById($bolao_id, true);
      $bolao->entrarNoBolao();
      if ($bolao->is_moderado) {
        return redirect('home')->with('success', 'Pedido de entrada feito ao criador do bolão');
      } else {
        return redirect('home')->with('success', 'Entrada em bolão realizada com sucesso');
      }
    } catch (\Exception $e) {
      return redirect('home')->with('error', $e->getMessage());
    }
  }

  /**
   * Sai de um bolão
   * @param $bolao_id - Identificador do bolão
   * @return \Illuminate\Http\RedirectResponse
   */
  public function sairDoBolao($bolao_id)
  {
    try {
      $bolao = (new Bolao())->getById($bolao_id);
      $bolao->sairDoBolao();
      return redirect('boloes')->with('success', 'Você saiu do bolão');
    } catch (\Exception $e) {
      return redirect('boloes')->with('error', $e->getMessage());
    }
  }

  /**
   * Convida um usuário para o bolão
   * @param $bolao_id - Idenfificador do bolão
   * @param $user_id - Identificador do usuário convidado
   * @return \Illuminate\Http\RedirectResponse
   */
  public function convidar($bolao_id, $user_id)
  {
    try {
      $bolao = (new Bolao())->getById($bolao_id, true);
      $bolao->entrarNoBolao($user_id);
      return redirect("boloes/{$bolao_id}/convidar")->with('success', 'Usuário convidado para o bolão');
    } catch (\Exception $e) {
      return redirect("boloes/{$bolao_id}/convidar")->with('error', $e->getMessage());
    }
  }

}
