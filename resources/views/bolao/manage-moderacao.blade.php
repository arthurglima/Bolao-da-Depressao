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
                    <a class="nav-link active" href="moderacao">Moderação</a>
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
                <th>Nome</th>
                <th>E-mail</th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($moderacao as $item)
                <tr>
                    <td>{{$item->nome}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                        <button class="btn btn-sm btn-success"
                                data-toggle="modal"
                                data-target="#confirmaModeracao{{$item->id}}"
                                style="color: white">
                            Aceitar
                        </button>
                        <button class="btn btn-sm btn-danger"
                                data-toggle="modal"
                                data-target="#recusaModeracao{{$item->id}}"
                                style="color: white">
                            Recusar
                        </button>
                    </td>
                </tr>
            @endforeach
            @if(count($moderacao) == 0)
                <tr>
                    <td> Sem convidados para confirmar</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    @foreach($moderacao as $item)
        @include('bolao.confirm-moderacao', ['user' => $item]);
        @include('bolao.recusa-moderacao', ['user' => $item]);
    @endforeach

@endsection

