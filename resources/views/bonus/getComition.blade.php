<table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Mayor que</th>
                <th>Comisi&oacute;n %</th>
                <th>Mayor que</th>
                <th>Menor que</th>
                <th>Comisi&oacute;n %</th>
                <th>Menor que</th>
                <th>Comisi&oacute;n %</th>
                <th>Agentes</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
           
                @foreach($bound as $boundInfo)
                 <tr>
                 <td>{{$boundInfo->date }} </td>
                 <td>$ {{number_format($boundInfo->higher_to,2) }} </td>
                 <td>{{ $boundInfo->comition_higher}} %</td>
                 
                 @if(!empty($boundInfo->higher_or_equal_to))
                 <td>$ {{number_format($boundInfo->higher_or_equal_to,2) }} </td>
                 @else 
                 <td>N/A</td>
                 @endif

                 @if(!empty($boundInfo->less_or_equal_to))
                 <td>$ {{number_format($boundInfo->less_or_equal_to,2) }} </td>
                 @else 
                 <td>N/A</td>
                 @endif
               
                 @if(!empty($boundInfo->comition_higher_less))
                 <td>{{ $boundInfo->comition_higher_less}} %</td>
                 @else 
                 <td>N/A</td>
                 @endif
                
               
                 <td>$ {{number_format($boundInfo->less_to,2) }} </td>
                 <td>{{ $boundInfo->comition_less}} %</td>

                <td class="viewAgentBondComit" data-id="{{$boundInfo->pkComition }}" style="cursor: pointer">
                    <span class="ti-eye"></span>
                </td>
                 <td class="text-center updateBounComition" data-id="{{$boundInfo->pkComition }}" style="cursor: pointer">
                    <span class="ti-pencil"></span>
                 </td>
                 <td class="text-center">
                    <button class="btn btn-danger btn-sm btn_deleteBounComit" data-id="{{ $boundInfo->pkComition}}"><span class="ti-close"></span></button> 
                 </td>
                 </tr>
                @endforeach
           
        </tbody>
    </table>