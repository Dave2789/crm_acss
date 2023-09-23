<table id="actividades" class="table display table-bordered table-striped no-wrap">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Fecha de vencimiento</th>
                <th>Hora de Vencimiento</th>
                <th>Empresa</th>
                <th>Campaña</th>
                <th>Usuario</th>
                <th>Asignado</th>
                <th>Comentario</th>
                <th>Título</th>
               <!-- <th>Detalle</th>-->
                
            </tr>
        </thead>
        <tbody>
            @foreach($activitiesQuery as $activitiesInfo)
            <tr>
                 <td>

                <a href="#" class="btn_editActivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-pencil"></span></a>

                <a href="#" class="deleteAvtivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-trash"></span></a>

                </td>
                <td data-order="{{$activitiesInfo->final_date}}">{{$activitiesInfo->final_dateact}}</td>
                <td>{{$activitiesInfo->final_hour}}</td>
                <td>
                   <a target="_blank" href="/detEmpresa/{{$activitiesInfo->pkBusiness  }}">{!! $activitiesInfo->business_name !!}</a>
                </td>
                @if(!empty($activitiesInfo->campaning))
                <td>{!!$activitiesInfo->campaning!!}</td>
                @else
                <td>N/A</td>
                @endif
                <td>{!!$activitiesInfo->full_name!!}</td>
                <td>{!!$activitiesInfo->full_name!!}</td>
                <td class="t-column" style="min-width:400px;">{!!$activitiesInfo->description!!}</td>
                <td>{!!$activitiesInfo->text!!}</td>
               <!--  <td>{!!$activitiesInfo->text!!}</td>-->
               
            </tr>
            @endforeach
        </tbody>
    </table>