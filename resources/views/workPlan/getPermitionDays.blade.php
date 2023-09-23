<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">D&iacute;as de permiso</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
          <button type="button" class="btn btn-info d-none d-lg-block m-l-15" id="addPermitionDay" data-id="{!!$pkWorkingPlan!!}"><i class="fa fa-plus-circle"></i> Agregar permiso</button>
          <div class="table-responsive m-t-40">
          <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>D&iacute;a</th>
                                                <th>Horas de permiso</th>
                                                <th>Comentario</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                @foreach($permition as $permitionInfo)
                                                 <tr>
                                                <td>{!!$permitionInfo->day !!}</td>
                                                <td>{!!$permitionInfo->hours !!}</td>
                                                <td>{!!$permitionInfo->comment !!}</td>
                                                 <td class="text-center">
                                                    <button class="btn btn-danger btn-sm btn_deleteDayPermition" data-work="{!!$pkWorkingPlan!!}" data-id="{!! $permitionInfo->pkPermitionDay!!}"><span class="ti-close"></span></button> 
                                                 </td>
                                                 </tr>
                                                @endforeach
                                           
                                        </tbody>
                                    </table>
          </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>