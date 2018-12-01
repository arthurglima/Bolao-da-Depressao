<!-- Modal Criação de bolão-->
<div class="modal fade" id="chooseFase{{$campeonato_id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="formJogo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="GET" action="{{ url('fase/'.$campeonato_id.'/edit')  }}">
                @method('GET') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Escolha a rodada para gerenciar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fase">Rodada</label>
                        <select name="fase" id="fase" class="form-control">
                            @foreach($fases as $fase)
                                <option value="{{$fase->id}}">{{$fase->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gerenciar</button>
                </div>
            </form>
        </div>
    </div>
</div>
