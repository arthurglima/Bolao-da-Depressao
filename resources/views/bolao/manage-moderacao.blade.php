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
            <a class="nav-link" href="palpites">Palpites</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="moderacao">Moderação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="convidar">Convidar Amigos</a>
        </li>
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

