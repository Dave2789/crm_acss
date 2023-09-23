<div class="dt-buttons">
        <button type="button" data-id="3" class="dowloadExcel dt-button buttons-excel buttons-html5 btn btn-primary mr-1" tabindex="0" aria-controls="activeEmp">
            <span>Excel</span>
        </button> 
    </div>
     <div id="activeEmp_filter" class="dataTables_filter">
         <label>Buscar:<input id="seacrhBussines" data-id="3" value="{!! $text !!}" type="search" class="form-control form-control-sm" placeholder="" aria-controls="activeEmp">
        </label>
    </div>
<table id="activeEmp" class="table display table-bordered table-striped no-wrap">
<thead>
    <tr>
        <th>Empresa</th>
        <th>Contacto</th>
        <th>Origen</th>
        <th>Categoría</th>
        <th>Giro</th>
        <th>Estatus</th>
        <th>Ventas</th>
        <th>Cotizaciones</th>
        <th>Oportunidades<br>de Negocio</th>
        <th>Fecha de <br>último contacto</th>
        <th>Siguiente actividad</th>
        <th>Fecha de vencimiento<br>siguiente actividad</th>
        <th>Ver empresa</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
    @foreach($bussines as $item)
  
    <tr>
        <td>
            <a href="/detEmpresa/{!!$item->pkBusiness!!}">{!! $item->name !!}</a>
        </td>
         <td>
             @if(!empty($item->nameContact))
            <div>{!!$item->nameContact!!}<br>
                <small><span class="ti-email"></span>{!!$item->mailContact!!}</small><br>
                @if(!empty($item->phoneContact))
                <small><span class="ti-headphone"></span> {!!$item->phoneContact!!}</small>
                @endif
                 @if(!empty($item->mobile_phone))
                <small><span class="ti-mobile"></span> {!!$item->mobile_phone!!}</small>
                 @endif
                 <small><a href="#" class="viewBussinesContact" data-id="{!!$item->pkBusiness!!}"><span class="ti-user"></span> Ver todos</a></small>
            </div>
             @else
              <div>
               N/A<br>
                 <small><a href="#" class="viewBussinesContact" data-id="{!!$item->pkBusiness!!}"><span class="ti-user"></span> Agregar</a></small>
              </div>
             @endif
        </td>
         <td>
          {!! html_entity_decode($item->fKOrigin) !!}
        </td>
         <td>
          {!! html_entity_decode($item->category) !!}
        </td>
          <td>
          {!! html_entity_decode($item->giro) !!}
        </td>
       

<td><span class="badge badge-warning badge-pill">Prospecto</span> </td>

       
          <td>
           <span class="label label-success">{!! $item->salesPay !!} </span> 
           <span class="label label-danger"> {!! $item->salesLoss !!}</span> </td>
            <td>    
 
        <span class="label label-info"> {!! $item->quotations !!}</span></td>
<td>  
<span class="label label-success">{!! $item->oportunityAproved !!}</span>
<span class="label label-info"> {!! $item->oportunityOpen !!}</span>
 <span class="label label-danger"> {!! $item->oportunityLoss !!}</span>
</td>
<td>
@if(isset($activities[$item->pkBusiness]["lastActivity"]))
<span> {!!$activities[$item->pkBusiness]["lastActivity"]!!} </span>
@else
 <span>N/A</span>
@endif
</td>
<td class="t-column" style="min-width: 400px;">
  @if(isset($activities[$item->pkBusiness]["nextActivity"]))
<span>   {!!$activities[$item->pkBusiness]["nextActivity"]!!} </span>
@else
 <span>N/A</span>
@endif

</td>
<td>
  @if(isset($activities[$item->pkBusiness]["finalActivity"]))
<span>{!!$activities[$item->pkBusiness]["finalActivity"]!!} </span>
@else
 <span>N/A</span>
@endif

</td>
          <td class="text-center"><a href="/detEmpresa/{!!$item->pkBusiness!!}"><span class="ti-eye"></span></a></td>
          <td>
             <button class="btn btn-info btn-sm btn_updateBussines" data-id="{!!$item->pkBusiness!!}"><span class="ti-pencil"></span></button>
             @if($item->status == 1)
             <button class="btn btn-danger btn-sm btn_deleteBussines" data-id="{!!$item->pkBusiness!!}"><span class="ti-close"></span></button>   
           @else 
           <button class="btn btn-success btn-sm btn_activeBussines" data-id="{!!$item->pkBusiness!!}"><span class="ti-check"></span></button>   
           @endif
          </td>
    </tr>
 
    @endforeach
</tbody>
</table>
