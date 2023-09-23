<table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Record</th>
            <th>Repartir</th>
            <th>Penalizaci&oacute;n</th>
            <th>Agentes</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>

        @foreach($bound as $boundInfo)
        <tr>
            <td>{{$boundInfo->date }} </td>
            <td>$ {{number_format($boundInfo->montMet,2) }} </td>
            @if($boundInfo->slcTypeMont == 1)
            <td>{{$boundInfo->montRep }} %</td>
            @else
            <td>$ {{number_format($boundInfo->montRep,2) }}</td>
            @endif
            <td>{{$boundInfo->montPen }} %</td>
            <td class="viewAgentBondTecho" data-id="{{$boundInfo->pkBonus_techo }}" style="cursor: pointer">
                <span class="ti-eye"></span>
            </td>
            <td class="text-center updateBounTecho" data-id="{{$boundInfo->pkBonus_techo }}" style="cursor: pointer">
                <span class="ti-pencil"></span>
            </td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm btn_deleteBounTecho" data-id="{{ $boundInfo->pkBonus_techo}}"><span class="ti-close"></span></button> 
            </td>
        </tr>
        @endforeach

    </tbody>
</table>