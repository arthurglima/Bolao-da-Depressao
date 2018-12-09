<div class="modal fade" id="recusaModeracao{{$user->id}}"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('boloes', ['id' => $id ?? null])  }}">
                @csrf
                @if(isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="createBolaoLabel">Recusa {{$user->nome}} no bolão?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ao apertar no "Recusar!" estará recusando a participação de {{$user->nome}} no bolão.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Recusar!</button>
                </div>
            </form>
        </div>
    </div>
</div>