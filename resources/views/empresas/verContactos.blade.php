<div class="modal-body">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Empresa "{!! $busssines->name !!}"</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
           
            <div class="form-body">
                <div class="row justify-content-end mb-3">
                  <div class="col-md-3 col-sm-4 col-12">
                      <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-right" id="addContactBussines" data-id=" {!!$busssines->pkBusiness!!}"><i class="fa fa-plus-circle"></i> Crear nuevo contacto</button>
                  </div>
                </div>
                 @php $count = 1; @endphp
                @foreach($bussinesContact as $item)
               
                <div>
                    <!--/row-->
                    <h3 class="box-title">Contacto {!!$count!!}  <button class="btn btn-danger btn-sm float-right btn_deleteContactBussines" data-business="{!!$item->fkBusiness!!}" data-id="{!!$item->pkContact_by_business!!}"><span class="ti-close"></span></button></h3>
                    <hr class="m-t-0 m-b-10">
                    <div class="row datos-e">
                        <div class="col-md-6 dat1">
                            <label class="control-label "><i class="ti-user"></i> Nombre:</label>
                            <p class="form-control-static">{!! $item->name !!}</p>
                        </div>
                        <div class="col-md-6 dat1">
                            <label class="control-label "><i class="ti-medall"></i> Cargo:</label>
                            <p class="form-control-static">{!!$item->area !!}</p>
                        </div>
                        <div class="col-md-6 dat1">
                                                        <label class="control-label "><i class="ti-email"></i> Correo:</label>
                                                        <p class="form-control-static">{!!$item->mail !!}</p>
                                                    </div>
                        <div class="col-md-6 dat1">
                            <label class="control-label "><i class="ti-headphone-alt"></i> Teléfono Fijo:</label>
                            <p class="form-control-static">{!!$item->phone !!}</p>
                        </div>
                        <div class="col-md-6 dat1">
                                                        <label class="control-label "><i class="ti-plus"></i> Extensión:</label>
                                                        <p class="form-control-static">{!!$item->extension !!}</p>
                                                    </div>
                        <div class="col-md-6 dat1">
                            <label class="control-label"><i class="ti-mobile"></i> Teléfono Móvil:</label>
                            <p class="form-control-static">{!!$item->mobile_phone !!} </p>
                        </div>
                        <div class="col-md-12 text-right">
                         <button type="button" class="btn btn-success btnUpdateContact" data-id="{!! $item->pkContact_by_business !!}"><i class="ti-check"></i> Modificar</button>
                        </div>
                    </div>
                  
                </div>
                 @php $count++; @endphp
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>