<!-- Modal Criação de bolão-->
<div class="modal fade" id="formBolaoPalpite"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST"
                  action="{{ url('boloes/palpites')  }}"
                  enctype="multipart/form-data">
                @method('POST') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Jogos da {{$possibles[0]->rodada}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row" style="margin: 0 auto">
                        @foreach($possibles as $key => $possible)
                            <div class="card col col-6">
                                @if(is_null($possible->palpite_mandante) || is_null($possible->palpite_visitante == null))
                                    <div class="modal-header">
                                        <smal class="modal-title" id="bolaoLabel">Pendente</smal>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <input type="hidden" id="palpite_id" value="{{$possible->id}}"
                                           name="palpites[{{$key}}][id]"/>

                                    <input type="hidden" id="bolao_has_user_bolao_id" value="{{$bolao->id}}"
                                           name="palpites[{{$key}}][bolao_has_user_bolao_id]"/>

                                    <input type="hidden" id="bolao_has_user_users_id"
                                           value="{{\Illuminate\Support\Facades\Auth::user()->id}}"
                                           name="palpites[{{$key}}][bolao_has_user_users_id]"/>

                                    <input type="hidden" id="jogo_id" value="{{$possible->jogo_id}}"
                                           name="palpites[{{$key}}][jogo_id]"/>

                                    <div class="row">
                                        <div class="col text-center">
                                            <img width="35"
                                                 src="{{asset('storage/'.$possible->mandante_escudo)}}" alt=""><br>
                                            {{$possible->mandante_alias}}
                                        </div>
                                        <div class="form-group col text-center">
                                            <input type="text" class="form-control" id="resultado_mandante" required
                                                   value="{{$possible->palpite_mandante  ?? null}}"
                                                   name="palpites[{{$key}}][palpite_mandante]"
                                                   placeholder="">
                                        </div>
                                        <div class="form-group col text-center">
                                            <input type="text" class="form-control" id="resultado_visitante" required
                                                   value="{{$possible->palpite_visitante  ?? null}}"
                                                   name="palpites[{{$key}}][palpite_visitante]"
                                                   placeholder="">
                                        </div>
                                        <div class="col text-center">
                                            <img width="35"
                                                 src="{{asset('storage/'.$possible->visitante_escudo)}}" alt=""><br>
                                            {{$possible->visitante_alias}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar palpites</button>
                </div>
            </form>
        </div>
    </div>
</div>
