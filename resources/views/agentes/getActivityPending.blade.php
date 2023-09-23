@foreach($activitiesQuery as $activitiesInfo)
                                    <div class="sl-item">
                                        <div class="sl-left bg-info" style="background-color: {{$activitiesInfo->color}}!important;"> <i class="{{$activitiesInfo->icon}}"></i>
                                        </div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a class="a-black">{{html_entity_decode($activitiesInfo->text)}} </a> <!-- CLIC PERMITE FINALIZAR LA ACTIVIDAD -->
                                                <?php 
                                                $dateNow        = strtotime($date);
                                                $dateAux        = strtotime($activitiesInfo->final_date);
                                                
                                                $hourNow        = strtotime($hour);
                                                $hourAux        = strtotime($activitiesInfo->final_hour);
                                                
                                                $fechaUno       = new DateTime($hour);
                                                $fechaDos       = new DateTime($activitiesInfo->final_hour);

                                                $dateInterval   = $fechaUno->diff($fechaDos);
                                                $time           = $dateInterval->format('%H').PHP_EOL;
                                                ?>
                                               
                                                @if($dateNow == $dateAux)
                                                    @if($time <= 3)
                                                    <span class="badge badge-pill badge-danger float-right">Urgente</span>
                                                    @else
                                                    <span class="badge badge-pill badge-warning float-right">Hoy</span>
                                                    @endif
                                                @else
                                                    @if(($dateNow >= $dateAux) && ($hourNow > $hourAux))
                                                    <span class="badge badge-pill badge-danger float-right" style="background-color: #red!important;">Actividad no realizada</span>
                                                    @else
                                                    <span class="badge badge-pill badge-info float-right">Después</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <p>{{html_entity_decode($activitiesInfo->description)}}</p>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> {{$activitiesInfo->final_date}} {{$activitiesInfo->final_hour}}</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> {{html_entity_decode($activitiesInfo->full_name)}}</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> {{html_entity_decode($activitiesInfo->business_name)}}</small> 
                                            </p>
                                             <p>
                                                <button type="button" class="btn btn-primary btn-sm btn_FinisActivity" data-id="{{ $activitiesInfo->pkActivities }}">Finalizar</button>
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                             
              