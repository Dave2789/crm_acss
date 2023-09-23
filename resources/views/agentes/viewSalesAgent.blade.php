<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Ventas realizadas</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
          <table id="tableSales" class="table table-hover no-wrap">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha y Hora</th>
                            <th>Monto</th>
                            <th>Lugares</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($SalesByAgent as $item)
                        <tr>
                            <td>{{$item->folio }}</td>
                            <td>{{$item->register_day }} {{$item->register_hour }}</td>
                            <td>$ {{number_format($item->price_total,2) }}</td>
                            <td>{{$item->number_places }}</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
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