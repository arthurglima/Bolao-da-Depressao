@extends('layouts.app')

@section('content')
    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-arrow-right-circle"></i> {{$campeonato->nome}} - {{$campeonato->fase_qtd}} Rodadas
        </div>
        <div class="card-body">
            @foreach($campeonato->Fases as $fase)
                <div id="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" id="heading{{$fase->id}}" role="tab">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" href="#collapse{{$fase->id}}" aria-expanded="true"
                                   aria-controls="collapse{{$fase->id}}">{{$fase->nome}}</a>
                            </h5>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addJogo"
                                    style="position: absolute;right: 20px;top: 10px;">
                                <i class="fa icon-plus"></i> Adicionar Jogo
                            </button>
                        </div>
                        <div class="collapse" id="collapse{{$fase->id}}" role="tabpanel"
                             aria-labelledby="heading{{$fase->id}}">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection

