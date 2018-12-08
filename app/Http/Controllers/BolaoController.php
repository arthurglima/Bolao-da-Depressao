<?php

namespace App\Http\Controllers;

use App\SisBolao\Bolao;
use App\SisBolao\Campeonato;
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
    $classificacao = $bolao->classificacao();
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
    return view('bolao.manage-palpites', compact('bolao'));
  }

  /**
   * Retorna os palpites do usuário no bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getModeracao($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    return view('bolao.manage-moderacao', compact('bolao'));
  }


  /**
   * Retorna os palpites do usuário no bolao
   * @param $bolao_id - identificador do bolao
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getInvites($bolao_id)
  {
    $bolao = (new Bolao())->getById($bolao_id);
    return view('bolao.manage-invite', compact('bolao'));
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    print_r($id . 'edit');
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
