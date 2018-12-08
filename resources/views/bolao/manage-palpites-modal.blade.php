<!-- Modal Criação de bolão-->
<div class="modal fade" id="formBolaoPalpite"
     tabindex="-1" role="dialog"
     aria-labelledby="createBolaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">Jogos da Rodada ...</div>

            <div class="modal-body">

                <form method="POST"
                      action="{{ url('campeonato', ['id' => $id ?? null])  }}"
                      enctype="multipart/form-data">

                </form>
            </div>
        </div>
    </div>
</div>
