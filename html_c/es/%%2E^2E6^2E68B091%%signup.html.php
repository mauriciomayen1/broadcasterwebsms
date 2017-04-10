<?php /* Smarty version 2.6.20, created on 2017-04-10 10:14:00
         compiled from signup.html */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <meta name="viewport" content="width=1024, user-scalable=no" />

    <title>BROADCASTERWEBSMS | </title>

    <!-- Bootstrap core CSS -->

    <link href="../html/es/css/bootstrap.min.css" rel="stylesheet">

    <link href="../html/es/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="../html/es/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../html/es/css/custom.css" rel="stylesheet">
    <link href="../html/es/css/icheck/flat/green.css" rel="stylesheet">


    <script src="../html/es/js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

<style type="text/css">
    select {
    text-indent: 38% !important;
}
</style>

</head>

<body style="background-image: url('../html/es/images/fondo_a.png'); background-size: 100% 1100px;     background-repeat: no-repeat;">
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
            <br><br><br><br>
                <section class="login_content">
                    <form role="form" action="signup.php" method="POST" id="signup">
                        <h1>Crear cuenta</h1>
                        <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <input type="text" class="form-control" placeholder="Nombre completo" required="" name="name" maxlength="100" />
                             </div>
                         </div>

                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <input type="text" class="form-control" placeholder="Usuario" required="" name="username" />
                             </div>
                         </div>

                         <div class="form-group margen">
                             <label class="col-md-12 control-label">Sin lada ni 044</label>
                             <div class="col-md-12">
                                  <input type="text" class="form-control" placeholder="Teléfono celular a 10 dígitos" required="" name="msisdn" maxlength="10" minlength="10"/>
                             </div>
                         </div>

                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <select name="operator" id="operator" class="form-control" required>
                                    <option value="">Operador</option>
                                    <option value="Telcel">Telcel</option>
                                    <option value="Movistar">Movistar</option>
                                    <option value="AT&T">AT&T</option>
                                </select>
                             </div>
                         </div>

                          <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                             </div>
                         </div>

                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <input type="text" class="form-control" placeholder="Empresa" required="" name="enterprise" />
                             </div>
                         </div>


                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <input type="email" class="form-control" placeholder="Correo" required="" name="email" />
                             </div>
                         </div>


                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <input type="password" class="form-control" placeholder="Contraseña" required="" name="password" />
                             </div>
                         </div>

                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12">
                                  <input type="password" class="form-control" placeholder="Confirme contraseña" required="" name="passwordn" />
                             </div>
                         </div>

                         <div class="form-group margen">
                             <label class="col-md-12 control-label"></label>
                             <div class="col-md-12" style="color: white; font-weight: 100;">
                                  <input type="checkbox" id="accept" value="si" /> <a href="../downloads/terminos.pdf" style="color: white; font-weight: 100;" target="_blank">Términos y condiciones</a>
                                  <p class="change_link"><a href="http://conceptomovil.com/politicas.html" class="to_register" style="color: white; font-weight: 100;" target="_blank">Aviso de privacidad</a>
                            </p>
                             </div>
                         </div>

                         <div class="col-md-12">
                             <br>
                         </div>

                        <div>
                            <button class="btn btn-default submit" type="submit" disabled="" id="ir" onclick="submitForm();">
                                Crear
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                        <input type="hidden" name="accion" value="agregar"/>

                            <p class="change_link"><a href="login.php" class="to_register" style="color: white; font-weight: 100;">¿Ya tienes cuenta?
                                 Ingresa aquí </a>
                            </p>
                            <div class="clearfix"></div>
                           <a href="<?php echo $this->_tpl_vars['help']; ?>
" target="_blank">
                               <i class="fa fa-question-circle fa-3x" aria-hidden="true"></i>
                            </a>
                            <div>
                                <img src="../html/es/images/cm.png" width="190" height="40">

                             </div>

                             <div>

                                <br>

                                <p style="color: white;">©2017 Todos los derechos reservados</p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

<script src="../html/es/js/bootstrapValidator.js" type="text/javascript"></script>

    <script type="text/javascript">
