<div class="modal fade" id="confirmaModeracao{{$user->id}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('boloes/decisaomoderacao')  }}">
                @csrf
                @if(isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="createBolaoLabel">Confirma {{$user->nome}} no bolão?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bolao_id" value="{{$user->bolao_id}}">
                    <input type="hidden" name="users_id" value="{{$user->id}}">
                    <input type="hidden" name="esta_aprovado" value="1">
                    Ao apertar no "Sim!" estará aceitando {{$user->nome}} no bolão.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Sim!</button>
                </div>
            </form>
        </div>
    </div>
</div>