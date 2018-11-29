<!-- Modal Criação de bolão-->
<div class="modal fade" id="formCampeonato"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBolaoLabel">Criar campeonato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="nome">Nome do campeonato</label>
                        <input type="text" class="form-control" id="nome" required
                               placeholder="Digite o nome do bolão">
                    </div>
                    <div class="form-group">
                        <label for="nome">Quantidade de fases</label>
                        <input type="number" class="form-control" id="nome" required
                               placeholder="Digite o nome do bolão">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </div>
</div>
