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
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createTime"
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
                </tr>
                </thead>
                <tbody>
                @foreach($times as $time)
                    <tr>
                        <td style="text-align:center">
                            <img width="50" style="border-radius: 31px !important;"
                                 src="{{asset('storage/'.$time->escudo)}}" alt="">
                        </td>
                        <td>{{$time->nome}}</td>
                        <td>{{$time->alias}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Criação de bolão-->
    <div class="modal fade" id="createTime"
         tabindex="-1" role="dialog"
         aria-labelledby="createBolaoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ url('times')  }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBolaoLabel">Criar novo time</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="campeonato">Nome do time</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                   placeholder="Digite o nome do time">
                        </div>
                        <div class="form-group">
                            <label for="alias">Apelido</label>
                            <input type="text" class="form-control" id="alias" name="alias"
                                   placeholder="Digite o nome do bolão">
                        </div>
                        <div class="form-group">
                            <label for="escudo">Escudo</label><br/>
                            <input type="file" name="escudo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

