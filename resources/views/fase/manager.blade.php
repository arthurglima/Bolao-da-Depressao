@extends('layouts.app')

@section('content')
    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-arrow-right-circle"></i> {{$campeonato->nome}} - {{$fase->nome}}
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addJogoFase{{$fase->id ?? null}}"
                    style="position: absolute;right: 20px;top: 10px;">
                <i class="fa icon-plus"></i> Adicionar Jogo
            </button>
        </div>
        <div class="card-body row">
            <table class="table table-responsive-sm table-striped">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Yiorgos Avraamu</td>
                    <td>Member</td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>

    {{--Modal de criação de jogo--}}
    @include('campeonato.jogo-modal', ['id' => $fase->id, 'nome' => $fase->nome])

@endsection

