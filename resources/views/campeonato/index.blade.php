@extends('layouts.app')

@section('content')
    <script src="js/bolao.js"></script>

    <div class="card" style="margin: 15px">
        <div class="card-header">
            <i class="fa icon-diamond"></i> Bolões
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBolao"
                    style="position: absolute;right: 20px;top: 10px;">
                <i class="fa icon-plus"></i> Criar Bolão
            </button>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Campeonato</th>
                    <th>É Moderado?</th>
                    <th>Data Inicio do Bolão</th>
                    <th>Data de criação</th>
                    <th>Valor Premiação</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Vishnu Serghei</td>
                    <td>2012/01/01</td>
                    <td>Member</td>
                    <td>Member</td>
                    <td>Member</td>
                    <td>
                        <span class="badge badge-success">Active</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Criação de bolão-->
    <div class="modal fade" id="createBolao"
         tabindex="-1" role="dialog"
         aria-labelledby="createBolaoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBolaoLabel">Criar novo bolão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="campeonato">Campeonato</label>
                            <select class="form-control" id="campeonato">
                                <option>1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome"
                                   placeholder="Digite o nome do bolão">
                        </div>
                        <div class="form-group">
                            <label for="emoderado">É moderado?</label>
                            <select class="form-control" id="emoderado">
                                <option value="true">Sim - Eu preciso aprovar a participação</option>
                                <option selected="selected" value="false">Não - Todo mundo pode participar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dataInicio">Data de Inicio</label>
                            <input id="dataInicio" type='date' class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="dataInicio">Descrição</label>
                            <textarea class="form-control" name="descricao" id="dataInicio" cols="30"
                                      rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Criar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

