@extends('layouts.app')

@section('content')
    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-arrow-right-circle"></i>
            {{$campeonato->nome}} - {{$fase->nome}}
            @if($fase->data_inicial !== null)| De {{$Carbon::parse($fase->data_inicial)->format('d/m/Y')}} @endif -
            @if($fase->data_final !== null) até {{$Carbon::parse($fase->data_final)->format('d/m/Y')}} @endif
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editFase{{$fase->id ?? null}}"
                    style="position: absolute;right: 150px;top: 10px;">
                <i class="fa icon-note"></i> Editar rodada
            </button>
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
    @include('fase.form', $fase)

@endsection

