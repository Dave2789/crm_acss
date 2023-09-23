<div class="modal-content">
    <div class="modal-header">
    <h2 class="modal-title" id="modalAgentesCLabel">Detalle de "{!! $activity !!}"</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <h3>{!!  $text !!}</h3>
        <div class="table-responsive m-t-40 table-ab">
            <table id="tableDetActividad" class="table display table-bordered table-striped no-wrap">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Subactividad</th>
                        <th>Agente</th>
                        <th>Empresa</th>
                        <th>Fecha y Hora</th>
                        <th>Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subActivities as $subActivitiesInfo)
                    <tr>
                        <td>{!! $subActivitiesInfo->type !!}</td>
                        <td>{!! $subActivitiesInfo->subtype !!}</td>
                        <td>{!! $subActivitiesInfo->agent !!}</td>
                        <td>{!! $subActivitiesInfo->bussines !!}</td>
                        <td>{{ $subActivitiesInfo->execution_date }} {{ $subActivitiesInfo->execution_hour }}</td>
                        <td>{!! $subActivitiesInfo->comment !!}</td>
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