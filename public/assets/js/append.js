$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).ready(function () {
    
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

    
    $("#username").focusout(function () {
        var username = $(this).val();
        var emailRegex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

     /*   if (!emailRegex.test(username)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            });
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }*/
    });

    $("#password").focusout(function () {
        var pass = $(this).val();
        var passRegex = /^[@.a-zA-Z0-9*]+$/g;

        if (!passRegex.test(pass)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    
    $("#login-form").submit(function (event) {
        var flag            = "true";
        var username        = $('#username').val();
        var pass            = $('#password').val();

        var emailRegex      = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        var passRegex       = /^[@.a-zA-Z0-9*]+$/g;

        event.preventDefault();

        if (!emailRegex.test(username)) {
            flag = "false";
            $("#username").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

        if (!passRegex.test(pass)) {
            flag = "false";
            $("#pass").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }

        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "username": username, "pass": pass },
                url: '/login',
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
                        if(response.page == 1){
                        location.href = "/dashboard";
                     }else{
                         if(response.page == 2){
                           location.href = "/verCotizaciones";    
                         }else{
                             if(response.page == 3){
                                location.href = "/viewSendMail/";
                             }else{
                          location.href = "/viewProfileAgent/"+response.idUser;    
                             } 
                         }
                        
                     }
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Usuario o contrase\u00F1a inv\u00E1lida'
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
    
    $(document).on('click', '.btn_addcategory', function () {
        var flag        = "true";
        var name        = $("#nameAddCategory").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addCategory',
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
                            text: 'Error al agregar categor\u00EDa'
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
    
    $(document).on('click', '.btn_updateCategory', function () {
        var flag        = "true";
        var idCategory  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idCategory": idCategory},
                url: '/viewupdateCategory',
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
                            text: 'Error al agregar forma de pago'
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
    
    $(document).on('click', '.btn_editcategory', function () {
        var flag        = "true";
        var name        = $("#nameEditCategory").val();
        var idCategory  = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#nameEditCategory").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        console.log(name);
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {"name": name
                      ,"idCategory":idCategory},
                url: '/updateCategory',
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
                                'Categoría modificada con \u00E9xito.',
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
        } else {
            event.preventDefault();
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Campos inv\u00E1lidos'
                });
        }
    });
    
    $(document).on('click', '.btn_deleteCategory', function () {
        var pkCategory        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la categor\u00EDa?',
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
                    url: '/deleteCategory',
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
    
    $(document).on('click', '.btn_addUserType', function () {
        var flag        = "true";
        var name        = $("#nameAddUserType").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addUserType',
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
                            text: 'Error al agregar tipo de usuario'
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
    
    $(document).on('click', '.btn_updateUserType', function () {
        var flag        = "true";
        var idUser  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"idUser": idUser},
                url: '/viewupdateUserType',
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
    
    $(document).on('click', '.btn_editUserType', function () {
        var flag        = "true";
        var name        = $("#nameEditUserType").val();
        var idType      = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#nameEditUserType").css({
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
                       ,"idType": idType},
                url: '/updateUserType',
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
                                'Tipo de usuario modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar tipo de usuario'
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
    
    $(document).on('click', '.btn_deleteUserType', function () {
        var pkUserType = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el tipo de usuario?',
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
                    data: { "pkUserType": pkUserType},
                    url: '/deleteUserType',
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
                                'Tipo de usuario eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar tipo de usuario'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addCommercialBusiness', function () {
        var flag        = "true";
        var name        = $("#nameAddCommercialBusiness").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addCommercialBusiness',
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
                            text: 'Error al agregar giro comercial'
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
    
    $(document).on('click', '.btn_updateCommercialBusiness', function () {
        var flag        = "true";
        var pkCommercial_business  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkCommercial_business": pkCommercial_business},
                url: '/viewupdateCommercialBusiness',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalGiros').empty();
                        $('#modalGiros').html(response.view);
                        $('.modalEditGiros').trigger('click');
                        
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
    
    $(document).on('click', '.btn_editCommercialBusiness', function () {
        var flag        = "true";
        var name        = $("#nameEditCommercialBusiness").val();
        var pkCommercialBusiness = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (name == "") {
            flag = "false";
            $("#nameEditCommercialBusiness").css({
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
                       ,"pkCommercialBusiness": pkCommercialBusiness},
                url: '/updateCommercialBusiness',
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
                                'Giro comercial modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al modificar giro comercial'
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
    
    $(document).on('click', '.btn_deleteCommercialBusiness', function () {
        var pkCommercialBusiness = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el giro comercial?',
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
                    data: { "pkCommercialBusiness": pkCommercialBusiness},
                    url: '/deleteCommercialBusiness',
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
                                'Giro Comercial eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar giro comercial'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addActivityType', function () {
        var flag        = "true";
        var name        = $("#textAddActivityType").val();
        var color       = $("#colorAddActivityType").val();
        var icon        = $(".type_activity_ico.active").children('i').attr("class");
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if(icon == undefined){
            icon = "";
        }
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: { "name": name, "color": color, "icon": icon},
                url: '/addActivityType',
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
                            text: 'Error al agregar tipo de actividad'
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
    
    $(document).on('click', '.btn_updateActivityType', function () {
        var flag        = "true";
        var pkActivities_type  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkActivities_type": pkActivities_type},
                url: '/viewupdateActivityType',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalActividad').empty();
                        $('#modalActividad').html(response.view);
                        $('.modalEditActividad').trigger('click');
                        
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
    
    $(document).on('click', '.btn_editActivityType', function () {
        var flag        = "true";
        var text        = $("#textEditActivityType").val();
        var color       = $("#colorEditActivityType").val();
        var icon        = $(".type_activity_ico.active").children('i').attr("class");
        var idType      = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(text)) {
            flag = "false";
            $("#textEditActivityType").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if(icon == undefined){
            icon = "";
        }
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: { "text": text, "color": color, "idType": idType, "icon": icon},
                url: '/updateActivityType',
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
                                'Tipo de actividad modificada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar tipo de actividad'
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
    
    $(document).on('click', '.btn_deleteActivityType', function () {
        var pkActivitiesType = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el tipo de actividad?',
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
                    data: { "pkActivitiesType": pkActivitiesType},
                    url: '/deleteActivityType',
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
                                'tipo de actividad eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar tipo de actividad'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addActivitySubtype', function () {
        var flag            = "true";
        var fkActivityType  = $("#activityType").val();
        var name            = $("#textAddActivitySubtype").val();
        var color           = $("#colorAddActivitySubtype").val();
        var type            = $("#slctypeCall").val();
        
        if (typeof type == "undefined") {
           type = 0;
         }
        console.log(type);
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
         if (type < 0) {
            flag = "false";
            $("#slctypeCall").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if(fkActivityType > -1){
            if (flag == "true") {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: {"fkActivityType": fkActivityType,  "name": name, "color": color,"slctypeCall":type},
                    url: '/addActivitySubtype',
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
                                text: 'Error al agregar subtipo de actividad'
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
        }else{
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Favor de seleccionar una actividad'
            });
        }
        
        
    });
    
    $(document).on('click', '.btn_updateActivityType', function () {
        var flag        = "true";
        var pkActivities_type  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkActivities_type": pkActivities_type},
                url: '/viewupdateActivityType',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalActividad').empty();
                        $('#modalActividad').html(response.view);
                        $('.modalEditActividad').trigger('click');
                        
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
    
    $(document).on('click', '.btn_updateActivitySubtypeActSubtype', function () {
        var flag        = "true";
        var pkActivities_subtype  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkActivities_subtype": pkActivities_subtype},
                url: '/viewupdateaddActivitySubtype',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalActivitySubtype').empty();
                        $('#modalActivitySubtype').html(response.view);
                        $('.modalEditActivitySubtype').trigger('click');
                        
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
    
    $(document).on('click', '.btn_editActivitySubtype', function () {
        var flag            = "true";
        var fkActivityType  = $("#activityTypeEdit").val();
        var text            = $("#textEditActivitySubtype").val();
        var color           = $("#colorEditActivitySubtype").val();
        var idSubType       = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(text)) {
            flag = "false";
            $("#textEditActivitySubtype").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if(fkActivityType > -1){
            if (flag == "true") {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: {"fkActivityType": fkActivityType,  "text": text, "color": color, "idSubType": idSubType},
                    url: '/updateActivitySubtype',
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
                                'Subtipo de actividad modificada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al agregar subtipo de actividad'
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
        }else{
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Favor de seleccionar una actividad'
            });
        }
        
        
    });
    
    $(document).on('click', '.btn_deleteActivitySubtype', function () {
        var pkActivitiesSubtype = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el subtipo de actividad?',
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
                    data: { "pkActivitiesSubtype": pkActivitiesSubtype},
                    url: '/deleteActivitySubtype',
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
                                'Subtipo de actividad eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar subtipo de actividad'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addBusinessStatus', function () {
        var flag        = "true";
        var name        = $("#nameAddBusinessStatus").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addBusinessStatus',
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
                            text: 'Error al agregar estatus de la empresa'
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
    
    $(document).on('click', '.btn_updateBusinessStatus', function () {
        var flag        = "true";
        var pkBusiness_status  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkBusiness_status": pkBusiness_status},
                url: '/viewupdateBusinessStatus',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalEstatus').empty();
                        $('#modalEstatus').html(response.view);
                        $('.modalEditEstatus').trigger('click');
                        
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
    
    $(document).on('click', '.btn_editBusinessStatus', function () {
        var flag        = "true";
        var name        = $("#nameEditBusinessStatus").val();
        var idEstate    = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name, "idEstate":idEstate},
                url: '/updateBusinessStatus',
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
                                'Modificada!',
                                'Estatus de la empresa modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar estatus de la empresa'
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
     
    $(document).on('click', '.btn_deleteBusinessStatus', function () {
        var pkBusinessStatus = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar el estatus de la empresa',
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
                    data: { "pkBusinessStatus": pkBusinessStatus},
                    url: '/deleteBusinessStatus',
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
                                'Estatus de la empresa eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar estatus de la empresa'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addLevelInterest', function () {
        var flag        = "true";
        var name        = $("#textAddLevelInterest").val();
        var color       = $("#colorAddLevelInterest").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name, "color": color},
                url: '/addLevelInterest',
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
                            text: 'Error al agregar nivel de inter\u00E9s'
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
    
    $(document).on('click', '.btn_updateLevelInterest', function () {
        var flag        = "true";
        var pkLevel_interest  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkLevel_interest": pkLevel_interest},
                url: '/viewupdateLevelInterest',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalNivel').empty();
                        $('#modalNivel').html(response.view);
                        $('.modalEditNivel').trigger('click');
                        
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
    
    $(document).on('click', '.btn_editLevelInterest', function () {
        var flag        = "true";
        var text        = $("#textEditLevelInterest").val();
        var color       = $("#colorEditLevelInterest").val();
        var idLevel     = $(this).data('id');
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(text)) {
            flag = "false";
            $("#textEditLevelInterest").css({
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
                data: { "text": text, "color": color, "idLevel":idLevel},
                url: '/updateLevelInterest',
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
                                'Nivel de inter\u00E9s modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar nivel de inter\u00E9s'
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
    
    $(document).on('click', '.btn_deleteLevelInterest', function () {
        var pkLevelInterest = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este nivel de inter\u00E9s?',
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
                    data: { "pkLevelInterest": pkLevelInterest},
                    url: '/deleteLevelInterest',
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
                                'Nivel de inter\u00E9s eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar nivel de inter\u00E9s'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addPaymentMethod', function () {
        var flag        = "true";
        var name        = $("#nameAddPaymentMethod").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addPaymentMethods',
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
                            text: 'Error al agregar forma de pago'
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
    
    $(document).on('click', '.btn_updatePaymentMethod', function () {
        var flag               = "true";
        var pkPayment_methods  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkPayment_methods": pkPayment_methods},
                url: '/viewupdatePaymentMethods',
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
    
    $(document).on('click', '.btn_editPaymentMethod', function () {
        var flag        = "true";
        var name        = $("#nameEditPaymentMethod").val();
        var idMethod    = $(this).data('id');
                
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#nameEditPaymentMethod").css({
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
                data: { "name": name, "idMethod":idMethod},
                url: '/updatePaymentMethods',
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
                                'Modificada!',
                                'Forma de pago modificada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar forma de pago'
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
    
    $(document).on('click', '.btn_deletePaymentMethod', function () {
        var pkPaymentMethod = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar forma de pago?',
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
                    data: { "pkPaymentMethod": pkPaymentMethod},
                    url: '/deletePaymentMethods',
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
                                'Forma de pago eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar forma de pago'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addBusinessType', function () {
        var flag        = "true";
        var name        = $("#nameAddBusinessType").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addBusinessType',
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
                            text: 'Error al agregar tipo de empresa'
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
    
    $(document).on('click', '.btn_updateBusinessType', function () {
        var flag               = "true";
        var pkPayment_methods  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkPayment_methods": pkPayment_methods},
                url: '/viewupdateBusinessType',
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
    
    $(document).on('click', '.btn_editBusinessType', function () {
        var flag        = "true";
        var name        = $("#nameEditBusinessType").val();
        var idMethod    = $(this).data('id');
                
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#nameEditBusinessType").css({
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
                data: { "name": name, "idMethod":idMethod},
                url: '/updateBusinessType',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response == "true"){
                       Swal.fire(
                                'Modificado!',
                                'Origen de empresa modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al actualizar tipo de empresa'
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
    
    $(document).on('click', '.btn_deleteBusinessType', function () {
        var pkBusinessType = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este tipo de origen?',
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
                    data: { "pkBusinessType": pkBusinessType},
                    url: '/deleteBusinessType',
                    beforeSend: function () {
                    },
                    success: function (response) {
                        if(response == "true"){
                            Swal.fire(
                                'Eliminado!',
                                'Origen de empresa eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar tipo de empresa'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_addCampaignsType', function () {
        var flag        = "true";
        var name        = $("#nameAddCampaignsType").val();
        
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
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
                data: { "name": name},
                url: '/addCampaignsType',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response == "true"){
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al agregar tipo de campa\u00F1a'
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
    
    $(document).on('click', '.btn_updateCampaignsType', function () {
        var flag               = "true";
        var pkCampaignsType  = $(this).data('id');        
        
        if (flag == "true") {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkCampaignsType": pkCampaignsType},
                url: '/viewupdateCampaignsType',
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
    
    $(document).on('click', '.btn_editCampaignsType', function () {
        var flag        = "true";
        var name        = $("#nameEditCampaignsType").val();
        var idMethod    = $(this).data('id');
                
        var nameRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#nameEditCampaignsType").css({
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
                data: { "name": name, "idMethod":idMethod},
                url: '/updateCampaignsType',
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
                                'Tipo de empresa modificado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al actualizar tipo de empresa'
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
    
    $(document).on('click', '.btn_deleteCampaignsType', function () {
        var pkCampaignsType = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar este tipo de campa\u00F1a?',
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
                    data: { "pkCampaignsType": pkCampaignsType},
                    url: '/deleteCampaignsType',
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
                                'Tipo de campa\u00F1a eliminado con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar tipo de campa\u00F1a'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $("#name").focusout(function () {
        var text = $(this).val();
        var textRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;

        if (!textRegex.test(text)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#code").focusout(function () {
        var text = $(this).val();
        var textRegex   = /^[a-zA-Z0-9-]+$/g;

        if (!textRegex.test(text)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#agentMain").focusout(function () {
        var value = $(this).val();

        if (value < 0) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#startDate").focusout(function () {
        var value = $(this).val();

        if (value == "") {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#endDate").focusout(function () {
        var value = $(this).val();

        if (value == "") {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#type").focusout(function () {
        var value = $(this).val();

        if (value < 0) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#description").focusout(function () {
        var text = $(this).val();
        var textRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;

        if (text == "") {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    

    
    $("#fileBusiness").focusout(function () {
        var value = $(this).val();

        if (value == "") {
            $(".custom-file").css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(".custom-file").css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
   
    $("#createCampaign").submit(function (event) {
        var flag            = "true";
        var name            = $('#name').val();
        var code            = $('#code').val();
        var agentMain       = $('#agentMain').val();
        var startDate       = $('#startDate').val();
        var endDate         = $('#endDate').val();
        var type            = $('#type').val();
        var description     = $('#description').val();
        var agentSecondary  = $('#agentSecondary').val();
        var fileBusiness    = $('#fileBusiness').val();
        event.preventDefault();
    

        var nameRegex           = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var descriptionRegex    = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
        var codeRegex           = /^[a-zA-Z0-9-]+$/g;

        
        
        if (!nameRegex.test(name)) {
            flag = "false";
            $("#name").css({
                "-moz-box-shadow": "0 0 5px #f40404",
                "-webkit-box-shadow": "0 0 5px #f40404",
                "box-shadow": "0 0 5px #f40404"
            }
            );
        }
        
        if (!codeRegex.test(code)) {
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
            sendData.append('name', name);
            sendData.append('code', code);
            sendData.append('agentMain', agentMain);
            sendData.append('startDate', startDate);
            sendData.append('endDate', endDate);
            sendData.append('type', type);
            sendData.append('description', description);
            sendData.append('agentSecondary', agentSecondary);
            sendData.append('fileBusiness', $('#fileBusiness')[0].files[0]);
            
            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/commercialCampaignsCreateDB',
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
    
    $(document).on('click', '.deleteCampaning', function () {
        var pkCampaning        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la campaña?',
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
                    data: { "pkCampaning": pkCampaning},
                    url: '/deleteCampaning',
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
                                'Campaña eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar actividad'
                            });
                        }
                    }
                });
            }
        });
    });
    
    $("#title").focusout(function () {
        var text = $(this).val();
        var textRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;

        if (!textRegex.test(text)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#message").focusout(function () {
        var text = $(this).val();
        var textRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;

        if (!textRegex.test(text)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#users").focusout(function () {
        var value = $(this).val();

        if (value == "") {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#createAlert").submit(function (event) {
        var flag            = "true";
        var title           = $('#title').val();
        var message         = $('#message').val();
        var users           = $('#users').val();
        var slcBussines     = $('#slcBussines').data('id');
        event.preventDefault();
    

        var titleRegex      = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;
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

            var sendData = new FormData();
            sendData.append('title', title);
            sendData.append('slcBussines', slcBussines);
            sendData.append('message', message);
            sendData.append('users', users);
            sendData.append('file', $('#file')[0].files[0]);

            $.ajax({
                type: "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                cache: false,
                data: sendData,
                url: '/createAlertDB',
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
                            'Notificaci\u00F3n enviada con \u00E9xito.',
                            'success'
                        ).then((result) => {
                            location.href = "/alertView";
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
    
    $(document).on('click', '.btn_deleteAlert', function () {
        var pkAlert        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la notificaci\u00F3n?',
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
                    data: { "pkAlert": pkAlert},
                    url: '/deleteAlert',
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
                                'Notificaci\u00F3n eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar notificaci\u00F3n'
                            });
                        }
                    }
                });
            }
        });
    });
    
    
    $(document).on('change', '#activityBusiness', function () {
        var pkBusiness        = $(this).val();
        
        $.ajax({
            type: "POST",
            dataType: "html",
            data: { "pkBusiness": pkBusiness},
            url: '/selectOportunitiesAndQuotations',
            beforeSend: function () {
            },
            success: function (response) {
                $('#type_event_business').empty();
                $('#type_event_business').html(response);
            }
        });
    });
    
    $("#message").focusout(function () {
        var text = $(this).val();
        var textRegex   = /^[a-zA-Z\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\u00D1\u00F1 0-9- \/]+$/g;

        if (!textRegex.test(text)) {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#users").focusout(function () {
        var value = $(this).val();

        if (value == "") {
            $(this).css({
                "-moz-box-shadow": "0 0 12px #ff0000",
                "-webkit-box-shadow": "0 0 12px #ff0000",
                "box-shadow": "0 0 12px #ff0000"
            }
            );
        } else {
            $(this).css({
                "-moz-box-shadow": "none",
                "-webkit-box-shadow": "none",
                "box-shadow": "none"
            });
        }
    });
    
    $("#createActivity").submit(function (event) {
        var flag                    = "true";
        var activityBusiness        = $('#activityBusiness').val();
        var type_event_business     = $('#type_event_business').val();
        var userAgent               = $('#userAgent').val();
        var type_activity           = $('#type_activity').val();
        var description             = $('#description').val();
        var date                    = $('#date').val();
        var hour                    = $('#hour').val();
        var campaning               = $('#campaningAc').val();
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
        
  
        if (flag == "true") {
            var sendData = new FormData();
            sendData.append('activityBusiness', activityBusiness);
            sendData.append('type_event_business', type_event_business);
            sendData.append('userAgent', userAgent);
            sendData.append('type_activity', type_activity);
            sendData.append('description', description);
            sendData.append('date', date);
            sendData.append('hour', hour);
            sendData.append('campaning', campaning);
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
    
    $(document).on('click', '.deleteAvtivity', function () {
        var pkActivity        = $(this).attr("data-id");
        
        
        Swal.fire({
            title: 'Est\u00E1s seguro de eliminar la actividad?',
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
                    data: { "pkActivity": pkActivity},
                    url: '/deleteAvtivity',
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
                                'Actividad eliminada con \u00E9xito.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error al eliminar actividad'
                            });
                        }
                    }
                });
            }
        });
    });
    
    
    $(document).on('click', '.type_activity_ico', function () {
        $(".type_activity_ico").removeClass("active");
        $(this).addClass("active");
    });
    
    
    
    
    
});
