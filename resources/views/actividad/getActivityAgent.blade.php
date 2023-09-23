<div class="col-md-6 col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex no-block align-items-center">
                <div>
                    <h4 class="card-title m-b-0">Actividades Pendientes</h4>
                </div>
                <div class="ml-auto">
                    <a href="/calendario" class="pull-right btn btn-circle btn-success"><i class="ti-calendar"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body steamline-scroll">
            <!-- To do list widgets -->
            <div class="steamline m-t-40">
                @foreach($activitiesQuery as $activitiesInfo)
                <div class="sl-item">
                    <div class="sl-left bg-info" style="background-color: {{$activitiesInfo->color}}!important;"> <i class="{{$activitiesInfo->icon}}"></i></div>
                    <div class="sl-right">
                        <div class="font-medium">
                            <a class="a-black">{{html_entity_decode($activitiesInfo->text)}} </a> <!-- CLIC PERMITE FINALIZAR LA ACTIVIDAD -->
                            <?php
                            $dateNow = strtotime($date);
                            $dateAux = strtotime($activitiesInfo->final_date);

                            $hourNow = strtotime($hour);
                            $hourAux = strtotime($activitiesInfo->final_hour);

                            $fechaUno = new DateTime($hour);
                            $fechaDos = new DateTime($activitiesInfo->final_hour);

                            $dateInterval = $fechaUno->diff($fechaDos);
                            $time = $dateInterval->format('%H') . PHP_EOL;
                            // dd($date);
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
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Actividades realizadas</h5>
            <div class="message-box steamline-scroll">
                <div class="message-widget">
                    <!-- Message -->
                    @foreach($lastActivitiesQuery as $lastActivitiesInfo)
                    <a>
                        <div class="user-img">
                            <span class="round" style="background-color: {{$lastActivitiesInfo->color}}!important;"> <i class="{{$lastActivitiesInfo->icon}}"></i></span>
                            <span class="profile-status away pull-right"></span>
                        </div>
                        <div class="mail-contnet">
                            <h5>{!!$lastActivitiesInfo->text!!}</h5>
                            <span class="mail-desc">{{html_entity_decode($lastActivitiesInfo->description)}}</span>
                            <p>
                                <small class="text-muted"><i class="ti-calendar"></i> {{$lastActivitiesInfo->execution_date}} {{$lastActivitiesInfo->execution_hour}}</small>
                                <small class="pl-2 text-muted"><i class="ti-user"></i> {{html_entity_decode($lastActivitiesInfo->full_name)}}</small>
                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> {{html_entity_decode($lastActivitiesInfo->business_name)}}</small>
                            </p>
                            <span class="badge badge-pill badge-danger float-right" style="background-color: {{$lastActivitiesInfo->color_subtype}}!important;"> {{html_entity_decode($lastActivitiesInfo->text_subtype)}}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>