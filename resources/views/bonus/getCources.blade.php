<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Cursos de capacitaci&oacute;n</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
          <div class="table-responsive m-t-40">
          <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Curso</th>
                                                <th>Penalizaci&oacute;n %</th>
                                                <th>Documento</th>
                                                <th>Fecha limite</th>
                                                <th>Visto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                @foreach($agentBond as $workInfo)
                                                 <tr>
                                                 @if(!empty($workInfo->pkCourse))
                                                <td>{!!$workInfo->code !!} - {!!$workInfo->name !!}</td>
                                                @else
                                                 <td>{!!$workInfo->code !!} - {!!$workInfo->nameCourse !!}</td>
                                                @endif
                                                 <td>{{$workInfo->penality }} %</td>
                                                 @if(!empty($workInfo->document))
                                                 <td><a target="_blank" href="/images/training/{{$workInfo->document}}">{{$workInfo->document}}</a> </td>
                                                 @else
                                                 <td>Sin subir</td>
                                                 @endif
                                                 <td>
                                                     {{$workInfo->expiration}} {{ $workInfo->expiration_hour }}
                                                 </td>
                                                 <td>
                                               @if($workInfo->isView == 1)
                                                 <button disabled type="button" class="btn btn-success" data-id="{{ $workInfo->pkCourses_by_capacitation }}"><span class="ti-check"></span> </button>
                                                @else
                                                <button type="button" class="btn btn-secondary updateToView" data-id="{{ $workInfo->pkCourses_by_capacitation }}"><span class="ti-check-box"></span></button>
                                                @endif
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