<div class="dt-buttons">
        <!--  <button type="button" data-id="0" class="dowloadExcelActivity dt-button buttons-excel buttons-html5 btn btn-primary mr-1" tabindex="0" aria-controls="activeEmp">
              <span>Excel</span>
          </button> -->
      </div>
       <div id="activeEmp_filter" class="dataTables_filter">
           <label>Buscar:<input id="seacrhActivitys" value="{!! $text !!}" type="search" class="form-control form-control-sm" placeholder="" aria-controls="activeEmp">
          </label>
      </div>  <table id="actividades" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Proceso</th>
                                                <th>Agente</th>
                                                <th>Tipo de actividad</th>
                                                <th>Registró</th>
                                                <th>Finaliza</th>
                                                <th>Comentario</th>
                                                <th>Finalizar<br>Actividad</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activitiesQuery as $activitiesInfo)
                                             @if(empty($activitiesInfo->execution_date))
                                             <tr>
                                             @else
                                              <tr style="background-color:#d0f4c8">
                                              @endif
                                                <td>{{html_entity_decode($activitiesInfo->name_business)}}</td>
                                                <td>
                                                    @if($activitiesInfo->pkOpportunities != "" && $activitiesInfo->pkOpportunities != null)
                                                    Oportunidad de negocio
                                                    @else
                                                        @if($activitiesInfo->pkQuotations != "" && $activitiesInfo->pkQuotations != null)
                                                        Cotización
                                                        @else
                                                        Actividad Inicial
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{html_entity_decode($activitiesInfo->full_name)}}<br>({{html_entity_decode($activitiesInfo->type_name)}})</td>
                                                <td><span class="label label-info" style="background-color: {{$activitiesInfo->color}}!important">{{html_entity_decode($activitiesInfo->text)}}</span></td>
                                                <td>{{$activitiesInfo->register_date}} {{$activitiesInfo->register_hour}}</td>
                                                <td>{{$activitiesInfo->final_date}} {{$activitiesInfo->final_hour}}</td>
                                                <td class="t-column" style="min-width:400px;">{{html_entity_decode($activitiesInfo->description)}}</td>
                                                @if(empty($activitiesInfo->execution_date))
                                                <td> <button type="button" class="btn btn-primary btn_FinisActivity" data-id="{{ $activitiesInfo->pkActivities }}">Finalizar</button>  </td>
                                               @else
                                               <td>Actividad Finalizada</td>
                                                @endif
                                                
                                              
                                                <td><a href="#" class="btn_editActivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-pencil"></span></a></td>
                                                <td><a href="#" class="deleteAvtivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-trash"></span></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>