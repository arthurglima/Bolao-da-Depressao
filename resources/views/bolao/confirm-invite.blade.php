<div class="modal fade" id="convidar{{$item->id}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url("/boloes/{$bolao_id}/convidar/user/{$item->id}")  }}">
                @method('POST') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createBolaoLabel">Confirma convite de {{$item->name}} no bolão?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bolao_id" value="{{$bolao_id}}">
                    <input type="hidden" name="users_id" value="{{$item->id}}">
                    <input type="hidden" name="esta_aprovado" value="0">
                    Ao apertar no "Sim!" estará convidando <b>{{$item->name}}</b> para o bolão.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Sim!</button>
                </div>
            </form>
        </div>
    </div>
</div>