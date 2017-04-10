<?php /* Smarty version 2.6.20, created on 2017-04-05 11:08:44
         compiled from load.html */ ?>
<style type="text/css">
    #tabla1_paginate{
        margin-left: 550px;
        position: absolute;
    }
</style>

<div class="right_col" role="main">

    <div class="">
        <div class="page-title2" style="padding: 35px 0;">
            <?php if ($this->_tpl_vars['mensaje1']): ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong>Registro Exitoso!</strong> <?php echo $this->_tpl_vars['mensaje1']; ?>

                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['mensaje2']): ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong>Ocurrio un Error!</strong> <?php echo $this->_tpl_vars['mensaje2']; ?>

                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['mensaje3']): ?>
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?php echo $this->_tpl_vars['mensaje3']; ?>
</strong>
                    </div>
                <?php endif; ?>
            
        </div>

        <div class="clearfix"></div>

        <!-- <div class="row"> -->
            <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
                <!-- <div class="x_panel"> -->
                    <!-- <div class="x_body"> -->
                        <div class="col-md-12 row2">
                            <div class="col-md-12 up">
                            <div class="page-title">
                                    <div class="title_left">
                                        <h1>
                                            <b>Cargar usuarios</b>
                                        </h1>
                                        <a href="<?php echo $this->_tpl_vars['help3']; ?>
" target="_blank" id="help3">
                                               <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    </a>
                                        <hr>
                                         <br>
                                    </div>

                            </div>
                                <div class="x_panel up2">
                                    <div class="x_content">
                                        <!-- <div class="col-md-12 col-lg-8 col-sm-7">
                                            
                                            <blockquote>
                                                <p><ul style="list-style-type:square">
                                                      <li>El archivo deberá ser en formato XLS (Office 97-2013)</li>
                                                      <li>La estructura del archivo es la siguiente:</li>
                                                        <ul>
                                                          <li>Columna A: Número telefónico (a 10 digitos sin lada ni 044)</li>
                                                          <li>Columna B: Operador (Telcel, Movistar, AT&T)</li>
                                                          <li>Columna C: Campaña</li>
                                                        </ul>
                                                    </ul>
                                                </p>
                                            </blockquote>
                                        </div> -->

                                        <!-- <div class="clearfix"></div>
                                        
                                        <form method="post" enctype="multipart/form-data" name="formaDatos" id="formaDatos">
                                        <div class="col-md-12 col-lg-8 col-sm-7">
                                            <div class="form-group">
                                                <label>File input</label>
                                                <input type="file" name="usuarios" id="usuarios" class="span12">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12 col-lg-6 col-sm-7">
                                            <div class="form-group">
                                                <label for="fullname">Correo Electrónico:</label>
                                                <input type="text" class="form-control" name="correo" id="correo">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12 col-lg-6 col-sm-7">
                                            <div class="form-group">
                                                <button type="submit" name="accion" value="cargar" class="btn btn-dark btn-sm">Enviar</button>
                                            </div>
                                        </div>
                                        </form> -->


                                        <div class="row x_igual">
                                            <form method="post" enctype="multipart/form-data" name="formaDatos" id="formaDatos">
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="x_panel tile fixed_height_320 griseaso">
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-md-12">
                                                            <center>
                                                              <h1>Carga tu base</h1>
                                                           </center>
                                                        </div>
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="x_content">
                                                           <div class="form-group margen enorme">
                                                               <div class="col-md-12">
                                                                      <input type="file" class="form-control inputfile3" name="usuarios" id="file" />
                                                                      <label for="file">Seleccionar archivo</label>
                                                                 </div>
                                                           </div>
                                                        </div>
                                                        <center>
                                                           <h5><b>*El excel debe ser 97-2004 (.xls)<br>
La estructura del archivo debe ser: Columna A: Número a 10 dígitos
sin lada ni 044 o 045</b></h5> 
                                                        </center>
                                                        

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="x_panel tile fixed_height_320 griseaso">
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-md-12">
                                                            <center>
                                                              <h1>Campaña</h1>
                                                           </center>
                                                        </div>
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="x_content">
                                                           <div class="col-md-12 botonzote">
                                                               <button type="button" class="btn btn-dark" id="nueva">NUEVA</button>
                                                            </div>
                                                            <div class="col-md-12 botonzote">
                                                               <button type="button" class="btn btn-dark" id="existente">EXISTENTE</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="x_panel tile fixed_height_320 overflow_hidden griseaso">
                                                       <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-md-12">
                                                            <center>
                                                              <h1>Nombre</h1>
                                                           </center>
                                                        </div>
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-md-12">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="x_content" id="estesi">
                                                            <div class="form-group margen enorme2">
                                                               <label class="col-md-12 control-label"></label>
                                                               <input type='text' class="form-control" name="nombrec" id="nombrec"/>
                                                           </div>
                                                        </div>

                                                        <div class="x_content" id="esteno">
                                                            <div class="form-group margen enorme2">
                                                               <label class="col-md-12 control-label"></label>
                                                               <select name="nombrec1" id="nombrec1" class="form-control" data-rel="chosen" >
                                                                        <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                                        <option value="<?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
