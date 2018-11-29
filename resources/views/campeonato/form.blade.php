<!-- Modal Criação de bolão-->
<div class="modal fade" id="formCampeonato{{$id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('campeonato', ['id' => $id ?? null])  }}" enctype="multipart/form-data">
                @if(isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                @csrf
                <div class="modal-header">
                    @if(isset($id))
                        <h5 class="modal-title" id="bolaoLabel">Atualizar campeonato</h5>
                    @else
                        <h5 class="modal-title" id="bolaoLabel">Criar campeonato</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome do campeonato</label>
                        <input type="text" class="form-control" id="nome" required
                               value="{{$nome  ?? null}}" name="nome"
                               placeholder="Digite o nome do bolão">
                    </div>
                    <div class="form-group">
                        <label for="nome">Quantidade de rodadas</label>
                        <input type="number" class="form-control" id="fase_qtd" name="fase_qtd" required
                               value="{{$fase_qtd  ?? null}}" @if(!is_null($fase_qtd ?? null)) disabled @endif
                               placeholder="Digite o nome do bolão">
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
