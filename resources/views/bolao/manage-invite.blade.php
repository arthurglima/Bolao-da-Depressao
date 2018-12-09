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
        <form method="POST" action="{{ url('boloes/buscarpessoas', ['id' => $id ?? null])  }}"
              class="form-inline my-2 my-lg-0">
            @csrf @method('POST')
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nome ou email"
                   aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>

        @if(!isset($seached) || count($seached) !== 0)
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
                @foreach($seached as $item)
                    <tr>
                        <td>{{$item->nome}}</td>
                        <td>{{$item->email}}</td>
                        <td>
                            <button class="btn btn-sm btn-success"
                                    data-toggle="modal"
                                    data-target="#convidar{{$item->id}}"
                                    style="color: white">
                                Convidar
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

