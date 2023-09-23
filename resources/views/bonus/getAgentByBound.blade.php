<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Agentes de este bonus</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
          <div class="table-responsive m-t-40">
          <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Agente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                @foreach($agentBond as $workInfo)
                                                 <tr>
                                                <td>{!!$workInfo->name !!}</td>
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