<!-- Modal Criação de bolão-->
<div class="modal fade" id="editFase{{$id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('fase', ['id' => $id ?? null])  }}" enctype="multipart/form-data">
                @method('PUT') @csrf
                <div class="modal-header">
                    @if(isset($id))
                        <h5 class="modal-title" id="bolaoLabel">Editar rodada</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col col-12">
                            <label for="nome">Nome da rodada</label>
                            <input type="text" class="form-control" id="nome" required
                                   value="{{$nome  ?? null}}" name="nome"
                                   placeholder="Digite o nome do bolão">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="nome">Data de inicio da rodada</label>
                            <input type="date" class="form-control" id="data_inicial" required
                                   value="{{$data_inicial  ?? null}}" name="data_inicial"
                                   placeholder="Digite o nome do bolão">
                        </div>
                        <div class="form-group col col-6">
                            <label for="nome">Data do final da rodada</label>
                            <input type="date" class="form-control" id="data_final" required
                                   value="{{$data_final  ?? null}}" name="data_final"
                                   placeholder="Digite o nome do bolão">
                        </div>
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
