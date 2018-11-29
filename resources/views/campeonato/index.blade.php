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
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Campeonato</th>
                    <th>É Moderado?</th>
                    <th>Data Inicio do Bolão</th>
                    <th>Data de criação</th>
                    <th>Valor Premiação</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Meu Bolão</td>
                    <td>Brasileirão 2018</td>
                    <td>Sim</td>
                    <td>10/11/2018</td>
                    <td>R$ 200,00</td>
                    <td>
                        <span class="badge badge-success">Active</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal de criação--}}
    @include('campeonato.form')

@endsection

