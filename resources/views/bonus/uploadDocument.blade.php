<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Subir archivo</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="#">
            <div class="form-body">
                <div class="card-body">
                    <div class="row pt-3 px-3">

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="inputGroupFile01">Elegir archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div><!--/row-->
            </div>
            <div class="form-actions text-center">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btn_uploadDocument" data-id="{{$pkBonus}}"> <i class="fa fa-check"></i>subir</button>
                </div>
            </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>

    <script src="/js/custom.min.js"></script>
