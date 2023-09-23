<table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Meta</th>
            <!--<th>Bono %</th>-->
            <th>Bono primero en romper base %</th>
            <th>Mínimo</th>
            <th>Penalizaci&oacute;n %</th>
            
            <th>Agentes</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>

        @foreach($bound as $boundInfo)
        <tr>
            <td>{{$boundInfo->date }} </td>
            <td>$ {{number_format($boundInfo->montRec,2) }} </td>
            <!--<td>{{$boundInfo->porcentBon }} %</td>-->
            <td>{{$boundInfo->porcentFirst }} %</td>
            <td>$ {{number_format($boundInfo->montMin) }} </td>
            <td> 
                @foreach($penality[$boundInfo->pkBond_base] as $penalityInfo)
                    <strong> - {{ $penalityInfo->penality }}% </strong> <label> {!! $penalityInfo->full_name !!} </label><br/>
                  @endforeach
            </td>
            
            <td class="viewAgentBono text-center" data-id="{{$boundInfo->pkBond_base }}" style="cursor: pointer">
                <span class="ti-user"></span>
            </td>
            <td class="text-center updateBounBase" data-id="{{$boundInfo->pkBond_base }}" style="cursor: pointer">
                <span class="ti-pencil"></span>
            </td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm btn_deleteBounBase" data-id="{{ $boundInfo->pkBond_base}}"><span class="ti-close"></span></button> 
            </td>
        </tr>
        @endforeach

    </tbody>
</table>