<!-- Modal Criação de bolão-->
<div class="modal fade" id="addJogoFase{{$id ?? null}}"
     tabindex="-1" role="dialog"
     aria-labelledby="formJogo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('jogo')  }}" enctype="multipart/form-data">
                @method('POST') @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bolaoLabel">Adicionar Jogo a {{$nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="fase_campeonato_id" value="{{$fase->campeonato_id}}">
                    <input type="hidden" name="fase_id" value="{{$fase->id}}">
                    <div class="row">
                        <div class="form-group col col-6">
                            <label for="campeonato">Data do jogo</label>
                            <input required class="form-control" type="date" name="data_jogo"/>
                        </div>
                        <div class="form-group col col-6">
                            <label for="campeonato">Hora do jogo</label>
                            <input required class="form-control" type="time" name="hora_jogo"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col col-6 ui-widget">
                            <label for="campeonato">Time mandante</label>
                            <input required class="form-control" type="text" name="time_mandante" id="time_mandante"/>
                            <input required class="form-control" type="hidden" name="time_id_mandante"
                                   id="time_id_mandante"/>
                        </div>
                        <div class="form-group  col col-6">
                            <label for="alias">Time visitante</label>
                            <input required class="form-control" type="text" name="time_visitante" id="time_visitante"/>
                            <input required class="form-control" type="hidden" name="time_id_visitante"
                                   id="time_id_visitante"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .ui-autocomplete {
        z-index: 999999999999999999999
    }
</style>

<script>
  $("#time_mandante").autocomplete({
    source: '/times/getbyname',
    minLength: 2,
    select: function (event, ui) {
      $("#time_mandante").val(ui.item.value);
      $("#time_id_mandante").val(ui.item.id);
      console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
      return false;
    }
  });

  $("#time_visitante").autocomplete({
    source: '/times/getbyname',
    minLength: 2,
    select: function (event, ui) {
      $("#time_visitante").val(ui.item.value);
      $("#time_id_visitante").val(ui.item.id);
      console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
      return false;
    }
  });
</script>
