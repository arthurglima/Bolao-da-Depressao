@extends('layouts.app')

@section('content')
    <div style="padding: 15px">
        <h3>{{$bolao->nome}}</h3>
        <small>{{$bolao->campeonato_nome}}</small>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="classificacao">Classificação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="palpites">Palpites</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="moderacao">Moderação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="convidar">Convidar Amigos</a>
        </li>
    </ul>
    <div class="content" style="padding: 15px">
        <table class="table table-responsive-md table-striped">
            <thead>
            <tr>
                <th class="text-center">Posição</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Acertou Placar</th>
                <th class="text-center">Gols Vencedor</th>
                <th class="text-center">Gols Perdedor</th>
                <th class="text-center">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($classificacao as $key => $item)
                <tr>
                    <td class="text-center"><b>{{$key + 1}} º</b></td>
                    <td class="text-center">{{$item->name}}</td>
                    <td class="text-center">{{$item->placar}}</td>
                    <td class="text-center">{{$item->gols_vencedor}}</td>
                    <td class="text-center">{{$item->gols_perdedor}}</td>
                    <td class="text-center">{{  $item->placar +  $item->gols_vencedor + $item->gols_perdedor}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection

