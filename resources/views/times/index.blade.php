@extends('layouts.app')

@section('content')
    <script src="js/times.js"></script>

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
            <i class="fa icon-diamond"></i> Times
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formTime"
                    style="position: absolute;right: 20px;top: 10px;">
                <i class="fa icon-plus"></i> Criar Time
            </button>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped">
                <thead>
                <tr>
                    <th style="width:100px;">Escudo</th>
                    <th>Nome</th>
                    <th>Alias</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($times as $time)
                    <tr>
                        <td style="text-align:center">
                            <img width="35" style="border-radius: 31px !important;"
                                 src="{{asset('storage/'.$time->escudo)}}" alt="">
                        </td>
                        <td>{{$time->nome}}</td>
                        <td>{{$time->alias}}</td>
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
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal Criação de bolão--}}
    @include('times.form')
    {{--Formes de atualização--}}
    @foreach($times as $time)
        @include('times.form', $time)
    @endforeach
    {{--Modal de deleção--}}
    @foreach($times as $time)
        @include('times.delete', $time)
    @endforeach
@endsection

