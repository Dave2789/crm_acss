<div class="text-right" style="padding: 10px;">
        <h4>Total: ${!! number_format($bussinesMoreTotal,2) !!}</h4>
    </div>
    <table class="table table-hover no-wrap" id="masCompras">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Fecha de<br>Registro</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
           @foreach($BussinessMoreRes as $bussinesAdd)
           @if($bussinesAdd->salesMont > 0)
            <tr>
                <td><a href="/detEmpresa/{!! $bussinesAdd->pkBusiness!!}">{!! $bussinesAdd->name !!}</a></td>
                <td>{!! $bussinesAdd->date_register !!}</td>
                <td><span class="text-success">$ {!! number_format($bussinesAdd->salesMont)!!}</span></td>
      
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>