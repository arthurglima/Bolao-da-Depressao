<!-- Atualização de placar -->
<div class="modal fade"
     id="atualizarPlacar{{$id}}"
     tabindex="-1" role="dialog"
     aria-labelledby="formJogo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('jogo', ['id' => $id])  }}">
                @method('PUT') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Modificar Placar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="fase_id" value="{{$fase_id}}" name="fase_id">
                    <input type="hidden" id="fase_campeonato_id" value="{{$fase_campeonato_id}}"
                           name="fase_campeonato_id">
                    <input type="hidden" id="time_id_mandante" value="{{$time_id_mandante}}" name="time_id_mandante">
                    <input type="hidden" id="time_id_visitante" value="{{$time_id_visitante}}" name="time_id_visitante">
                    <div class="row">
                        <div class="col text-center">
                            <img width="35"
                                 src="{{asset('storage/'.$time_escudo_mandante)}}" alt=""><br>
                            {{$time_apelido_mandante}}
                        </div>
                        <div class="form-group col text-center">
                            <input type="text" class="form-control" id="resultado_mandante" required
                                   value="{{$resultado_mandante  ?? null}}" name="resultado_mandante"
                                   placeholder="">
                        </div>
                        <div class="form-group col text-center">
                            <input type="text" class="form-control" id="resultado_visitante" required
                                   value="{{$resultado_visitante  ?? null}}" name="resultado_visitante"
                                   placeholder="">
                        </div>
                        <div class="col text-center">
                            <img width="35"
                                 src="{{asset('storage/'.$time_escudo_visitante)}}" alt=""><br>
                            {{$time_apelido_visitante}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
