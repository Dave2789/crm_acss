<table id="oporNeg" class="table display table-bordered table-striped no-wrap">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Folio</th>
            <th>Empresa</th>
            <th>Precio total</th>
            <th>Lugares</th>
            <th>Estado / País</th>
            <th>Nivel de<br>inter&eacute;s</th>
            <th>Estatus</th>
            <th>Agente</th>
            <th>Tiene<br>Presupuesto</th>
            @if($arrayPermition["change"] == 1)
            <th>Convertir a<br>cotización</th>
            @endif
            <th>Detalle</th>
            @if($arrayPermition["edit"] == 1)
            <th>Editar</th>
            @endif
            @if($arrayPermition["delete"] == 1)   
            <th>Eliminar</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($oportunity as $item)
        <tr>
            <td>{!!$item->register_day !!}<br>{!!$item->register_hour !!}</td>
            <td>{!!$item->folio !!}</td>
            <td class="text-center">
                <img style="max-height: 40px;" src="/images/business/{!!$item->image!!}" class="rounded-circle">
                <div>
                    <a href="/detEmpresa/{!! $item->pkBusiness !!}">{!!$item->bussines !!}</a>
                </div>
            </td>
            <td><span class="label label-success">$ {!!number_format($montWithIva[$item->pkOpportunities],2) !!}</span></td>
            <td class="text-center">
                <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Precio</th>
                            <th>Lugares</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oportunityDetail[$item->pkOpportunities] as $oportunityDetailInfo)
                        <tr>
                            @if(isset($oportunityDetailInfo["course"]))
                            <td> {!!$oportunityDetailInfo["course"] !!}</td>
                            <td> {!!$oportunityDetailInfo["price"] !!}</td>
                            <td> {!!$oportunityDetailInfo["qtyPlaces"] !!}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>



            </td>
            <td>{!!$item->state !!} / {!!$item->country !!}</td>
            <td>
                <span class="badge badge-pill text-white" style="background-color:{!!$item->color !!}">{!!$item->level !!}</span>
            </td>
            <td>
                {!!$item->opportunities_status!!}
            </td>
            <td style="min-width:150px;">
                Asignado:
                @if(isset($item->agent))
                <br><strong>{!!$item->agent!!}</strong>
                @else
                <br><strong></strong>
                @endif
                <hr style="margin:7px;">
                Atendió:
                <br>
                @if(isset($item->asing))
                <strong>{!!$item->asing  !!}</strong>
                @else
                <strong></strong>
                @endif

            </td>
            <th class="text-center">
                @if($item->isBudget == 0)
                <span class="ti-close text-danger">
                    @endif

                    @if($item->isBudget == 1)
                    <span class="ti-check text-success">
                        @endif

                        @if($item->isBudget == 2)
                        <span class="text-warning">Sin definir</span>
                        @endif

                        </th>
                        @if($arrayPermition["change"] == 1)
                        @if($item->opportunities_statu != 5)
                        <td class="text-center"><span class="convertToQuotation cursor-h"  data-id="{!! $item->pkOpportunities!!}"><span class="ti-write"> </span>Convertir</span></td>
                        @else
                        <td class="text-center"><span>Oportunidad cotizada </span></td>
                        @endif
                        <td>
                            <a href="#" data-id="{!!$item->pkOpportunities!!}" class="viewDetailOportunity"><i class="ti-eye"></i> Ver<br>detalle</a>
                        </td> 
                        @endif
                        <td class="text-center">
                            @if($arrayPermition["edit"] == 1)
                            @if($item->opportunities_statu != 5)
                            <a href="#" data-id="{!! $item->pkOpportunities!!}" class="btn btn-primary btn-sm btn_editOportunity"> <span class="ti-pencil"> </span></a>
                            @else
                            <span> No editable </span>
                            @endif
                            @endif
                        </td>

                        <td class="text-center">
                            @if($arrayPermition["delete"] == 1)    
                            @if($item->opportunities_statu != 5)
                            <button class="btn btn-danger btn-sm btn_deleteOportunity" data-id="{!! $item->pkOpportunities!!}">
                                <span class="ti-close"></span></button>
                            @else
                            <span> No eliminable </span>
                            @endif
                            @endif
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>