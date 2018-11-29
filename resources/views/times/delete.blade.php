<!-- Modal Criação de bolão-->
<div class="modal fade" id="deleteTime{{$id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('times', ['id' => $id ?? null])  }}">
                @method('DELETE') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Remover {{$nome}}?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="card-text">O time será removido do sistema permanentemente, deseja continuar?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm">Sim!!</button>
                    <button type="button"
                            class="btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close">Não
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
