<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">{!!$text !!}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <h3>{{ $user }}</h3>
        <div class="table-responsive m-t-40 table-ab">
            <table id="tableDetAgente" class="table display table-bordered table-striped no-wrap">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Subactividad</th>
                        <th>Fecha y Hora</th>
                        <th>Ver comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subActivities as $subActivitiesInfo)
                    <tr>
                        <td>{!! $subActivitiesInfo->bussines !!}</td>
                        <td>{!! $subActivitiesInfo->subtype !!}</td>
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