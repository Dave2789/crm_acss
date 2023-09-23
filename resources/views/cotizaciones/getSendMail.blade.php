<div class="modal-content">
    <div class="modal-header">
    <h2 class="modal-title" id="modalAgentesCLabel">Cotizacion # {{ $bussines->folio}}  Enviar Correo</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                         <div class="form-group">
                            <label class="control-label">Para:</label>
                            <br>
                           <div class="btn-group" style="width: 100%;">
                                <select  class="form-control" id="dest">
                                            <option value="-1">Selecciona un contacto</option>
                                           @foreach($bussines_contact as $info)
                                            <option value="{{ $info->mail }}">{{$info->mail }} - {!! $info->name!!}</option>
                                            @endforeach
                                        </select>
                              
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="copia" placeholder="CC:">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="copiaO" placeholder="CCO:">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="subject" placeholder="Asunto:">
                        </div>
                          <div class="form-group">
                                     <textarea class="textarea_editor form-control" id="message" rows="15" placeholder="Enter text ..."></textarea>
                                   </div>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success btn-send-mail-quotation" data-id="{{$pkQuotations }}" data-open="{{$type}}" ><span class="ti-check"></span>Enviar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
 <script>
    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();
    });
    </script>