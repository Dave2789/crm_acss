<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Usuario</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nombre Completo *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                        </div>
                        <input type="text" id="name" class="form-control" placeholder="" value="{!! $users->full_name !!}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Numero de extension *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                        </div>
                        <input type="text" id="extension" class="form-control" placeholder="" value="{!! $users->phone_extension !!}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Color *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"></span>
                        </div>
                        <input type="color" id="colorUpdate" value="{{$users->color}}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Correo <small>(Con este correo se podrá iniciar sesión)</small>*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>
                        </div>
                        <input type="text" id="email" class="form-control" placeholder="" value="{!! $users->mail !!}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Contraseña *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-lock"></i></span>
                        </div>
                        <input type="text" id="password" class="form-control" placeholder="" value="{!! $users->password !!}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
    
                            <div class="fileUpload divHoverProfile">
                                <output style="text-align: center" id="list">
                                    <img style="width:100px; height:100px" class="img-responsive" alt="Responsive image" src="/images/usuarios/{!! $users->image !!}"/>   
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
            <div class="col-md-12 text-right">
                <button class="btn btn-success btn_editUser" data-id="{!!$users->pkUser !!}" ><span class="ti-check"></span> Modificar</button>
            </div>
        </div>
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