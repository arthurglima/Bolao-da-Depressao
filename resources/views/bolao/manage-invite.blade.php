@extends('layouts.app')

@section('content')
    <div style="padding: 15px">
        <h3>{{$bolao->nome}}</h3>
        <small>{{$bolao->campeonato_nome}}</small>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="classificacao">Classificação</a>
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
                <a class="nav-link active" href="convidar">Convidar Amigos</a>
            </li>
        @endif
    </ul>
    <div class="content" style="padding: 15px">
        <table class="table table-responsive-md table-striped">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Campeonato</th>
                <th>É Moderado?</th>
                <th>Data Inicio do Bolão</th>
                <th>Data de criação</th>
                <th>Valor Premiação</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection

