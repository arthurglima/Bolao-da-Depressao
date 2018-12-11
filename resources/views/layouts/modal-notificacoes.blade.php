<!-- Modal Criação de bolão-->
<div class="modal fade" id="notificacoes{{\Illuminate\Support\Facades\Auth::user()->id}}"
     tabindex="-1" role="dialog"
     aria-labelledby="formJogo" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('jogo')  }}" enctype="multipart/form-data">
                @method('POST') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Notificações</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive-md table-striped">
                        <tbody>
                        @foreach(\Illuminate\Support\Facades\Auth::user()->getNotificacoes() as $notificacao)
                            <tr>
                                <td>{{$notificacao->notificacao}}</td>
                                <td>{{ \Carbon\Carbon::parse($notificacao->created_at)->format('d/m/Y H:i:s')  }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
