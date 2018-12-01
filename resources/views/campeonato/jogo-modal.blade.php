<!-- Modal Criação de bolão-->
<div class="modal fade" id="addJogoFase{{$id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="formJogo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('times', ['id' => $id ?? null])  }}" enctype="multipart/form-data">
                @if(isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Adicionar Jogo a {{$nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="fase_campeonato_id" value="{{$fase->campeonato_id}}">
                    <input type="hidden" name="fase_id" value="{{$fase->id}}">
                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="campeonato">Data do jogo</label>
                            <input required class="form-control" type="date" name="data_jogo"/>
                        </div>
                        <div class="form-group col col-6">
                            <label for="campeonato">Hora do jogo</label>
                            <input required class="form-control" type="time" name="hora_jogo"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="campeonato">Time mandante</label>
                            <input type="text" class="form-control" id="time_id_mandante" name="time_id_mandante"
                                   required
                                   value="{{$nome ?? null}}"
                                   placeholder="Digite o nome do time">
                        </div>
                        <div class="form-group  col col-6">
                            <label for="alias">Time visitante</label>
                            <input type="text" class="form-control" id="time_id_visitante" name="time_id_visitante"
                                   value="{{$alias  ?? null}}" required
                                   placeholder="Digite o nome do bolão">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