$(document).ready(function() {

    $('#accept').click(function() {
     var ids = [];
    $('.glyphicon-ok').each(function(key, element){
      ids.push($(element).parent().attr('name'));
    });


        if ($(this).is(':checked')) {
            if(ids.length==8){
               $('#ir').removeAttr('disabled');
            }else{
               alert("No ha llenado todos los campos");
               $( "#accept" ).prop( "checked", false );
            }
        } else {
            $('#ir').attr('disabled', 'disabled');
        }
    });


    function submitForm()
        {
             document.getElementById("signup").submit();
        } 
// Generate a simple captcha


$('#signup').bootstrapValidator({
feedbackIcons: {
                   valid: 'glyphicon glyphicon-ok',
                   invalid: 'glyphicon glyphicon-remove',
                   validating: 'glyphicon glyphicon-refresh'
               },
fields: {
   name: {
               validators: {
                        notEmpty: {
                        message: 'El NOMBRE no puede ser vacío'
                        },
                        stringLength: {
                        min: 4,
                        max: 30,
                        message: 'El NOMBRE debe contener entre 4 y 30 caracteres'
                        },
                        regexp: {
                        regexp: /^[a-zA-Z0-9_\.\s]+$/,
                        message: 'Los caracteres sólo pueden ser alfanuméricos'
                        }
               }
   },
   password: {
               validators: {
                        notEmpty: {
                        message: 'La CONTRASEÑA no puede ser vacía'
                        },
                        stringLength: {
                        min: 4,
                        max: 30,
                        message: 'La CONTRASEÑA debe contener entre 4 y 30 caracteres'
                        },
                        regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'Los caracteres sólo pueden ser alfanuméricos'
                        },
                        identical: {
                            field: 'passwordn',
                            message: 'La contraseña y la confirmación no son iguales'
                        }
               }
   },
   passwordn: {
               validators: {
                        notEmpty: {
                        message: 'La CONTRASEÑA no puede ser vacía'
                        },
                        stringLength: {
                        min: 4,
                        max: 30,
                        message: 'La CONTRASEÑA debe contener entre 4 y 30 caracteres'
                        },
                        regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'Los caracteres sólo pueden ser alfanuméricos'
                        },
                        identical: {
                            field: 'password',
                            message: 'La contraseña y la confirmación no son iguales'
                        }
               }
   },
   msisdn: {
               validators: {
                        notEmpty: {
                        message: 'El NÚMERO DE CELULAR no puede ser vacío'
                        },
                        stringLength: {
                        min: 10,
                        max: 10,
                        message: 'El NÚMERO DE CELULAR debe contener 10 caracteres'
                        },
                        regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Los caracteres sólo pueden ser numéricos'
                        },
                        remote: {
                                type: 'POST',
                                url: "/dashboard/broadcasterwebsms/router/validatel.php",
                                data: function(validator) {
                                    return {
                                        celular: validator.getFieldElements('msisdn').val()
                                    };
                                },
                                message: 'Este teléfono ya existe'
                                
                            }
               }
   },
   username: {
               validators: {
                        notEmpty: {
                        message: 'El USUARIO no puede ser vacío'
                        },
                        stringLength: {
                        min: 4,
                        max: 80,
                        message: 'El USUARIO debe contener entre 4 y 80 caracteres'
                        },
                        regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                        message: 'Los caracteres sólo pueden ser alfabeticos'
                        },
                        remote: {
                                type: 'POST',
                                url: "/dashboard/broadcasterwebsms/router/validanombre.php",
                                data: function(validator) {
                                    return {
                                        nombre: validator.getFieldElements('username').val()
                                    };
                                },
                                message: 'Este usuario ya existe'
                                
                            }
               }
   },
   enterprise: {
               validators: {
                        notEmpty: {
                        message: 'La EMPRESA no puede ser vacío'
                        },
                        stringLength: {
                        min: 4,
                        max: 80,
                        message: 'La EMPRESA debe contener entre 4 y 80 caracteres'
                        },
                        regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,]+$/,
                        message: 'Los caracteres sólo pueden ser alfabeticos'
                        }
               }
   },
   email: {
               validators: {
                        notEmpty: {
                        message: 'El correo no puede ser vacío'
                        },
                        emailAddress: {
                        message: 'No es un correo válido'
                        },
                        remote: {
                                type: 'POST',
                                url: "/dashboard/broadcasterwebsms/router/validacorreo.php",
                                data: function(validator) {
                                    return {
                                        correo: validator.getFieldElements('email').val()
                                    };
                                },
                                message: 'Este correo ya existe'
                                
                            }
               }
   },

   operator: {
                    validators: {
                        callback: {
                            message: 'Escoge una opción',
                            callback: function(value, validator) {
                                // Get the selected options
                                var options = validator.getFieldElements('operator').val();
                                return (options != null && options.length >= 1 && options.length <= 100);
                            }
                        }
                     }
   }
}
});
});


</script>


</body>

</html>