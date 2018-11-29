@extends('layouts.app')

@section('content')
    <script src="js/bolao.js"></script>

    @if(@session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{@session('success')}}</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-layers"></i> Campeonatos
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formCampeonato"
                    style="position: absolute;right: 20px;top: 10px;">
                <i class="fa icon-plus"></i> Criar campeonato
            </button>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade de rodadas</th>
                    <th>Data de criação</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($campeonatos as $campeonato)
                    <tr>
                        <td>{{$campeonato->nome}}</td>
                        <td>{{$campeonato->fase_qtd}}</td>
                        <td>{{$Carbon::parse($campeonato->created_at)->format('d/m/Y')}}</td>
                        <td>
                            <div class="float-right">
                                <button class="btn btn-sm" data-toggle="modal"
                                        data-target="#deleteCampeonato{{$campeonato->id ?? null}}"> Remover
                                </button>
                            </div>
                            <div class="float-right">
                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#formCampeonato{{$campeonato->id ?? null}}">
                                    Editar
                                </button>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-sm btn-warning"> Gerenciar
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if(count($campeonatos) == 0)
                    <tr>
                        <td style="text-align:center"></td>
                        <td>Nenhum campeonato foi encontrado</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal de criação--}}
    @include('campeonato.form')
    @foreach($campeonatos as $campeonato)
        {{--Formes de atualização--}}
        @include('campeonato.form', $campeonato)
        {{--Modal de deleção--}}
        @include('campeonato.delete', $campeonato)
    @endforeach
@endsection

