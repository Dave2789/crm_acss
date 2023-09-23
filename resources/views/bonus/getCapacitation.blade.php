<table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
        <thead>
            <tr>
                <th>Agente</th>
                <th>Cursos</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
           
                @foreach($bound as $boundInfo)
                 <tr>

                 <td>{!! $boundInfo->full_name !!}</td>
                
                <td class="viewCources" data-id="{{$boundInfo->pkCapacitation }}" data-user="{{ $boundInfo->pkUser }}" style="cursor: pointer">
                    <span class="ti-eye"></span>
                </td>
                 <td class="text-center updateCapacitation" data-id="{{$boundInfo->pkCapacitation }}" data-user="{{ $boundInfo->pkUser }}" style="cursor: pointer">
                    <span class="ti-pencil"></span>
                 </td>
                 <td class="text-center">
                    <button class="btn btn-danger btn-sm btn_deleteCapacitation" data-id="{{ $boundInfo->pkCapacitation}}" data-user="{{ $boundInfo->pkUser }}"><span class="ti-close"></span></button> 
                 </td>
                 </tr>
                @endforeach
           
        </tbody>
    </table>