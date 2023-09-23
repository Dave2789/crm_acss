<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Empresa</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="#">
            <div class="form-body">
                <div class="card-body">
                    <div class="row pt-3 px-3">
                        <div class="col-12 mb-3"><small id="emailHelp" class="form-text text-muted">* Campos obligatorios.</small></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nombre de la empresa (Razón Social) *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                    </div>
                                    <input type="text" id="firstName" class="form-control" placeholder="Persona Física o Moral" value="{!!$Bussines->name!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">RFC</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                    </div>
                                    <input type="text" id="rfc" class="form-control" value="{!!$Bussines->rfc!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Correo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>
                                    </div>
                                    <input type="text" id="emailEmp" class="form-control" placeholder="correo" value="{!! $Bussines->mail !!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                                    </div>
                                    <input type="text" id="phoneBussines" class="form-control" placeholder="Lada + número" value="{!!$Bussines->phone!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Página Web</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-world"></i></span>
                                    </div>
                                    <input type="text" id="web" class="form-control" placeholder="http://" value="{!!$Bussines->web!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Propietario</label>
                                <select id="propierty" class="form-control custom-select" data-placeholder="Agente para el que se asigna" tabindex="1">
                                    <option value="-1">Selecciona un agente</option>
                                    @foreach($agent as $agenInfo)
                                     @if($agenInfo->pkUser == $Bussines->fkUser)
                                    <option selected value="{!!$agenInfo->pkUser !!}">{!! $agenInfo->full_name !!}</option>
                                    @else
                                    <option value="{!!$agenInfo->pkUser !!}">{!! $agenInfo->full_name !!}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Domicilio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-home"></i></span>
                                    </div>
                                    <input type="text" id="domicilio" class="form-control" placeholder="Calle, número y colonia" value="{!!$Bussines->address!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Ciudad *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-location-pin"></i></span>
                                    </div>
                                    <input type="text" id="city" class="form-control" value="{!!$Bussines->city!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Estado *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-map-alt"></i></span>
                                    </div>
                                    <input type="text" id="state" class="form-control" value="{!!$Bussines->state!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">País *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-flag-alt-2"></i></span>
                                    </div>
                                    <input type="text" id="country" class="form-control" value="{!!$Bussines->country!!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Giro *</label>
                                <select id="giro" class="form-control custom-select" data-placeholder="Selecciona el Giro de la empresa" tabindex="1">
                                    <option value="-1">Selecciona un giro</option>
                                    @foreach($commercial_business as $item)
                                    @if($Bussines->fkComercial_business ==  $item->pkCommercial_business)
                                    <option selected value="{!!$item->pkCommercial_business!!}">{!!$item->name!!}</option>
                                    @else
                                    <option value="{!!$item->pkCommercial_business!!}">{!!$item->name!!}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Categoría *</label>
                                <select id="cat" class="form-control custom-select" data-placeholder="Elige Categoría" tabindex="1">
                                    <option value="-1">Selecciona una categoría</option>
                                    @foreach($categories as $item)
                                    @if($Bussines->fkCategory ==  $item->pkCategory)
                                    <option selected value="{!!$item->pkCategory!!}">{!!$item->name!!}</option>
                                    @else
                                    <option value="{!!$item->pkCategory!!}">{!!$item->name!!}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Origen</label>
                                <select id="origen" class="form-control custom-select" data-placeholder="Elige Categoría" tabindex="1">
                                    <option value="-1">Selecciona un origen</option>
                                    @foreach($origin as $item)
                                    @if($Bussines->fKOrigin == $item->pkBusiness_origin)
                                    <option selected value="{!!$item->pkBusiness_origin!!}">{!!$item->name!!}</option>
                                    @else
                                    <option value="{!!$item->pkBusiness_origin!!}">{!!$item->name!!}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fileUpload divHoverProfile">
                                <output style="text-align: center" id="list">
                                    <img style="width:100px; height:100px" class="img-responsive" alt="Responsive image" src="/images/business/{!! $Bussines->image !!}"/>   
                                </output>
                            </div>
                            <div class="form-group">
                                <label>Imagen</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="inputGroupFile01">Elegir Imagen</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div><!--/row-->
                </div>
                <div class="form-actions">
                    <div class="card-body">
                        <button type="button" class="btn btn-success" id="btn_updateCompany" data-id="{!!$Bussines->pkBusiness!!}"> <i class="fa fa-check"></i> Modificar</button>
                    </div> 
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<script type="text/javascript">
    //script para cargar previemente la imagen
    function archivo(evt) {
        var files = evt.target.files; // FileList object

        //Obtenemos la imagen del campo "file". 
        for (var i = 0, f; f = files[i]; i++) {
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            reader.onload = (function (theFile) {
                return function (e) {
                    // Creamos la imagen.
                    document.getElementById("list").innerHTML = ['<img style="width:100px; height:100px" class="img-responsive" alt="Responsive image" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                };
            })(f);

            reader.readAsDataURL(f);
        }
    }

    document.getElementById('image').addEventListener('change', archivo, false);


</script>