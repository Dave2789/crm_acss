<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Cotizaciones</h2>
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
                                                <th>&Uacute;ltima actividad</th>
                                                <th>Siguiente actividad</th>
                                                <th>Vencimiento siguiente</th>
                                                <th>Documento</th>
                                                <th>Actualizar status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                @foreach($SalesByAgent as $item)
                                                 <tr>
                                                <td>
                                                    {!!$item->folio !!}
                                                </td>
                                                 <td>
                                                    {{ $item->register_day }} {{ $item->register_hour }}
                                                </td>
                                                 <td>
                                                     <span class="badge" style="background-color:{{$item->color }}">{{$item->level }}</span>
                                                </td>
                                                 <td>
                                                    {{$item->quotations_status }}
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
                                                 <td class="text-center"><a href=""><span class="ti-file"> </span>Ver</a></td>
                                                 <td class="text-center" data-id="{{$item->pkQuotations }}">
                                                  @if($item->quotation_status != 5)
                                                
                                                   <span class="ti-write updateStatus" data-id="{{$item->pkQuotations }}"></span>
                                             
                                                @else
                                        <span>No editable</span>
                                           </td>
                                                @endif
                                    
                                     
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

 </div><!-- End Wrapper -->
    
     <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario" class="modalEditUsuario"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">
       
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