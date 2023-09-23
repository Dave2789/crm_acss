<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Campaña "{!! $nameCampaning->name !!}"</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
         <h3>Listado de agentes</h3>
           @foreach($agenByCampaning as $infoAgent)
           <div class="card">
              <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                     {!! $infoAgent->full_name !!}
                  </h5>
              </div>
           </div>
           @endforeach
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>