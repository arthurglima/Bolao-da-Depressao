@extends('layouts.app')

@section('content')
    <form action="{{url("boloes/{$bolao->id}/sair")}}" method="POST">
        @method('POST') @csrf
        <div style="padding: 15px">
            <h3>{{$bolao->nome}}</h3>
            <small>{{$bolao->campeonato_nome}}</small>
            @if(!$bolao->is_owner)
                <button class="btn btn-sm btn-primary" type="submit"
                        style="color: white; margin-left: 5px">
                    Sair do Bolão
                </button>
            @else
                <button class="btn btn-sm btn-primary" type="submit"
                        style="color: white; margin-left: 5px">
                    Excluir bolão
                </button>
            @endif
        </div>
    </form>
    <div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="classificacao">Classificação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="palpites">Meus palpites</a>
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
        <table class="table table-responsive-md table-striped">
            <thead>
            <tr>
                <th class="text-center">Posição</th>
                <th class="text-center">Nome</th>
                <th class="text-center">
                    Acertou Placar <br>
                    <small>{{$classificacao[0]->pontos_placar}} ponto(s) por acerto</small>
                </th>
                <th class="text-center">
                    Gols Vencedor <br>
                    <small>{{$classificacao[0]->pontos_gol_vencedor}} ponto(s) por acerto</small>
                </th>
                <th class="text-center">
                    Gols Perdedor <br>
                    <small>{{$classificacao[0]->pontos_gol_perdedor}} ponto(s) por acerto</small>
                </th>
                <th class="text-center">
                    Total <br>
                    <small>Somatórios de pontos</small>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($classificacao as $key => $item)
                <tr>
                    <td class="text-center">
                        @if(\Illuminate\Support\Facades\Auth::user()->id == $item->id)
                            <b>{{$key + 1}} º</b>
                        @else
                            {{$key + 1}} º
                        @endif
                    </td>
                    <td class="text-center">
                        @if(\Illuminate\Support\Facades\Auth::user()->id == $item->id)
                            <b>{{$item->name . " (Você)"}}</b>
                        @else
                            {{$item->name}}
                        @endif
                    </td>
                    <td class="text-center">{{$item->placar}} ({{ $item->placar / $item->pontos_placar }})</td>
                    <td class="text-center">{{$item->gols_vencedor}}
                        ({{ $item->gols_vencedor / $item->pontos_gol_vencedor }})
                    </td>
                    <td class="text-center">{{$item->gols_perdedor}}
                        ({{ $item->gols_perdedor / $item->pontos_gol_perdedor }})
                    </td>
                    <td class="text-center">{{  $item->placar +  $item->gols_vencedor + $item->gols_perdedor}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$classificacao->links()}}

    </div>
@endsection

