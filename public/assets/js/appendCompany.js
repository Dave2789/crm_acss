  //get usuarios conectados
  function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }
    
  function calTotalQuotation(op){
         var iva           = $('input:radio[name=iva]:checked').val();
         
         var total         = 0;
         var places        = 0;
         var desc          = 0;
         var subtotal      = 0;
         console.log("op"+op);
         $('.contentNewOpcion2').each(function(){
             
             $(this).find('#coursesQuotation_'+op).each(function(){ 
                 
              $(this).find('.coursesQuotation_detail').each(function(){ 
                    if(typeof $(this).find('.qtyEmployeeQ').val() != "undefined"){
               places = places + parseInt($(this).find('.qtyEmployeeQ').val());
                 }
              });
           });
         });
         
         console.log(places);
         
         return places;
  }
  
  function calTotalQuotationConv(op){
         var iva           = $('input:radio[name=iva2]:checked').val();
         
         var total         = 0;
         var places        = 0;
         var desc          = 0;
         var subtotal      = 0;
         console.log("op"+op);
         $('.contentNewOpcion').each(function(){
             
             $(this).find('#coursesQuotationC_'+op).each(function(){ 
                 
              $(this).find('.coursesQuotationC_detail').each(function(){ 
                    if(typeof $(this).find('.qtyEmployeeQC').val() != "undefined"){
               places = places + parseInt($(this).find('.qtyEmployeeQC').val());
                 }
              });
           });
         });
         
         console.log(places);
         
         return places;
  }
  
  function calTotalOportunity(op){
        // var iva           = $('input:radio[name=iva]:checked').val();
        
         var places        = 0;
         console.log("op"+op);
         
             $('#coursesOportunity').each(function(){ 
                 
              $(this).find('.coursesOportunity').each(function(){ 
                    if(typeof $(this).find('.qtyEmployeeOp').val() != "undefined"){
               places = places + parseInt($(this).find('.qtyEmployeeOp').val());
                 }
              });
        });

         
         console.log(places);
         
         return places;
  }
  
  function calTotalOportunityEdit(op){
        // var iva           = $('input:radio[name=iva]:checked').val();
        
         var places        = 0;
         console.log("op"+op);
         
             $('#coursesOportunityEdit').each(function(){ 
                 
              $(this).find('.coursesOportunityEdit').each(function(){ 
                    if(typeof $(this).find('.qtyEmployeeOpEdit').val() != "undefined"){
               places = places + parseInt($(this).find('.qtyEmployeeOpEdit').val());
                 }
              });
        });

         
         console.log(places);
         
         return places;
  }
    
  $(document).ready(function(){
    
          $.ajax({
                type: "POST",
                dataType: "json",
                async: true,
                url: '/getUsersConect',
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response.view);
                       $('#chatOnline').empty();
                       $('#chatOnline').html(response.view);
                }
            });
            
             $.ajax({
                type: "POST",
                dataType: "json",
                async: true,
                url: '/getNotification',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.new == "0"){
                       $('.notify').empty();  
                    }
                   // console.log(response.view);
                       $('.notificationUser').empty();
                       $('.notificationUser').html(response.view);
                }
            });
            
   
});

  $(document).on('click', '#viewDetailNotification', function () {
    
          $.ajax({
                type: "POST",
                dataType: "json",
                url: '/getNotification',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.new == "0"){
                       $('.notify').empty();  
                    }
                  //  console.log(response.view);
                       $('.notificationUser').empty();
                       $('.notificationUser').html(response.view);
                }
            });
});
  
  $(document).on('click', '.viewNotification', function () {
      
      var title     = $(this).data('title').replace("&aacute;","\u00E0").replace("&eacute;","\u00E9").replace("&iacute;","\u00ED").replace("&oacute;","\u00F3").replace("&uacute;","\u00FA").replace("&ntilde;","\u00F1");
      var comment   = $(this).data('comment').replace("&aacute;","\u00E0").replace("&eacute;","\u00E9").replace("&iacute;","\u00ED").replace("&oacute;","\u00F3").replace("&uacute;","\u00FA").replace("&ntilde;","\u00F1");
      var pkAlert   = $(this).data('id');
      var type      = $(this).data('type');
      var quotation = $(this).data('quotation');
      var doument   = $(this).data('document');
      
      if(type == 1){
       ref = title;
      }else{
       var ref       = '<a href="/viewQuotationFormat/'+ quotation +'">'+title+'</a>';   
      }
      
      if(doument != ""){
      comment += '<br /> <a download href="/images/alerts/'+doument+'">Descargar documento</a>';
      }
      
    Swal.fire({
            title: ref,
            html: comment,
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:  'Cerrar',
            confirmButtonText: 'Marcar como leída'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkAlert": pkAlert},
                    url: '/NotificationView',
                    beforeSend: function () {
                      $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");  
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Marcada como leida!',
                                'La notificacion se ha marcado como leida.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al marcar como leída'
                            });
                        }
                    }
                });
            }
        });

   });
  
  $(document).on('change', '#state', function () {
        var idState     = $(this).val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idState": idState},
                url: '/getCity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#city').empty();
                       $('#city').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
   
  $(document).on('click', '#addMoreContact', function () {
        $("#addContentContact").append('<div class="contentNewContact row" style="margin-right:0px;margin-left:0px"><div class="col-12">'
            + '<h3 class="title-section mb-4 mt-3">Nuevo contacto <button type="button" class="btn btn-danger btn-sm btn_deleteNewContact float-right" data-id="4" style="margin-top: -4px;margin-right: -7px;"><span class="ti-close"></span></button></h3>'
            + '</div>'
            + '<div class="col-md-6">'
            + ' <div class="form-group">'
            + '    <label class="control-label">Nombre</label>'
            + '    <div class="input-group">'
            + '       <div class="input-group-prepend">'
            + '         <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>'
            + '       </div>'
            + '       <input type="text" id="nombreContacto" class="form-control nameContact">'
            + '    </div>'
            + '  </div>'
            + ' </div>'
            + ' <div class="col-md-6">'
            + '    <div class="form-group">'
            + '       <label class="control-label">Cargo / Puesto</label>'
            + '         <div class="input-group">'
            + '         <div class="input-group-prepend">'
            + '             <span class="input-group-text" id="basic-addon11"><i class="ti-medall"></i></span>'
            + '         </div>'
            + '         <input type="text" id="cargo" class="form-control cargo">'
            + '        </div>'
            + ' </div>'
            + ' </div>'
            + ' <div class="col-md-6">'
            + '    <div class="form-group">'
            + '       <label class="control-label">Correo</label>'
            + '       <div class="input-group">'
            + '         <div class="input-group-prepend">'
            + '             <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>'
            + '         </div>'
            + '         <input type="email" id="correo" class="form-control email">'
            + '        </div>'
            + '     </div>'
            + ' </div>'
            + '  <div class="col-md-6">'
            + '     <div class="form-group">'
            + '        <label class="control-label">Teléfono fijo</label>'
            + '       <div class="input-group">'
            + '         <div class="input-group-prepend">'
            + '             <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>'
            + '         </div>'
            + '       <input type="text" id="phone" class="form-control phone" placeholder="Incluir código de área">'
            + '        </div>'
            + '  </div>'
            + ' </div>'
            + ' <div class="col-md-6">'
            + '    <div class="form-group">'
            + '       <label class="control-label">Extensión</label>'
            + '         <div class="input-group">'
            + '         <div class="input-group-prepend">'
            + '             <span class="input-group-text" id="basic-addon11"><i class="ti-plus"></i></span>'
            + '         </div>'
            + '         <input type="text" id="extension" class="form-control extension">'
            + '        </div>'
            + ' </div>'
            + ' </div>'
            + ' <div class="col-md-6">'
            + '    <div class="form-group">'
            + '       <label class="control-label">Teléfono móvil</label>'
            + '       <div class="input-group">'
            + '         <div class="input-group-prepend">'
            + '             <span class="input-group-text" id="basic-addon11"><i class="ti-mobile"></i></span>'
            + '         </div>'
            + '      <input type="text" id="cel" class="form-control cel">'
            + '        </div>'
            + ' </div>'
            + '</div></div>');       
    });
    
  $(document).on('click', '.btn_deleteNewContact', function () {
       $(this).parent().parent().parent().empty();
    });
    
  $(document).on('click', '#btn_addCompany', function () {
        
        var flag        = "true";
        var firstName   = $("#firstName").val();
        var web         = $("#web").val();
        var rfc         = $("#rfc").val();
        var domicilio   = $("#domicilio").val();
        var city        = $("#city").val();
        var state       = $("#state").val();
        var country     = $("#country").val();
        var emailEmp    = $("#emailEmp").val();
        var giro        = $("#giro").val();
        var cat         = $("#cat").val();
        var origen      = $("#origen").val();
        var image       = $("#image").val();
        var propierty     = $("#propierty").val();
        var phoneBussines = $("#phoneBussines").val();
        var arrayContacts = [];
        var numContatcs   = 0;
        
        var ext              = image.substring(image.lastIndexOf("."));
        
        if(ext == 'jpg' || ext == 'png' || ext == 'jpeg'){
            
        }else{
         // flag = "false";   
        }
        
          $('.contentNewContact').each(function(){
            
          var nameContact = $(this).find('.nameContact').val();
          var cargo       = $(this).find('.cargo').val();
          var email       = $(this).find('.email').val();
          var phone       = $(this).find('.phone').val();
          var extension   = $(this).find('.extension').val();
          var cel         = $(this).find('.cel').val();
          
           var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g; 
           
           if(nameContact == ""){
               nameContact = "N/A";
           }
           if(cargo == ""){
               cargo = "N/A";
           }
           if(email == ""){
               email = "N/A";
           }
            if(phone == ""){
               phone = "N/A";
           }
            if(extension == ""){
               extension = "N/A";
           }
            if(cel == ""){
               cel = "N/A";
           }
               
                if(typeof nameContact != "undefined"){
          arrayContacts[numContatcs] = new Array(nameContact
                                       ,cargo
                                       ,email
                                       ,phone
                                       ,extension
                                       ,cel);
          numContatcs++;
      }
     

         });
        
        console.log(arrayContacts);
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        if (firstName == "") {
            flag = "false";
            $("#firstName").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (city == "") {
            flag = "false";
            $("#city").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (state == "") {
            flag = "false";
            $("#state").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (country == "") {
            flag = "false";
            $("#country").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (giro < 0) {
            flag = "false";
            $("#giro").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (cat < 0) {
            flag = "false";
            $("#cat").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (origen < 0) {
            flag = "false";
            $("#origen").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('firstName', firstName);
            sendData.append('domicilio', domicilio);
            sendData.append('city',      city);
            sendData.append('state',     state);
            sendData.append('email',     emailEmp);
            sendData.append('giro',      giro);
            sendData.append('cat',       cat);
            sendData.append('origen',    origen);
            sendData.append('country',   country);
            sendData.append('web',       web);
            sendData.append('rfc',       rfc);
            sendData.append('phoneBussines', phoneBussines);
            sendData.append('propierty',     propierty);
            sendData.append('image',     $('#image')[0].files[0]);
            sendData.append('arrayContacts', JSON.stringify(arrayContacts));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addbusinessDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    var resp = JSON.parse(response);
                    $.LoadingOverlay("hide");
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Empresa creada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/detEmpresa/"+resp.id+"";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar empresa'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
  $(document).on('click', '.btn_deleteBussines', function () {
        var pkBusiness        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de inactivar esta empresa?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, inactivar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBusiness": pkBusiness},
                    url: '/deleteBusiness',
                    beforeSend: function () {
                      $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");  
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Empresa inactivada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar empresa'
                            });
                        }
                    }
                });
            }
        });
    });
    
  $(document).on('click', '.btn-addContact', function () {
        var flag        = "true";
        var slcBussines  = $('#slcBussines').data('id');
        
        if(slcBussines < 0){
           flag = "false";
        }
        
        if (flag == "true") {

           $('.modaladdContact').trigger('click');
                    
        } else {
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Debes seleccionar primero una empresa'
                });
        }
    });
    
  $(document).on('click', '.btn-addContact2', function () {
        var flag        = "true";
        var slcBussines  = $('#slcBussines2').data('id');
        
        if(slcBussines < 0){
           flag = "false";
        }
        
        if (flag == "true") {

           $('.modaladdContact').trigger('click');
                    
        } else {
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Debes seleccionar primero una empresa'
                });
        }
    });
    
  $(document).on('change', '#slcBussines', function () {
        var slcBussines     = $(this).data('id');
        console.log(slcBussines);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "slcBussines": slcBussines},
                url: '/getContactBussines',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#slcContact').empty();
                       $('#slcContact').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
  $(document).on('click', '#btn_addcontactBussines2', function () {
        
          var flag        = "true";
          var nameContact = $('#nameContact').val();
          var cargo       = $('#cargo').val();
          var email       = $('#email').val();
          var phone       = $('#phone').val();
          var extension   = $('#extension').val();
          var cel         = $('#cel').val();
     
          
         if(typeof $('#slcBussines').val() == "undefined"){
             
             if(typeof $('#slcBussines2').val() != "undefined"){
               var slcBussines = $('#slcBussines2').data('id');  
             }
         }else{
           var slcBussines = $('#slcBussines').data('id');   
         }
        

        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('nameContact', nameContact);
            sendData.append('cargo',     cargo);
            sendData.append('email',     email);
            sendData.append('phone',     phone);
            sendData.append('extension', extension);
            sendData.append('cel',       cel);
            sendData.append('slcBussines', slcBussines);
            
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addbusinessContactDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    console.log(response);
                    $.LoadingOverlay("hide");
                 var resp = JSON.parse(response);
                 
                    if(resp.valid == "true"){
                       
                        Swal.fire({
                            type: 'Agregado',
                            title: 'Agregado',
                            text: 'contacto agregado con exito'
                        });
                        
                        $('#slcContact').empty();
                        $('#slcContact').html(resp.view);
                        $('#slcContact2').empty();
                        $('#slcContact2').html(resp.view);
                        $('#slcContact3').empty();
                        $('#slcContact3').html(resp.view);
                        
                        $('#closeModalAddContact').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
  $(document).on('click', '#createOportunity', function () {
        
          var flag        = "true";
          var slcBussines = $('#slcBussines').data('id');
          var slcContact  = $('#slcContact').val();
          var qtyEmployee = $('#qtyEmployee').val();
          var slcCourse   = $('#slcCourse').val();
          var qtyPlace    = $('#qtyPlace_1').val();
          var slcAgent    = $('#slcAgent').val();
          var mont        = $('#precio_1').val();
          var customradio1= $('input:radio[name=pres]:checked').val();
          var necesites   = $('#necesites').val();
          var comments    = $('#comments').val();
          var level       = $('#level').val();
          var slcPayment  = $('#slcPayment').val();
          var name        = $('#name').val();

        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var numRegex    = /^[a-zA-Z0-9-]+$/g;
        

          console.log(slcCourse);
        
         if (name == '') {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
          if (mont == "") {
            flag = "false";
            console.log("mont");
            $("#mont").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (qtyPlace == "") {
            flag = "false";
             console.log("qtyPlace");
            $("#qtyPlace").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (level < 0) {
            flag = "false";
            $("#level").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcPayment < 0) {
            flag = "false";
            $("#slcPayment").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcCourse.length == 0) {
            flag = "false";
            $("#slcCourse").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines', slcBussines);
            sendData.append('slcContact',  slcContact);
            sendData.append('qtyEmployee', qtyEmployee);
            sendData.append('slcCourse',    JSON.stringify(slcCourse));
            sendData.append('qtyPlace',    qtyPlace);
            sendData.append('slcAgent',    slcAgent);
            sendData.append('mont',        mont);
            sendData.append('customradio1',customradio1);
            sendData.append('necesites',   necesites);
            sendData.append('comments',    comments);
            sendData.append('level',       level);
            sendData.append('slcPayment',  slcPayment);
            sendData.append('name',        name);
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addOportunityDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.href = '/verOportunidades';
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#createOportunity2', function () {
        
          var flag        = "true";
          var slcBussines = $('#slcBussines2').data('id');
          var slcContact  = $('#slcContact2').val();
          var qtyEmployee = $('#qtyEmployee2').val();
          var slcCourse   = [];
          var slcAgent    = $('#slcAgent2').val();
          var customradio1= $('input:radio[name=pres2]:checked').val();
          var necesites   = $('#necesites2').val();
          var comments    = $('#comments2').val();
          var level       = $('#level2').val();
          var slcPayment  = $('#slcPayment2').val();
          var name        = $('#name2').val();
          var campaning   = $('#campaning').val();
          var comentPresupuesto  = $('#comentPresupuesto').val();
          var requicapa  = $('#requicapa').val();
          var con        = 0;
          var totalqty   = 0;
           $('.coursesOportunity').each(function(){
              
             var id = $(this).data('id');
             
             var qty     = $('#qtyEmployeeOp_'+id).val();
             var course  = $('#slcCourseOp_'+id).val();
             var price   = $('#precioOp_'+id).data('id');
             
           
        
               if (qty == "") {
            flag = "false";
            $('#qtyEmployeeOp_'+id).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
               if (price == "") {
            flag = "false";
            $('#precioOp_'+id).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
            if(flag == "true" && typeof qty != "undefined"){
                
                totalqty = totalqty + parseInt(qty);
             slcCourse[con] =  {"qty":qty,"course":course,"price":price};
             con++;
         }
             
             });
              

        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var numRegex    = /^[a-zA-Z0-9-]+$/g;
        
         if (name == '') {
            flag = "false";
            $("#name2").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines2").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact2").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
 
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent2").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines', slcBussines);
            sendData.append('slcContact',  slcContact);
            sendData.append('qtyEmployee', qtyEmployee);
            sendData.append('slcCourse',   JSON.stringify(slcCourse));
            sendData.append('slcAgent',    slcAgent);
            sendData.append('customradio1',customradio1);
            sendData.append('necesites',   necesites);
            sendData.append('comments',    comments);
            sendData.append('level',       level);
            sendData.append('slcPayment',  slcPayment);
            sendData.append('name',        name);
            sendData.append('campaning',   campaning);
            sendData.append('comentPresupuesto',   comentPresupuesto);
            sendData.append('requicapa',   requicapa);
            sendData.append('totalqty',   totalqty);
            
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addOportunityDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteOportunity', function () {
        var pkOportunity        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la oportunidad?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkOportunity": pkOportunity},
                    url: '/deleteOportunity',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Oportunidad eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar oportunidad'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '#addMoreOpcion', function () {
        var count = $("#count").val();
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {"count":count },
        url: '/getCoursesQuotation2',
        beforeSend: function () {
        },
        success: function (response) {
            console.log(response);
            
            $("#addContentOPcion").append('<div class="contentNewOpcion" style="margin-top:10px">'
                    + '  <div class="row" style="background:#dadada;padding: 5px 10px;margin-bottom: 15px;margin-top:30px;">'
                    + '       <div class="col-sm-4 mt-1">'
                    + '          <div class="nav-small-cap">- - - OPCIÓN ' + count + ' </div>'
                    + '            </div>'
                    + '         <div class="col-md-7 mt-1">'
                    + '             <div class="form-group d-flex mb-0">'
                    + '                 <label class="control-label mr-5 mb-0">Tipo de precio</label>'
                    + '                 <div class="custom-control custom-radio mr-4">'
                    + '                     <input type="radio" class="custom-control-input typePriceN" name="typePrice1' + count + '"  value="0" id="rNormal' + count + '">'
                    + '                     <label class="custom-control-label mb-0" for="rNormal' + count + '">Normal</label>'
                    + '                 </div>'
                    + '                 <div class="custom-control custom-radio mr-4">'
                    + '                     <input type="radio" class="custom-control-input typePriceP" name="typePrice1' + count + '" checked value="1" id="rPromo' + count + '">'
                    + '                     <label class="custom-control-label mb-0" for="rPromo' + count + '">Promoción</label>'
                    + '                 </div>'
                    + '             </div>'
                    + '         </div>'
                    + '         <div class="col-sm-1 pr-0 text-right"><button type="button" class="btn btn-danger btn-sm btn_deleteNewOption" data-id="4"><span class="ti-close"></span></button></div> '
                    +'  </div>'
                    + '  <div class="form-row">'

                    + '               <div id="coursesQuotationC_' + count + '" class="coursesQuotationC">'
                    + '    <div class="row coursesQuotationC_' + count + ' coursesQuotationC_detail" data-id="' + count + '">'
                    + '  <div class="col-md-5">'
                    + '  <div class="form-group">'
                    + '   <label class="control-label">Cantidad de colaboradores / lugares'

                    + '  </label>'
                    + '  <div class="input-group">'
                    + '   <div class="input-group-prepend">'
                    + '  <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + ' </div>'
                    + ' <input id="qtyEmployeeQC_' + count + '_1" type="number" data-op="' + count + '" data-id="1" class="form-control qtyEmployeeQC" placeholder="0">'
                    + '  </div>'
                    + ' </div>'
                    + ' </div>'
                    + ' <div class="col-md-4">'
                    + '  <div class="form-group">'
                    + '          <label class="control-label">Cursos'

                    + '       </label>'

                    +  response
                    + ' </div>'

                    + '  </div>'
                    + '   <div class="col-md-3">'
                    + '   <div class="form-group">'
                    + '     <label class="control-label">Precio total</label>'
                    + '    <div class="input-group">'
                    + '     <div class="input-group-prepend">'
                    + '        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + '    </div>'
                    + '   <input id="precioQC_' + count + '_1" data-id="0" type="text"  class="form-control precioQC" placeholder="$ 0.00">'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '     <input type="hidden" id="countQuotationC_' + count + '" value="2"/>'
                    + '   <div class="col-12 text-right">'
                    + '           <div class="form-group">'
                    + '   <div  style="margin-top: 1.5px; "><button type="button" data-id="'+count+'" class="btn btn-secondary addMoreCourseQuotationConvert" id="addMoreCourseQuotationConvert"><span class="ti - plus"></span> Agregar Más Cursos</button></div>'
                    + '          </div>'
                    + '    </div>'
            
                     + '      <div class="row">'
                       + '           <div class="col-md-3">'
                       + '         <div class="form-group">'
                            + '     <label class="control-label">Subtotal</label>'
                            + '     <div class="input-group">'
                                + '     <div class="input-group-prepend">'
                                  + '       <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                 + '    </div>'
                                  + '    <input id="subQC_' + count + '" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control subQC" placeholder="$ 0.00">  '
                               + '  </div>'
                             + '   </div>'
                         + '    </div>'
                            + '      <div class="col-md-3">'
                             + '    <div class="form-group">'
                             + '    <label class="control-label">Descuento</label>'
                              + '   <div class="input-group">'
                              + '       <div class="input-group-prepend">'
                                    + '     <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                  + '   </div>'
                               + '      <input id="descQC_' + count + '" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control descQC" placeholder="$ 0.00">  '
                                 + '</div>'
                              + '   </div>'
                           + '  </div>'
                              + '    <div class="col-md-3">'
                              + '   <div class="form-group">'
                              + '   <label class="control-label">Total</label>'
                              + '   <div class="input-group">'
                                + '     <div class="input-group-prepend">'
                                 + '        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                 + '    </div>'
                                + '      <input id="totalQC_' + count + '" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control totalQC" placeholder="$ 0.00">  '
                             + '    </div>'
                             + '    </div>'
                          + '   </div>'

                          + '    <div class="col-md-1" >'
                          + '                             <div class="form-group">'
                          + '                               <button type="button" style="margin-top:30px; display:none"'
                          + '                                 class="btn btn-danger CanceleditTotal" data-id="1"'
                          + '                                 id="CanceleditTotal_' + count + '"><span class="ti-close"></span></button>'
                         
                          + '                                <button type="button" style="margin-top:30px;display:block"'
                          + '                                   class="btn btn-primary editTotal" data-id="1"'
                          + '                                     id="editTotal_' + count + '"><span class="ti-pencil-alt"></span></button>'
                          + '                              </div>'
                          + '                           </div>'
          
                          + '                           <input type="hidden" id="editQ_' + count + '" value="0">'

                                  
                               + '     <div class="col-md-2">'
                             + '    <div class="form-group">'
                                     + '<button type="button" style="margin-top:30px" class="btn btn-secondary recalcularQC"  data-id="' + count + '" id="recalcularQC">Recalcular</button>'
                           + '   </div>'
                         + '     </div>'
                                                            
                         + '   </div> '
            

                    + '         <div class="col-sm-6">'
                    + '             <label class="control-label">Vigencia opción ' + count + '</label>'
                    + '             <div class="input-group">'
                    + '               <div class="input-group-prepend">'
                    + '                 <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>'
                    + '               </div>'
                    + '               <input type="date" id="vigencia" class="form-control vigencia">'
                    + '             </div>'
                    + '         </div></div>'
                    + '</div></div>');
            count++;
            $("#count").val(count);
        }
    });

    });

    $(document).on('click', '#addMoreOpcion3', function () {
        var count = $("#count").val();
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {"count":count },
        url: '/getCoursesQuotation2',
        beforeSend: function () {
        },
        success: function (response) {
            console.log(response);
            
            $("#addContentOPcion").append('<div class="contentNewOpcion" style="margin-top:10px">'
                    + '  <div class="row" style="background:#dadada;padding: 5px 10px;margin-bottom: 15px;margin-top:30px;">'
                    + '       <div class="col-sm-4 mt-1">'
                    + '          <div class="nav-small-cap">- - - NUEVA OPCIÓN </div>'
                    + '       </div>'
                    + '         <div class="col-md-7 mt-1">'
                    + '             <div class="form-group d-flex mb-0">'
                    + '                 <label class="control-label mr-5 mb-0">Tipo de precio</label>'
                    + '                 <div class="custom-control custom-radio mr-4">'
                    + '                     <input type="radio" class="custom-control-input typePriceN" name="typePrice1' + count + '"  value="0" id="rNormal' + count + '">'
                    + '                     <label class="custom-control-label mb-0" for="rNormal' + count + '">Normal</label>'
                    + '                 </div>'
                    + '                 <div class="custom-control custom-radio mr-4">'
                    + '                     <input type="radio" class="custom-control-input typePriceP" name="typePrice1' + count + '"  value="1" id="rPromo' + count + '">'
                    + '                     <label class="custom-control-label mb-0" for="rPromo' + count + '">Promoción</label>'
                    + '                 </div>'
                    + '             </div>'
                    + '         </div>'
                    + '       <div class="col-sm-1 text-right pr-0">'
                    + '          <button type="button" class="btn btn-danger btn-sm btn_deleteNewOption" data-id="4"><span class="ti-close"></span></button>'
                    + '       </div>'
                    + '     </div>'
                    + '  <div class="form-row">'

                    + '               <div id="coursesQuotationC_' + count + '" class="coursesQuotationC">'
                    + '    <div class="row coursesQuotationC_' + count + ' coursesQuotationC_detail" data-id="' + count + '">'
                    + '  <div class="col-md-5">'
                    + '  <div class="form-group">'
                    + '   <label class="control-label">Cantidad de colaboradores / lugares'

                    + '  </label>'
                    + '  <div class="input-group">'
                    + '   <div class="input-group-prepend">'
                    + '  <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + ' </div>'
                    + ' <input id="qtyEmployeeQC_' + count + '_1" type="number" data-op="' + count + '" data-id="1" class="form-control qtyEmployeeQC" placeholder="0">'
                    + '  </div>'
                    + ' </div>'
                    + ' </div>'
                    + ' <div class="col-md-4">'
                    + '  <div class="form-group">'
                    + '          <label class="control-label">Cursos'

                    + '       </label>'

                    +  response
                    + ' </div>'

                    + '  </div>'
                    + '   <div class="col-md-3" style="margin-top: 40px">'
                    + '     <div class="form-group">'
                    + '       <label class="control-label">Precio Unitario</label>'
                    + '         <div class="input-group">'
                    + '            <div class="input-group-prepend">'
                    + '               <span class="input-group-text"'
                    + '                id="basic-addon11"><i'
                    + '                    class="ti-money"></i></span>'
                    + '              </div>'
                    + '                <input id="precioU_' + count + '_1" data-id="0" data-iva-="0"'
                    + '                  type="text" class="form-control precioU"'
                    + '                    placeholder="$ 0.00">'
                    + '               </div>'
                    + '            </div>'
                    + '           </div>'
                    + '   <div class="col-md-3">'
                    + '   <div class="form-group">'
                    + '     <label class="control-label">Precio total</label>'
                    + '    <div class="input-group">'
                    + '     <div class="input-group-prepend">'
                    + '        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + '    </div>'
                    + '   <input id="precioQC_' + count + '_1" data-id="0" type="text"  class="form-control precioQC" placeholder="$ 0.00">'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '     <input type="hidden" id="countQuotationC_' + count + '" value="2"/>'
                    + '   <div class="col-12 text-right">'
                    + '           <div class="form-group">'
                    + '   <div  style="margin-top: 1.5px; "><button type="button" data-id="'+count+'" class="btn btn-secondary addMoreCourseQuotationConvert" id="addMoreCourseQuotationConvert"><span class="ti-plus"></span> Agregar Más Cursos</button></div>'
                    + '          </div>'
                    + '    </div>'
            
                     + '      <div class="row">'
                       + '           <div class="col-md-3">'
                       + '         <div class="form-group">'
                            + '     <label class="control-label">Subtotal</label>'
                            + '     <div class="input-group">'
                                + '     <div class="input-group-prepend">'
                                  + '       <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                 + '    </div>'
                                  + '    <input id="subQC_' + count + '" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control subQC" placeholder="$ 0.00">  '
                               + '  </div>'
                             + '   </div>'
                         + '    </div>'
                            + '      <div class="col-md-3">'
                             + '    <div class="form-group">'
                             + '    <label class="control-label">Descuento</label>'
                              + '   <div class="input-group">'
                              + '       <div class="input-group-prepend">'
                                    + '     <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                  + '   </div>'
                               + '      <input id="descQC_' + count + '" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control descQC" placeholder="$ 0.00">  '
                                 + '</div>'
                              + '   </div>'
                           + '  </div>'
                              + '    <div class="col-md-3">'
                              + '   <div class="form-group">'
                              + '   <label class="control-label">Total</label>'
                              + '   <div class="input-group">'
                                + '     <div class="input-group-prepend">'
                                 + '        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                 + '    </div>'
                                + '      <input id="totalQC_' + count + '" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control totalQC" placeholder="$ 0.00">  '
                             + '    </div>'
                             + '    </div>'
                          + '   </div>'

                          + '   <div class="col-md-1" >'
                          + '  <div class="form-group">'

                          + '    <button type="button" style="margin-top:30px; display:none"'
                          + '    class="btn btn-danger CanceleditTotal" data-id="'+ count + '"'
                          + '    id="CanceleditTotal_'+ count + '"><span class="ti-close"></span></button>'

                          + '    <button type="button" style="margin-top:30px;display:block"'
                          + '      class="btn btn-primary editTotal" data-id="'+ count + '"'
                          + '    id="editTotal_'+ count + '"><span class="ti-pencil-alt"></span></button>'
                                + ' </div>'
                                + '  </div>'
                       
                                + '  <input type="hidden" id="editQ_'+ count + '" class="editQ" value="0">'
                                  
                               + '     <div class="col-md-2">'
                             + '    <div class="form-group">'
                                     + '<button type="button" style="margin-top:30px" class="btn btn-secondary recalcularQC" data-id="1" id="recalcular">Recalcular</button>'
                           + '   </div>'
                         + '     </div>'
                                                            
                         + '   </div> '
            

                    + '         <div class="col-sm-6">'
                    + '             <label class="control-label">Nueva Vigencia</label>'
                    + '             <div class="input-group">'
                    + '               <div class="input-group-prepend">'
                    + '                 <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>'
                    + '               </div>'
                    + '               <input type="date" id="vigencia" class="form-control vigencia">'
                    + '             </div>'
                    + '         </div></div>'
                    + '</div></div>');
            count++;
            $("#count").val(count);
        }
    });

    });
    
    $(document).on('click', '#addMoreOpcion2', function () {
          var count = $("#count2").val();
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {"count":count },
        url: '/getCoursesQuotation',
        beforeSend: function () {
        },
        success: function (response) {
            
            console.log(response);
            
            $("#addContentOPcion2").append('<div class="contentNewOpcion2" style="margin-top:10px">'
                    + '  <div class="row" style="background:#dadada;padding: 5px 10px;margin-bottom: 15px;margin-top:30px;">'
                    + '       <div class="col-sm-4 mt-1">'
                    + '          <div class="nav-small-cap">- - - OPCIÓN ' + count + ' </div>'
                    + '       </div>'
                    + '       <div class="col-md-7 mt-1">'
                    + '             <div class="form-group d-flex mb-0">'
                    + '                 <label class="control-label mr-5 mb-0">Tipo de precio</label>'
                    + '                 <div class="custom-control custom-radio mr-4">'
                    + '                     <input type="radio"  class="custom-control-input typePriceN" name="typePrice2' + count + '"  value="0" id="rNormal' + count + '">'
                    + '                     <label class="custom-control-label mb-0" for="rNormal' + count + '">Normal</label>'
                    + '                 </div>'
                    + '                 <div class="custom-control custom-radio mr-4">'
                    + '                     <input type="radio" class="custom-control-input typePriceP" name="typePrice2' + count + '"  checked value="1" id="rPromo' + count + '">'
                    + '                     <label class="custom-control-label mb-0" for="rPromo' + count + '">Promoción</label>'
                    + '                 </div>'
                    + '             </div>'
                    + '         </div>'
                    +'          <div class="col-sm-1 text-right pr-0"><button type="button" class="btn btn-danger btn-sm btn_deleteNewOption" data-id="4"><span class="ti-close"></span></button></div> '
                    + '  </div>'
                    + '  <div class="form-row">'

                    + '               <div id="coursesQuotation_' + count + '" class="coursesQuotation">'
                    + '    <div class="row coursesQuotation_' + count + ' coursesQuotation_detail" data-id="1">'
                    + '  <div class="col-md-2">'
                    + '  <div class="form-group">'
                    + '   <label class="control-label">Cantidad de colaboradores / lugares'

                    + '  </label>'
                    + '  <div class="input-group">'
                    + '   <div class="input-group-prepend">'
                    + '  <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + ' </div>'
                    + ' <input id="qtyEmployeeQ_' + count + '_1" type="number" data-op="' + count + '" data-id="1" class="form-control qtyEmployeeQ" placeholder="0">'
                    + '  </div>'
                    + ' </div>'
                    + ' </div>'
                    + ' <div class="col-md-4" style="margin-top: 40px">'
                    + '  <div class="form-group">'
                    + '          <label class="control-label">Cursos'

                    + '       </label>'

                    +  response
                    + ' </div>'

                    + '  </div>'

                    + ' <div class="col-md-3" style="margin-top: 40px">'
                    + '  <div class="form-group">'
                    + '   <label class="control-label">Precio Unitario</label>'
                    + '   <div class="input-group">'
                    + '      <div class="input-group-prepend">'
                    + '         <span class="input-group-text"'
                    + '            id="basic-addon11"><i'
                    + '               class="ti-money"></i></span>'
                    + '      </div>'
                    + '      <input id="precioU_' + count + '_1" data-id="0" data-iva-="0"'
                    + '        type="text" class="form-control precioU"'
                    + '      placeholder="$ 0.00">'
                    + '     </div>'
                    + '   </div>'
                    + '</div>'

                    + '   <div class="col-md-3" style="margin-top: 40px">'
                    + '   <div class="form-group">'
                    + '     <label class="control-label">Precio total</label>'
                    + '    <div class="input-group">'
                    + '     <div class="input-group-prepend">'
                    + '        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + '    </div>'
                    + '   <input id="precioQ_' + count + '_1" data-id="0" data-iva-="0" type="text"  class="form-control precioQ" placeholder="$ 0.00">'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
            
                                + '   <div class="col-12 text-right">'
                    + '           <div class="form-group">'
                    + '   <div  style="margin-top: 1.5px; "><button type="button" data-id="'+count+'" class="btn btn-secondary addMoreCourseQuotation" id="addMoreCourseQuotation"><span class="ti-plus"></span> Agregar Más Cursos</button></div>'
                    + '          </div>'
                    + '    </div>'
            
           +' <div class="row">'
                   +            '  <div class="col-md-3">'
                    +          ' <div class="form-group">'
                    +          '  <label class="control-label">Subtotal</label>'
                     +         '  <div class="input-group">'
                      +            '  <div class="input-group-prepend">'
                       +            '     <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                        +           ' </div>'
                         +           ' <input disabled="true" id="subQ_' + count + '" data-id="0" data-iva="0" type="text"  class="form-control subQ" placeholder="$ 0.00">  '
                          +   '   </div>'
                           +   ' </div>'
                          + ' </div>'
                           +      '<div class="col-md-3">'
                            +   ' <div class="form-group">'
                             +  ' <label class="control-label">Descuento</label>'
                              + ' <div class="input-group">'
                               +    ' <div class="input-group-prepend">'
                                +     '   <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                 +  ' </div>'
                                  +   '<input disabled="true" id="descQ_' + count + '" data-id="0" data-iva="0" type="text"  class="form-control descQ" placeholder="$ 0.00">  '
                           +   '  </div>'
                            +   ' </div>'
                          + ' </div>'
                           +   '   <div class="col-md-3">'
                            +  '  <div class="form-group">'
                             + '  <label class="control-label">Total</label>'
                              +'  <div class="input-group">'
                               +  '   <div class="input-group-prepend">'
                                + '       <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                                 +'   </div>'
                                 + '   <input disabled="true" id="totalQ_' + count + '"  data-row="'+ count +'" data-id="0" data-iva="0" type="text"  class="form-control totalQ" placeholder="$ 0.00">'
                            + '   </div>'
                       + '        </div>'
                        +   ' </div>'

                        + '    <div class="col-md-1" >'
                        + '                             <div class="form-group">'
                        + '                               <button type="button" style="margin-top:30px; display:none"'
                        + '                                 class="btn btn-danger CanceleditTotal" data-id="' + count + '"'
                        + '                                 id="CanceleditTotal_' + count + '"><span class="ti-close"></span></button>'
                       
                        + '                                <button type="button" style="margin-top:30px;display:block"'
                        + '                                   class="btn btn-primary editTotal" data-id="' + count + '"'
                        + '                                     id="editTotal_' + count + '"><span class="ti-pencil-alt"></span></button>'
                        + '                              </div>'
                        + '                           </div>'
        
                        + '                           <input type="hidden" id="editQ_' + count + '" class="editQ" value="0">'

                            +   '        <div class="col-md-2">'
                            +   '     <div class="form-group">'
                             +   '        <button type="button" style="margin-top:30px" class="btn btn-secondary recalcular" data-id="' + count + '" id="recalcular">Recalcular</button>'
                             +   '    </div>'
                          +   '   </div>'
                                                            
                         + ' </div>'
            
                    + '     <input type="hidden" id="countQuotation_' + count + '" value="2"/>'


                    + '         <div class="col-sm-6">'
                    + '             <label class="control-label">Vigencia opción ' + count + '</label>'
                    + '             <div class="input-group">'
                    + '               <div class="input-group-prepend">'
                    + '                 <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>'
                    + '               </div>'
                    + '               <input type="date" id="vigencia2" class="form-control vigencia2">'
                    + '             </div>'
                    + '         </div></div>'
                    + '</div></div>');
            count++;
            $("#count2").val(count);
        }
    });



      
    });
    
    $(document).on('click', '.btn_deleteNewOption', function () {
var count = $("#count2").val() - 1;
       $("#count2").val(count);
       $(this).parent().parent().parent().empty();
    });
    
    $(document).on('click', '#btnCreateQuotation', function () {
        
          var flag         = "true";
          var slcBussines  = $('#slcBussines').data('id');
          var slcContact   = $('#slcContact').val();
          var vigency      = $('#vigency').val();
          var slcAgent     = $('#slcAgent').val();
          var slcPayment   = $('#slcPayment').val();
          var level        = $('#level').val();
          var name         = $('#name').val();    
          var arrayOptions = [];
          var numOptions   = 0;
          var numRadio     = 1;
          
              $('.contentNewOpcion').each(function(){
            
          var qtyPlaces   = $(this).find('.qtyPlaces').val();
          var price       = $(this).find('.price').val();
          var typePrice   = $(this).find('input:radio[name=typePrice'+numRadio+']:checked').val();
          var vigencia    = $(this).find('.vigencia').val();
     
     if(typeof qtyPlaces != "undefined"){
          arrayOptions[numOptions] = new Array(qtyPlaces
                                       ,price
                                       ,typePrice
                                       ,vigencia);
             
               var numRegex    = /^[a-zA-Z0-9-]+$/g; 
               
              if (price == "") {
            flag = "false";
            $(this).find('.price').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
                                       
                 numOptions++;
                          }        
               numRadio++;
         });
        
          console.log(arrayOptions);

        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
              
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines', slcBussines);
            sendData.append('slcContact',  slcContact);
            sendData.append('slcAgent',    slcAgent);
            sendData.append('level',       level);
            sendData.append('vigency',     vigency);
            sendData.append('name',        name);
            sendData.append('slcPayment', slcPayment);
            sendData.append('arrayOptions', JSON.stringify(arrayOptions));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addQuotationDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.href = '/verCotizaciones';
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
      $(document).on('change', 'input:radio[name=iva]:checked', function () {
        var conIva     = $(this).val();
        
         $('.contentNewOpcion2').each(function(){
             
               var subtotal        = $(this).find('.subQ').data('id');
              var subtotalIva     = $(this).find('.subQ').data('iva');
              
              var descuento        = $(this).find('.descQ').data('id');
              var descuentoIva     = $(this).find('.descQ').data('iva');
              
              var total           = $(this).find('.totalQ').data('id');
              var totalIva        = $(this).find('.totalQ').data('iva');
              
             
             $(this).find('.coursesQuotation').each(function(){ 
                 
              $(this).find('.coursesQuotation_detail').each(function(){ 
                  
              var price        = $(this).find('.precioQ').data('id');
              var priceIva     = $(this).find('.precioQ').data('iva');
              
               if(conIva == 1){
                 $(this).find('.precioQ').val(number_format(priceIva,2)); 
                 
               }else{
                 $(this).find('.precioQ').val(number_format(price,2)); 
               }
              });
           });
           
            if(conIva == 1){
                 $(this).find('.subQ').val(number_format(subtotalIva,2)); 
                 $(this).find('.descQ').val(number_format(descuentoIva,2)); 
                 $(this).find('.totalQ').val(number_format(totalIva,2)); 

               }else{
                 $(this).find('.subQ').val(number_format(subtotal,2)); 
                 $(this).find('.descQ').val(number_format(descuento,2)); 
                 $(this).find('.totalQ').val(number_format(total,2)); 
               }
               
              console.log("s"+subtotalIva);
              console.log("s"+subtotal);
              
              console.log("d"+descuentoIva);
              console.log("d"+descuento);
              
              console.log("t"+totalIva);
              console.log("ti"+total);
         });
         
         
         console.log(conIva);
       
    });
    
     $(document).on('change', 'input:radio[name=iva2]:checked', function () {
         var conIva     = $(this).val();
        
         $('.contentNewOpcion').each(function(){
             
               var subtotal        = $(this).find('.subQC').data('id');
              var subtotalIva     = $(this).find('.subQC').data('iva');
              
              var descuento        = $(this).find('.descQC').data('id');
              var descuentoIva     = $(this).find('.descQC').data('iva');
              
              var total           = $(this).find('.totalQC').data('id');
              var totalIva        = $(this).find('.totalQC').data('iva');
              
             
             $(this).find('.coursesQuotationC').each(function(){ 
                 
              $(this).find('.coursesQuotationC_detail').each(function(){ 
                  
              var price        = $(this).find('.precioQC').data('id');
              var priceIva     = $(this).find('.precioQC').data('iva');
              
               if(conIva == 1){
                 $(this).find('.precioQC').val(number_format(priceIva,2)); 
                 
               }else{
                 $(this).find('.precioQC').val(number_format(price,2)); 
               }
              });
           });
           
            if(conIva == 1){
                 $(this).find('.subQC').val(number_format(subtotalIva,2)); 
                 $(this).find('.descQC').val(number_format(descuentoIva,2)); 
                 $(this).find('.totalQC').val(number_format(totalIva,2)); 

               }else{
                 $(this).find('.subQC').val(number_format(subtotal,2)); 
                 $(this).find('.descQC').val(number_format(descuento,2)); 
                 $(this).find('.totalQC').val(number_format(total,2)); 
               }
               
              console.log("s"+subtotalIva);
              console.log("s"+subtotal);
              
              console.log("d"+descuentoIva);
              console.log("d"+descuento);
              
              console.log("t"+totalIva);
              console.log("ti"+total);
         });
         
         
         console.log(conIva);
       
    });
    
    $(document).on('click', '#btnCreateQuotation2', function () {
        
          var flag         = "true";
          var slcBussines  = $('#slcBussines3').data('id');
          var slcContact   = $('#slcContact3').val();
          var vigency      = $('#vigency3').val();
          var slcAgent     = $('#slcAgent3').val();
          var level        = $('#level3').val();
          var name         = $('#name3').val(); 
          var slcPayment   = $('#slcPayment3').val();
          var campaning    = $('#campaningq').val();
          var iva          = $('input:radio[name=iva]:checked').val();
          var arrayOptions = [];
         
          var numOptions   = 0;
          var numRadio     = 1;
     
          
          $('.contentNewOpcion2').each(function(){
              
          var totalQty     = 0;     
          var totalPrice   = 0;
          var slcCourseQuo = [];
        //  var qtyPlaces    = $(this).find('.qtyPlaces2').val();
         // var price        = $(this).find('.price2').data('id');
          var typePrice    = $(this).find('input:radio[name=typePrice2'+numRadio+']:checked').val();
          var vigencia     = $(this).find('.vigencia2').val();
          var totalEdit   = $(this).find('#editQ_'+numRadio).val();
          console.log(totalEdit);
          var con = 0;
       if(typeof vigencia != "undefined"){  
          
          if(typeof typePrice != "undefined"){
              
          }else{
              flag = "false";
            $("input:radio[name=typePrice2"+numRadio+"]").parent().css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            });  
          }
          
            $('.coursesQuotation_'+numRadio).each(function(){
             
              
             var id = $(this).data('id');
             
             var qty     = $(this).find('.qtyEmployeeQ').val();
             var course  = $(this).find('.slcCourseQ').val();
             var price   = $(this).find('.precioQ').data('id');
            
             
            if(typeof qty != "undefined"){
               if (qty == "") {
            flag = "false";
            $(this).find('.qtyEmployeeQ').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
               if (price == "") {
            flag = "false";
            $(this).find('.precioQ').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
            if(flag == "true" && typeof qty != "undefined"){
                totalQty = totalQty + parseInt(qty);
             slcCourseQuo[con] =  {"qty":qty,"course":course,"price":price};
             console.log(price);
             totalPrice = totalPrice+price;
             con++;
         }
     }
             
             });
     
          arrayOptions[numOptions] = new Array(typePrice
                                              ,vigencia
                                              ,slcCourseQuo
                                              ,totalQty
                                              ,totalEdit
                                              ,totalPrice);
                 numOptions++;
                          }        
               numRadio++;
         });
   
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines3").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact3").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
              
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent3").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines', slcBussines);
            sendData.append('slcContact',  slcContact);
            sendData.append('slcAgent',    slcAgent);
            sendData.append('level',       level);
            sendData.append('vigency',     vigency);
            sendData.append('name',        name);
            sendData.append('iva',        iva);
            sendData.append('slcPayment', slcPayment);
            sendData.append('campaning', campaning);           
            sendData.append('arrayOptions', JSON.stringify(arrayOptions));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addQuotationDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar cotización'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteQuotation', function () {
        var pkQuotations        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la cotización?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkQuotations": pkQuotations},
                    url: '/deleteQuotation',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'cotización eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar cotización'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_viewQuotation', function () {
      var flag        = "true";
      var idQuotation = $(this).data('id');        
        
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idQuotation": idQuotation},
                url: '/viewDetailQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_updateBussines', function () {
        var flag        = "true";
        var pkBusiness  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkBusiness": pkBusiness},
                url: '/viewupdateBusiness',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                    $.LoadingOverlay("hide");
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_updateCompany', function () {
        
        var flag          = "true";
        var firstName   = $("#firstName").val();
        var web         = $("#web").val();
        var rfc         = $("#rfc").val();
        var domicilio   = $("#domicilio").val();
        var city        = $("#city").val();
        var state       = $("#state").val();
        var country     = $("#country").val();
        var emailEmp    = $("#emailEmp").val();
        var giro        = $("#giro").val();
        var cat         = $("#cat").val();
        var origen      = $("#origen").val();
        var image       = $("#image").val();
        var propierty     = $("#propierty").val();
        var phoneBussines = $("#phoneBussines").val();
        var arrayContacts = [];
        var numContatcs   = 0;
        var pkBusiness    = $(this).data('id');
        console.log(pkBusiness);
        var ext              = image.substring(image.lastIndexOf("."));
        
        if(ext == 'jpg' || ext == 'png' || ext == 'jpeg'){
            
        }else{
         // flag = "false";   
        }
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
      if (firstName == "") {
            flag = "false";
            $("#firstName").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (city == "") {
            flag = "false";
            $("#city").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (state == "") {
            flag = "false";
            $("#state").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (country == "") {
            flag = "false";
            $("#country").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (giro < 0) {
            flag = "false";
            $("#giro").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (cat < 0) {
            flag = "false";
            $("#cat").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (origen < 0) {
            flag = "false";
            $("#origen").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('firstName', firstName);
            sendData.append('domicilio', domicilio);
            sendData.append('city',      city);
            sendData.append('state',     state);
            sendData.append('email',     emailEmp);
            sendData.append('giro',      giro);
            sendData.append('cat',       cat);
            sendData.append('origen',    origen);
            sendData.append('country',   country);
            sendData.append('web',       web);
            sendData.append('rfc',       rfc);
            sendData.append('phoneBussines', phoneBussines);
            sendData.append('propierty',     propierty);
            sendData.append('pkBusiness',pkBusiness);
            sendData.append('image',     $('#image')[0].files[0]);
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/editupdateBusiness',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Modificado!',
                                'Empresa modificada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar empresa'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_editOportunity', function () {
        var flag        = "true";
        var pkOportunity  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkOportunity": pkOportunity},
                url: '/updateOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_editOportunitydb', function () {
        
          var flag        = "true";
          var slcBussines = $('#slcBussines').data('id');
          var slcContact  = $('#slcContact').val();
          var slcCourse   = [];
          var slcAgent    = $('#slcAgent').val();
          var customradio1= $('input:radio[name=pres]:checked').val();
          var necesites   = $('#necesites').val();
          var comments    = $('#comments').val();
          var level       = $('#level').val();
          var slcPayment  = $('#slcPayment').val();
          var name        = $('#name').val();
          var slcStatus   = $('#slcStatus').val(); 
          var pkOpportunities = $(this).data('id');
          var comentPresupuestos = $('#comentPresupuestos').val();
          var requicapas  = $('#requicapas').val();
          var con             = 0;
    
          
           $('.coursesOportunityEdit').each(function(){
              
             var id = $(this).data('id');
             
             var qty     = $('#qtyEmployeeOpEdit_'+id).val();
             var course  = $('#slcCourseOpEdit_'+id).val();
             var price   = $('#precioOpEdit_'+id).data('id');
             
           
        
               if (qty == "") {
            flag = "false";
            $('#qtyEmployeeOpEdit_'+id).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
               if (price == "") {
            flag = "false";
            $('#precioOpEdit_'+id).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
            if(flag == "true" && typeof qty != "undefined"){
             slcCourse[con] =  {"qty":qty,"course":course,"price":price};
             con++;
         }
             
             });

         
         if (name == '') {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
       
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcPayment < 0) {
            flag = "false";
            $("#slcPayment").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines', slcBussines);
            sendData.append('slcContact',  slcContact);
            sendData.append('slcCourse',   JSON.stringify(slcCourse));
            sendData.append('slcAgent',    slcAgent);
            sendData.append('customradio1',customradio1);
            sendData.append('necesites',   necesites);
            sendData.append('comments',    comments);
            sendData.append('level',       level);
            sendData.append('slcPayment',  slcPayment);
            sendData.append('name',        name);
            sendData.append('slcStatus',   slcStatus);
            sendData.append('comentPresupuestos',   comentPresupuestos);
            sendData.append('requicapas',   requicapas);
            sendData.append('pkOpportunities',  pkOpportunities);
            
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateOportunityDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    console.log(response);
                    if(response == "true"){
                       Swal.fire(
                                'Modificado!',
                                'Oportunidad modificada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.convertToQuotation', function () {
        var flag        = "true";
        var pkOportunity  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkOportunity": pkOportunity},
                url: '/convertToQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btnConvertQuotation', function () {
        
          var flag         = "true";
          var idOportunity = $(this).data('id');
          var slcBussines  = $('#slcBussines').data('id');
          var slcContact   = $('#slcContact').val();
          var vigency      = $('#vigency').val();
          var slcAgent     = $('#slcAgent').val();
          var level        = $('#level').val();
          var name         = $('#name').val();    
          var slcPayment   = $('#slcPayment').val();
          var campaning    = $('#campaningq').val();
          var iva          = $('input:radio[name=iva2]:checked').val();
          var arrayOptions = [];
          var numOptions   = 0;
          var numRadio     = 1;
          
          
       $('.contentNewOpcion').each(function(){
         var slcCourseQuo = [];
         var totalqty     = 0;
         var totalPrice   = 0;
        //  var qtyPlaces    = $(this).find('.qtyPlaces2').val();
         // var price        = $(this).find('.price2').data('id');
          var typePrice    = $(this).find('input:radio[name=typePrice1'+numRadio+']:checked').val();
          var vigencia     = $(this).find('.vigencia').val();
          var totalEdit    = $(this).find('#editQC_'+numRadio).val();
          var con = 0;
          
          console.log(typePrice);
          if(typeof typePrice != "undefined"){
              
          }else{
              flag = "false";
            $("input:radio[name=typePrice2"+numRadio+"]").parent().css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            });  
          }
          
            $('.coursesQuotationC_'+numRadio).each(function(){
             
              
             var id = $(this).data('id');
             
             var qty     = $(this).find('.qtyEmployeeQC').val();
             var course  = $(this).find('.slcCourseQC').val();
             var price   = $(this).find('.precioQC').data('id');
             
            if(typeof qty != "undefined"){
                
               if (qty == "") {
            flag = "false";
            $(this).find('.qtyEmployeeQC').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
               if (price == "") {
            flag = "false";
            $(this).find('.precioQC').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

           
            if(flag == "true" && typeof qty != "undefined"){
                totalqty = totalqty + parseInt(qty);
             slcCourseQuo[con] =  {"qty":qty,"course":course,"price":price};
             totalPrice = totalPrice+price;
             con++;
         }
     }
             
             });
     
     if(typeof vigencia != "undefined"){
         
          arrayOptions[numOptions] = new Array(typePrice
                                              ,vigencia
                                              ,slcCourseQuo
                                              ,totalqty
                                              ,totalEdit
                                              ,totalPrice);
                 numOptions++;
                          }        
               numRadio++;
         });
        
          console.log(arrayOptions);
          
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
              
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines', slcBussines);
            sendData.append('slcContact',  slcContact);
            sendData.append('slcAgent',    slcAgent);
            sendData.append('level',       level);
            sendData.append('vigency',     vigency);
            sendData.append('name',        name);
            sendData.append('iva',         iva);
            sendData.append('campaning',   campaning);
            sendData.append('idOportunity',idOportunity);
            sendData.append('slcPayment', slcPayment);
            sendData.append('arrayOptions', JSON.stringify(arrayOptions));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/convertToQuotationDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al convertir'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.updateQuotation', function () {
        var flag        = "true";
        var pkQuotations  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkQuotations": pkQuotations},
                url: '/updateQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btnUpdateQuotation', function () {
        
          var flag         = "true";
          var slcBussines  = $('#slcBussines').data('id');
          var slcContact   = $('#slcContact').val();
          var slcAgent     = $('#slcAgent').val();
          var level        = $('#level').val();
          var name         = $('#name').val();    
          var slcPayment   = $('#slcPayment').val();   
          var campaning    = $('#campaning').val();
          var iva          = $('input:radio[name=ivaM]:checked').val();
          var pkQuotations = $(this).data('id');
          
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
        if (slcBussines < 0) {
            flag = "false";
            $("#slcBussines").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcContact < 0) {
            flag = "false";
            $("#slcContact").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
              
        if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('slcBussines',  slcBussines);
            sendData.append('slcContact',   slcContact);
            sendData.append('slcAgent',     slcAgent);
            sendData.append('level',        level);
            sendData.append('name',         name);
            sendData.append('slcPayment',   slcPayment);
            sendData.append('iva',          iva);
            sendData.append('campaning',    campaning);
            sendData.append('pkQuotations', pkQuotations);
            
            
            
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateQuotationDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Modificado!',
                                'cotización modificada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteDetailQuotation', function () {
        var pkQuotationsDetail  = $(this).attr("data-id");
        var pkQuotations        = $(this).attr("data-quo");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la opcion de la cotización?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkQuotationsDetail": pkQuotationsDetail},
                    url: '/deleteDetailQuotation',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'cotización eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {

                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    data: {"idQuotation": pkQuotations},
                                    url: '/viewDetailQuotation',
                                    beforeSend: function () {
                                    },
                                    success: function (response) {
                                        if (response.valid == "true") {

                                            $('#modalUsuario').empty();
                                            $('#modalUsuario').html(response.view);
                                            location.reload();
                                        } else {
                                            Swal.fire({
                                                type: 'error',
                                                title: 'Oops...',
                                                text: 'Error al editar'
                                            });
                                        }
                                    }
                                });
                            });
                        }else{
                            if(response == "false2"){
                                Swal.fire({
                                    type: 'error',
                                    title: 'La cotización no puede quedar vacía',
                                    text: ''
                                });
                            }
                            else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar cotización'
                            });
                          }
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.viewBussinesContact', function () {
        var flag        = "true";
        var pkBusiness  = $(this).data('id');  
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkBusiness": pkBusiness},
                url: '/viewBusinessContact',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteContactBussines', function () {
        var pkContact  = $(this).attr("data-id");
        var business   = $(this).attr("data-business");
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el contacto?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkContact": pkContact},
                    url: '/deleteBusinessContact',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Contacto eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {

                               $.ajax({
                                 type: "POST",
                                 dataType: "json",
                                 data: {"pkBusiness":business},
                                 url: '/viewBusinessContact',
                                 beforeSend: function () {
                                      },
                                 success: function (response) {
                                if (response.valid == "true"){
                                     location.reload();
                                 } else{
                                 Swal.fire({
                                  type: 'error',
                                  title: 'Oops...',
                                     text: 'Error al editar'
                                    });
                                   }
                                  }
                                });
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar cotización'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '#addContactBussines', function () {
        var pkBusiness = $(this).data('id');
        
        $('#modalEditCat').empty();
        $("#modalEditCat").append('<div class="modal-content">'
        + '  <div class="modal-header">'
        + '<h2 class="modal-title" id="modalAgentesCLabel">Agregar Nuevo Contacto</h2>'
        + '   <button type="button" class="close" data-dismiss="modal" aria-label="Close">'
        + '  <span aria-hidden="true">&times;</span>'
        + '</button>'
        + ' </div>'
        + ' <div class="modal-body">'
        + '<div class="col-12 ">'
        + '  <h3 class="title-section mb-4 mt-3">Agregar Contacto(s)</h3>'
        + ' </div>'
        + '  <div id="addContentContact">'
        + '  <div class="contentNewContact row">'
        + '<div class="col-md-6">'
        + ' <div class="form-group">'
        + '    <label class="control-label">Nombre *</label>'
        + '    <div class="input-group">'
        + '       <div class="input-group-prepend">'
        + '         <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>'
        + '       </div>'
        + '       <input type="text" id="nombreContacto" class="form-control nameContact">'
        + '    </div>'
        + '  </div>'
        + ' </div>'
        + ' <div class="col-md-6">'
        + '    <div class="form-group">'
        + '       <label class="control-label">Cargo / Puesto *</label>'
        + '         <div class="input-group">'
        + '         <div class="input-group-prepend">'
        + '             <span class="input-group-text" id="basic-addon11"><i class="ti-medall"></i></span>'
        + '         </div>'
        + '         <input type="text" id="cargo" class="form-control cargo">'
        + '        </div>'
        + ' </div>'
        + ' </div>'
        + ' <div class="col-md-6">'
        + '    <div class="form-group">'
        + '       <label class="control-label">Correo *</label>'
        + '       <div class="input-group">'
        + '         <div class="input-group-prepend">'
        + '             <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>'
        + '         </div>'
        + '         <input type="email" id="correo" class="form-control email">'
        + '        </div>'
        + '     </div>'
        + ' </div>'
        + '  <div class="col-md-6">'
        + '     <div class="form-group">'
        + '        <label class="control-label">Teléfono fijo</label>'
        + '       <div class="input-group">'
        + '         <div class="input-group-prepend">'
        + '             <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>'
        + '         </div>'
        + '       <input type="text" id="phone" class="form-control phone" placeholder="Incluir código de área">'
        + '        </div>'
        + '  </div>'
        + ' </div>'
        + ' <div class="col-md-6">'
        + '    <div class="form-group">'
        + '       <label class="control-label">Extensión</label>'
        + '         <div class="input-group">'
        + '         <div class="input-group-prepend">'
        + '             <span class="input-group-text" id="basic-addon11"><i class="ti-plus"></i></span>'
        + '         </div>'
        + '         <input type="text" id="extension" class="form-control extension">'
        + '        </div>'
        + ' </div>'
        + ' </div>'
        + ' <div class="col-md-6">'
        + '    <div class="form-group">'
        + '       <label class="control-label">Teléfono móvil *</label>'
        + '       <div class="input-group">'
        + '         <div class="input-group-prepend">'
        + '             <span class="input-group-text" id="basic-addon11"><i class="ti-mobile"></i></span>'
        + '         </div>'
        + '      <input type="text" id="cel" class="form-control cel">'
        + '        </div>'
        + ' </div>'
        + '  </div>  '
        + ' </div>'
        + '     </div>'
        + ' <div class="col-12">'
        + '  <div class="form-group">'
        + ' <div class="add-user"><button type="button" class="btn btn-secondary"  id="addMoreContact"><span class="ti-user"></span> Agregar Más Contactos</button></div>'
        + ' </div>'
        + '  </div>'
        + ' <div class="form-actions">'
        + ' <div class="card-body">'
        + '  <button type="button" class="btn btn-success " id="btn_addcontactBussines" data-id="'+pkBusiness+'"> <i class="fa fa-check"></i> Agregar</button>'
        + '<button type="button" class="btn btn-secondary float-right" id="btn_returnContact" data-id="'+pkBusiness+'"> regresar</button>'
        + '    </div>'

        + '<div class="modal-footer">'
        + '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'
        + '</div>'
        + '</div>');       
    });
    
    $(document).on('click', '#btn_returnContact', function () {
        var flag        = "true";
        var pkBusiness  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkBusiness": pkBusiness},
                url: '/viewBusinessContact',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
  
    $(document).on('click', '#btn_addcontactBussines', function () {
        
        var flag        = "true";
        var pkBussiness = $(this).data('id');
         var arrayContacts = [];
        var numContatcs   = 0;
        
         $('.contentNewContact').each(function(){
            
          var nameContact = $(this).find('.nameContact').val();
          var cargo       = $(this).find('.cargo').val();
          var email       = $(this).find('.email').val();
          var phone       = $(this).find('.phone').val();
          var extension   = $(this).find('.extension').val();
          var cel         = $(this).find('.cel').val();
          
           var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g; 
           
           if(typeof nameContact != "undefined"){
               
          arrayContacts[numContatcs] = new Array(nameContact
                                       ,cargo
                                       ,email
                                       ,phone
                                       ,extension
                                       ,cel);
          numContatcs++;
                                   }
                                   

         });
        
       
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('pkBussiness', pkBussiness);
            sendData.append('arrayContacts', JSON.stringify(arrayContacts));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addContactBusinessDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                  $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                                'Agregado!',
                                'Contactos agregados con \u00E9xito.',
                                'success'
                            ).then((result) => {
                              $.ajax({
                                 type: "POST",
                                 dataType: "json",
                                 data: {"pkBusiness": pkBussiness},
                                 url: '/viewBusinessContact',
                                 beforeSend: function () {
                                      },
                                 success: function (response) {
                                  if(response.valid == "true"){
                                    $('#modalEditCat').empty();
                                    $('#modalEditCat').html(response.view);
                               
                                     }else{
                                      Swal.fire({
                                           type: 'error',
                                           title: 'Oops...',
                                           text: 'Error al editar'
                              });
                    }
                }
            });
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contactos'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#addOptionPerQuotation', function () {
        var pkQuotation = $(this).data('id');
        var count = 1;
        $.ajax({
        type: "POST",
        dataType: "html",
        data: {"count":count },
        url: '/getCoursesQuotation',
        beforeSend: function () {
        },
        success: function (response) {
        $('#modalUsuario').empty();
        
        
        $("#modalUsuario").append('<div class="modal-content">'
        + '  <div class="modal-header">'
        + '<h2 class="modal-title" id="modalAgentesCLabel">Opciones cotización</h2>'
        + '   <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">'
        + '  <span aria-hidden="true">&times;</span>'
        + '</button>'
        + ' </div>'
        + ' <div class="modal-body">'
            + '  <div class="col-md-12" id="addContentOPcion">'
            + '     <div class="contentNewOpcion">'
            + ' <div class="row">'
            + '   <div class="col-sm-4">'
            + '      <div class="nav-small-cap mb-2">- - - OPCIÓN 1</div>'
            + '   </div>'
            + '  <div class="col-sm-8">'
            + '  <div class="form-group d-flex">'
            + '    <label class="control-label mr-5">Tipo de precio</label>'
            + '  <div class="custom-control custom-radio mr-4">'
            + '      <input type="radio" class="custom-control-input typePriceN" name="typePrice1"  value="0" id="rNorma2">'
            + '    <label class="custom-control-label" for="rNorma2">Normal</label>'
            + ' </div>'
            + '  <div class="custom-control custom-radio mr-4">'
            + '     <input type="radio" class="custom-control-input typePriceP" name="typePrice1"  value="1" id="rProm2">'
            + '   <label class="custom-control-label" for="rProm2">Promoción</label>'
            + '   </div>'
            + '   </div>'
            + '   </div>'
            + '  </div>'
            + '   <div class="form-row">'
            + '       <div class="col-sm-4">'
            + '      <div class="form-group">'
            + '       <label class="control-label">Cantidad de lugares</label>'
            + '     <div class="input-group">'
            + '      <div class="input-group-prepend">'
            + '         <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
            + '     </div>'
            + ' <input type="number" id="qtyPlaces_1" data-id="1" class="form-control qtyPlaces">'
            + '    </div>'
            + '   </div>'
            + '  </div>'
            + '  <div class="col-md-4">'
            + '   <div class="form-group">'
            + ' <label class="control-label">Cursos</label>'
            + '   <br>'
            + ' <div class="btn-group" style="width: 100%;">'
            + ' <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;">'
            + '     Selecciona cursos'
            + '  </a>'
            + '  <ul class="dropdown-menu" style="width: 100%; height: 300px; overflow-y: scroll;">'
            + response
            + ' </ul>'
            + ' </div>'

            + '   </div>'
            + '  </div>'
            + '  <div class="col-sm-4">'
            + '    <div class="form-group">'
            + '     <label class="control-label">Precio total</label>'
            + '    <div class="input-group">'
            + '      <div class="input-group-prepend">'
            + '       <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
            + '   </div>'
            + '  <input type="text" id="precio_1" class="form-control price" placeholder="$ 0.00">'
            + ' </div>'
            + ' </div>'
            + '  </div>'
            + '   <div class="col-sm-6">'
            + '    <label class="control-label">Vigencia Opción 1</label>'
            + '   <div class="input-group">'
            + '    <div class="input-group-prepend">'
            + '    <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>'
            + '  </div>'
            + ' <input type="date" id="vigencia" class="form-control vigencia">'
            + ' </div>'
            + '  </div>'
            + '  </div>'
            + '  </div>'
            + ' </div>'
        + '<input type="hidden" id="count" value="2"/>'
        + '<div class="col-12">'
        + ' <div class="form-group">'
        + '  <div class="add-user" style="margin-top: 5px;"><button type="button" class="btn btn-secondary" id="addMoreOpcion"><span class="ti-plus"></span>Agregar Más Opciones</button></div>'
        + ' </div>'
        + '</div>'
        + '  <button type="button" class="btn btn-success " id="btn_addOptionsBussines" data-id="'+pkQuotation+'"> <i class="fa fa-check"></i> Agregar</button>'
        + '<button type="button" class="btn btn-secondary float-right" id="btn_returnOptions" data-id="'+pkQuotation+'"> regresar</button>'
        + '  </div>'
        + ' <div class="modal-footer">'
        + '   <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'
        + '</div>'
        + '</div>');   
         }
       });
    });
    
    $(document).on('click', '#btn_returnOptions', function () {
      var flag        = "true";
      var idQuotation = $(this).data('id');        
        
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idQuotation": idQuotation},
                url: '/viewDetailQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_addOptionsBussines', function () {
          var idQuotation = $(this).data('id');  
          var flag         = "true";
          var arrayOptions = [];
          var numOptions   = 0;
          var numRadio     = 1;
          var iva          = $("#iva").val();
          
                 
  $('.contentNewOpcion').each(function(){
         var totalQty     = 0;
         var totalPrice   = 0;
         var slcCourseQuo = [];
         
        //  var qtyPlaces    = $(this).find('.qtyPlaces2').val();
         // var price        = $(this).find('.price2').data('id');
          var typePrice    = $(this).find('input:radio[name=typePrice1'+numRadio+']:checked').val();
          var vigencia     = $(this).find('.vigencia').val();
          var totalEdit    = $(this).find('#editQC_'+numRadio).val();
          var con = 0;
          
          console.log(typePrice);
          if(typeof typePrice != "undefined"){
              
          }else{
              flag = "false";
            $("input:radio[name=typePrice2"+numRadio+"]").parent().css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            });  
          }
          
            $('.coursesQuotationC_'+numRadio).each(function(){
             
              
             var id = $(this).data('id');
             
             var qty     = $(this).find('.qtyEmployeeQC').val();
             var course  = $(this).find('.slcCourseQC').val();
             var price   = $(this).find('.precioQC').data('id');
             
            if(typeof qty != "undefined"){
                
               if (qty == "") {
            flag = "false";
            $(this).find('.qtyEmployeeQC').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
               if (price == "") {
            flag = "false";
            $(this).find('.precioQC').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
           console.log('///////////////////////////////');
           console.log("r"+numRadio);
           console.log("q"+qty);
           console.log("p"+price);
           console.log("cu"+course);
           console.log("c"+con);
           console.log('///////////////////////////////');
           
            if(flag == "true" && typeof qty != "undefined"){
             totalQty = totalQty + parseInt(qty);
             slcCourseQuo[con] =  {"qty":qty,"course":course,"price":price};
             totalPrice = totalPrice+price;
             con++;
         }
     }
             
             });
     
     if(typeof vigencia != "undefined"){
         
          arrayOptions[numOptions] = new Array(typePrice
                                              ,vigencia
                                              ,slcCourseQuo
                                              ,totalQty
                                              ,totalEdit
                                              ,totalPrice);
                 numOptions++;
                          }        
               numRadio++;
         });
        
          console.log(arrayOptions);
         
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('idQuotation', idQuotation);
            sendData.append('iva', iva);
            sendData.append('arrayOptions', JSON.stringify(arrayOptions));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addDetailQuotation',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                $.LoadingOverlay("hide");
                    if(response == "true"){
                         Swal.fire(
                                'Agregado!',
                                'Opciones agregadas con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                $.ajax({
                            type: "POST",
                            dataType: "json",
                            data: {"idQuotation": idQuotation},
                            url: '/viewDetailQuotation',
                            beforeSend: function () {
                                  },
                            success: function (response) {
                               if(response.valid == "true"){
                                     $('#modalUsuario').empty();
                                     $('#modalUsuario').html(response.view);
                                     location.reload();
                                 }else{
                                  Swal.fire({
                                      type: 'error',
                                      title: 'Oops...',
                                    text: 'Error al editar'
                            });
                    }
                }
            });
                            });
                        
                       
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_editNotification', function () {
        var flag        = "true";
        var pkAlert  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkAlert": pkAlert},
                url: '/updateAlert',
                beforeSend: function () {

                },
                success: function (response) {
          
                    if(response.valid == "true"){
                       
                        $('#modalAlert').empty();
                        $('#modalAlert').html(response.view);
                        $('.modalEditAlert').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_editAlert', function () {
        var flag        = "true";
        var title       = $('#title').val();
        var message     = $('#message').val();
        var users       = $('#users').val();
        var slcBussines     = $('#slcBussines').data('id');
        var pkAler      = $(this).data('id');
        event.preventDefault();
    

        var titleRegex           = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var messageRegex    = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;

        
        
        if (title == "") {
            flag = "false";
            $("#title").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (message == "") {
            flag = "false";
            $("#message").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (users == "") {
            flag = "false";
            $("#users").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {"title":title,"slcBussines":slcBussines,"message":message,"users":""+users+"","pkAler":pkAler},
                url: '/updateAlertDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                          $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Notificaci\u00F3n modificada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_editActivity', function () {
        var flag        = "true";
        var pkActivity  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkActivity": pkActivity},
                url: '/updateAvtivity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       console.log("true");
                        $('#modalActivity').empty();
                        $('#modalActivity').html(response.view);
                        $('.modalEditActivity').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_updateActivity', function () { 
        var flag                    = "true";
        var activityBusiness        = $('#activityBusiness').val();
        var type_event_business     = $('#type_event_business').val();
        var userAgent               = $('#userAgent').val();
        var type_activity           = $('#type_activity').val();
        var description             = $('#description').val();
        var date                    = $('#date').val();
        var hour                    = $('#hour').val();
        var document                = $('#document').val();
        var pkActivity              = $(this).data('id');
        
        console.log(activityBusiness);
        console.log(type_event_business);
        console.log(userAgent);
        console.log(type_activity);
        console.log(description);
        console.log(date);
        console.log(hour);
    
        var descriptionRegex      = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
        if (activityBusiness == "-1") {
            flag = "false";
            $("#activityBusiness").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (type_event_business == "-1") {
            flag = "false";
            $("#type_event_business").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (userAgent == "-1") {
            flag = "false";
            $("#userAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (type_activity == "-1") {
            flag = "false";
            $("#type_activity").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (description == "") {
            flag = "false";
            $("#description").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (date == "") {
            flag = "false";
            $("#date").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (hour == "") {
            flag = "false";
            $("#hour").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('activityBusiness', activityBusiness);
            sendData.append('type_event_business', type_event_business);
            sendData.append('userAgent', userAgent);
            sendData.append('type_activity', type_activity);
            sendData.append('description', description);
            sendData.append('date', date);
            sendData.append('hour', hour);
            sendData.append('pkActivity', pkActivity); 
            sendData.append('document', $('#document')[0].files[0]);
            
            
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateAvtivityDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Actividad modificada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
         
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btnEditCampaigns', function () {
        var flag         = "true";
        var pkCampaning  = $(this).data('id');        
        console.log("esee");
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkCampaning": pkCampaning},
                url: '/updateCampaign',
                beforeSend: function () {
                },
                success: function (response) {
                     console.log(response);
                    if(response.valid == "true"){
                       console.log("true");
                        $('#modalActivity').empty();
                        $('#modalActivity').html(response.view);
                        $('.modalEditActivity').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_updateCompanydb', function () {
        var flag            = "true";
        var name            = $('#name').val();
        var code            = $('#code').val();
        var agentMain       = $('#agentMain').val();
        var startDate       = $('#startDate').val();
        var endDate         = $('#endDate').val();
        var type            = $('#type').val();
        var description     = $('#description').val();
        var agentSecondary  = $('#agentSecondary').val();
        var pkCompaning     = $(this).data('id');
    

        var nameRegex           = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var descriptionRegex    = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var codeRegex           = /^[a-zA-Z0-9-]+$/g;

        
        
        if (name == "") {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (code=="") {
            flag = "false";
            $("#code").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (agentMain < 0) {
            flag = "false";
            $("#agentMain").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (startDate == "") {
            flag = "false";
            $("#startDate").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (endDate == "") {
            flag = "false";
            $("#endDate").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (type < 0) {
            flag = "false";
            $("#type").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (description == "") {
            flag = "false";
            $("#description").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
       
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('name', name);
            sendData.append('code', code);
            sendData.append('agentMain', agentMain);
            sendData.append('startDate', startDate);
            sendData.append('endDate', endDate);
            sendData.append('type', type);
            sendData.append('description', description);
            sendData.append('agentSecondary', agentSecondary);
            sendData.append('pkCompaning', pkCompaning);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateCampaignDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Campa\u00F1a modificada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.saveCsv', function () {
        var idCampaning = $(this).data('id');
    $('#modalActivity').empty();
    $("#modalActivity").html('<div class="modal-content">'
            + ' <div class="modal-header">'
            + '    <h2 class="modal-title" id="modalAgentesCLabel">Asignación de empresas</h2>'
            + '  <button type="button" class="close" data-dismiss="modal" aria-label="Close">'
            + '       <span aria-hidden="true">&times;</span>'
            + '  </button>'
            + ' </div>'
            + ' <div class="modal-body">'
            + '   <div class="row">'
            + '   <div class="col-md-6">'
            + '     <div class="form-group">'
            + '         <label>Cargar Excel</label>'
            + '         <div class="input-group">'
            + '             <div class="custom-file">'
            + '                 <input type="file" class="custom-file-input" id="fileBusiness">'
            + '                 <label class="custom-file-label" for="inputGroupFile01">Buscar</label>'
            + '             </div>'
            + '         </div>'
            + '     </div>'
            + '  </div>'
            + '  <div class="col-md-6">'
            + '     <div class="form-actions">'
            + '         <div class="card-body mt-2">'
            + '             <button type="button" class="btn btn-success" id="asignBussines" data-id="'+idCampaning+'"> <i class="fa fa-check"></i> Asignar</button>'
            + '         </div>'
            + '     </div>'
            + '  </div>'
            + ' </div>'
            + ' </div>'
            + ' <div class="modal-footer">'
            + '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'
            + ' </div>'
            + '</div>'); 
     $('.modalEditActivity').trigger('click');
    });
    
    $(document).on('click', '#asignBussines', function () {
        var flag            = "true";
        var fileBusiness    = $('#fileBusiness').val();
        var idCampaning     = $(this).data('id');        
       
        if (fileBusiness == "") {
            flag = "false";
            $(".custom-file").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('idCampaning', idCampaning);
            sendData.append('fileBusiness', $('#fileBusiness')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/udateBusinessByCampaning',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Campa\u00F1a agregada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document.body).on('keyup', '.main-input-text-search-header', function(event) {
            var textSearch  = $(this).val();
            var count       = textSearch.length;
            
            if(count >= 3 && count <= 50){ 
                if(event.keyCode == 13){
                    //location.href = "/buscar-empresa/"+textSearch;
                }
                
                $.ajax({
                    type:"POST",
                    dataType:"html", 
                    data:{"textSearch":textSearch},   
                    url: "/searcher",                          
                    success: function(data){ 
                        $('.search-header').empty();       
                        $(".search-header").html(data);                                     
                    }
                });
            }else{
                $('.search-header').empty();
            }
    });
     
    $(document).on('click', '.updateStatus', function () {
        var flag        = "true";
        var pkQuotations  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkQuotations": pkQuotations},
                url: '/updateStatus',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                         $('#optionQuotation').hide();
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('change', '#slcStatus', function () {
        var idState     = $(this).val();
        
          if(idState == 4){
              $('#optionQuotation').show();
          }else{
              $('#optionQuotation').hide();
          }
       
    });
    
    $(document).on('click', '#btnUpdateStateQuotation', function () { 
        var flag                    = "true";
        var activityBusiness        = $('#slcStatus').val();
        var pkQuotation             = $(this).data('id');
        var option                  = $('input:radio[name=options]:checked').val();
    
      var serie                   = $('#serie').val();
      var slccfdi                 = $('#slccfdi').val();
      var payment                 = $('#payment').val();
      var method                  = $('#method').val();
      var condition               = $('#condition').val();
      var rfc                     = $('#rfc').val();
      var social                  = $('#social').val();
      var slcProduct              = $('#slcProduct').val();
      var slcUnity                = $('#slcUnity').val();
      var numIden                 = $('#numIden').val();
      var desc                    = $('#desc').val();
      

      
      if(activityBusiness == 4){
          
                if(typeof option == "undefined") {
      flag = "false2";
            $(".custom-radio").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
     }
     
        if (rfc == "") {
            flag = "false";
            $("#rfc").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (social == "") {
            flag = "false";
            $("#social").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
      
        if (slccfdi < 0) {
            flag = "false";
            $("#slccfdi").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (payment < 0) {
            flag = "false";
            $("#payment").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
      
      if (method < 0) {
            flag = "false";
            $("#method").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (condition < 0) {
            flag = "false";
            $("#condition").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
    }
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('status', activityBusiness);
            sendData.append('option', option);
            sendData.append('pkQuotation', pkQuotation);            
           
           sendData.append('serie',     serie);
           sendData.append('slccfdi',   slccfdi);
           sendData.append('payment',   payment);
           sendData.append('method',    method);
           sendData.append('condition', condition);
           sendData.append('rfc',       rfc);
           sendData.append('social',    social);
           sendData.append('slcProduct',slcProduct);
           sendData.append('slcUnity',  slcUnity);
           sendData.append('numIden',   numIden);
           sendData.append('desc',      desc);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateStatusDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                      $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Status modificado con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
         
         if(flag == "false2"){
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Seleccione una opcion de venta'
                });
            }else{
               Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });  
            }
        }
    });
    
    $(document).on('click', '.viewAprovedQuotation', function () {
       
        var idBussines  = $(this).data('id'); 
        var idUsers     = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBussines": idBussines,"idUsers":idUsers},
                url: '/viewSalesAgent',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.viewLossQuotation', function () {
       
        var idBussines  = $(this).data('id'); 
        var idUsers     = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBussines": idBussines,"idUsers":idUsers},
                url: '/viewSalesLostAgent',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.viewOpenQuotation', function () {
       
        var idBussines  = $(this).data('id'); 
        var idUsers     = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBussines": idBussines,"idUsers":idUsers},
                url: '/viewOpenQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.viewAprovedOportunity', function () {
       
        var idBussines  = $(this).data('id'); 
        var idUsers     = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBussines": idBussines,"idUsers":idUsers},
                url: '/viewAprovedOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.viewOpenOportunity', function () {
       
        var idBussines  = $(this).data('id'); 
        var idUsers     = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBussines": idBussines,"idUsers":idUsers},
                url: '/viewOpenOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.viewLossOportunity', function () {
       
        var idBussines  = $(this).data('id'); 
        var idUsers     = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBussines": idBussines,"idUsers":idUsers},
                url: '/viewLossOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#saveMasiveBussines', function () {
        var flag            = "true";
        var fileBusiness    = $('#fileBusiness').val();  
       
        if (fileBusiness == "") {
            flag = "false";
            $(".custom-file").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('fileBusiness', $('#fileBusiness')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/saveMasiveBussinesDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Empresas agregadas con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.href = "/verEmpresas";
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
  
    $(document.body).on('click', '.search-item', function() { 
        var dataId          = $(this).attr("data-id");
        var dataType        = $(this).attr("data-type");
        var text            = $(this).html();
    
        $('.search-header').empty();
        $('.main-input-text-search-header').val(text);
        $('.main-input-text-search-header').attr("data-id",dataId);
        $('.main-input-text-search-header').attr("data-type",dataType);
        
        switch(dataType) {
            default:    
                location.href = "/detEmpresa/"+dataId+"";
        }
    });
    
    $(document.body).on('keyup', '.autocomplete_bussines', function(event) {
            var textSearch  = $(this).val();
            var count       = textSearch.length;
            
            if(count >= 3 && count <= 50){                 
                $.ajax({
                    type:"POST",
                    dataType:"html", 
                    data:{"textSearch":textSearch},   
                    url: "/searcherTextBussines",                          
                    success: function(data){ 
                        $('.search-header-bussines').empty();       
                        $(".search-header-bussines").html(data);                                     
                    }
                });
            }else{
                $('.search-header-bussines').empty();
            }
    });
    
    $(document.body).on('click', '.search-item-bussines', function() { 
        var dataId          = $(this).attr("data-id");
        var dataType        = $(this).attr("data-type");
        var text            = $(this).html();
    
                  $("#slcBussines").empty();       
                  $("#slcBussines").val(text);
                 // $("#slcBussines").attr('data-id',dataId);
                  $("#slcBussines").data('id',dataId);
                  console.log(dataId);
              $.ajax({
                type: "POST",
                dataType: "json",
                data: { "slcBussines": dataId},
                url: '/getContactBussines',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#slcContact').empty();
                       $('#slcContact').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
            
               $('.search-header-bussines').empty();   
        
    });
    
    $(document.body).on('keyup', '.autocomplete_bussines2', function(event) {
            var textSearch  = $(this).val();
            var count       = textSearch.length;
            
            if(count >= 3 && count <= 50){                 
                $.ajax({
                    type:"POST",
                    dataType:"html", 
                    data:{"textSearch":textSearch},   
                    url: "/searcherTextBussines",                          
                    success: function(data){ 
                        $('.search-header-bussines2').empty();       
                        $(".search-header-bussines2").html(data);                                     
                    }
                });
            }else{
                $('.search-header-bussines2').empty();
            }
    });
    
    $(document.body).on('click', '.search-item-bussines', function() { 
        var dataId          = $(this).attr("data-id");
        var dataType        = $(this).attr("data-type");
        var text            = $(this).html();
    
                  $("#slcBussines2").empty();       
                  $("#slcBussines2").val(text);
                 // $("#slcBussines").attr('data-id',dataId);
                  $("#slcBussines2").data('id',dataId);
                  console.log(dataId);
              $.ajax({
                type: "POST",
                dataType: "json",
                data: { "slcBussines": dataId},
                url: '/getContactBussines',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#slcContact2').empty();
                       $('#slcContact2').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
            
               $('.search-header-bussines2').empty();   
        
    });
    
    $(document.body).on('keyup', '.autocomplete_bussines3', function(event) {
            var textSearch  = $(this).val();
            var count       = textSearch.length;
            
            if(count >= 3 && count <= 50){                 
                $.ajax({
                    type:"POST",
                    dataType:"html", 
                    data:{"textSearch":textSearch},   
                    url: "/searcherTextBussines",                          
                    success: function(data){ 
                        $('.search-header-bussines3').empty();       
                        $(".search-header-bussines3").html(data);                                     
                    }
                });
            }else{
                $('.search-header-bussines3').empty();
            }
    });
    
    $(document.body).on('click', '.search-item-bussines', function() { 
        var dataId          = $(this).attr("data-id");
        var dataType        = $(this).attr("data-type");
        var text            = $(this).html();
    
                  $("#slcBussines3").empty();       
                  $("#slcBussines3").val(text);
                 // $("#slcBussines").attr('data-id',dataId);
                  $("#slcBussines3").data('id',dataId);
                  console.log(dataId);
              $.ajax({
                type: "POST",
                dataType: "json",
                data: { "slcBussines": dataId},
                url: '/getContactBussines',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#slcContact3').empty();
                       $('#slcContact3').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
            
               $('.search-header-bussines3').empty();   
        
    });
    
    $(document).on('click', '.btn_FinisActivity', function () {
        var flag               = "true";
        var pkActivity  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkActivity":pkActivity},
                url: '/finishActivity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalPago').empty();
                        $('#modalPago').html(response.view);
                        $('.modalEditPago').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_finishDB', function () { 
        var flag                    = "true";
        var description             = $('#description').val();
        var subtypeActivity         = $('input:radio[name=subActivity]:checked').val();
        var pkActivy                = $(this).data('id');
      
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('description', description);
            sendData.append('subtypeActivity', subtypeActivity);
            sendData.append('pkActivy', pkActivy);            
           
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/finishActivityDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Actividad terminada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
         
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#dowloadBussines', function () {
        var idgiro     = $('#slcGiro').val();
        var type       = $('#slcType').val();
        
         location.href = "/dowloadBussienes/"+idgiro+"/"+type;
       
    });
    
     $(document).on('click', '.paymentQuotation', function () {
        var flag        = "true";
        var pkQuotations  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkQuotations": pkQuotations},
                url: '/paymetQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                         $('#optionQuotation').hide();
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btnpaymentQuotation', function () {
        var flag          = "true";
        var pkQuotations  = $(this).data('id');        
        var social        = $('#social').val();
        var rfc           = $('#rfc').val();
        var address       = $('#address').val();
        var phone         = $('#phoneUser').val();
        var mail          = $('#mail').val();
        var cfdi          = $('#cfdi').val();
        var document      = $('#document').val();
        var slcPayment    = $('#slcPayment').val();
        var ext           = document.substring(document.lastIndexOf("."));

        console.log(ext);
        
         if (social == "") {
              console.log(social);
            flag = "false";
            $("#social").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (rfc == "") {
             console.log(rfc);
            flag = "false";
            $("#rfc").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (address == "") {
            console.log(address);
            flag = "false";
            $("#address").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (phone == "") {
            console.log(phone);
            flag = "false";
            $("#phone").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (mail == "") {
            console.log(mail);
            flag = "false";
            $("#mail").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (cfdi == "") {
            console.log(cfdi);
            flag = "false";
            $("#cfdi").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slcPayment < 0) {
            console.log(slcPayment);
            flag = "false";
            $("#slcPayment").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            
            var sendData = new FormData();
            sendData.append('pkQuotations', pkQuotations); 
            sendData.append('social', social); 
            sendData.append('rfc', rfc); 
            sendData.append('pkActivity', address); 
            sendData.append('phone', phone);
            sendData.append('address', address);
            sendData.append('mail', mail); 
            sendData.append('cfdi', cfdi); 
            sendData.append('slcPayment', slcPayment); 
            sendData.append('document', $('#document')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/paymetQuotationDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                      console.log(response);
                    
                 
                    if(response == "true"){
                       Swal.fire(
                                'Éxito!',
                                'Cotización pagada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    
     $(document).on('click', '.createOportunity', function () {
        var flag        = "true";
        var pkBussines  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkBussines": pkBussines},
                url: '/addOportunityModal',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    
     $(document).on('click', '#saveMasiveCalls', function () {
        var flag            = "true";
        var fileBusiness    = $('#fileBusiness').val();  
       
        if (fileBusiness == "") {
            flag = "false";
            $(".custom-file").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('fileBusiness', $('#fileBusiness')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/saveMasiveCallsDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                   $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Llamadas agregadas con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
     $(document).on('click', '#saveMasiveGiros', function () {
        var flag            = "true";
        var fileBusiness    = $('#fileBusiness').val();  
       
        if (fileBusiness == "") {
            flag = "false";
            $(".custom-file").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('fileBusiness', $('#fileBusiness')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/saveMasiveBussinesTypeDB',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'giros agregados con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.href = "/viewCommercialBusiness";
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
     $(document).on('click', '#search_activity', function () {
      var flag       = "true";
      var Agent      = $('#agent').val();    
      var status     = $('#status_activity').val(); 
      var type       = $('#type_activitys').val();   
      var fechStart  = $('#date_start').val();   
      var fechFinish = $('#date_finish').val(); 
        
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                async: true,
                data: {"Agent"     : Agent
                      ,"type"      : type
                      ,"status"    : status
                      ,"fechStart" : fechStart
                      ,"fechFinish": fechFinish},
                url: '/seachArcivity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#actividadesDiv').empty();
                        $('#actividadesDiv').html(response.view);
                        
                         $('#actividades').DataTable({
                            dom: 'Bfrtip',
                            "searching": false,
                             buttons: [
                              'excel'
                             ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
     $(document).on('click', '#search_quotation', function () {
      var flag       = "true";
      var status     = $('#status').val();
      var agent      = $('#agent').val();
      var fechStart  = $('#date_start').val();   
      var fechFinish = $('#date_finish').val(); 
      var day        = -1;   
      var month      = -1;  
      var year       = -1; 

      $('.searchInfor').each(function() { 
        if($(this).is(':checked')){
            if($(this).val()== 1){
                day = 1;  
              }
               if($(this).val()== 2){
               month = 1;   
              }
               if($(this).val()== 3){
               year = 1;   
              }
        }
   });
        
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"status"    : status
                      ,"agent"     : agent
                      ,"fechStart" : fechStart
                      ,"fechFinish": fechFinish
                      ,"day": day
                      ,"month": month
                      ,"year":  year},
                url: '/searchQuotations',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        $('.totalQuotation').text('$ '+number_format(response.total,2));
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                             "order": [],
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
     $(document).on('click', '#search_oportunity', function () {
      var flag       = "true";
      var status     = $('#status').val();   
      var agent      = $('#agent').val();
      var fechStart  = $('#date_start').val();   
      var fechFinish = $('#date_finish').val(); 
        
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"status"    : status
                      ,"agent"     : agent
                      ,"fechStart" : fechStart
                      ,"fechFinish": fechFinish},
                url: '/searchOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#totalOportunity').text("$ "+number_format(response.totalMount,2));
                        $('#oporNegDiv').empty();
                        $('#oporNegDiv').html(response.view);
                        
                        
                         $('#oporNeg').DataTable({
                            dom: 'Bfrtip',
                             "order": [],
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
     
    $(document).on('change', '#slcAgentCalendary', function () {
        var id     = $(this).val();
        
        location.href = '/AgentCalendary/'+id;
       
    });
    
    $(document).on('click', '.viewAgent', function () {
        var flag         = "true";
        var pkCampaning  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkCampaning": pkCampaning},
                url: '/viewCampaningAgent',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       console.log("true");
                        $('#modalActivity').empty();
                        $('#modalActivity').html(response.view);
                        $('.modalEditActivity').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('change', '#slcViewStatusBussines', function () {
        var idState     = $(this).val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idState": idState},
                url: '/searchBusinessByStatus',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#activeEmpDiv').empty();
                        $('#activeEmpDiv').html(response.view);
                        
                         $('#activeEmp').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('change', '#slcViewStatusBussinesPros', function () {
        var idState     = $(this).val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idState": idState},
                url: '/searchBusinessByStatusPros',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#activeEmpDiv').empty();
                        $('#activeEmpDiv').html(response.view);
                        
                         $('#activeEmp').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#addDayFestive', function () {
        
        var count = $("#count").val();
       
        $("#addContentOPcionDay").append('<div class="contentNewOpcionDay"><div class="nav-small-cap mb-2">- - - Día festivo  <button type="button" class="btn btn-danger btn-sm btn_deleteNewOption float-right" data-id="4"><span class="ti-close"></span></button></div>'
            + '<div class="form-row">'
            + '  <div class="col-sm-6">'
        + '          <div class="form-group">'
        + '               <label class="control-label">Cantidad de lugares</label>'
        + '                <div class="input-group">'
        + '                   <div class="input-group">'
        + '                        <div class="input-group-prepend">'
        + '                          <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>'
        + '                         </div>'
        + '                         <input type="date" id="vigencia" class="form-control vigencia">'
        + '                        </div>'
        + '                 </div>'
        + '             </div>'
        + '         </div>'
        + '</div></div>'); 
     count++;
     $("#count").val(count);
    });
    
    $("#all").change(function () {
    //Si el checkbox está seleccionado
        if ($(this).is(":checked")) {
            $("input:checkbox").each(function () {
            $(this).prop("checked", true);
            });
         } else {
           $("input:checkbox").each(function () {
            $(this).prop("checked", false);
            });
           }
   });
    
    $(document).on('click', '#btn_addWorkPlan', function () {
        var flag            = "true";  
        var slcAgent        = $('#slcAgent').val();
        var callsPerHour    = $('#callsPerHour').val();
        //var hourPerMont     = $('#hourPerMont').val();
        var callsLinked     = $('#callsLinked').val();
        var callsFaild      = $('#callsFaild').val();
        var penalty         = $('#penalty').val();
        var montBase        = $('#montBase').val();
        var typeChange      = $('#typeChange').val();
        var slctypeCurrency = $('#slctypeCurrency').val();
        var datePlan        = $('#datePlan').val();
        var days            = [];
        var arrayDays       = [];
        var numOptions      = 0;
        
          $("input:checkbox:checked").each(function() {
         
             switch($(this).val()) {
               case '1':
                days[$(this).val()] = {idDay:$(this).val(), type:$("#slcLunes").val() };
               break;
               case '2':
               days[$(this).val()]  = {idDay:$(this).val(), type:$("#slcMartes").val() };
               break;
               case '3':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcMiercoles").val() };
               break;
               case '4':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcJueves").val() };
               break;
               case '5':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcViernes").val() };
               break;
               case '6':
               days[$(this).val()] = {idDay:$(this).val(), type: $("#slcSabado").val() };
               break;
               case '7':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcDomingo").val() };
               break;
              default:
              // code block
            }
            
        });
        
              $('.contentNewOpcionDay').each(function () {

        var vigencia = $(this).find('.vigencia').val();

        if (typeof vigencia != "undefined") {

            arrayDays[numOptions] = {vigencia:vigencia};

            numOptions++;
        }
    });
        
        //console.log(days);
       // console.log(arrayDays);
        
         if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (callsPerHour == "") {
            flag = "false";
            $("#callsPerHour").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (callsLinked == "") {
            flag = "false";
            $("#callsLinked").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (callsFaild == "") {
            flag = "false";
            $("#callsFaild").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (penalty == "") {
            flag = "false";
            $("#penalty").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (montBase == "") {
            flag = "false";
            $("#montBase").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (typeChange == "") {
            flag = "false";
            $("#typeChange").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slctypeCurrency < 0) {
            flag = "false";
            $("#slctypeCurrency").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
          if (flag == "true") {
            
            var sendData = new FormData();
            sendData.append('slcAgent', slcAgent); 
            sendData.append('callsPerHour', callsPerHour); 
            sendData.append('callsLinked', callsLinked); 
            sendData.append('callsFaild', callsFaild);
            sendData.append('penalty', penalty);
            sendData.append('montBase', montBase); 
            sendData.append('typeChange', typeChange); 
            sendData.append('slctypeCurrency', slctypeCurrency); 
            sendData.append('arrayDays', JSON.stringify(arrayDays));
            sendData.append('days', JSON.stringify(days.filter(Boolean)));
            sendData.append('datePlan', JSON.stringify(datePlan));
            
            
            $.ajax({
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addWorkPlandDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                      console.log(response);
                    
                 
                    if(response.valid == "true"){
                       Swal.fire(
                                'Éxito!',
                                'Plan de trabajo agregado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/verplandetrabajo";
                            });
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        } 
    });
    
    $(document).on('click', '.viewDaysWorking', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/viewWorkingPlan',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_workinPlan', function () {
        var pkWorkinPlan        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este plan de trabajo?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkWorkinPlan": pkWorkinPlan},
                    url: '/deleteWorkinPlan',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Plan de trabajo eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar plan de trabajo'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.updateWorkinPlan', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/updateWorkinPlan',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_updateWorkPlan', function () {
        var flag            = "true";  
        var slcAgent        = $('#slcAgent').val();
        var callsPerHour    = $('#callsPerHour').val();
        var hourPerMont     = $('#hourPerMont').val();
        var callsLinked     = $('#callsLinked').val();
        var callsFaild      = $('#callsFaild').val();
        var penalty         = $('#penalty').val();
        var montBase        = $('#montBase').val();
        var typeChange      = $('#typeChange').val();
        var slctypeCurrency = $('#slctypeCurrency').val();
        var idWorkin        = $(this).data('id');

       // console.log(arrayDays);
        
         if (slcAgent < 0) {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (callsPerHour == "") {
            flag = "false";
            $("#callsPerHour").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (hourPerMont == "") {
            flag = "false";
            $("#hourPerMont").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (callsLinked == "") {
            flag = "false";
            $("#callsLinked").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (callsFaild == "") {
            flag = "false";
            $("#callsFaild").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (penalty == "") {
            flag = "false";
            $("#penalty").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (montBase == "") {
            flag = "false";
            $("#montBase").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (typeChange == "") {
            flag = "false";
            $("#typeChange").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (slctypeCurrency < 0) {
            flag = "false";
            $("#slctypeCurrency").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
          if (flag == "true") {
            
            var sendData = new FormData();
            sendData.append('slcAgent', slcAgent); 
            sendData.append('callsPerHour', callsPerHour); 
            sendData.append('hourPerMont', hourPerMont); 
            sendData.append('callsLinked', callsLinked); 
            sendData.append('callsFaild', callsFaild);
            sendData.append('penalty', penalty);
            sendData.append('montBase', montBase); 
            sendData.append('typeChange', typeChange); 
            sendData.append('slctypeCurrency', slctypeCurrency); 
            sendData.append('idWorkin', idWorkin);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateWorkinPlanDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                      console.log(response);
                    
                 
                    if(response == "true"){
                       Swal.fire(
                                'Éxito!',
                                'Plan de trabajo modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar plan de trabajo'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        } 
    });

    $(document).on('click', '.deleteCalls', function () {
        var pkWorkinPlan        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar las llamadas del mes?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkWorkinPlan": pkWorkinPlan},
                    url: '/deleteCalls',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Llamadas eliminadas con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar llamadas'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.viewDaysFestiveWorking', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/viewFestiveDays',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteDayWorking', function () {
        var pkWorkinPlan        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este día de la jornada?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkWorkinPlan": pkWorkinPlan},
                    url: '/deleteDaysWorkin',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Día de trabajo eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar día de trabajo'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '#addDayLaboral', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/addDaysWorkin',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                        // $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_addDays', function () {
        var flag            = "true";  
        var idDays          = $(this).data('id');
        var days            = [];
        
          $("input:checkbox:checked").each(function() {
         
             switch($(this).val()) {
               case '1':
                days[$(this).val()] = {idDay:$(this).val(), type:$("#slcLunes").val() };
               break;
               case '2':
               days[$(this).val()]  = {idDay:$(this).val(), type:$("#slcMartes").val() };
               break;
               case '3':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcMiercoles").val() };
               break;
               case '4':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcJueves").val() };
               break;
               case '5':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcViernes").val() };
               break;
               case '6':
               days[$(this).val()] = {idDay:$(this).val(), type: $("#slcSabado").val() };
               break;
               case '7':
               days[$(this).val()] = {idDay:$(this).val(), type:$("#slcDomingo").val() };
               break;
              default:
              // code block
            }
            
        });

        console.log(days);
       // console.log(arrayDays);
     
        
          if (flag == "true") {
            
            var sendData = new FormData();

            sendData.append('days', JSON.stringify(days));
            sendData.append('idDays', idDays);
            
            $.ajax({
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addDaysWorkinDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                      console.log(response);
                    
                 
                    if(response.valid == "true"){
                       Swal.fire(
                                'Éxito!',
                                'Días agregados con \u00E9xito.',
                                'success'
                            ).then((result) => {
                               $('#modalUsuario').empty();
                               $('#modalUsuario').html(response.view);
                            });
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        } 
    });
    
    $(document).on('click', '#backDays', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/viewWorkingPlan',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteFestivalDays', function () {
        var pkWorkinPlan        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este día festivo?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkWorkinPlan": pkWorkinPlan},
                    url: '/deleteDaysFestive',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Día festivo eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar día festivo'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '#addFestiveDays', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/addDaysFestive',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                        // $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#backDaysFestive', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/viewFestiveDays',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_addFestiveDays', function () {
        var flag            = "true";  
        var idDays          = $(this).data('id');
        var arrayDays       = [];
        var numOptions      = 0;
        
              $('.contentNewOpcionDay').each(function () {

        var vigencia = $(this).find('.vigencia').val();

        if (typeof vigencia != "undefined") {

            arrayDays[numOptions] = {vigencia:vigencia};

            numOptions++;
        }
    });
        console.log(arrayDays);
       
          if (flag == "true") {
            
            var sendData = new FormData();
            sendData.append('arrayDays', JSON.stringify(arrayDays));
            sendData.append('idDays', idDays);
            
            $.ajax({
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addDaysFestiveDB',
                beforeSend: function () {
                },
                success: function (response) {
                      console.log(response);
                    
                 
                    if(response.valid == "true"){
                        
                          Swal.fire(
                                'Éxito!',
                                'Días agregados con \u00E9xito.',
                                'success'
                            ).then((result) => {
                               $('#modalUsuario').empty();
                               $('#modalUsuario').html(response.view);
                            });
                       
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        } 
    });
    
    $(document).on('click', '.viewPermitionDay', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/viewPermission',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#addPermitionDay', function () {
        var idWorkinPlan     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idWorkinPlan": idWorkinPlan},
                url: '/addPermission',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         //$('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_addPermitionDays', function () {
        var flag            = "true";
        var idWorkinPlan    = $(this).data('id');
        var vigencia        = $("#vigencia").val();
        var qtyhours        = $("#qtyhours").val();
        var comment         = $("#comment").val();

        if (vigencia == "") {
            flag = "false";
            $("#vigencia").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (qtyhours == "") {
            flag = "false";
            $("#qtyhours").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (comment == "") {
            flag = "false";
            $("#comment").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
       
          if (flag == "true") {
            
            var sendData = new FormData();
            sendData.append('idWorkinPlan', idWorkinPlan);
            sendData.append('vigencia', vigencia);
            sendData.append('qtyhours', qtyhours);
            sendData.append('comment', comment);
            
            $.ajax({
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addPermissionDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                      console.log(response);
                    
                 
                    if(response.valid == "true"){
                        
                          Swal.fire(
                                'Éxito!',
                                'Permiso agregado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                               $('#modalUsuario').empty();
                               $('#modalUsuario').html(response.view);
                            });
                       
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        } 
       
    });
    
    $(document).on('click', '.btn_deleteDayPermition', function () {
        var pkWorkinPlan        = $(this).attr("data-id");
        var idWorkinPlan        = $(this).attr("data-work");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este permiso?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: { "pkWorkinPlan": pkWorkinPlan
                            ,"idWorkinPlan": idWorkinPlan},
                    url: '/deletePermission',
                    beforeSend: function () {
                    },
                    success: function (response) {
                        if(response.valid == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Permiso eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                $('#modalUsuario').empty();
                                $('#modalUsuario').html(response.view);
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar día festivo'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('change', '#activityType', function () {
        var typeSubActivity     = $(this).val();
        
                 if(typeSubActivity == 1){
                       $('#slctypeDiv').empty();
                       $('#slctypeDiv').html('<select id="slctypeCall" class="form-control">'
                                + '<option value="-1">Selecciona tipo de Llamada</option>'
                                + '<option value="1">Enlazada</option>'
                                + '<option value="2">Fallida</option>'
                                + '</select>');
                    }else{
                        $('#slctypeDiv').empty();
   
                    }
                    
    });
    
    $(document).on('change', '#activityTypeEdit', function () {
        var typeSubActivity     = $(this).val();
        
                 if(typeSubActivity == 1){
                       $('#slctypeDiv2').empty();
                       $('#slctypeDiv2').html('<select id="slctypeCall" class="form-control">'
                                + '<option value="-1">Selecciona tipo de Llamada</option>'
                                + '<option value="1">Enlazada</option>'
                                + '<option value="2">Fallida</option>'
                                + '</select>');
                    }else{
                        $('#slctypeDiv2').empty();
   
                    }
                    
    });
    
    $(document).on('click', '#btn_addBon', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var montRec         = $("#montRec").val();
        //var porcentBon      = $("#porcentBon").val();
        var montMin         = $("#montMin").val();
       // var porcentPenalty  = $("#porcentPenalty").val();
        var porcentFirst    = $("#porcentFirst").val();
        var dateBon         = $("#dateBon").val();
        var penality        = [];
        var numOptions      = 0;
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        $('.Addagents').each(function(){
            
            var slcAgent   = $(this).find('.slcAgent').val();
            var porcentPenalty = $(this).find('.porcentPenalty').val();
       
       if(typeof porcentPenalty != "undefined"){
             penality[numOptions] = {slcAgent:slcAgent
                                       ,porcentPenalty:porcentPenalty}
               
                 
                if (porcentPenalty == "") {
              flag = "false";
              $(this).find('.porcentPenalty').css({
                  "-moz-box-shadow": "0 0 5px #f40404",
                  "-webkit-box-shadow": "0 0 5px #f40404",
                  "box-shadow": "0 0 5px #f40404"
              }
              );
          } 
          
           if (slcAgent == "") {
              flag = "false";
              $(this).find('.slcAgent').css({
                  "-moz-box-shadow": "0 0 5px #f40404",
                  "-webkit-box-shadow": "0 0 5px #f40404",
                  "box-shadow": "0 0 5px #f40404"
              }
              );
          } 
                 numOptions++;
                            }      
           });

        if (slcAgent == "") {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (montRec == "") {
            flag = "false";
            $("#montRec").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         /*if (porcentBon == "") {
            flag = "false";
            $("#porcentBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }*/
        
        if (montMin == "") {
            flag = "false";
            $("#montMin").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        /* if (porcentPenalty == "") {
            flag = "false";
            $("#porcentPenalty").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }*/
        
        if (porcentFirst == "") {
            flag = "false";
            $("#porcentFirst").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('montRec',         montRec);
            //sendData.append('porcentBon',      porcentBon);
            sendData.append('montMin',         montMin);
           // sendData.append('porcentPenalty',  porcentPenalty);
            sendData.append('porcentFirst',    porcentFirst);
            sendData.append('dateBon',         dateBon);
            sendData.append('slcAgent',        JSON.stringify(slcAgent));
            sendData.append('penality',        JSON.stringify(penality));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addBono',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                   $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Bono creado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/viwbonosBase";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.viewAgentBono', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewAgentByBono',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteBounBase', function () {
        var pkBond        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el bono',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBond": pkBond},
                    url: '/delteBono',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");

                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Bono eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar bono'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.updateBounBase', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewUpdateByBono',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_updateBondBase', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var montRec         = $("#montRec").val();
        //var porcentBon      = $("#porcentBon").val();
        var montMin         = $("#montMin").val();
       // var porcentPenalty  = $("#porcentPenalty").val();
        var porcentFirst    = $("#porcentFirst").val();
        var dateBon         = $("#dateBon").val();
        var pkBond          = $(this).data('id');
        var penality        = [];
        var numOptions      = 0;
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
   $('.Addagents').each(function(){
            
            var slcAgent   = $(this).find('.slcAgent').val();
            var porcentPenalty = $(this).find('.porcentPenalty').val();
       
       if(typeof porcentPenalty != "undefined"){
             penality[numOptions] = {slcAgent:slcAgent
                                       ,porcentPenalty:porcentPenalty}
               
                 
                if (porcentPenalty == "") {
              flag = "false";
              $(this).find('.porcentPenalty').css({
                  "-moz-box-shadow": "0 0 5px #f40404",
                  "-webkit-box-shadow": "0 0 5px #f40404",
                  "box-shadow": "0 0 5px #f40404"
              }
              );
          } 
          
           if (slcAgent == "") {
              flag = "false";
              $(this).find('.slcAgent').css({
                  "-moz-box-shadow": "0 0 5px #f40404",
                  "-webkit-box-shadow": "0 0 5px #f40404",
                  "box-shadow": "0 0 5px #f40404"
              }
              );
          } 
                 numOptions++;
                            }      
           });
       


        if (slcAgent == "") {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (montRec == "") {
            flag = "false";
            $("#montRec").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         /*if (porcentBon == "") {
            flag = "false";
            $("#porcentBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }*/
        
        if (montMin == "") {
            flag = "false";
            $("#montMin").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
     /*    if (porcentPenalty == "") {
            flag = "false";
            $("#porcentPenalty").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }*/
        
        if (porcentFirst == "") {
            flag = "false";
            $("#porcentFirst").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('montRec',         montRec);
           // sendData.append('porcentBon',      porcentBon);
            sendData.append('montMin',         montMin);
          //  sendData.append('porcentPenalty',  porcentPenalty);
            sendData.append('porcentFirst',    porcentFirst);
            sendData.append('dateBon',         dateBon);
            sendData.append('pkBond',         pkBond);
            sendData.append('slcAgent',        JSON.stringify(slcAgent));
            sendData.append('penality',        JSON.stringify(penality));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateByBono',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Bono modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: 'error al modificar bono'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_addBonRecord', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var slcTypeMont     = '1';//$("#slcTypeMont").val();
        var montRep         = $("#montRep").val();
        var montMet         = $("#montMet").val();
        var dateBon         = $("#dateBon").val();
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        if (slcAgent == "") {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (montRep == "") {
            flag = "false";
            $("#montRep").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (montMet == "") {
            flag = "false";
            $("#montMet").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('montRep',         montRep);
            sendData.append('slcTypeMont',     slcTypeMont);
            sendData.append('montMet',         montMet);
            sendData.append('dateBon',         dateBon);
            sendData.append('slcAgent',        JSON.stringify(slcAgent));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addBonoRecord',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Bono creado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/viwbonosRecord";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.viewAgentBondRecord', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewAgentByBonoRecord',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteBounRecord', function () {
        var pkBond        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el bono',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBond": pkBond},
                    url: '/delteBonoRecord',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Bono eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar bono'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.updateBounRecord', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewUpdateByBonoRecord',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_updateBondRecord', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var slcTypeMont     = 1;//$("#slcTypeMont").val();
        var montRep         = $("#montRep").val();
        var montMet         = $("#montMet").val();
        var pkBond          = $(this).data('id');
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        if (slcAgent == "") {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (montRep == "") {
            flag = "false";
            $("#montRep").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (montMet == "") {
            flag = "false";
            $("#montMet").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('montRep',         montRep);
            sendData.append('slcTypeMont',     slcTypeMont);
            sendData.append('montMet',         montMet);
            sendData.append('pkBond',          pkBond);
            sendData.append('slcAgent',        JSON.stringify(slcAgent));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateByBonoRecord',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Bono modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('change', '#year', function () {
        var years     = $(this).val();
        
         $.ajax({
                type: "POST",
                dataType: "json",
                data: { "years": years},
                url: '/getMontRecord',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#month').empty();
                       $('#month').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
                    
    });
    
    $(document).on('change', '#yearBase', function () {
        var years     = $(this).val();
        
         $.ajax({
                type: "POST",
                dataType: "json",
                data: { "years": years},
                url: '/getMontBase',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#month').empty();
                       $('#month').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
                    
    });
    
    $(document).on('click', '#search_bonusRecord', function () {
        var year      = $('#year').val();
        var month     = $('#month').val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "year": year
                       ,"month": month},
                url: '/searchBonusRecord',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#search_bonusBase', function () {
        var year      = $('#yearBase').val();
        var month     = $('#month').val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "year": year
                       ,"month": month},
                url: '/searchBonusBase',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#addConfig', function () {
        
        var flag            = "true";
        var pricePlace      = $("#pricePlace").val();
        var priceIva        = $("#priceIva").val();
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        if (pricePlace == "") {
            flag = "false";
            $("#pricePlace").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (priceIva == "") {
            flag = "false";
            $("#priceIva").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('pricePlace',       pricePlace);
            sendData.append('priceIva',         priceIva);
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/configPriceDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                  $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Precio actualizado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: 'error al actualizar precio'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#saveMasiveDesc', function () {
        var flag            = "true";
        var fileBusiness    = $('#fileBusiness').val();  
       
        if (fileBusiness == "") {
            flag = "false";
            $(".custom-file").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('fileBusiness', $('#fileBusiness')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/saveMasiveDescDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Descuentos agregados con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#btn_addBonTech', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var montMet         = $("#montMet").val();
        var montRep         = $("#montRep").val();
        var slcTypeMont     = $("#slcTypeMont").val();
        var montPen         = $("#montPen").val();
        var dateBon         = $("#dateBon").val();
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        if (slcAgent == "") {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (montRep == "") {
            flag = "false";
            $("#montRep").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (montMet == "") {
            flag = "false";
            $("#montMet").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (montPen == "") {
            flag = "false";
            $("#montPen").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('montRep',         montRep);
            sendData.append('slcTypeMont',     slcTypeMont);
            sendData.append('montMet',         montMet);
            sendData.append('montPen',         montPen);
            sendData.append('dateBon',         dateBon);
            sendData.append('slcAgent',        JSON.stringify(slcAgent));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addBonoTecho',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Bono creado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/viwbonosTecho";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('change', '#yearTecho', function () {
        var years     = $(this).val();
        
         $.ajax({
                type: "POST",
                dataType: "json",
                data: { "years": years},
                url: '/getMontTecho',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#month').empty();
                       $('#month').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
                    
    });
    
    $(document).on('click', '#searchBonusTecho', function () {
        var year      = $('#yearTecho').val();
        var month     = $('#month').val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "year": year
                       ,"month": month},
                url: '/searchBonusTecho',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteBounTecho', function () {
        var pkBond        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el bono',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBond": pkBond},
                    url: '/delteBonoTecho',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Bono eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar bono'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.viewAgentBondTecho', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewAgentBondTecho',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.updateBounTecho', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewUpdateByBonoTecho',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_updateBondTecho', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var montMet         = $("#montMet").val();
        var montRep         = $("#montRep").val();
        var slcTypeMont     = $("#slcTypeMont").val();
        var montPen         = $("#montPen").val();
        var dateBon         = $("#dateBon").val();
        var pkBond          = $(this).data('id');
       
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
           if (slcAgent == "") {
            flag = "false";
            $("#slcAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (montRep == "") {
            flag = "false";
            $("#montRep").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (montMet == "") {
            flag = "false";
            $("#montMet").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (montPen == "") {
            flag = "false";
            $("#montPen").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('montRep',         montRep);
            sendData.append('slcTypeMont',     slcTypeMont);
            sendData.append('montMet',         montMet);
            sendData.append('montPen',         montPen);
            sendData.append('dateBon',         dateBon);
            sendData.append('pkBond',          pkBond);
            sendData.append('slcAgent',        JSON.stringify(slcAgent));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateByBonoTecho',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Bono modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('focusout', '.qtyPlaces', function () {
        var qtyPlaces     = $(this).val();
        var id            = $(this).data('id');
        var iva           = $('input:radio[name=iva]:checked').val();
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                 console.log(response.priceIva);
                 if(iva == 1){
                 $('#precio_'+id).val(response.priceIva); 
                   }else{
                   $('#precio_'+id).val(response.price);  
                  }
                 $('#precio_'+id).data('id',response.price);
                 $('#precio_'+id).data('iva',response.priceIva); 
                }
            });
       
    });
    
    $(document).on('focusout', '.qtyPlaces2', function () {
        var qtyPlaces     = $(this).val();
        var id            = $(this).data('id');
        var iva           = $('input:radio[name=iva]:checked').val();
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces,"iva":iva},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                 if(iva == 1){
                 $('#precio2_'+id).val(number_format(response.priceIva,2)); 
                 }else{
                  $('#precio2_'+id).val(number_format(response.price,2)); 
                  }
                 $('#precio2_'+id).data('id',response.price);
                
                 $('#precio2_'+id).data('iva',response.priceIva); 
                }
            });
       
    });
    
    $(document).on('click', '#sendFacture', function () {
        var idQuotation     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "html",
                data: { "idQuotation": idQuotation},
                url: '/invoiceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response == "true"){
                      Swal.fire(
                                'Facturada!',
                                'cotización facturada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_addComition', function () {
        
        var flag                 = "true";
        var slcAgent            = $("#slcAgent").val();
        var higher_to            = $("#higher_to").val();
        var higher_or_equal_to   = $("#higher_or_equal_to").val();
        var less_or_equal_to     = $("#less_or_equal_to").val();
        var less_to              = $("#less_to").val();
        var comition_higher      = $("#comition_higher").val();
        var comition_higher_less = $("#comition_higher_less").val();
        var comition_less        = $("#comition_less").val();
        var dateBon              = $("#dateBon").val();
        var isActive             = $("#isActive").val();
      console.log(isActive);
        
        if (higher_to == "") {
            flag = "false";
            $("#higher_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if(isActive == 1){

        if (higher_or_equal_to == "") {
            flag = "false";
            $("#higher_or_equal_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

        if (less_or_equal_to == "") {
            flag = "false";
            $("#less_or_equal_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

        if (comition_higher_less == "") {
            flag = "false";
            $("#comition_higher_less").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
    }
      
        
        
        if (less_to == "") {
            flag = "false";
            $("#less_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (comition_higher == "") {
            flag = "false";
            $("#comition_higher").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
    
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (comition_less == "") {
            flag = "false";
            $("#comition_less").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('higher_to',            higher_to);
            sendData.append('higher_or_equal_to',   higher_or_equal_to);
            sendData.append('less_or_equal_to',     less_or_equal_to);
            sendData.append('less_to',              less_to);
            sendData.append('comition_higher',      comition_higher);
            sendData.append('comition_higher_less', comition_higher_less);
            sendData.append('comition_less',        comition_less);
            sendData.append('dateBon',              dateBon);
            sendData.append('slcAgent',             JSON.stringify(slcAgent));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addcomition',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Comisión creada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/viewComition";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteNewCourse', function () {
       $(this).parent().empty();
    });
    
    $(document).on('click', '#addMoreCourses', function () {
     
         $.ajax({
                type: "POST",
                dataType: "json",
                url: '/getCourses',
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var count = $("#count").val();
                    if (response.valid == "true") {
                $("#courses").append('<div class="contentNewOpcion"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourse float-right" data-id="4"><span class="ti-close"></span></button>'
                        + '  <div class="row">   '
                        + '   <div class="col-md-2">'
                        + ' <div class="form-group">'
                        + '   <label class="control-label">Curso</label>'
                        + '  <select id="slcCourse" class="form-control custom-select slcCourse"  tabindex="1">'
                        + response.courses
                        + ' </select>'
                        + ' </div>'

                        + ' </div>'

                        + ' <div class="col-md-3">'
                        + '   <div class="form-group">'
                        + '    <label class="control-label">Otro</label>'
                        + '  <div class="input-group">'
                        + '  <input type="text" id="comition_higher" class="form-control other">'
                        + ' <div class="input-group-append">'

                        + ' </div>'
                        + '</div>'
                        + '</div>'
                        + '  </div>'

                        + '  <div class="col-md-2">'
                        + '  <div class="form-group">'
                        + '  <label class="control-label">Penalización *</label>'
                        + '<div class="input-group">'
                        + ' <input type="text" id="comition_higher" class="form-control penality">'
                        + ' <div class="input-group-append">'
                        + '  <span class="input-group-text" id="basic-addon11">%</span>'
                        + ' </div>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '<div class="col-md-3">'
                        + '<div class="form-group">'
                        + '<label class="control-label">Fecha Limite</label>'
                        + '<div class="input-group">'
                        + '<div class="input-group-prepend">'
                        + '<span class="input-group-text date" id="basic-addon11"><i class="ti-calendar"></i></span>'
                        + '</div>'
                        + '<input type="date" id="date_' + count + '" class="form-control date">'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + ' <div class="col-md-2">'

                        + '      <div class="form-group">'
                        + '  <label class="control-label">Hora Limite</label>'
                        + '   <div class="input-group">'
                        + '    <input class="form-control hour" type="time" id="hour_'+ count +'">'
                        + ' </div>'
                        + ' </div>   '
                        + '  </div>'
                        + '</div>'
                        + '</div>'
                        + '</div>'); 
                 
                 count++;
                 $("#count").val(count);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
     

    });
    
    $(document).on('click', '#btn_addCapacitation', function () {
        
        var flag            = "true";
        var slcAgent        = $("#slcAgent").val();
        var dateBon         = $("#dateBon").val();
        var arrayOptions    = [];
        var numOptions      = 0;
        var count           = 1;
        
      $('.contentNewOpcion').each(function(){
            
          var slcCourse   = $(this).find('.slcCourse').val();
          var other       = $(this).find('.other').val();
          var penality    = $(this).find('.penality').val();
          var date        = $(this).find('#date_'+count).val();
          var hour        = $(this).find('#hour_'+count).val();
    /* console.log(slcCourse);
     console.log(other);
     console.log(penality);
     console.log(date);*/
     
     if(typeof penality != "undefined"){
          arrayOptions[numOptions] = new Array(slcCourse
                                       ,other
                                       ,penality
                                       ,date
                                       ,hour);
             
               
              if (penality == "") {
            flag = "false";
            $(this).find('.penality').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
         if (date == "") {
            flag = "false";
            $(this).find('#date_'+count).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
        if (hour == "") {
            flag = "false";
            $(this).find('#hour_'+count).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
                                       
                 numOptions++;
                          }      
                  count++;
         });
       
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('dateBon',       dateBon);
            sendData.append('slcAgent',      JSON.stringify(slcAgent));
            sendData.append('arrayOptions',  JSON.stringify(arrayOptions));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addCourses',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Capacitación creada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/viewcapacitation";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
     $(document).on('change', '#yearCapacitation', function () {
        var years     = $(this).val();
        
         $.ajax({
                type: "POST",
                dataType: "json",
                data: { "years": years},
                url: '/getMontCapacitation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#month').empty();
                       $('#month').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
                    
    });
    
    $(document).on('click', '#searchCapacitation', function () {
        var year      = $('#yearCapacitation').val();
        var month     = $('#month').val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "year": year
                       ,"month": month},
                url: '/searchCapacitation',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    })
    
    $(document).on('change', '#yearComition', function () {
        var years     = $(this).val();
        
         $.ajax({
                type: "POST",
                dataType: "json",
                data: { "years": years},
                url: '/getMontComition',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       $('#month').empty();
                       $('#month').html(response.view);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
                    
    });
      
    $(document).on('click', '#searchBonusComition', function () {
        var year      = $('#yearComition').val();
        var month     = $('#month').val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "year": year
                       ,"month": month},
                url: '/searchBonusComition',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.viewAgentBondComit', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewAgentBondComit',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.updateBounComition', function () {
        var idBonus     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus},
                url: '/viewUpdateByBonoComit',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteBounComit', function () {
        var pkBond        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la comisión',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBond": pkBond},
                    url: '/delteBonoComit',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Comisión eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar comisión'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.viewCources', function () {
        var idBonus     = $(this).data('id');
        var pkUser      = $(this).data('user');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus
                       ,"pkUser":  pkUser},
                url: '/viewCources',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.updateToView', function () {
        var pkBond        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de marcar la capacitación como vista',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Marcar como visto!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBond": pkBond},
                    url: '/updateCourseview',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Hecho!',
                                'Capacitación vista con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al marcar como vista la Capacitación'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_deleteCapacitation', function () {
        var pkBond        = $(this).attr("data-id");
        var pkUser        = $(this).attr("data-user");
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la capacitación',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBond": pkBond
                          ,"pkUser": pkUser},
                    url: '/deleteCourses',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Capacitación eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar Capacitación'
                            });
                        }
                    }
                });
            }
        });
    });
    
     $(document).on('click', '#btn_addMoreCourses', function () {
        
        var arrayOptions = [];
        var numOptions   = 0;
        var id           = $(this).data('id');
        var user         = $(this).data('user');
        var count        = 1;
        var flag         = "true";
        
            $('.contentNewOpcion').each(function(){
             var slcCourse   = $(this).find('.slcCourse').val();
          var other       = $(this).find('.other').val();
          var penality    = $(this).find('.penality').val();
          var date        = $(this).find('#date_'+count).val();
          var hour        = $(this).find('#hour_'+count).val();
     
    /* console.log(slcCourse);
     console.log(other);
     console.log(penality);
     console.log(date);*/
     
     if(typeof penality != "undefined"){
          arrayOptions[numOptions] = new Array(slcCourse
                                       ,other
                                       ,penality
                                       ,date
                                       ,hour);
             
               
              if (penality == "") {
            flag = "false";
            $(this).find('.penality').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
         if (date == "") {
            flag = "false";
            $(this).find('#date_'+count).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
         if (hour == "") {
            flag = "false";
            $(this).find('#hour_'+count).css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
                                       
                 numOptions++;
                          }      
                  count++;      
         });
         
       // console.log(arrayOptions);
        
            var sendData = new FormData();
            sendData.append('user',      user);
            sendData.append('id',        id);
            sendData.append('arrayOptions',  JSON.stringify(arrayOptions));
         $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addMoreCourses',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    //console.log(response);
                      var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                         Swal.fire(
                                'Éxito!',
                                'Cursos añadidos con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
    });
    
    $(document).on('click', '.updateCapacitation', function () {
        var idBonus     = $(this).data('id');
        var pkUser        = $(this).attr("data-user");
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idBonus": idBonus
                       ,"pkUser": pkUser},
                url: '/viewUpdateByCourse',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_updateComition', function () {
        
        var flag                 = "true";
        var slcAgent            = $("#slcAgent").val();
        var higher_to            = $("#higher_to").val();
        var higher_or_equal_to   = $("#higher_or_equal_to").val();
        var less_or_equal_to     = $("#less_or_equal_to").val();
        var less_to              = $("#less_to").val();
        var comition_higher      = $("#comition_higher").val();
        var comition_higher_less = $("#comition_higher_less").val();
        var comition_less        = $("#comition_less").val();
        var dateBon              = $("#dateBon").val();
        var id                   = $(this).data('id');
        var isActive             = $("#isActive").val();
        
        if (higher_to == "") {
            flag = "false";
            $("#higher_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if(isActive == 1){
        if (higher_or_equal_to == "") {
            flag = "false";
            $("#higher_or_equal_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (less_or_equal_to == "") {
            flag = "false";
            $("#less_or_equal_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

        if (comition_higher_less == "") {
            flag = "false";
            $("#comition_higher_less").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
    }
        if (less_to == "") {
            flag = "false";
            $("#less_to").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        if (comition_higher == "") {
            flag = "false";
            $("#comition_higher").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
       
        if (dateBon == "") {
            flag = "false";
            $("#dateBon").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (comition_less == "") {
            flag = "false";
            $("#comition_less").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('higher_to',            higher_to);
            sendData.append('higher_or_equal_to',   higher_or_equal_to);
            sendData.append('less_or_equal_to',     less_or_equal_to);
            sendData.append('less_to',              less_to);
            sendData.append('comition_higher',      comition_higher);
            sendData.append('comition_higher_less', comition_higher_less);
            sendData.append('comition_less',        comition_less);
            sendData.append('dateBon',              dateBon);
            sendData.append('id',                   id);
            sendData.append('slcAgent',             JSON.stringify(slcAgent));
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateByBonoComit',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Comisión creada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.href = "/viewComition";
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                           text: resp.error
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
       
    $(document).on('click', '.btn-uploadDocument', function () {
        var idBonus     = $(this).data('id');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idBonus": idBonus},
                url: '/addDocumentByUser',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '#btn_uploadDocument', function () {
        
        var flag        = "true";
        var image       = $("#image").val();
        var id           = $(this).data('id');
        var ext              = image.substring(image.lastIndexOf("."));
        
        if(ext == 'jpg' || ext == 'png' || ext == 'jpeg'){
            
        }else{
         // flag = "false";   
        }
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1\. 0-9- \/]+$/g;
        
        if (image == "") {
            flag = "false";
            $("#image").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
       
        
      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('image',     $('#image')[0].files[0]);
            sendData.append('id',        id);
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addDocumentByUserDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Documento subido con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al subir documento'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_addcourse', function () {
        var flag        = "true";
        var name        = $("#nameCourse").val();
        var code        = $("#codeCourse").val();
        var link        = $("#linkCourse").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (name == "") {
            flag = "false";
            $("#nameCourse").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (code == "") {
            flag = "false";
            $("#codeCourse").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {"name": name
                      ,"code":code
                      ,"link":link},
                url: '/addCourse',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar curso'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_updateCourse', function () {
        var flag        = "true";
        var idCategory  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idCategory": idCategory},
                url: '/viewUpdateCourse',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEdit').empty();
                        $('#modalEdit').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteCourse', function () {
        var pkCategory        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el curso?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'S\u00ED, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkCategory": pkCategory},
                    url: '/deleteCourse',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Curso eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar curso'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_updateCoursedb', function () {
        var flag        = "true";
        var name        = $("#nameCourse2").val();
        var code        = $("#codeCourse2").val();
        var link        = $("#linkCourse2").val();
        var pkCourse    = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (name == "") {
            flag = "false";
            $("#nameCourse2").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (code == "") {
            flag = "false";
            $("#codeCourse2").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: { "name": name
                        ,"code":code
                        ,"pkCourse":pkCourse
                        ,"link":link},
                url: '/updateCourse',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response == "true"){
                         Swal.fire(
                                'Modificado!',
                                'Curso modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#sendmail', function () {
        var flag        = "true";
        var destinity   = $("#destinity").val();
        var subject     = $("#subject").val();
        var message     = $("#message").val();
        var document    = $("#document").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(subject)) {
            flag = "false";
            $("#subject").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (destinity == "") {
            flag = "false";
            $("#destinity").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (message == "") {
            flag = "false";
            $("#message").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
           var sendData = new FormData();
            sendData.append('file',     $('#file')[0].files[0]);
            sendData.append('destinity',  destinity);
            sendData.append('subject',    subject);
            sendData.append('message',    message);
            sendData.append('document',   document);
            
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/sendEmail',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Eviado!',
                                'Correo enviado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al enviar correo'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.searchInfo', function () {
        //LIMPIAMOS
        $('#startDay').val('');
        $('#finishDay').val('');

        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        var startDay   = $('#startDay').val();
        var finishDay  = $('#finishDay').val();
        var pkUser     = $('#pkUser').val();
        var pkGiro     = $('#pkGiro').val();
        var pkCampanin = $('#pkCampanin').val();
        
        console.log(startDay);
        console.log(pkUser);
        console.log(pkGiro);
        console.log(pkCampanin);
        
              if(id== 1){
                day = 1;  
              }
               if(id== 2){
               month = 1;   
              }
               if(id== 3){
               year = 1;   
              }
              
       console.log(day);
       console.log(month);
       console.log(year);
       
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"day": day
                      ,"month": month
                      ,"year":  year
                      ,"startDay": startDay
                      ,"finishDay": finishDay
                      ,"pkUser": pkUser
                      ,"pkGiro": pkGiro
                      ,"pkCampanin": pkCampanin
            },
                url: '/dashboardFilter',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#infoChange').empty();
                        $('#infoChange').html(response.view);

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });
    
    $(document).on('click', '#search_dashboard', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        var startDay   = $('#startDay').val();
        var finishDay  = $('#finishDay').val();
        var pkUser     = $('#pkUser').val();
        var pkGiro     = $('#pkGiro').val();
        var pkCampanin = $('#pkCampanin').val();
        var customTooltip = function (valor) {
            var val = parseFloat(valor).toFixed(2);
            var ventas = new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }).format(val);
            return '$ ' + ventas  + ' MXN';
        };

        var options = {
            seriesBarDistance: 10,
            plugins: [
                Chartist.plugins.tooltip({
                    transformTooltipTextFnc: customTooltip
                })
            ]
        };

        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5
            }]
        ];
        
        console.log(startDay);
        console.log(pkUser);
        console.log(pkGiro);
        console.log(pkCampanin);
        

        
        $('.searchInfor').each(function() { 
            if($(this).is(':checked')){
                if($(this).val()== 1){
                    day = 1;  
                  }
                   if($(this).val()== 2){
                   month = 1;   
                  }
                   if($(this).val()== 3){
                   year = 1;   
                  }
            }
       });
             
              
       console.log(day);
       console.log(month);
       console.log(year);
       
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"day": day
                      ,"month": month
                      ,"year":  year
                      ,"startDay": startDay
                      ,"finishDay": finishDay
                      ,"pkUser": pkUser
                      ,"pkGiro": pkGiro
                      ,"pkCampanin": pkCampanin
            },
                url: '/dashboardFilter',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){

                        $('#infoChange').empty();
                        $('#infoChange').html(response.view);
                        $("#quotationsBar").empty()

                        var ene = response.salesTotal['01'] ? response.salesTotal['01'] : 0
                        var feb = response.salesTotal['02'] ? response.salesTotal['02'] : 0
                        var mar = response.salesTotal['03'] ? response.salesTotal['03'] : 0
                        var abr = response.salesTotal['04'] ? response.salesTotal['04'] : 0
                        var may = response.salesTotal['05'] ? response.salesTotal['05'] : 0
                        var jun = response.salesTotal['06'] ? response.salesTotal['06'] : 0
                        var jul = response.salesTotal['07'] ? response.salesTotal['07'] : 0
                        var ago = response.salesTotal['08'] ? response.salesTotal['08'] : 0
                        var sep = response.salesTotal['09'] ? response.salesTotal['09'] : 0
                        var oct = response.salesTotal['10'] ? response.salesTotal['10'] : 0
                        var nov = response.salesTotal['11'] ? response.salesTotal['11'] : 0
                        var dic = response.salesTotal['12'] ? response.salesTotal['12'] : 0
                        var enep = response.salesTotalRejectArray['01'] ? response.salesTotalRejectArray['01'] : 0
                        var febp = response.salesTotalRejectArray['02'] ? response.salesTotalRejectArray['02'] : 0
                        var marp = response.salesTotalRejectArray['03'] ? response.salesTotalRejectArray['03'] : 0
                        var abrp = response.salesTotalRejectArray['04'] ? response.salesTotalRejectArray['04'] : 0
                        var mayp = response.salesTotalRejectArray['05'] ? response.salesTotalRejectArray['05'] : 0
                        var junp = response.salesTotalRejectArray['06'] ? response.salesTotalRejectArray['06'] : 0
                        var julp = response.salesTotalRejectArray['07'] ? response.salesTotalRejectArray['07'] : 0
                        var agop = response.salesTotalRejectArray['08'] ? response.salesTotalRejectArray['08'] : 0
                        var sepp = response.salesTotalRejectArray['09'] ? response.salesTotalRejectArray['09'] : 0
                        var octp = response.salesTotalRejectArray['10'] ? response.salesTotalRejectArray['10'] : 0
                        var novp = response.salesTotalRejectArray['11'] ? response.salesTotalRejectArray['11'] : 0
                        var dicp = response.salesTotalRejectArray['12'] ? response.salesTotalRejectArray['12'] : 0

                        var newData = {
                            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                            series: [
                                [
                                    { meta: 'Ventas', value: ene },
                                    { meta: 'Ventas', value: feb },
                                    { meta: 'Ventas', value: mar },
                                    { meta: 'Ventas', value: abr },
                                    { meta: 'Ventas', value: may },
                                    { meta: 'Ventas', value: jun },
                                    { meta: 'Ventas', value: jul },
                                    { meta: 'Ventas', value: ago },
                                    { meta: 'Ventas', value: sep },
                                    { meta: 'Ventas', value: oct },
                                    { meta: 'Ventas', value: nov },
                                    { meta: 'Ventas', value: dic },
                                ],
                                [
                                    { meta: 'Descartados', value: enep },
                                    { meta: 'Descartados', value: febp },
                                    { meta: 'Descartados', value: marp },
                                    { meta: 'Descartados', value: abrp },
                                    { meta: 'Descartados', value: mayp },
                                    { meta: 'Descartados', value: junp },
                                    { meta: 'Descartados', value: julp },
                                    { meta: 'Descartados', value: agop },
                                    { meta: 'Descartados', value: sepp },
                                    { meta: 'Descartados', value: octp },
                                    { meta: 'Descartados', value: novp },
                                    { meta: 'Descartados', value: dicp },
                                ]
                            ]
                        };

                        new Chartist.Bar('.ct-bar-chart', newData, options, responsiveOptions);

                        var ene = response.monthValues[0]
                        var feb = response.monthValues[1]
                        var mar = response.monthValues[2]
                        var abr = response.monthValues[3]
                        var may = response.monthValues[4]
                        var jun = response.monthValues[5]
                        var jul = response.monthValues[6]
                        var ago = response.monthValues[7]
                        var sep = response.monthValues[8]
                        var oct = response.monthValues[9]
                        var nov = response.monthValues[10]
                        var dic = response.monthValues[11]

                        Morris.Bar({
                            element: 'quotationsBar',
                            data: [
                                { y: ene.y, a: ene.a, b: ene.b, c: ene.c },
                                { y: feb.y, a: feb.a, b: feb.b, c: feb.c },
                                { y: mar.y, a: mar.a, b: mar.b, c: mar.c },
                                { y: abr.y, a: abr.a, b: abr.b, c: abr.c },
                                { y: may.y, a: may.a, b: may.b, c: may.c },
                                { y: jun.y, a: jun.a, b: jun.b, c: jun.c },
                                { y: jul.y, a: jul.a, b: jul.b, c: jul.c },
                                { y: ago.y, a: ago.a, b: ago.b, c: ago.c },
                                { y: sep.y, a: sep.a, b: sep.b, c: sep.c },
                                { y: oct.y, a: oct.a, b: oct.b, c: oct.c },
                                { y: nov.y, a: nov.a, b: nov.b, c: nov.c },
                                { y: dic.y, a: dic.a, b: dic.b, c: dic.c },
                            ],
                            xkey: 'y',
                            ykeys: ['a', 'b', 'c'],
                            labels: ['Cerrada', 'Abierta', 'Descartadas'],
                            barColors:['#55ce63', '#009efb', '#e46a76'],
                            hideHover: 'auto',
                            gridLineColor: '#eef0f2',
                            resize: true
                        });

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });
    
    $(document).on('click', '.Checkbox', function () {
        
        var pkQuotation = $(this).data('id');

     if( $(this).prop('checked') ) {
         Swal.fire({
            title: 'Est\u00E1s seguro que el dinero ya est\u00E1 en la cuenta bancaria?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, marcar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkQuotation": pkQuotation},
                    url: '/setPaymentInCount',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");

                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Dinero en cuenta!',
                                'Se ha confirmado pago con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al confirmar pago'
                            });
                        }
                    }
                });
            }else{
               $(this).prop('checked', false); 
            }
        });
     }
}); 
    
 
$(document).on('click', '#viewbtnPrefacture', function () {
        
    var pkQuotation             = $(this).data('id');
    var serie                   = $('#serie').val();
    var slccfdi                 = $('#slccfdi').val();
    var payment                 = $('#payment').val();
    var method                  = $('#method').val();
    var condition               = $('#condition').val();
    var rfc                     = $('#rfc').val();
    var social                  = $('#social').val();
    var slcProduct              = $('#slcProduct').val();
    var slcUnity                = $('#slcUnity').val();
    var numIden                 = $('#numIden').val();
    var desc                    = $('#desc').val();
    var comment                 = $('#comment').val();
    var flag                    = "true";
    var description             = [];
    var cont = 0;
    
    $('.descFact').each(function() { 
       var id   = $(this).data('id');
       var desc = $(this).val();

       description[cont] = {"id": id,"desc":desc};
       cont++;
   });
    

     if (rfc == "") {
          flag = "false";
          $("#rfc").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
      
      if (social == "") {
          flag = "false";
          $("#social").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
    
      if (slccfdi < 0) {
          flag = "false";
          $("#slccfdi").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
      
       if (payment < 0) {
          flag = "false";
          $("#payment").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
    
    if (method < 0) {
          flag = "false";
          $("#method").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
      
      if (condition < 0) {
          flag = "false";
          $("#condition").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
      
       if (slcProduct < 0) {
          flag = "false";
          $("#slcProduct").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
      
       if (slcUnity < 0) {
          flag = "false";
          $("#slcUnity").css({
              "-moz-box-shadow": "0 0 5px #f40404",
              "-webkit-box-shadow": "0 0 5px #f40404",
              "box-shadow": "0 0 5px #f40404"
          }
          );
      }
         if(flag == "true"){
          var sendData = new FormData();    
         sendData.append('serie',     serie);
         sendData.append('slccfdi',   slccfdi);
         sendData.append('payment',   payment);
         sendData.append('method',    method);
         sendData.append('condition', condition);
         sendData.append('rfc',       rfc);
         sendData.append('social',    social);
         sendData.append('slcProduct',slcProduct);
         sendData.append('slcUnity',  slcUnity);
         sendData.append('numIden',   numIden);
         sendData.append('desc',      desc);
         sendData.append('comment',      comment);
         sendData.append('pkQuotation', pkQuotation);
         sendData.append('description', JSON.stringify(description));
         

              $.ajax({
                  type: "POST",
                  dataType: "html",
                  contentType: false,
                  processData: false,
                  cache: false,
                  data: sendData,
                  url: '/prefactura',
                  beforeSend: function () {
                   $.LoadingOverlaySetup({
                          image: "/images/loading.gif",
                          imageAnimation: "1.5s fadein"
                      });

                      $.LoadingOverlay("show");
                  },
                  success: function (response) {
                      $.LoadingOverlay("hide");
                      if(response == "true"){
                        window.open('/prefactura/'+pkQuotation);
                      }else{
                          Swal.fire({
                              type: 'error',
                              title: 'Error al timbrar factura',
                              text: response.message
                          });
                      }
                  },
                error: function(xhr, status, error) {
                   $.LoadingOverlay("hide");
                      }
              });

  }else{
        Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Campos inv\u00E1lidos'
              });
  }
 
}); 

    $(document).on('click', '#btnUpdateFacture', function () {
        
      var pkQuotation             = $(this).data('id');
     
            var sendData = new FormData();    
           sendData.append('pkQuotation', pkQuotation);
           
         Swal.fire({
            title: 'Est\u00E1s seguro de timbrar esta factura',
            text: "verifica que todos los datos sean correctos!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, timbrar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: sendData,
                    url: '/generateInvoice',
                    beforeSend: function () {
                     $.LoadingOverlaySetup({
                            image: "/images/loading.gif",
                            imageAnimation: "1.5s fadein"
                        });

                        $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response.valid == "true"){
                            Swal.fire(
                                'Facturada!',
                                'Se ha timbrado la factura con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Error al timbrar factura',
                                text: response.message
                            });
                        }
                    },
                  error: function(xhr, status, error) {
                     $.LoadingOverlay("hide");
                        }
                });
            }
        });
   
   
}); 
    
    $(document).on('click', '.modalpay', function () {
        
        var pkQuotation = $(this).data('id');
        
        $('.addPay').attr('data-id', pkQuotation);

      }); 

    $(document).on('click', '.addPay', function () {
          
        var flag        = "true";
        var image       = $("#image").val();
        var id          = $(this).data('id');

        
        var ext              = image.substring(image.lastIndexOf("."));
        console.log(ext);
        if(ext == '.jpg' || ext == '.png' || ext == '.jpeg' || ext == '.pdf'){
            
        }else{
          flag = "false";   
        }
   

      if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('image',  $('#image')[0].files[0]);
            sendData.append('id',     id);
             
            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addpayment',
                beforeSend: function () {
                },
                success: function (response) {
                    var resp = JSON.parse(response);
                    if(resp.valid == "true"){
                        Swal.fire(
                                'Éxito!',
                                'Comprobante agregado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                              location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar comprobante'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
  
    }); 
    
    $(document).on('click', '#createActivity', function () {
        $.ajax({
                type: "POST",
                dataType: "json",
                url: '/getCreateActivity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario2').empty();
                        $('#modalUsuario2').html(response.view);
                        $('.modalEditUsuario2').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });    
    }); 
    
    $(document).on('click', '#createActivityModal', function () {
        var flag                    = "true";
        var activityBusiness        = $('#activityBusiness').val();
        var type_event_business     = $('#type_event_business').val();
        var userAgent               = $('#userAgent').val();
        var type_activity           = $('#type_activity').val();
        var description             = $('#description').val();
        var date                    = $('#date').val();
        var hour                    = $('#hour').val();
        var document                = $('#document').val();
        event.preventDefault();
    
        var descriptionRegex      = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        
        if (activityBusiness == "-1") {
            flag = "false";
            $("#activityBusiness").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (type_event_business == "-1") {
            flag = "false";
            $("#type_event_business").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (userAgent == "-1") {
            flag = "false";
            $("#userAgent").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (type_activity == "-1") {
            flag = "false";
            $("#type_activity").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (description == "") {
            flag = "false";
            $("#description").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (date == "") {
            flag = "false";
            $("#date").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (hour == "") {
            flag = "false";
            $("#hour").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
      
        
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('activityBusiness', activityBusiness);
            sendData.append('type_event_business', type_event_business);
            sendData.append('userAgent', userAgent);
            sendData.append('type_activity', type_activity);
            sendData.append('description', description);
            sendData.append('date', date);
            sendData.append('hour', hour);
            sendData.append('document', $('#document')[0].files[0]);
            
            
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/activityCreateDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Actividad registrada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.viewDetailOportunity', function () {
      var flag        = "true";
      var idOPortunity = $(this).data('id');        
        
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idOPortunity": idOPortunity},
                url: '/viewDetailOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '#search_bussines', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        var startDay   = $('#startDay').val();
        var finishDay  = $('#finishDay').val();
        var slcViewStatusBussines     = $('#slcViewStatusBussines2').val();
        var pkGiro     = $('#pkGiro').val();
        var pkCampanin = $('#pkCampanin').val();
        
        console.log(startDay);
        console.log(slcViewStatusBussines);
        console.log(pkGiro);
        console.log(pkCampanin);
        
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"startDay": startDay
                      ,"finishDay": finishDay
                      ,"slcViewStatusBussines": slcViewStatusBussines
                      ,"pkGiro": pkGiro
                      ,"pkCampanin": pkCampanin
            },
                url: '/searchBusiness',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#activeEmpDiv').empty();
                        $('#activeEmpDiv').html(response.view);
                        
                         $('#activeEmp').DataTable({
                            dom: 'Bfrtip',
                            "searching": false,
                            buttons: [
                              
                            ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });
    
    $(document).on('click', '#search_bussines_prospect', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        var startDay   = $('#startDay').val();
        var finishDay  = $('#finishDay').val();
        var slcViewStatusBussines     = $('#slcViewStatusBussines2').val();
        var pkGiro     = $('#pkGiro').val();
        var pkCampanin = $('#pkCampanin').val();
        
        console.log(startDay);
        console.log(slcViewStatusBussines);
        console.log(pkGiro);
        console.log(pkCampanin);
        
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"startDay": startDay
                      ,"finishDay": finishDay
                      ,"slcViewStatusBussines": slcViewStatusBussines
                      ,"pkGiro": pkGiro
                      ,"pkCampanin": pkCampanin
            },
                url: '/searchBusinessProspect',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#activeEmpDiv').empty();
                        $('#activeEmpDiv').html(response.view);
                        
                         $('#activeEmp').DataTable({
                            dom: 'Bfrtip',
                            "searching": false,
                            buttons: [
                              
                            ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });
    
    $(document).on('click', '#search_bussines_leads', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        var startDay   = $('#startDay').val();
        var finishDay  = $('#finishDay').val();
        var slcViewStatusBussines     = $('#slcViewStatusBussines2').val();
        var pkGiro     = $('#pkGiro').val();
        var pkCampanin = $('#pkCampanin').val();
        
        console.log(startDay);
        console.log(slcViewStatusBussines);
        console.log(pkGiro);
        console.log(pkCampanin);
        
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"startDay": startDay
                      ,"finishDay": finishDay
                      ,"slcViewStatusBussines": slcViewStatusBussines
                      ,"pkGiro": pkGiro
                      ,"pkCampanin": pkCampanin
            },
                url: '/searchBusinessLeads',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#activeEmpDiv').empty();
                        $('#activeEmpDiv').html(response.view);
                        
                         $('#activeEmp').DataTable({
                            dom: 'Bfrtip',
                            "searching": false,
                            buttons: [
                              
                            ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });
    $(document).on('click', '#search_bussines_clients', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        var startDay   = $('#startDay').val();
        var finishDay  = $('#finishDay').val();
        var slcViewStatusBussines     = $('#slcViewStatusBussines2').val();
        var pkGiro     = $('#pkGiro').val();
        var pkCampanin = $('#pkCampanin').val();
        
        console.log(startDay);
        console.log(slcViewStatusBussines);
        console.log(pkGiro);
        console.log(pkCampanin);
        
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"startDay": startDay
                      ,"finishDay": finishDay
                      ,"slcViewStatusBussines": slcViewStatusBussines
                      ,"pkGiro": pkGiro
                      ,"pkCampanin": pkCampanin
            },
                url: '/searchBusinessClient',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#activeEmpDiv').empty();
                        $('#activeEmpDiv').html(response.view);
                        
                         $('#activeEmp').DataTable({
                            dom: 'Bfrtip',
                            "searching": false,
                            buttons: [
                              
                            ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });
    
   $(document).on('click', '#search_activiy_agent', function () {
      var flag       = "true";
      var Agent      = $('#agent').val();      
        console.log(Agent);
      if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"Agent" : Agent},
                url: '/seachArcivityAgent',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                    
                        $('#activitysAgent').empty();
                        $('#activitysAgent').html(response.view);
                       
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
   function checkChildren(input) {

    var permition = $(input).data('id');
    var parentPermition = $(input).data('parent');

    if ($(input).prop('checked')) {
          //para chekear los hijos
        var children = $('*[data-parent="' + permition + '"]');
        if (children.data('id') != "" && typeof children.data('id') !== typeof undefined) {
            console.log(children.data('id'));
            $('*[data-parent="' + permition + '"]').prop("checked", true);
            checkChildren(children);
        }
 
    }

}

   function uncheckChildren(input) {

    var permition = $(input).data('id');
    var parentPermition = $(input).data('parent');

    if ($(input).prop('checked')) {
      
    }else{
        var parent = $('*[data-parent="' + permition + '"]');
        if (parent.data('id') != "" && typeof parent.data('id') !== typeof undefined) {

            console.log(parent.data('id'));
            $('*[data-parent="' + permition + '"]').prop("checked", false);
            uncheckChildren(parent);
        }  
    }

}

   function checkParent(input) {
       
    var parentPermition = $(input).data('parent');

    if ($(input).prop('checked')) {
        var parent = $('*[data-id="' + parentPermition + '"]');
        if (parent.data('id') != "" && typeof parent.data('id') !== typeof undefined) {
            console.log(parent.data('id'));
            $('*[data-id="' + parentPermition + '"]').prop("checked", true);
            checkParent(parent);
        }
 
    }

}

   function uncheckParent(input) {
       
    var parentPermition = $(input).data('parent');

    if ($(input).prop('checked')) {
    }else{
        var parent = $('*[data-id="' + parentPermition + '"]');
        if (parent.data('id') != "" && typeof parent.data('id') !== typeof undefined) {
            console.log(parent.data('id'));
            $('*[data-id="' + parentPermition + '"]').prop("checked", true);
            checkParent(parent);
        }      
    }

}
    
   $(document).on('click', '.checkPermition', function () {
           if ($(this).prop('checked')) {
               
          checkChildren(this);
          checkParent(this);
          
           }else{
            uncheckChildren(this);  
            uncheckParent(this);
           }
    });
    
   function searchChildren(father){
       
      var permitionChildren = [];
      var permitionAux      = new Array();
      var parent = $(father).data('id');
      cont = 0;
       $('*[data-parent="' + parent + '"]').each(function (index) {
          var children = $(this).data('id');
          permitionChildren[cont] = children;
          cont++;
       });
       //permitionAux[parent] = permitionChildren;
       
       return permitionChildren;
   }
   
   function isCheck(module){
      if ($(module).prop('checked')) {
       return "1";
      }else{
       return "0";   
      } 
   }
   
   
   $(document).on('change', '#typeGroupUser', function () {
        var typeUser     = $(this).val();
        
           if(typeUser == 2){
               $("#permitionUser").css("display","block");
           }else{
             $("#permitionUser").css("display","none");  
           }
       
    });
      
   $(document).on('click', '#btnCreateUser', function () {
       
    var group      = $("#typeGroupUser").val();
    var type       = $("#typeUser").val();
    var name       = $("#name").val();
    var username   = $("#username").val();
    var extension  = $("#extension").val();
    var email      = $("#email").val();
    var password   = $("#password").val();
    var image      = $("#image").val();
    var flag       = "true";
    var ext              = image.substring(image.lastIndexOf("."));

    var permitionAux = {};
    var permitionAux2 = {};
    var permition = {};
    var fathers   = new Array();
    var cont = 0;
    
    $(".checkPermition").each(function (index) {
      if ($(this).data('children') == "1" || $(this).data('children') == "2"){
        //console.log($(this).data('id'));
         //permition[$(this).data('id')] = isCheck(this);
        permitionAux[$(this).data('id')] =  searchChildren(this);
          if ($(this).data('children') == "1"){
           fathers[cont] = $(this).data('id');
            cont++;
         }
       
     }else{
         if($(this).data('children') == "-1"){
       permition[$(this).data('id')] = isCheck(this);
         }
     }
    });
    // console.log(permitionAux);
     $.each(fathers, function(index, value){
       // console.log(value);
        var per2 = { };
         $.each(permitionAux[value], function(indexF, valueF){
             
           //console.log(value);
          if(typeof permitionAux[valueF] != 'undefined'){
               var per = { };
           $.each(permitionAux[valueF], function(index2, value2){
               //console.log(value2);   
           
            per[value2] = isCheck($("#"+value2));
            per2[valueF] = per;
           
            // console.log(per);  
            permitionAux2[value] = per2;
            permition[value] = permitionAux2[value];
           });
       
          }else{
             
           // console.log(valueF);  
            per2[valueF] = isCheck($("#"+valueF));
           permitionAux2[value]= per2;
           console.log(permitionAux2[value]);
               permition[value] = permitionAux2[value];
          }
       });
    });

  // console.log(fathers);
      console.log(permition);
    var permitionDef = {"permition":permition};
    
      console.log(JSON.stringify(permitionDef)); 
     // alert(JSON.stringify(permitionDef));

        if(ext == '.jpg' || ext == '.png' || ext == '.jpeg'){
            
        }else{
         flag = "false";  
           $("#image").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            });
        }
        
          if (name == "") {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
           if (username == "") {
            flag = "false";
            $("#username").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (extension == "") {
            flag = "false";
            $("#extension").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (email == "") {
            flag = "false";
            $("#email").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (password == "") {
            flag = "false";
            $("#password").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('permition',JSON.stringify(permitionDef));
            sendData.append('group'    ,group);
            sendData.append('type'     ,type);
            sendData.append('name'     ,name);
            sendData.append('username' ,username);
            sendData.append('extension',extension);
            sendData.append('email'    ,email);
            sendData.append('password' ,password);
            sendData.append('image',     $('#image')[0].files[0]);

            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/addCreateUserDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Agregado!',
                                'Usuario agregado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al crear usuario'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    
  
});

   $(document).on('click', '.btn_deleteUser', function () {
        var pkUser        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el usuario',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkUser": pkUser},
                    url: '/deleteUser',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Usuario eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar bono'
                            });
                        }
                    }
                });
            }
        });
    });

   $(document).on('click', '.updateUser', function () {
        var flag        = "true";
        var pkUser  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkUser": pkUser},
                url: '/updateUser',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                    $.LoadingOverlay("hide");
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
   $(document).on('click', '.btn_editUser', function () {
    var pkUser     = $(this).data('id');
    var group      = $("#typeGroupUser").val();
    var type       = $("#typeUser").val();
    var name       = $("#name").val();
    var username   = $("#username").val();
    var extension  = $("#extension").val();
    var email      = $("#email").val();
    var color      = $("#colorUpdate").val();
    var password   = $("#password").val();
    var image      = $("#image").val();
    var flag       = "true";
    var ext              = image.substring(image.lastIndexOf("."));

    
        
          if (name == "") {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
           if (username == "") {
            flag = "false";
            $("#username").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (extension == "") {
            flag = "false";
            $("#extension").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (email == "") {
            flag = "false";
            $("#email").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (password == "") {
            flag = "false";
            $("#password").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('pkUser'  ,pkUser);
            sendData.append('name'     ,name);
            sendData.append('username' ,username);
            sendData.append('extension',extension);
            sendData.append('email'    ,email);
            sendData.append('color'    ,color);
            sendData.append('password' ,password);
            sendData.append('image',     $('#image')[0].files[0]);

            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateUserDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Modificado!',
                                'Usuario modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar usuario'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    
  
}); 
    
   $(document).on('click', '.updatePermition', function () {
        var flag        = "true";
        var pkUser  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkUser": pkUser},
                url: '/updatePermition',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                    $.LoadingOverlay("hide");
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
   $(document).on('click', '#btnUpdatePermition', function () {
       
    var pkUser     = $(this).data('id');
    var group      = $("#typeGroupUser").val();
    var type       = $("#typeUser").val();
    var flag       = "true";
    var permitionAux = {};
    var permitionAux2 = {};
    var permition = {};
    var fathers   = new Array();
    var cont = 0;
    
    $(".checkPermition").each(function (index) {
      if ($(this).data('children') == "1" || $(this).data('children') == "2"){
        //console.log($(this).data('id'));
         //permition[$(this).data('id')] = isCheck(this);
        permitionAux[$(this).data('id')] =  searchChildren(this);
          if ($(this).data('children') == "1"){
           fathers[cont] = $(this).data('id');
            cont++;
         }
       
     }else{
         if($(this).data('children') == "-1"){
       permition[$(this).data('id')] = isCheck(this);
         }
     }
    });
    // console.log(permitionAux);
     $.each(fathers, function(index, value){
       // console.log(value);
        var per2 = { };
         $.each(permitionAux[value], function(indexF, valueF){
             
           //console.log(value);
          if(typeof permitionAux[valueF] != 'undefined'){
               var per = { };
           $.each(permitionAux[valueF], function(index2, value2){
               //console.log(value2);   
           
            per[value2] = isCheck($("#"+value2));
            per2[valueF] = per;
           
            // console.log(per);  
            permitionAux2[value] = per2;
            permition[value] = permitionAux2[value];
           });
       
          }else{
             
           // console.log(valueF);  
            per2[valueF] = isCheck($("#"+valueF));
           permitionAux2[value]= per2;
           console.log(permitionAux2[value]);
               permition[value] = permitionAux2[value];
          }
       });
    });

  // console.log(fathers);
      console.log(permition);
    var permitionDef = {"permition":permition};
    
      console.log(JSON.stringify(permitionDef)); 
     // alert(JSON.stringify(permitionDef));

      
       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('permition',JSON.stringify(permitionDef));
            sendData.append('group'    ,group);
            sendData.append('type'     ,type);
            sendData.append('pkUser'   ,pkUser);

            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updatePermitionDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Modificado!',
                                'Perimisos de usuario modificados con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar permisos'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    
  
});

   $(document).on('click', '.btnUpdateContact', function () {
        var flag        = "true";
        var pkContact  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkContact": pkContact},
                url: '/updateContact',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                    $.LoadingOverlay("hide");
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                      //  $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
   
   $(document).on('click', '.btnUpdateContactDB', function () {
        var flag         = "true";
        var nameContact  = $("#nameContactw").val();
        var cargo        = $("#cargow").val();
        var email        = $("#emailw").val();
        var phone        = $("#phonew").val();
        var extension    = $("#extensionw").val();
        var cel          = $("#celw").val();
        var idContact    = $(this).data('id');
        console.log(nameContact);
        var nameRegex    = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        

        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {"nameContact": nameContact
                      ,"cargo": cargo
                      ,"email": email        
                      ,"phone": phone 
                      ,"extension": extension 
                      ,"cel": cel
                      ,"idContact":idContact},
                url: '/btnUpdateContactDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                                'Modificado!',
                                'Contacto modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar contacto'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
   /*$(document).on('focusout', '.qtyEmployee2', function () {
        var qtyEmployee   = $(this).val();
        var slcCourse2    = $(this).data('id');
       
        $("#qtyPlaces2_10").val(qtyEmployee *slcCourse2);
       
    });*/
    
   $(document).on('focusout', '.qtyEmployeeOp', function () {
        var qtyEmployee   = $(this).val();
        var cantCourses   = 0;
        //var iva           = $('input:radio[name=iva]:checked').val();
       
       
        
        var qtyPlaces     = qtyEmployee;
        var id            = $(this).data('id');
        var places        = calTotalOportunity(id);
        console.log(places);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                 $('#precioOp_'+id).val(number_format(response.priceIva,2)); 
                 $('#precioOp_'+id).data('id',response.price); 
                 
                 $('.subOp').val(number_format(response.subtotalIva,2)); 
                 $('.descOp').val(number_format(response.descuentoIva,2)); 
                 $('.totalOp').val(number_format(response.totalIva,2)); 

                }
            });
       
    });
    
   $(document).on('focusout', '.qtyEmployeeOpEdit', function () {
      var qtyEmployee   = $(this).val();
        var cantCourses   = 0;
        //var iva           = $('input:radio[name=iva]:checked').val();
       
       
        
        var qtyPlaces     = qtyEmployee;
        var id            = $(this).data('id');
        var places        = calTotalOportunityEdit(id);
        console.log(places);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                 $('#precioOpEdit_'+id).val(number_format(response.priceIva,2)); 
                 $('#precioOpEdit_'+id).data('id',response.price); 
                 
                 $('.subOpD').val(number_format(response.subtotalIva,2)); 
                 $('.descOpD').val(number_format(response.descuentoIva,2)); 
                 $('.totalOpD').val(number_format(response.totalIva,2)); 

                }
            });
    });
    
   $(document).on('focusout', '.qtyEmployeeQ', function () {
        var qtyEmployee   = $(this).val();
        var cantCourses   = 0;
        var iva           = $('input:radio[name=iva]:checked').val();
        var id            = $(this).data('op');
        var type          = $('input:radio[name=typePrice2'+id+']:checked').val();
       
       console.log(type);
       console.log("palces "+places);
       console.log(cantCourses);
       console.log("iva "+iva);
        
        var qtyPlaces     = qtyEmployee;
        var id            = $(this).data('id');
        var op            = $(this).data('op');
        var places        = calTotalQuotation(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                if(iva == 1){
                 $('#precioQ_'+op+'_'+id).val(number_format(response.priceIva,2)); 
                 $('#precioU_'+op+'_'+id).val(number_format(response.priceUnitIva,2)); 
             }else{
                 $('#precioQ_'+op+'_'+id).val(number_format(response.price,2)); 
                 $('#precioU_'+op+'_'+id).val(number_format(response.priceUnit,2));  
             }
                 $('#precioQ_'+op+'_'+id).data('iva',response.priceIva); 
                 $('#precioQ_'+op+'_'+id).data('id',response.price); 

                 $('#precioU_'+op+'_'+id).data('iva',response.priceUnitIva); 
                 $('#precioU_'+op+'_'+id).data('id',response.priceUnit); 
                 
                 //subtota,total,desc
                 if(iva == 1){
                 $('#subQ_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQ_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQ_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQ_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQ_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQ_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQ_'+op).data('iva',response.subtotalIva); 
                 $('#subQ_'+op).data('id',response.subtotal);
                 
                 $('#descQ_'+op).data('iva',response.descuentoIva); 
                 $('#descQ_'+op).data('id',response.descuento);
                 
                 $('#totalQ_'+op).data('iva',response.totalIva); 
                 $('#totalQ_'+op).data('id',response.total);
                 
                }
            });
       
    });
    
   $(document).on('click', '.recalcular', function () {
    
        var iva           = $('input:radio[name=iva]:checked').val();
        var op            = $(this).data('id');
        var qtyPlaces     = 1;
        var type          = $('input:radio[name=typePrice2'+op+']:checked').val();

        var places        = calTotalQuotation(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                
                //subtota,total,desc
                 if(iva == 1){
                 $('#subQ_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQ_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQ_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQ_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQ_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQ_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQ_'+op).data('iva',response.subtotalIva); 
                 $('#subQ_'+op).data('id',response.subtotal);
                 
                 $('#descQ_'+op).data('iva',response.descuentoIva); 
                 $('#descQ_'+op).data('id',response.descuento);
                 
                 $('#totalQ_'+op).data('iva',response.totalIva); 
                 $('#totalQ_'+op).data('id',response.total);
                 
                }
            });
       
    });
    
    $(document).on('click', '.recalcularQC', function () {
    
        var iva           = $('input:radio[name=iva2]:checked').val();
        var op            = $(this).data('id');
        var qtyPlaces     = 1;
        var type          = $('input:radio[name=typePrice1'+op+']:checked').val();

        var places        = calTotalQuotationConv(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places, "type":type},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                
                //subtota,total,desc
                 if(iva == 1){
                 $('#subQC_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQC_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQC_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQC_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQC_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQC_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQC_'+op).data('iva',response.subtotalIva); 
                 $('#subQC_'+op).data('id',response.subtotal);
                 
                 $('#descQC_'+op).data('iva',response.descuentoIva); 
                 $('#descQC_'+op).data('id',response.descuento);
                 
                 $('#totalQC_'+op).data('iva',response.totalIva); 
                 $('#totalQC_'+op).data('id',response.total);
                 
                }
            });
       
    });
    
   $(document).on('click', '.recalcularOP', function () {
    
  
        var qtyPlaces  = 1;

        var places     = calTotalOportunity();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {

                 $('.subOp').val(number_format(response.subtotalIva,2)); 
                 $('.descOp').val(number_format(response.descuentoIva,2)); 
                 $('.totalOp').val(number_format(response.totalIva,2)); 
                }
            });
       
    });
    
    $(document).on('click', '.recalcularOPD', function () {
    
  
        var qtyPlaces  = 1;

        var places     = calTotalOportunityEdit();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {

                 $('.subOpD').val(number_format(response.subtotalIva,2)); 
                 $('.descOpD').val(number_format(response.descuentoIva,2)); 
                 $('.totalOpD').val(number_format(response.totalIva,2)); 
                }
            });
       
    });
    
   $(document).on('focusout', '.qtyEmployeeQC', function () {
        var qtyEmployee   = $(this).val();
        var cantCourses   = 0;
        var iva           = $('input:radio[name=iva2]:checked').val();
        var id            = $(this).data('op');
        var type          = $('input:radio[name=typePrice1'+id+']:checked').val();
       
       console.log("palces "+places);
       console.log(cantCourses);
       console.log("iva "+iva);
        
        var qtyPlaces     = qtyEmployee;
        var id            = $(this).data('id');
        var op            = $(this).data('op');
        var places        = calTotalQuotationConv(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                if(iva == 1){
                 $('#precioQC_'+op+'_'+id).val(number_format(response.priceIva,2)); 
                 $('#precioUC_'+op+'_'+id).val(number_format(response.priceUnitIva,2)); 
             }else{
                 $('#precioQC_'+op+'_'+id).val(number_format(response.price,2));
                 $('#precioUC_'+op+'_'+id).val(number_format(response.priceUnit,2));   
             }
                 $('#precioQC_'+op+'_'+id).data('iva',response.priceIva); 
                 $('#precioQC_'+op+'_'+id).data('id',response.price); 

                 $('#precioUC_'+op+'_'+id).data('iva',response.priceUnitIva); 
                 $('#precioUC_'+op+'_'+id).data('id',response.priceUnit); 
                 
                 //subtota,total,desc
                 if(iva == 1){
                 $('#subQC_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQC_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQC_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQC_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQC_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQC_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQC_'+op).data('iva',response.subtotalIva); 
                 $('#subQC_'+op).data('id',response.subtotal);
                 
                 $('#descQC_'+op).data('iva',response.descuentoIva); 
                 $('#descQC_'+op).data('id',response.descuento);
                 
                 $('#totalQC_'+op).data('iva',response.totalIva); 
                 $('#totalQC_'+op).data('id',response.total);
                 
                }
            });
       
    });
    
   $(document).on('focusout', '.qtyEmployee', function () {
        var qtyEmployee   = $(this).val();
        var slcCourse2    = $(this).data('id');
       
        $("#qtyPlaces").val(qtyEmployee *slcCourse2);
       
    });
    
   $(document).on('focusout', '#qtyEmployee', function () {
        var qtyEmployee   = $(this).val();
        var cantCourses   = 0;
        
          $('.defaultCheckO').each(function(){
              
             if($(this).is(":checked")){
               cantCourses++;
            }
             });
        

       console.log(cantCourses);
        $("#qtyPlaces").val(qtyEmployee * cantCourses);
        
          var qtyPlaces     = qtyEmployee * cantCourses;
        var id            = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                 $('#mont').val(number_format(response.priceIva,2)); 
                 $('#mont').data('id',response.price); 
                }
            });
       
    });
    
    $(document).on('focusout', '#checkLinkOd', function () {
        var qtyEmployee   = $("#qtyEmployee").val();
        var cantCourses   = 0;
        
          $('.defaultCheckO').each(function(){
              
             if($(this).is(":checked")){
               cantCourses++;
            }
             });

       console.log(qtyEmployee * cantCourses);
        $("#qtyPlaces").val(qtyEmployee * cantCourses);
        
        var qtyPlaces     = qtyEmployee * cantCourses;
        var id            = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                 $('#mont').val(number_format(response.priceIva,2)); 
                 $('#mont').data('id',response.price); 
                }
            });
        
    });
    
   $(document).on('focusout', '#checkLink', function () {
        var qtyEmployee   = $("#qtyEmployee2").val();
        var cantCourses   = 0;
        
          $('.defaultCheck1_1').each(function(){
              
             if($(this).is(":checked")){
               cantCourses++;
            }
             });

       console.log(qtyEmployee * cantCourses);
        $("#qtyPlaces2_10").val(qtyEmployee * cantCourses);
        
        var qtyPlaces     = qtyEmployee * cantCourses;
        var id            = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "qtyPlaces": qtyPlaces},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {
                console.log(response.priceIva);
                 $('#precio2_'+id).val(number_format(response.priceIva,2)); 
                 $('#precio2_'+id).data('id',response.price); 
                }
            });
        
    });
    
   $(document).on('click', '.btn-generate-breakdown', function () {
        var flag         = "true";
        var pkQuotation  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkQuotation": pkQuotation},
                url: '/generateBreakdown',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                    $.LoadingOverlay("hide");
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    }); 
    
   $(document).on('click', '.btn-generatedb', function () {
       
    var pkQuotation     = $(this).data('id');
    var arrayOptions    = [];
    var numOptions      = 0;
    var flag            = "true";

   $(".coursesQuotation").each(function (index) {
           
          var id          = $(this).find('.fkCourse').data('id');
          var places      = $(this).find('.places').val();
     
     if(typeof id != "undefined"){
          arrayOptions[numOptions] = new Array(id
                                              ,places);
             
               var numRegex    = /^[a-zA-Z0-9-]+$/g; 
               
              if (places == "") {
            flag = "false";
            $(this).find('.places').css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        } 
        
                                       
                 numOptions++;
                          }        
    });
    

       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('arrayOptions'   ,JSON.stringify(arrayOptions));
            sendData.append('pkQuotation'    ,pkQuotation);

            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/generateBreakdownDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Cotización desglosada!',
                                'cotización desglosada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al desglosar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    
  
});
   
   $(document).on('click', '.btn-send-mail', function () {
        var flag         = "true";
        var pkQuotation  = $(this).data('id'); 
        var type         = $(this).data('open');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkQuotation": pkQuotation
                      ,"type":type},
                url: '/sendMailQuotation',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                    $.LoadingOverlay("hide");
                    if(response.valid == "true"){
                       
                        $('#modalEditCat').empty();
                        $('#modalEditCat').html(response.view);
                        $('.modalEditCategoria').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
   $(document).on('click', '.btn-send-mail-quotation', function () {
       
    var pkQuotation     = $(this).data('id');
    var type            = $(this).data('open');
    var dest            = $('#dest').val();
    var copia           = $('#copia').val();
    var copiaO          = $('#copiaO').val();
    var subject         = $('#subject').val();
    var message         = $('#message').val();
    var slcCourseQuo    = [];
    var con      = 0;
    var flag            = "true";

        $('.defaultCheck1').each(function(){
              if($(this).is(":checked")){
             slcCourseQuo[con] = $(this).val();
             con++;
            }
         });
    

       if (flag == "true") {
           
            var sendData = new FormData();
            sendData.append('arrayOptions'   ,JSON.stringify(slcCourseQuo));
            sendData.append('pkQuotation'    ,pkQuotation);
            sendData.append('destinity'      ,dest);
            sendData.append('copia'          ,copia);
            sendData.append('copiaO'         ,copiaO);
            sendData.append('subject'        ,subject);
            sendData.append('message'        ,message);
            sendData.append('type'           ,type);

            $.ajax({
                 type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/sendMailQuotationDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                          Swal.fire(
                                'Formato de Cotización enviado!',
                                'Formato enviado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al enviar formato'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    
  
}); 

   $(document).on('click', '.btn-remove-breakdown', function () {
        var pkQuotation       = $(this).attr("data-id");
        
        Swal.fire({
            title: 'Est\u00E1s seguro remover el desglose',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, remover!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkQuotation": pkQuotation},
                    url: '/removeBreakdown',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Desglose removido!',
                                'Desglosr removido con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al remover desglose'
                            });
                        }
                    }
                });
            }
        });
    });
   
   $(document).on('click', '.btn_addDocument', function () {
        var flag        = "true";
        var name        = $("#nameDocument").val();
        var file        = $("#file").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (name == "") {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            
             var sendData = new FormData();
              sendData.append('name',     name);
              sendData.append('file',     $('#file')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/viewCreateDocumentDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al subir documento'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
   
   $(document).on('click', '.btn_deleteDocument', function () {
        var pkDocument        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el documento?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'S\u00ED, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkDocument": pkDocument},
                    url: '/deleteDocument',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Documento eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar documento'
                            });
                        }
                    }
                });
            }
        });
    });
    
   $(document).on('click', '.btn_updateDocument', function () {
        var flag               = "true";
        var pkDocument  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkDocument": pkDocument},
                url: '/updateDocument',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalPago').empty();
                        $('#modalPago').html(response.view);
                        $('.modalEditPago').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
$(document).on('click', '.btn_editDocument', function () {
        var flag        = "true";
        var id          = $(this).data('id');
        var name        = $("#nameDocumentUpdate").val();
        var file        = $("#file").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (name == "") {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (flag == "true") {
            
             var sendData = new FormData();
              sendData.append('name',   name);
              sendData.append('id',     id);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/updateDocumentDB',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al subir documento'
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    }); 
    
$(document).on('click', '.optionsPlaces', function () {
    //Si el checkbox está seleccionado

        if ($(this).data('id') == 1) { 
            $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "date": 1},
                    url: '/reloadCuorses',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        $('#cousemore').empty();
                        $('#cousemore').html(response);
                        
                         $('#mas-vendidos').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }
                });
         } 
           if ($(this).data('id') == 2) { 
            $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "date": 2},
                    url: '/reloadCuorses',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        $('#cousemore').empty();
                        $('#cousemore').html(response);
                        
                         $('#mas-vendidos').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }
                });
         } 
           if ($(this).data('id') == 3) { 
            $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "date": 3},
                    url: '/reloadCuorses',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                   success: function (response) {
                        $.LoadingOverlay("hide");
                        $('#cousemore').empty();
                        $('#cousemore').html(response);
                        
                         $('#mas-vendidos').DataTable({
                            dom: 'Bfrtip',
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }
                });
         } 
   });

$(document).on('click', '.changeTotal', function () {
        var status   = $(this).data('id');

            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "status": status},
                url: '/getTotalOportunity',
                beforeSend: function () {
                },
                success: function (response) {
                 $('#totalOportunity').text("$ "+ number_format(response.oportunity,2)); 
                }
            });
       
    });
   
$(document).on('change', '#slcSearchLine', function () {
        var id       = $(this).val();
        var type     = $(this).find(':selected').data('id');
        var bussines = $(this).find(':selected').data('bu');

            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "id": id
                       ,"type": type
                       ,"bussines":bussines},
                url: '/searchTimeLine',
                beforeSend: function () {
                },
                success: function (response) {
                 $('.timeline').empty(); 
                 $('.timeline').html(response.view); 
                }
            });
       
    });
 
$(document).on('click', '#addMoreCourseOportunity', function () {

    $.ajax({
        type: "POST",
        dataType: "html",
        url: '/getCoursesOportunity',
        beforeSend: function () {
        },
        success: function (response) {
             var count = $("#countOportunity").val();
            $("#coursesOportunity").append(' <div class="row coursesOportunity" data-id="'+count+'"><div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>'
                    + '<div class="col-md-5">'
                    + ' <div class="form-group">'
                    + '  <label class="control-label">Cantidad de colaboradores / lugares'
                    + '   <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la cantidad de empleados que tiene la empresa:'
                    + '   <ul>'
                    + '   <li>- Cantidad total de su personal</li>'
                    + '  <li>- Cantidad de personal que requiere capacitar</li>'
                    + '  <li>- Del Personal a Capacitar, todos son internos o tambien son externos (contratistas) </li>'
                    + '  </ul>'
                    + '  * * Atención: No todas las empresas requieren Contratistas."><i class="ti-info-alt"></i>'
                    + ' </span>'
                    + ' </label>'
                    + ' <div class="input-group">'
                    + '   <div class="input-group-prepend">'
                    + '       <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + '  </div>'
                    + '  <input id="qtyEmployeeOp_'+count+'" type="number" data-id="'+count+'" class="form-control qtyEmployeeOp" placeholder="0">'
                    + '</div>'
                    + ' </div>'
                    + '</div>'
                    + '<div class="col-md-4">'
                    + '  <div class="form-group">'
                    + '     <label class="control-label">Cursos'
                    + '  <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la Cantidad de Riesgos que la empresa tiene o la cantidad de Cursos que necesita:'
                    + '   <ul>'
                    + '  <li>• ¿En su empresa tienen identificadas las actividades con riesgo de accidente laboral?</li> '
                    + '   <li>• ¿Su personal ocupacionalmente expuesto conoce las medidas de seguridad que debe seguir ante los riesgos que están presentes en sus actividades laborales?</li>'
                    + '  <li>Si contesta sí o no, preguntar….<br>• ¿Usted sabe a cuantos riesgos está expuesto su personal operativo / sus instaladores / sus técnicos / incluso su personal administrativo?</li>'
                    + '  </ul>'
                    + '  "><i class="ti-info-alt"></i>'
                    + ' </span>'
                    + ' </label>'
                    + '  <br>'
                    + '   <select id="slcCourseOp_'+count+'" class="form-control">'
                    + '      <option value="-1">Sin definir</option>'
                              +response+ '</select>'
                    + ' </div>'

                    + ' </div>'
                    + '  <div class="col-md-3">'
                    + '  <div class="form-group">'
                    + '  <label class="control-label">Precio total</label>'
                    + '<div class="input-group">'
                    + '  <div class="input-group-prepend">'
                    + '   <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + '  </div>'
                    + ' <input id="precioOp_'+count+'" data-id="0" type="text"  class="form-control price2" placeholder="$ 0.00">'
                    + ' </div>'
                    + '</div>'
                    + ' </div>'
                    + ' </div>'
                    );
                count++;
            $("#countOportunity").val(count);
        }
    });
});

$(document).on('click', '#addMoreCourseOportunityEdit', function () {

    $.ajax({
        type: "POST",
        dataType: "html",
        url: '/getCoursesOportunity',
        beforeSend: function () {
        },
        success: function (response) {
             var count = $("#countOportunityEdit").val();
            $("#coursesOportunityEdit").append(' <div class="row coursesOportunityEdit" data-id="'+count+'"><div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>'
                    + '<div class="col-md-5">'
                    + ' <div class="form-group">'
                    + '  <label class="control-label">Cantidad de colaboradores / lugares'
                    + '   <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la cantidad de empleados que tiene la empresa:'
                    + '   <ul>'
                    + '   <li>- Cantidad total de su personal</li>'
                    + '  <li>- Cantidad de personal que requiere capacitar</li>'
                    + '  <li>- Del Personal a Capacitar, todos son internos o tambien son externos (contratistas) </li>'
                    + '  </ul>'
                    + '  * * Atención: No todas las empresas requieren Contratistas."><i class="ti-info-alt"></i>'
                    + ' </span>'
                    + ' </label>'
                    + ' <div class="input-group">'
                    + '   <div class="input-group-prepend">'
                    + '       <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + '  </div>'
                    + '  <input id="qtyEmployeeOpEdit_'+count+'" type="number" data-id="'+count+'" class="form-control qtyEmployeeOpEdit" placeholder="0">'
                    + '</div>'
                    + ' </div>'
                    + '</div>'
                    + '<div class="col-md-4">'
                    + '  <div class="form-group">'
                    + '     <label class="control-label">Cursos'
                    + '  <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la Cantidad de Riesgos que la empresa tiene o la cantidad de Cursos que necesita:'
                    + '   <ul>'
                    + '  <li>• ¿En su empresa tienen identificadas las actividades con riesgo de accidente laboral?</li> '
                    + '   <li>• ¿Su personal ocupacionalmente expuesto conoce las medidas de seguridad que debe seguir ante los riesgos que están presentes en sus actividades laborales?</li>'
                    + '  <li>Si contesta sí o no, preguntar….<br>• ¿Usted sabe a cuantos riesgos está expuesto su personal operativo / sus instaladores / sus técnicos / incluso su personal administrativo?</li>'
                    + '  </ul>'
                    + '  "><i class="ti-info-alt"></i>'
                    + ' </span>'
                    + ' </label>'
                    + '  <br>'
                    + '   <select id="slcCourseOpEdit_'+count+'" class="form-control">'
                    + '      <option value="-1">Sin definir</option>'
                              +response+ '</select>'
                    + ' </div>'

                    + ' </div>'
                    + '  <div class="col-md-3">'
                    + '  <div class="form-group">'
                    + '  <label class="control-label">Precio total</label>'
                    + '<div class="input-group">'
                    + '  <div class="input-group-prepend">'
                    + '   <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + '  </div>'
                    + ' <input id="precioOpEdit_'+count+'" data-id="0" type="text"  class="form-control price2" placeholder="$ 0.00">'
                    + ' </div>'
                    + '</div>'
                    + ' </div>'
                    + ' </div>'
                    );
                count++;
            $("#countOportunityEdit").val(count);
        }
    });
});

$(document).on('click', '.addMoreCourseQuotation', function () {
    
     var id = $(this).data('id');
    $.ajax({
        type: "POST",
        dataType: "html",
        url: '/getCoursesOportunity',
        beforeSend: function () {
        },
        success: function (response) {
             
             var count2 = $("#count2").val() - 1;
            
             console.log(id);
             var count = $("#countQuotation_"+id).val();
             
            $("#coursesQuotation_"+id).append(' <div class="row coursesQuotation_'+id+' coursesQuotation_detail data-id="'+count+'"><div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>'
                    + '  <div class="col-md-2">'
                    + '     <div class="form-group">'
                    + '       <label class="control-label">Cantidad de colaboradores / lugares'
                    + '    </label>'
                    + '    <div class="input-group">'
                    + '       <div class="input-group-prepend">'
                    + '      <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + '   </div>'
                    + '  <input id="qtyEmployeeQ_'+id+'_'+count+'" type="number" data-op="'+id+'" data-id="'+count+'" class="form-control qtyEmployeeQ" placeholder="0">'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '  <div class="col-md-4" style="margin-top: 40px">'
                    + '    <div class="form-group">'
                    + '          <label class="control-label">Cursos'
                    + '         </label>'
                    + '        <select id="slcCourseQ_'+id+'_'+count+'" class="form-control slcCourseQ">'
                    + '          <option value="-1">Sin definir</option>'
                    +response
                    + ' </select>'
                    + ' </div>'
                    + '   </div>'
                    + ' <div class="col-md-3" style="margin-top: 40px">'
                    + '  <div class="form-group">'
                    + '  <label class="control-label">Precio Unitario</label>'
                    + '   <div class="input-group">'
                    + '      <div class="input-group-prepend">'
                    + '         <span class="input-group-text"'
                    + '            id="basic-addon11"><i'
                    + '               class="ti-money"></i></span>'
                    + '      </div>'
                    + '      <input id="precioU_'+id+'_'+count+'" data-id="0" data-iva-="0"'
                    + '         type="text" class="form-control precioU"'
                    + '         placeholder="$ 0.00">'
                    + '   </div>'
                    + '  </div>'
                    + ' </div>'
                    + '   <div class="col-md-3" style="margin-top: 40px">'
                    + '    <div class="form-group">'
                    + '     <label class="control-label">Precio total</label>'
                    + '  <div class="input-group">'
                    + '    <div class="input-group-prepend">'
                    + '      <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + ' </div>'
                    + '    <input id="precioQ_'+id+'_'+count+'" data-id="0" data-iva-="0" type="text"  class="form-control precioQ" placeholder="$ 0.00">'
                    + '  </div>'
                    + '   </div>'
                    + '  </div>'
                    + '   </div>'
                    + '  </div>'
                    );
            count++;
            $("#countQuotation_"+id).val(count);
        }
    });
});


$(document).on('click', '.addMoreCourseQuotationConvert', function () {
    
     var id = $(this).data('id');
    $.ajax({
        type: "POST",
        dataType: "html",
        url: '/getCoursesOportunity',
        beforeSend: function () {
        },
        success: function (response) {
             
             var count2 = $("#count").val() - 1;
            
             console.log(id);
             var count = $("#countQuotationC_"+id).val();
             
            $("#coursesQuotationC_"+id).append(' <div class="row coursesQuotationC_'+id+' coursesQuotationC_detail" data-id="'+count+'"><div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>'
                    + '  <div class="col-md-2">'
                    + '     <div class="form-group">'
                    + '       <label class="control-label">Cantidad de colaboradores / lugares'
                    + '    </label>'
                    + '    <div class="input-group">'
                    + '       <div class="input-group-prepend">'
                    + '      <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>'
                    + '   </div>'
                    + '  <input id="qtyEmployeeQC_'+id+'_'+count+'" type="number" data-op="'+id+'" data-id="'+count+'" class="form-control qtyEmployeeQC" placeholder="0">'
                    + '   </div>'
                    + '   </div>'
                    + '   </div>'
                    + '  <div class="col-md-4" style="margin-top: 40px">'
                    + '    <div class="form-group">'
                    + '          <label class="control-label">Cursos'
                    + '         </label>'
                    + '        <select id="slcCourseQC_'+id+'_'+count+'" class="form-control slcCourseQC">'
                    + '          <option value="-1">Sin definir</option>'
                    +response
                    + ' </select>'
                    + ' </div>'

                    + '   </div>'

                    + '  <div class="col-md-3" style="margin-top: 40px">'
                    + '   <div class="form-group">'
                    + '    <label class="control-label">Precio Unitario</label>'
                    + '    <div class="input-group">'
                    + '       <div class="input-group-prepend">'
                    + '          <span class="input-group-text"'
                    + '             id="basic-addon11"><i'
                    + '                class="ti-money"></i></span>'
                    + '       </div>'
                    + '       <input id="precioUC_'+id+'_'+count+'" data-id="0" data-iva-="0"'
                    + '          type="text" class="form-control precioUC"'
                    + '          placeholder="$ 0.00">'
                    + '     </div>'
                    + '    </div>'
                    + '  </div>'
                    + '   <div class="col-md-3" style="margin-top: 40px">'
                    + '    <div class="form-group">'
                    + '     <label class="control-label">Precio total</label>'
                    + '  <div class="input-group">'
                    + '    <div class="input-group-prepend">'
                    + '      <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>'
                    + ' </div>'
                    + '    <input id="precioQC_'+id+'_'+count+'" data-id="0" data-iva="0" type="text"  class="form-control precioQC" placeholder="$ 0.00">'
                    + '  </div>'
                    + '   </div>'
                    + '  </div>'
                    + '   </div>'
                    + '  </div>'
                    
                    
                    );
            count++;
            $("#countQuotationC_"+id).val(count);
        }
    });
});
 
$(document).on('click', '.btn_deleteNewCourseOportunity', function () {
       $(this).parent().parent().empty();
    });
    
    $(document).on('change', '#slcAgentPipeline', function () {
        var id     = $(this).val();
        location.href = '/AgentPipeline/'+id;
       
    });    

    $(document).on('change', '#slcTypeActivity', function () {
        var idState     = $(this).val();
        var id          = $(this).data('id');
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idState": idState
                       ,"id":id},
                url: '/filterActivity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#activityPending').empty();
                        $('#activityPending').html(response.view);
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al filtrar actividades'
                        });
                    }
                }
            });
       
    });
    
    $(document).on('click', '.btn_deleteBussinesOfCampaign', function () {
        var pkBusiness          = $(this).attr("data-id");
        var pkBusinessCampaign  = $(this).attr("data-campaign-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar esta empresa de la campa\u00F1a?',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBusiness": pkBusiness, "pkBusinessCampaign":pkBusinessCampaign},
                    url: '/deleteBusinessCampaign',
                    beforeSend: function () {
                      $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");  
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminada!',
                                'Empresa eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar empresa'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('change', '#slcAgentCallLost', function () {
        var idUser     = $(this).val();
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "idUser": idUser},
                url: '/searchPendingCalls',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                        $('#actividadesDiv').empty();
                        $('#actividadesDiv').html(response.view);
                        
                         $('#actividades').DataTable({
                            dom: 'Bfrtip',
                            buttons: ['copy'
                            ,'excel'
                            ,'csv'
                            ,'pdf'
                    ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });

  $(document).on('click', '#btn_activeComition', function () {

        
        $("#higher_or_equal_to").removeAttr('disabled');
        $("#less_or_equal_to").removeAttr('disabled');
        $("#comition_higher_less").removeAttr('disabled');
        
        $("#desactiveComition").css('display','block');
        $("#activeComition").css('display','none');

        $("#isActive").val("1");

    });

    $(document).on('click', '#btn_desactiveComition', function () {

        
        $("#higher_or_equal_to").attr('disabled','disabled');
        $("#less_or_equal_to").attr('disabled','disabled');
        $("#comition_higher_less").attr('disabled','disabled');
        
        $("#activeComition").css('display','block');
        $("#desactiveComition").css('display','none');

        $("#isActive").val("0");

    });
    
    $(document).on('click', '#addNewPenalitation', function () {
        
        var count = 1;
        $.ajax({
        type: "POST",
        dataType: "html",
        data: {"count":count },
        url: '/getAgent',
        beforeSend: function () {
        },
        success: function (response) {
        $("#agents").append('<div class="Addagents row"><div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>'
        +'<div class="col-md-6">'
        +' <div class="form-group">'
        +'    <div class="custom-control custom-checkbox">'
        +'    <label class="control-label">Agente*</label>'
        + response
        +'     </div>'
        +'   </div>'
        +' </div>'
        +'<div class="col-md-6">'
        +'   <div class="input-group">'
        +'           <label class="control-label">Porcentaje de Penalizaci&oacute;n *</label>'
        +'          <div class="input-group">'
        +'               <input type="text" class="form-control porcentPenalty">'
        +'              <div class="input-group-append">'
        +'                   <span class="input-group-text" id="basic-addon11">%</span>'
        +'              </div>'
        +'          </div>'
        +'      </div>'
        +'   </div>'
        +' </div>');   
         }
       });
    });

    $(document).on('click', '.dowloadExcel', function () {
        var type     = $(this).data('id');
        
        location.href = "/dowloadExcel/"+type;
       
    });

    $(document).on('keyup', '#seacrhBussines', function () {
        var text = $(this).val();
        var type = $(this).data('id');

          if(text.length > 2){

                   $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {"text": text
                              ,"type": type
                            },
                        url: '/searchnameBussines',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            if(response.valid == "true"){
                               
                                $('#activeEmpDiv').empty();
                                $('#activeEmpDiv').html(response.view);
                                
                                 $('#activeEmp').DataTable({
                                    dom: 'Bfrtip',
                                   "paging":   false,
                                   "info":     false,
                                   "searching": false,
                                    buttons: [
                  
                                    ]
                                   });    
                                $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        
                            }else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Error al editar curso'
                                });
                            }
                        }
                    });

          }
        console.log(text.length);
        console.log(type);
	}); 
    
    $(document).on('keyup', '#seacrhActivitys', function () {
        var text = $(this).val();
            console.log(text);
          if(text.length > 3){

                   $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {"text": text
                            },
                        url: '/seachArcivityText',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            if(response.valid == "true"){
                               
                                $('#actividadesDiv').empty();
                                $('#actividadesDiv').html(response.view);
                                
                                 $('#actividades').DataTable({
                                    dom: 'Bfrtip',
                                   "paging":   false,
                                   "info":     false,
                                   "searching": false,
                                    buttons: [
                                     'excel'
                                    ]
                                   });    
                                $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        
                            }else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Error al editar curso'
                                });
                            }
                        }
                    });

          }
   
	}); 
    
    $(document).on('click', '.searchInfoBussines', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1;  
        
        
              if(id== 1){
                day = 1;  
              }
               if(id== 2){
               month = 1;   
              }
               if(id== 3){
               year = 1;   
              }
              
       console.log(day);
       console.log(month);
       console.log(year);
       
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"day": day
                      ,"month": month
                      ,"year":  year
            },
                url: '/searchBussinesMoreSale',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('.table-bussinesMoreSale').empty();
                        $('.table-bussinesMoreSale').html(response.view);

                        $('#masCompras').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ]
                        });  

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });

    $(document).on('click', '#search_comercial_activiy_agent', function () {
        var flag           = "true";
        var typeActivity   = $('#typeActivity').val();
        var typeCampaning  = $('#typeCampaning').val();
        var dateInitial    = $('#dateInitial').val();      
        var dateFinish     = $('#dateFinish').val(); 
         
        if (flag == "true") {
              $.ajax({
                  type: "POST",
                  dataType: "json",
                  data: {"typeActivity" : typeActivity
                        ,"typeCampaning" : typeCampaning
                        ,"dateInitial" : dateInitial
                        ,"dateFinish" : dateFinish},
                  url: '/actividadSearch',
                  beforeSend: function () {
                  },
                  success: function (response) {
                      if(response.valid == "true"){
                      
                          $('#activityComercial').empty();
                          $('#activityComercial').html(response.view);
                         
                          
                      }else{
                          Swal.fire({
                              type: 'error',
                              title: 'Oops...',
                              text: 'Error al editar'
                          });
                      }
                  }
              });
          } else {
              event.preventDefault();
              Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Campos inv\u00E1lidos'
                  });
          }
      });
    
      $(document).on('click', '.btn_activeBussines', function () {
        var pkBusiness        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de activar esta empresa?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Activar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkBusiness": pkBusiness},
                    url: '/activeBusiness',
                    beforeSend: function () {
                      $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");  
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Activada!',
                                'Empresa activada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar empresa'
                            });
                        }
                    }
                });
            }
        });
    });
      
    $(document).on('click', '.btn_deletePromotion', function () {
        var pkPromotion  = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la promocion',
            text: "No podr\u00E1s revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: { "pkPromotion": pkPromotion},
                    url: '/deleteProMotion',
                    beforeSend: function () {
                        $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Promocion eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar promocion'
                            });
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '.updatePromotion', function () {
        var pkPromotion     = $(this).data('id');
       
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "pkPromotion": pkPromotion},
                url: '/viewUpdatePromotion',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                         $('#modalUsuario').empty();
                         $('#modalUsuario').html(response.view);
                         $('.modalEditUsuario').trigger('click');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar categor\u00EDa'
                        });
                    }
                }
            });
       
    });
    
    
    $(document).on('click', '.btn_editPromotion', function () {

        var pkPromotion  = $(this).data('id');
        var places       = $("#places").val();
        var discount     = $("#discount").val(); 
        var flag         = "true";

        if (places == "") {
            flag = "false";
            $("#places").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (discount == "") {
            flag = "false";
            $("#discount").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
            
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {"discount":discount,"places":places,"pkPromotion":pkPromotion},
                url: '/updatePromotion',
                beforeSend: function () {
                    $.LoadingOverlaySetup({
                     image: "/images/loading.gif",
                     imageAnimation: "1.5s fadein"  
                     });
                     
                     $.LoadingOverlay("show");
                },
                success: function (response) {
                    
                          $.LoadingOverlay("hide");
                    if(response == "true"){
                        Swal.fire(
                            'Proceso Exitoso!',
                            'Promocion modificada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: response
                        });
                    }
                }
            });
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });

    $(document).on('click', '.searchInfoQuotation', function () {
        
        var id         =  $(this).data('id');
        var day        = -1;   
        var month      = -1;  
        var year       = -1; 
        var status     = $('#status').val();
        var agent      = $('#agent').val();
        var fechStart  = $('#date_start').val();   
        var fechFinish = $('#date_finish').val();  
        
        
              if(id== 1){
                day = 1;  
              }
               if(id== 2){
               month = 1;   
              }
               if(id== 3){
               year = 1;   
              }
              
       console.log(day);
       console.log(month);
       console.log(year);
       
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"day": day
                      ,"month": month
                      ,"year":  year
                      ,"status"    : status
                      ,"agent"     : agent
                      ,"fechStart" : fechStart
                      ,"fechFinish": fechFinish
            },
                url: '/searchQuotations',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                    
                        $('#cotizacionesDiv').empty();
                        $('#cotizacionesDiv').html(response.view);
                        $('.totalQuotation').text('$ '+number_format(response.total,2));
                         $('#cotizaciones').DataTable({
                            dom: 'Bfrtip',
                             "order": [],
                           buttons: [
                              'excel'
                               ]
                           });    
                        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar curso'
                        });
                    }
                }
            });
 
    });

    $(document).on('click', '.editTotal', function () {
    
        var id = $(this).data('id');

        $('#editQ_'+id).val("1");
        $('#totalQ_'+id).prop('disabled', false);
        $('#CanceleditTotal_'+id).css('display', 'block');
        $('#editTotal_'+id).css('display', 'none');
       
    });

    $(document).on('click', '.CanceleditTotal', function () {
    
        var id = $(this).data('id');
        

        $('#editQ_'+id).val("0");
        $('#totalQ_'+id).prop('disabled', true);
        $('#CanceleditTotal_'+id).css('display', 'none');
        $('#editTotal_'+id).css('display', 'block');

        var iva           = $('input:radio[name=iva]:checked').val();
        var op            = $(this).data('id');
        var qtyPlaces     = 1;
        var type          = $('input:radio[name=typePrice2'+op+']:checked').val();
        var total         = $(this).val();

        var places        = calTotalQuotation(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                context: this,
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {

                    $('#coursesQuotation_'+op).each(function(){ 
                        console.log("op "+op);
                        var id = 1;
                        $(this).find('.coursesQuotation_detail').each(function(){ 
                            
                            console.log("id "+id);
                            if(typeof $(this).find('.qtyEmployeeQ').val() != "undefined"){
                             var cant = $(this).find('.qtyEmployeeQ').val();

                             var total    = response.priceUnit * cant;
                             var totalIva = response.priceUnitIva * cant;

                             console.log("total "+total);
                             console.log("totalIva "+totalIva);

                             if(iva == 1){
                              $('#precioQ_'+op+'_'+id).val(number_format(totalIva,2)); 
                              $('#precioU_'+op+'_'+id).val(number_format(response.priceUnitIva,2)); 
                          }else{
                              $('#precioQ_'+op+'_'+id).val(number_format(total,2)); 
                              $('#precioU_'+op+'_'+id).val(number_format(response.priceUnit,2));  
                          }
                              $('#precioQ_'+op+'_'+id).data('iva',totalIva); 
                              $('#precioQ_'+op+'_'+id).data('id',total); 
             
                              $('#precioU_'+op+'_'+id).data('iva',response.priceUnitIva); 
                              $('#precioU_'+op+'_'+id).data('id',response.priceUnit); 
                           }
                           id++;
                        });
                     });
                
                //subtota,total,desc
                 if(iva == 1){
                 $('#subQ_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQ_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQ_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQ_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQ_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQ_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQ_'+op).data('iva',response.subtotalIva); 
                 $('#subQ_'+op).data('id',response.subtotal);
                 
                 $('#descQ_'+op).data('iva',response.descuentoIva); 
                 $('#descQ_'+op).data('id',response.descuento);
                 
                 $('#totalQ_'+op).data('iva',response.totalIva); 
                 $('#totalQ_'+op).data('id',response.total);
                 
                }
            });
       
    });

    $(document).on('focusout', '.totalQ', function () {
    
        var iva           = $('input:radio[name=iva]:checked').val();
        var op            = $(this).data('row');
        var qtyPlaces     = 1;
        var type          = $('input:radio[name=typePrice2'+op+']:checked').val();
        var total         = $(this).val();

        var places        = calTotalQuotation(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                context: this,
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type,"total":total},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {

                    $('#coursesQuotation_'+op).each(function(){ 
                        console.log("op "+op);
                        var id = 1;
                        $(this).find('.coursesQuotation_detail').each(function(){ 
                            
                            console.log("id "+id);
                            if(typeof $(this).find('.qtyEmployeeQ').val() != "undefined"){
                             var cant = $(this).find('.qtyEmployeeQ').val();

                             var total    = response.priceUnit * cant;
                             var totalIva = response.priceUnitIva * cant;

                             console.log("total "+total);
                             console.log("totalIva "+totalIva);

                             if(iva == 1){
                              $('#precioQ_'+op+'_'+id).val(number_format(totalIva,2)); 
                              $('#precioU_'+op+'_'+id).val(number_format(response.priceUnitIva,2)); 
                          }else{
                              $('#precioQ_'+op+'_'+id).val(number_format(total,2)); 
                              $('#precioU_'+op+'_'+id).val(number_format(response.priceUnit,2));  
                          }
                              $('#precioQ_'+op+'_'+id).data('iva',totalIva); 
                              $('#precioQ_'+op+'_'+id).data('id',total); 
             
                              $('#precioU_'+op+'_'+id).data('iva',response.priceUnitIva); 
                              $('#precioU_'+op+'_'+id).data('id',response.priceUnit); 
                           }
                           id++;
                        });
                     });
                
                //subtota,total,desc
                 if(iva == 1){
                 $('#subQ_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQ_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQ_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQ_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQ_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQ_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQ_'+op).data('iva',response.subtotalIva); 
                 $('#subQ_'+op).data('id',response.subtotal);
                 
                 $('#descQ_'+op).data('iva',response.descuentoIva); 
                 $('#descQ_'+op).data('id',response.descuento);
                 
                 $('#totalQ_'+op).data('iva',response.totalIva); 
                 $('#totalQ_'+op).data('id',response.total);
                 
                }
            });
       
    });

    //CONVERTIR A COTIZACION
    $(document).on('click', '.editTotalC', function () {
    
        var id = $(this).data('id');

        $('#editQC_'+id).val("1");
        $('#totalQC_'+id).prop('disabled', false);
        $('#CanceleditTotalC_'+id).css('display', 'block');
        $('#editTotalC_'+id).css('display', 'none');
       
    });

    $(document).on('click', '.CanceleditTotalC', function () {
    
        var id = $(this).data('id');
        

        $('#editQC_'+id).val("0");
        $('#totalQC_'+id).prop('disabled', true);
        $('#CanceleditTotalC_'+id).css('display', 'none');
        $('#editTotalC_'+id).css('display', 'block');

        var iva           = $('input:radio[name=iva2]:checked').val();
        var op            = $(this).data('id');
        var qtyPlaces     = 1;
        var type          = $('input:radio[name=typePrice1'+op+']:checked').val();
        var total         = $(this).val();

        var places        = calTotalQuotationConv(op);
        
            $.ajax({
                type: "POST",
                dataType: "json",
                context: this,
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {

                    $('.contentNewOpcion').each(function(){ 
                        console.log("op "+op);
                        var id = 1;
                        $(this).find('.coursesQuotationC_'+id).each(function(){ 
                            
                            console.log("id "+id);
                            if(typeof $(this).find('.qtyEmployeeQC').val() != "undefined"){
                             var cant = $(this).find('.qtyEmployeeQC').val();

                             var total    = response.priceUnit * cant;
                             var totalIva = response.priceUnitIva * cant;

                             console.log("total "+total);
                             console.log("totalIva "+totalIva);

                             if(iva == 1){
                              $('#precioQC_'+op+'_'+id).val(number_format(totalIva,2)); 
                              $('#precioUC_'+op+'_'+id).val(number_format(response.priceUnitIva,2)); 
                          }else{
                              $('#precioQC_'+op+'_'+id).val(number_format(total,2)); 
                              $('#precioUC_'+op+'_'+id).val(number_format(response.priceUnit,2));  
                          }
                              $('#precioQC_'+op+'_'+id).data('iva',totalIva); 
                              $('#precioQC_'+op+'_'+id).data('id',total); 
             
                              $('#precioUC_'+op+'_'+id).data('iva',response.priceUnitIva); 
                              $('#precioUC_'+op+'_'+id).data('id',response.priceUnit); 
                           }
                           id++;
                        });
                     });
                
                //subtota,total,desc
                 if(iva == 1){
                 $('#subQC_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQC_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQC_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQC_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQC_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQC_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQC_'+op).data('iva',response.subtotalIva); 
                 $('#subQC_'+op).data('id',response.subtotal);
                 
                 $('#descQC_'+op).data('iva',response.descuentoIva); 
                 $('#descQC_'+op).data('id',response.descuento);
                 
                 $('#totalQC_'+op).data('iva',response.totalIva); 
                 $('#totalQC_'+op).data('id',response.total);
                 
                }
            });
       
    });

    $(document).on('focusout', '.totalQC', function () {
    
        var iva           = $('input:radio[name=iva2]:checked').val();
        var op            = $(this).data('row');
        var qtyPlaces     = 1;
        var type          = $('input:radio[name=typePrice1'+op+']:checked').val();
        var total         = $(this).val();

        var places        = calTotalQuotationConv(op);
        console.log("places"+places);
        console.log("type"+type);
        console.log("places"+total);
            $.ajax({
                type: "POST",
                dataType: "json",
                context: this,
                data: { "qtyPlaces": qtyPlaces, "places":places,"type":type,"total":total},
                url: '/getPriceQuotation',
                beforeSend: function () {
                },
                success: function (response) {

                    $('.contentNewOpcion').each(function(){ 
                        console.log("op "+op);
                        var id = 1;
                        $(this).find('.coursesQuotationC_'+id).each(function(){
                            
                            console.log("id "+id);
                            if(typeof $(this).find('.qtyEmployeeQC').val() != "undefined"){
                             var cant = $(this).find('.qtyEmployeeQC').val();

                             var total    = response.priceUnit * cant;
                             var totalIva = response.priceUnitIva * cant;

                             console.log("total "+total);
                             console.log("totalIva "+totalIva);

                             if(iva == 1){
                              $('#precioQC_'+op+'_'+id).val(number_format(totalIva,2)); 
                              $('#precioUC_'+op+'_'+id).val(number_format(response.priceUnitIva,2)); 
                          }else{
                              $('#precioQC_'+op+'_'+id).val(number_format(total,2)); 
                              $('#precioUC_'+op+'_'+id).val(number_format(response.priceUnit,2));  
                          }
                              $('#precioQC_'+op+'_'+id).data('iva',totalIva); 
                              $('#precioQC_'+op+'_'+id).data('id',total); 
             
                              $('#precioUC_'+op+'_'+id).data('iva',response.priceUnitIva); 
                              $('#precioUC_'+op+'_'+id).data('id',response.priceUnit); 
                           }
                           id++;
                        });
                     });
                
                //subtota,total,desc
                 if(iva == 1){
                 $('#subQC_'+op).val(number_format(response.subtotalIva,2)); 
                 $('#descQC_'+op).val(number_format(response.descuentoIva,2)); 
                 $('#totalQC_'+op).val(number_format(response.totalIva,2)); 
             }else{
                 $('#subQC_'+op).val(number_format(response.subtotal,2)); 
                 $('#descQC_'+op).val(number_format(response.descuento,2)); 
                 $('#totalQC_'+op).val(number_format(response.total,2));  
             }
           
                 $('#subQC_'+op).data('iva',response.subtotalIva); 
                 $('#subQC_'+op).data('id',response.subtotal);
                 
                 $('#descQC_'+op).data('iva',response.descuentoIva); 
                 $('#descQC_'+op).data('id',response.descuento);
                 
                 $('#totalQC_'+op).data('iva',response.totalIva); 
                 $('#totalQC_'+op).data('id',response.total);
                 
                }
            });
       
    });
    
    