<!-- Modal Criação de bolão-->
<div class="modal fade" id="formTime{{$id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
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
                    @if(isset($id))
                        <h5 class="modal-title" id="bolaoLabel">Atualizar time</h5>
                    @else
                        <h5 class="modal-title" id="bolaoLabel">Criar novo time</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="campeonato">Nome do time</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                               value="{{$nome ?? null}}"
                               placeholder="Digite o nome do time">
                    </div>
                    <div class="form-group">
                        <label for="alias">Apelido</label>
                        <input type="text" class="form-control" id="alias" name="alias"
                               value="{{$alias  ?? null}}"
                               placeholder="Digite o nome do bolão">
                    </div>
                    <div class="form-group">
                        <label for="escudo">Escudo</label><br/>
                        <input type="file" name="escudo">
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
