@extends('layouts.app')

@section('content')
    <form action="{{url("boloes/{$bolao->id}/sair")}}">
        <div style="padding: 15px">
            <h3>{{$bolao->nome}}</h3>
            <small>{{$bolao->campeonato_nome}}</small>
            <button class="btn btn-sm btn-primary" type="submit"
                    style="color: white; margin-left: 5px">
                Sair do Bolão
            </button>
        </div>
    </form>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="classificacao">Classificação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="palpites">Meus palpites</a>
        </li>
        @if($bolao->is_owner)
            @if($bolao->is_moderado)
                <li class="nav-item">
                    <a class="nav-link " href="moderacao">Moderação</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="convidar">Convidar Amigos</a>
            </li>
        @endif
    </ul>
    <div class="content" style="padding: 15px">
        <div style="padding-bottom: 10px">
            <button class="btn btn-sm btn-primary"
                    data-toggle="modal"
                    data-target="#formBolaoPalpite">
                Gerenciar meus palpites
            </button>
        </div>
        <table class="table table-responsive-md table-striped">
            <thead>
            <tr>
                <th>Data / Hora do jogo</th>
                <th>Mandante</th>
                <th>Visitante</th>
                <th class="text-center">Palpites</th>
                <th class="text-center">Placar</th>
                <th>Status do jogo</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($palpites as $palpite)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($palpite->data_jogo)->format('d/m/Y')  }} / {{$palpite->hora_jogo}}
                    </td>
                    <td>
                        <img width="35"
                             src="{{asset('storage/'.$palpite->mandante_escudo)}}" alt="">
                        {{$palpite->mandante_alias}}
                    </td>
                    <td>
                        <img width="35"
                             src="{{asset('storage/'.$palpite->visitante_escudo)}}" alt="">
                        {{$palpite->visitante_alias}}
                    </td>
                    <td class="text-center">
                        {{$palpite->palpite_mandante}} X {{$palpite->palpite_visitante}}
                    </td>
                    <td class="text-center">
                        {{$palpite->resultado_mandante}} X {{$palpite->resultado_visitante}}
                    </td>
                    <td>
                        {{$palpite->status_nome}}
                    </td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>


    @include('bolao.manage-palpites-modal', ['bolao'=> $bolao, 'possibles' => $possibles])


@endsection