"><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                                                        <?php endforeach; endif; unset($_from); ?>
                                                                </select>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 botonzote">
                                                  <input type="hidden" name="accion" value="guardar">
                                                   <button type="submit" class="btn btn-success" name="accion" value="cargar" id="cargar">CARGAR</button>
                                                </div>
                                              </form>
                                            </div>

                                        </div>

                                        <div class="x_content">


                                            <div class="row x_igual">
                                                          <form role="form" action="canceledc.php" method="POST" style="width: 100%;" name="eliminaa">
                                                        <a href="<?php echo $this->_tpl_vars['help2']; ?>
" target="_blank" id="help2">
                                                           <i class="fa fa-question-circle " aria-hidden="true"></i>
                                                        </a>
                                                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive order" style="font-size:15px; width: 100%;" align="center" id="tabla1">
                                                        <thead>
                                                        <tr class="info">
                                                            <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Campaña</th>
                                                            <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Total de registros</th>
                                                            <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Estatus</th>
                                                            <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Eliminar</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                            <tr>
                                                                <td class="center"><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
&nbsp;</td>
                                                                <td class="center"><?php echo $this->_tpl_vars['row']['total']; ?>
&nbsp;</td>
                                                                <?php if ($this->_tpl_vars['row']['total'] == $this->_tpl_vars['row']['total2']): ?>
                                                                      <td class="center">Procesada&nbsp;</td>
                                                                <?php else: ?>
                                                                      <td class="center">En proceso&nbsp;</td>
                                                                <?php endif; ?>
                                                                <td class="center"><input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
"></td>
                                                                <!-- <td class="center">
                                                            <?php if ($this->_tpl_vars['row']['costo_check'] == 'SI'): ?>
                                                                 <input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
" checked>
                                                            <?php else: ?>
                                                                 <input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
">
                                                                 <input type='hidden' value='No' name='ide[]'>
                                                            <?php endif; ?>
                                                            </td> -->
                                                            <!-- <td class="center">
                                                            <?php if ($this->_tpl_vars['row']['costo_check2'] == 'SI'): ?>
                                                                 <input type="checkbox" name="ide2[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
" checked>
                                                            <?php else: ?>
                                                                 <input type="checkbox" name="ide2[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
">
                                                                 <input type='hidden' value='No' name='ide2[]'>
                                                            <?php endif; ?>
                                                                </td> -->
                                                            </tr>
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        </tbody>
                                                    </table>
                                                    <input type="hidden" name="accion" value="guardar"/>
                                                    <button class="btn btn-danger submit" type="submit" id="cancelaa">
                                                            Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
        

        </div>
    </div>

    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <center>
                        ¿Estás segur@ que deseas eliminar las campañas?
                    </center>
                  </div>
                  <div class="modal-footer">
                    <center>
                        <button type="button" data-dismiss="modal" class="btn btn-primary" id="yes">Aceptar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                    </center>
                  </div>
                </div>
              </div>
            </div>


<script src="../html/es/js/bootstrapValidator2.js" type="text/javascript"></script>

<script type="text/javascript">


$(document).ready(function() {

    $("#estesi").show();
    $("#esteno").hide();


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
   }
}
});
});


$(document).delegate('#nueva','click', function() {
    /*identificador = document.getElementById("identificador");*/
    $("#estesi").show();
    $("#esteno").hide();
    /*identificador.replaceWith('<h1>'+identificador.value+'</h1>');*/
});

$(document).delegate('#existente','click', function() {
    /*identificador = document.getElementById("identificador");*/
    $("#estesi").hide();
    $("#esteno").show();
    /*identificador.replaceWith('<h1>'+identificador.value+'</h1>');*/
});


</script>

<script type="text/javascript" src="../html/es/js/dataTable.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tabla1').DataTable();
    });

    $('button[id="cancelaa"]').on('click', function(e) {
                  var $form = $(this).closest('form');
                  e.preventDefault();
                  $('#confirm').modal({
                      backdrop: 'static',
                      keyboard: false
                    })
                    .one('click', '#yes', function(e) {
                      document.eliminaa.submit();
                    });
                });
</script>