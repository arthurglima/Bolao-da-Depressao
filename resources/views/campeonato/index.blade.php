@extends('layouts.app')

@section('content')
    <script src="js/bolao.js"></script>

    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-diamond"></i> Bolões
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
                    <th>Data de criação</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Brasileirão 2018</td>
                    <td>10/11/2018</td>
                    <td>

                        <div class="float-right">
                            <button class="btn btn-sm" data-toggle="modal"
                                    data-target="#deleteTime{{$time->id ?? null}}"> Remover
                            </button>
                        </div>
                        <div class="float-right">

                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#formTime{{$time->id ?? null}}">
                                Editar
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal de criação--}}
    @include('campeonato.form')

@endsection

