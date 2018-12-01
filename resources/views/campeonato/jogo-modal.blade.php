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
                    <div class="form-group">
                        <label for="campeonato">Campeonato</label>
                        <input type="text" class="form-control" id="campeonato_id" name="campeonato_id"
                               required
                               value="{{$nome ?? null}}"
                               placeholder="Digite o nome do time">
                    </div>
                    <div class="form-group">
                        <label for="alias">Apelido</label>
                        <input type="text" class="form-control" id="alias" name="alias"
                               value="{{$alias  ?? null}}" required
                               placeholder="Digite o nome do bolão">
                    </div>
                    <div class="form-group">
                        <label for="escudo">Escudo</label><br/>
                        <input size="3" accept="image/jpeg,image/png" type="file" name="escudo">
                    </div>
                </div>
                <div class="modal-footer">
                    @if(isset($id))
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    @else
                        <button type="submit" class="btn btn-primary">Criar</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
