<?php /* Smarty version 2.6.20, created on 2017-04-07 09:40:09
         compiled from profile.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'profile.html', 189, false),)), $this); ?>
<style type="text/css">
    select {
        text-indent: 44% !important;
    }
</style>
            <!-- page content -->
            <div class="right_col" role="main">

                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h1>Perfil</h1>
                            <hr>
                             <br>
                        </div>

                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12 row2 up5">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <!-- <h2>Usuario: <small><?php echo $this->_tpl_vars['activo']; ?>
</small> Identificador: <small><?php echo $this->_tpl_vars['id']; ?>
</small></h2> -->
                                    <div class="clearfix"></div>

                                 
                                    <div class="row x_igual">
                                        <form id="signup2" class="formu" enctype="multipart/form-data" method="post">
                                            <?php if ($this->_tpl_vars['logotipo']): ?>
												<div class="col-md-12">
		                                        <div class="x_panel tile fixed_height_320 griseaso">
		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>
		                                            <div class="col-md-12">
		                                               <center>
		                                               	<div class="circle2">
		                                               	     <img src="../html/es/images/<?php echo $this->_tpl_vars['logotipo']; ?>
" width="100%;">
                                                            <input type="hidden" name="ide" value="<?php echo $this->_tpl_vars['id']; ?>
"/>
                                                             <input type="hidden" name="accion" value="foto" />
											                
											             </div>
		                                               </center>
		                                    
		                                            </div>
		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>
		                                       

		                                            <div class="col-md-12">
		                                                <center>
		                                                	<h1><?php echo $this->_tpl_vars['nombre']; ?>
</h1>
		                                                </center>
		                                            </div>

		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>


		                                            <div class="x_content">
		                                               <div class="form-group margen enorme5">
		                                                         <div class="col-md-12">
		                                                              <input type="file" class="form-control inputfile2"  name="foto" id="file"/>
		                                                              <label for="file">Seleccionar archivo</label>
		                                                         </div>
		                                                     </div>
		                                            </div>

		                                        </div>
		                                    </div>
											<?php else: ?>
												<div class="col-md-12">
		                                        <div class="x_panel tile fixed_height_320 griseaso">
		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>
		                                            <div class="col-md-12">
		                                                <center>
		                                                  <h1>Logotipo</h1>
		                                               </center>
		                                            </div>
		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>
		                                            <div class="x_content">
		                                               <div class="form-group margen enorme5">
		                                                         <div class="col-md-12">
		                                                              <input type="file" class="form-control inputfile"  name="foto" id="file"/>
		                                                              <label for="file">Seleccionar archivo</label>
                                                                      <input type="hidden" name="ide" value="<?php echo $this->_tpl_vars['id']; ?>
"/>
                                                             <input type="hidden" name="accion" value="foto" />
		                                                         </div>
		                                                     </div>
		                                            </div>

		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>
		                                            <div class="col-md-12">
		                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                            </div>

		                                            <div class="col-md-12">
		                                                <center>
		                                                	<h1><?php echo $this->_tpl_vars['nombre']; ?>
</h1>
		                                                </center>
		                                            </div>

		                                        </div>
		                                    </div>
											<?php endif; ?>
		      
                                            </form>
                                           
		                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="x_panel tile fixed_height_320 overflow_hidden griseaso">

                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                    <div class="col-md-12">
                                                        <center>
                                                          <h1>ID de Cliente</h1>
                                                       </center>
                                                    </div>

                                                    <div class="x_content">
                                                        

                                                     <div class="form-group margen enorme6">
                                                         <div class="col-md-12">
                                                              <input type="password" class="form-control" name="identificador" id="identificador" value="<?php echo $this->_tpl_vars['id']; ?>
" readonly="" />
                                                         </div>
                                                     </div>

                           
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>

                                                     <div class="col-md-12 botonzote">
                                                           <input type="hidden" name="ide" value="<?php echo $this->_tpl_vars['id']; ?>
"/>
                                                           <button type="button" class="btn btn-dark"  id="accion2">VER</button>
                                                           <button type="button" class="btn btn-dark"  id="accion3" style="display: none;">OCULTAR</button>
                                                     </div>


                                                    </div>
                                                </div>

		                                    </div>
		                   
		                                </div>

                                        <form id="signup" class="formu todo">
		                                <div class="row x_igual">
		                                    <div class="col-md-12">
                                                 <div class="x_panel tile fixed_height_320 overflow_hidden griseasoy">
                                                    <div class="x_content">

                                                    <center>
                                                        <h1>Mi cuenta</h1>
                                                    </center>

                                                    <div class="form-group margen enorme5">
                                                         <div class="col-md-12">
                                                              <input type="text" class="form-control" placeholder="Nombre" required="" name="name" value="<?php echo $this->_tpl_vars['usuario']; ?>
" onkeydown="" readonly="" />
                                                         </div>
                                                     </div>

                                                     <div class="form-group margen enorme5">
                                                         <div class="col-md-12">
                                                              <input type="text" class="form-control" placeholder="Usuario" required="" name="username" value="<?php echo $this->_tpl_vars['nombre']; ?>
" onkeydown="" readonly=""/>
                                                         </div>
                                                     </div>

                                                     <div class="form-group margen enorme5">
                                                         <div class="col-md-12">
                                                              <input type="text" class="form-control" placeholder="# Celular" required="" name="msisdn" maxlength="10" minlength="10" value="<?php echo $this->_tpl_vars['msisdn']; ?>
" onkeydown=""/>
                                                         </div>
                                                     </div>

                                                     <div class="form-group margen enorme5">
                                                         <div class="col-md-12">
                                                              <select name="operator" id="operator" class="form-control" required onclick="">
                                                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['opciones'],'selected' => $this->_tpl_vars['operador']), $this);?>

                                                            </select>
                                                         </div>
                                                     </div>


                                                     <div class="form-group margen enorme5">
                                                         <div class="col-md-12">
                                                              <input type="text" class="form-control" placeholder="Empresa" required="" name="enterprise" value="<?php echo $this->_tpl_vars['empresa']; ?>
" onkeydown="" readonly=""/>
                                                         </div>
                                                     </div>


                                                     <div class="form-group margen enorme5">
                                                         <div class="col-md-12">
                                                              <input type="email" class="form-control" placeholder="Correo" required="" name="email" value="<?php echo $this->_tpl_vars['correo']; ?>
" onkeydown=""/>
                                                         </div>
                                                     </div>


                                                     <div class="form-group margen enorme5">
                                                         <label class="col-md-12 control-label"></label>
                                                         <div class="col-md-12">
                                                              <input type="password" class="form-control" placeholder="Nueva contraseña" name="password" onkeydown=""/>
                                                         </div>
                                                     </div>

                                                     <div class="form-group margen enorme5">
                                                         <label class="col-md-12 control-label"></label>
                                                         <div class="col-md-12">
                                                              <input type="password" class="form-control" placeholder="Nueva contraseña" name="passwordn" onkeydown=""/>
                                                         </div>
                                                     </div>

                                                     <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                     <div class="col-md-12 botonzote">
                                                           <button type="submit" class="btn btn-dark" name="accion" value="editar" id="accion">GUARDAR</button>
                                                     </div>


                                                     <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
 

                                                    </div>
                                                </div>
		                                        
		                                    </div>

                                        

		                                </div>
                                        </form>
		                              



                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>

<script src="../html/es/js/bootstrapValidator2.js" type="text/javascript"></script>

    <script type="text/javascript">


$(document).ready(function() {


$('#signup').bootstrapValidator({
message: 'This value is not valid',
feedbackIcons: {
                   valid: 'glyphicon glyphicon-ok',
                   invalid: 'glyphicon glyphicon-remove',
                   validating: 'glyphicon glyphicon-refresh'
               },
submitHandler: function(validator, form, submitButton) {
    // Do nothing
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
                                message: 'Ese teléfono ya existe'
                                
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
                                message: 'Ese usuario ya existe'
                                
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
                                message: 'Ese correo ya existe'
                                
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
   },
   password: {
               validators: {
                        stringLength: {
                        min: 4,
                        max: 30,
                        message: 'La CONTRASEÑA debe contener entre 4 y 30 caracteres'
                        },
                        regexp: {
                        regexp: /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,:/$;()]+$/,
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
                        stringLength: {
                        min: 4,
                        max: 30,
                        message: 'La CONTRASEÑA debe contener entre 4 y 30 caracteres'
                        },
                        regexp: {
                        regexp: /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,:/$;()]+$/,
                        message: 'Los caracteres sólo pueden ser alfanuméricos'
                        },
                        identical: {
                            field: 'password',
                            message: 'La contraseña y la confirmación no son iguales'
                        }
               }
   },
}
});
});


$(document).delegate('#accion2','click', function() {
	/*identificador = document.getElementById("identificador");*/
	$("#identificador").prop('type','text');
	$("#accion3").show();
	$("#accion2").hide();
    /*identificador.replaceWith('<h1>'+identificador.value+'</h1>');*/
});

$(document).delegate('#accion3','click', function() {
	/*identificador = document.getElementById("identificador");*/
	$("#identificador").prop('type','password');
	$("#accion3").hide();
	$("#accion2").show();
    /*identificador.replaceWith('<h1>'+identificador.value+'</h1>');*/
});

$('#file').change(
    function(){
        $( "#signup2" ).submit();
    });


</script>
               