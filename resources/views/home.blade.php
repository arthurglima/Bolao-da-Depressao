@extends('layouts.app')

@section('content')
    <div class="justify-content-center" style="width: 70%;margin: 0 auto;">
        <form action="{{ url('home')  }}" method="GET">
            <div class="input-group mb-3" style="margin-top:50px">
                @method('GET') @csrf
                <input type="text" class="form-control" placeholder="Buscar bolão"
                       aria-label="Buscar bolão" aria-describedby="basic-addon2" name="query">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card" style="margin: 30px">
        <div class="card-header">
            @if($busca)
                Busca por "{{$query}}"
            @else
                Bolões Favoritos
            @endif
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Campeonato</th>
                    <th>Data Inicio do Bolão</th>
                    <th>Valor Premiação</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($boloes as $bolao)
                    <tr>
                        <td>{{$bolao->nome}}</td>
                        <td>{{$bolao->campeonato_nome}}</td>
                        <td>{{ \Carbon\Carbon::parse($bolao->data_inicio)->format('d/m/Y')  }}</td>
                        <td>R$ {{ number_format($bolao->valor_premiacao, 2)  }}</td>
                        <td>
                            @if(!$bolao->e_dono)
                                <form action="{{url("boloes/{$bolao->id}/participar")}}" method="POST">
                                    @method('POST') @csrf
                                    @if($bolao->is_moderado == 0 && $bolao->esta_aprovado == null)
                                        <div class="float-right">
                                            <button class="btn btn-sm btn-success" style="color: white"
                                                    type="submit"> Participar
                                            </button>
                                        </div>
                                    @elseif ($bolao->is_moderado == 1 && $bolao->esta_aprovado == null)
                                        <div class="float-right">
                                            <button class="btn btn-sm btn-primary" style="color: white"
                                                    type="submit"> Pedir entrada
                                            </button>
                                        </div>
                                    @elseif ($bolao->is_moderado == 0 && ($bolao->esta_aprovado == 1 && !$bolao->is_inactive))
                                        <div class="float-right">
                                            <a class="btn btn-sm btn-secondary" style="color: white"
                                               href="boloes/{{$bolao->id}}/classificacao"> Visualizar
                                            </a>
                                        </div>
                                    @elseif($bolao->is_moderado == 1 && $bolao->esta_aprovado == 0)
                                        <div class="float-right">
                                            <button class="btn btn-sm btn-primary" style="color: white"
                                                    type="submit"> Aguardando aprovação
                                            </button>
                                        </div>
                                    @elseif($bolao->is_moderado == 1 && ($bolao->esta_aprovado == 1 && !$bolao->is_inactive))
                                        <div class="float-right">
                                            <a class="btn btn-sm btn-secondary" style="color: white"
                                               href="boloes/{{$bolao->id}}/classificacao"> Visualizar
                                            </a>
                                        </div>
                                    @endif
                                </form>
                            @else
                                @if(!$bolao->is_inactive)
                                    <div class="float-right">
                                        <a class="btn btn-sm btn-secondary" style="color: white"
                                           href="boloes/{{$bolao->id}}/classificacao"> Visualizar
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $boloes->links() }}
        </div>
@endsection
