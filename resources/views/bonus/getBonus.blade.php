<table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Meta</th>
            <th>Repartir</th>
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
            <td class="viewAgentBondRecord text-center" data-id="{{$boundInfo->pkBound_record }}" style="cursor: pointer">
                <span class="ti-user"></span>
            </td>
            <td class="text-center updateBounRecord" data-id="{{$boundInfo->pkBound_record }}" style="cursor: pointer">
                <span class="ti-pencil"></span>
            </td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm btn_deleteBounRecord" data-id="{{ $boundInfo->pkBound_record}}"><span class="ti-close"></span></button> 
            </td>
        </tr>
        @endforeach

    </tbody>
</table>