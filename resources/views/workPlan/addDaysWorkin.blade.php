<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Añadir D&iacute;as de Trabajo</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-md-12">                                           
            <div class="nav-small-cap mb-4">- - - Semana laboral</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="pres" value="0" id="all">
                            <label class="custom-control-label" for="all">Todos</label>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($arrayDaysFal as $key => $infoDays)
            <div class="row">
                <div class="col-md-2 col-sm-4">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="pres" value="{!!$key!!}" id="{!!$infoDays !!}">
                            <label class="custom-control-label" for="{!!$infoDays !!}">{!!$infoDays !!}</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-8">
                    <div class="form-group">
                          <input id="slc{!!$infoDays!!}" class="form-control" type="number" name="quantity" min="1" max="8">
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-4 col-sm-8">
                <div class="form-actions">
                    <button type="button" class="btn btn-success" id="btn_addDays" data-id="{!! $pkWorkingPlan  !!}"> <i class="fa fa-check"></i> Agregar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="backDays" data-id="{!!$pkWorkingPlan !!}">Regresar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<script>
    $("#all").change(function () {
        //Si el checkbox está seleccionado
        if ($(this).is(":checked")) {
            $("input:checkbox").each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $("input:checkbox").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
</script>