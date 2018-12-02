@extends('layouts.app')

@section('content')
    <script src="js/times.js"></script>
    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-people"></i> Times
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formTime"
                    style="position: absolute;right: 20px;top: 10px;">
                <i class="fa icon-plus"></i> Criar Time
            </button>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Apelido</th>
                    <th>Data de criação</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($times as $time)
                    <tr>
                        <td><img width="35"
                                 src="{{asset('storage/'.$time->escudo)}}" alt=""> {{$time->nome}}
                        </td>
                        <td>{{$time->alias}}</td>
                        <td>{{$Carbon::parse($time->created_at)->format('d/m/Y')}}</td>
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
                @endforeach
                @if(count($times) == 0)
                    <tr>
                        <td style="text-align:center"></td>
                        <td>Nenhum time foi encontrado</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal Criação de bolão--}}
    @include('times.form')
    @foreach($times as $time)
        {{--Formes de atualização--}}
        @include('times.form', $time)
        {{--Modal de deleção--}}
        @include('times.delete', $time)
    @endforeach
@endsection

