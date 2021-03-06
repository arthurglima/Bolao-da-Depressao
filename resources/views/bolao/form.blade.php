<div class="modal fade" id="createBolao"
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
                    <h5 class="modal-title" id="createBolaoLabel">Criar novo bolão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="campeonato">Campeonato</label>
                            <select class="form-control" id="campeonato" name="campeonato_id" required>
                                <option></option>
                                @foreach($campeonatos as $campeonato)
                                    <option value="{{$campeonato->id}}">{{$campeonato->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col col-6">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required
                                   placeholder="Digite o nome do bolão">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="emoderado">É moderado?</label>
                            <select class="form-control" id="emoderado" name="is_moderado" required>
                                <option value="1">Sim - Eu preciso aprovar a participação</option>
                                <option selected="selected" value="0">Não - Todo mundo pode participar</option>
                            </select>
                        </div>
                        <div class="form-group col col-6">
                            <label for="can_buscar">Aparece nas buscas?</label>
                            <select class="form-control" id="can_buscar" name="can_buscar" required>
                                <option value="1">Sim</option>
                                <option selected="selected" value="0">Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="dataInicio">Data de Inicio</label>
                            <input id="dataInicio" name="data_inicio" type='date' class="form-control" required/>
                        </div>
                        <div class="form-group col col-6">
                            <label for="nome">Valor da premiação</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                </div>
                                <input class="form-control" id="valor_premiacao" name="valor_premiacao" required
                                       placeholder="0.00" type="number" min="1" step="any">
                            </div>
                        </div>
                    </div>
                    <div class="navbar navbar-light bg-light">
                        <div class="navbar-brand" style="font-size: 16px" href="#">Configurações do bolão</div>
                        <small>(Pontuações)</small>
                    </div>

                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="placar">Pontos do placar</label>
                            <input id="placar" name="pontos_placar" type='number' value="1" class="form-control"
                                   required/>
                        </div>
                        <div class="form-group col col-6">
                            <label for="vencedor">Pontos do gols do vencedor</label>
                            <input id="vencedor" name="pontos_gol_vencedor" type='number' value="1" class="form-control"
                                   required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col col-12">
                            <label for="perdedor">Pontos do gols do perdedor</label>
                            <input id="perdedor" name="pontos_gol_perdedor" type='number' value="1" class="form-control"
                                   required/>
                        </div>
                    </div>
                    <div class="navbar navbar-light bg-light">
                        <div class="navbar-brand" style="font-size: 16px" href="#">Configurações de desempate</div>
                    </div>
                    <div class="row">
                        <div class="form-group col col-12">
                            <select class="form-control" id="desempate" name="desempate" required>
                                <option value="0" selected>
                                    Quem criou palpites mais cedo
                                </option>
                                <option value="1">
                                    Quem criou palpites mais proximo do horário do jogo
                                </option>
                                <option value="2">
                                    Quem criou palpites mais cedo e não editou
                                </option>
                                <option value="3">
                                    Quem criou palpites mais proximo do horário do jogo e não editou
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>