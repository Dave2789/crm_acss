<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Oportunidades convertidas a cotizacion</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
         <div class="table-responsive m-t-40">
         <table id="tableSales" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Fecha</th>
                                                <th>Nivel de inter&eacute;s</th>
                                                <th>Estatus</th>
                                                <th>&Uacute;ltima</th>
                                                <th>Siguiente actividad</th>
                                                <th>Vencimiento siguiente</th>
                                                <th>Cantidad empleados</th>
                                                <th>Cursos interesados</th>
                                                <th>Lugares</th>
                                                <th>Agente</th>
                                                <th>Monto</th>
                                                <th>Presupuesto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($oportunity as $item)
                                            <tr>
                                                <td>{{$item->folio }}</td>
                                                <td>{{$item->register_day }} {{$item->register_hour }}</td>
                                                <td>
                                                 <span class="badge" style="background-color:{{$item->color }}">{{$item->level }}</span>
                                                </td>
                                                  <td>
                                                    {{$item->opportunities_status}}
                                                </td>
                                                 <td>
                                                     @if(!empty($item->lastActivity))
                                                     <span> {{$item->lastActivity}} </span>
                                                     @else
                                                      <span>N/A</span>
                                                     @endif
                                                 </td>
                                                  <td>
                                                       @if(!empty($item->nextActivity))
                                                     <span>   {{$item->nextActivity}} </span>
                                                     @else
                                                      <span>N/A</span>
                                                     @endif
                                               
                                                </td>
                                                 <td>
                                                       @if(!empty($item->finalActivity))
                                                     <span>{{$item->finalActivity}} </span>
                                                     @else
                                                      <span>N/A</span>
                                                     @endif
                                                 
                                                </td>
                                                 <td>{{$item->number_employees }}</td>
                                                <td>{!!$item->course !!}</td>
                                                <td>{{$item->number_places }}</td>
                                                <td>{!!$item->agent !!}</td>
                                                 <td><span class="label label-success">$ {{number_format($item->price_total,2) }}</span></td>
                         
                                                <th class="text-center">
                                                    @if($item->isBudget == 0)
                                                    <span class="ti-close text-danger">
                                                    @else
                                                    <span class="ti-check text-success">
                                                    @endif
                                                </th>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
         </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>

 <script>
        $(function () {
            $('#tableSales').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });
       
    </script>