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
                    <th>Mandante</th>
                    <th>Visitante</th>
                    <th>Data/Hora de Inicio</th>
                    <th>Placar</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($fase->Jogos as $jogo)
                    <tr>
                        <td>
                            <img width="35"
                                 src="{{asset('storage/'.$jogo->time_escudo_mandante)}}" alt="">
                            {{$jogo->time_nome_mandante}}
                        </td>
                        <td>
                            <img width="35"
                                 src="{{asset('storage/'.$jogo->time_escudo_visitante)}}" alt="">
                            {{$jogo->time_nome_visitante}}
                        </td>
                        <td>{{\Carbon\Carbon::parse($jogo->data_jogo)->format('d/m/Y')}} - {{$jogo->hora_jogo}}</td>
                        <td>{{$jogo->resultado_mandante}} X {{$jogo->resultado_visitante}}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#atualizarPlacar{{$jogo->fase_id}}{{$jogo->fase_campeonato_id}}{{$jogo->time_id_mandante}}{{$jogo->time_id_visitante}}">
                                Editar Placar
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{--Modal de criação de jogo--}}
    @include('jogo.jogo-modal', ['id' => $fase->id, 'nome' => $fase->nome])
    @include('fase.form', $fase)

    @foreach($fase->Jogos as $jogo)
        @include('jogo.atualizar-placar', $jogo)
    @endforeach
@endsection


