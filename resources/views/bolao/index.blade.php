@extends('layouts.app')

@section('content')
    <script src="js/bolao.js"></script>

    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-diamond"></i> Bolões
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBolao"
                    style="position: absolute;right: 20px;top: 10px;">
                <i class="fa icon-plus"></i> Criar Bolão
            </button>
        </div>
        <div class="card-body">
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
                @foreach($boloes as $bolao)
                    <tr>
                        <td>{{$bolao->nome}}</td>
                        <td>{{$bolao->campeonato_nome}}</td>
                        <td>{{ $bolao->is_moderado ? 'Sim' : 'Não' }}</td>
                        <td>{{ \Carbon\Carbon::parse($bolao->data_inicio)->format('d/m/Y')  }}</td>
                        <td>{{ \Carbon\Carbon::parse($bolao->created_at)->format('d/m/Y')  }}</td>
                        <td>R$ {{ number_format($bolao->valor_premiacao, 2)  }}</td>
                        <td>
                            <div class="float-right">
                                <a class="btn btn-sm btn-primary" style="color: white"
                                   href="boloes/{{$bolao->id}}/classificacao"> Visualizar
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @include('bolao.form', ['campeonatos' => $campeonatos])

@endsection

