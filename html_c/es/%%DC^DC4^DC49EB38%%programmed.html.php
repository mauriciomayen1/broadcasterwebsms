<?php /* Smarty version 2.6.20, created on 2017-04-07 09:47:52
         compiled from programmed.html */ ?>
<style type="text/css">
    #tabla1_paginate{
        margin-left: 550px;
        position: absolute;
    }

    select {
        text-indent: 28% !important;
    }
</style>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title2" style="padding: 35px 0;">
            <?php if ($this->_tpl_vars['mensaje']): ?>
                                <div class="alert alert-success alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h2>¡<?php echo $this->_tpl_vars['mensaje']; ?>
!</h2>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['error']): ?>
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h2><?php echo $this->_tpl_vars['error']; ?>
</h2>
                                </div>
                            <?php endif; ?>

                                <div class="alert alert-danger alert-dismissible fade in" role="alert" id="sin" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h2>No tienes crédito suficiente para programar el envío. Si deseas hacer una recarga da click <a href="payment.php">aquí</a></h2>
                                </div>
            
        </div>
        
        <div class="clearfix"></div>

        
        <div class="col-md-12  row2">
            <!-- TABLA -->
            <div class="col-md-12 up">
            <div class="page-title">
                                    <div class="title_left">
                                        <h1>Envío Programado</h1> <!-- <a href="canceled.php"><button type="button" class="btn btn-danger" name="accion" id="gor">CANCELAR</button></a> -->
                                        <hr>
                                         <br>
                                    </div>
                            </div>
                <div class="x_panel up2">
                    <div class="x_content">
                    <!-- <a href="canceled.php">Cancelar envíos</a>
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" name="demoform">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Campaña: <span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="categoria" id="categoria" class="form-control" data-rel="chosen" onchange="find_preparation();">
                                        <optgroup label="Campañas">
                                            <?php $_from = $this->_tpl_vars['rows2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                            <option><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Hora de envío <span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="horaenvio" id="horaenvio" class="form-control" data-rel="chosen" >
                                        <optgroup label="Categorias">
                                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                            <option value="<?php echo $this->_tpl_vars['row']['mkthorario_id']; ?>
"><?php echo $this->_tpl_vars['row']['mkthorario_hora']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Envío</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class='input-group date' id='datetimepickerw'>
                                        <input type='text' class="form-control" name="fechaenvio" id="fechaenvio"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="msgtxt" class="control-label col-md-3 col-sm-3 col-xs-12">Mensaje a enviar</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="msgtxt" class="form-control col-md-7 col-xs-12" type="text" name="msgtxt" maxlength="160" onKeyDown="cuenta();" onKeyUp="cuenta();">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="campania" class="control-label col-md-3 col-sm-3 col-xs-12">Identificador de Campaña</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="campania" class="form-control col-md-7 col-xs-12" type="text" name="campania">
                                </div>
                            </div> 

                            <div class="ln_solid"></div>
                            <div class="form-group">
                            	<input type="text" name="caracteres" id="caracteres" size="4">Caracteres<br>
                                <input type="text" name="costo" id="costo" readonly="" placeholder="Costo Telcel del envío">Costo Telcel a pagar por el envío<br>
                                <input type="text" name="costo2" id="costo2" readonly="" placeholder="Costo Movistar del envío">Costo Movistar a pagar por el envío<br>
                                <input type="text" name="costo3" id="costo3" readonly="" placeholder="Costo AT&T del envío">Costo AT&T a pagar por el envío<br>
                               <input type="hidden" name="accion" value="guardar">
                                <div class="col-md-12"><br>
                                    <button type="submit" class="btn btn-success" name="accion" value="guardar" id="guardar">Guardar</button>
                                </div>
                            </div>

                        </form> -->


                        <div class="row x_igual">
                                <form id="demo-form" data-parsley-validate name="demoform" class="formu">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="x_panel tile fixed_height_320 griseaso">
                                          <div class="col-md-12">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <div class="col-md-12">
                                                <center>
                                                  <h4>Selecciona tu campaña</h4>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                               <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <select name="categoria" id="categoria" class="form-control" data-rel="chosen" onchange="find_preparation();">
                                                        <optgroup label="Campañas">
                                                            <?php $_from = $this->_tpl_vars['rows2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                            <?php if ($this->_tpl_vars['row']['total'] == $this->_tpl_vars['row']['total2']): ?>
                                                                  <option><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                                            <?php else: ?>
                                                                  
                                                            <?php endif; ?>
                                                            
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        </optgroup>
                                                    </select>
                                               </div>
                                            </div>

                                            <center>
                                                <a href="load.php"><h4>¿Campaña nueva?</h4></a>
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
                                                  <h4>Selecciona tu horario</h4>
                                               </center>
                                            </div>
                                            <div class="col-md-12">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <div class="x_content">
                                               <div class="form-group margen enorme2">
                                                   <label class="col-md-12 control-label"></label>
                                                   <div class='input-group date' id='datetimepickerw'>
                                                        <input type='text' class="form-control" name="fechaenvio" id="fechaenvio"/>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                    </div>
                                                </div>


                                                    <div class="form-group margen enorme2">
                                                   <label class="col-md-12 control-label"></label>
                                                       <select name="horaenvio" id="horaenvio" class="form-control" data-rel="chosen" >
                                                        <optgroup label="Categorias">
                                                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['row']['mkthorario_id']; ?>
"><?php echo $this->_tpl_vars['row']['mkthorario_hora']; ?>
</option>
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        </optgroup>
                                                    </select>
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
                                                 <h4>Tu mensaje...</h4>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                                <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <div class="col-md-12">
                                                        <textarea id="msgtxt" class="form-control" name="msgtxt" minlength="1" maxlength="160" onKeyDown="cuenta();" onKeyUp="cuenta();"></textarea>
                                                   </div>
                                               </div>

                                               <div class="col-md-12">
                                                 &nbsp;
                                               </div>
                                               <div class="col-md-12 linea2">
                                                 <center>
                                                  <input type="text" name="caracteres" id="caracteres" size="4"><h5>CARACTERES</h5>
                                                </center>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 botonzote">
                                      <input type="hidden" name="accion" value="guardar">
                                      <input type="hidden" name="retenido" id="retenido"/>
                                       <button type="submit" class="btn btn-success" name="accion" value="guardar" id="guardar">GUARDAR</button>
                                    </div>
                                  </form>
                                </div>
                        
                    </div>

                <div class="x_content">


                                            <div class="row x_igual">
                                                   <form role="form" action="canceled.php" method="POST" style="width: 100%;" id="eliminaa" name="otroform">
                                                   <a href="<?php echo $this->_tpl_vars['help2']; ?>
" target="_blank" id="help2">
                                                           <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                        </a>
                                                       <button class="btn btn-danger submit" type="submit" id="cancelaa5">
                                                                Cancelar
                                                        </button>
                                                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive order" style="font-size:15px;" align="center" id="tabla1">
                                                            <thead>
                                                            <tr class="info">
                                                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Campaña</th>
                                                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Horario</th>
                                                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Fecha</th>
                                                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Cancelar</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $_from = $this->_tpl_vars['programados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                                <tr>
                                                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_region']; ?>
&nbsp;</td>
                                                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_horarionombre']; ?>
&nbsp;</td>
                                                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_fechaenvio']; ?>
&nbsp;</td>
                                                                    <td class="center"><input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['mensaje_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['mensaje_id']; ?>
"></td>
                                                                </tr>
                                                                <?php endforeach; endif; unset($_from); ?>
                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" name="accion" value="guardar"/>
                                                    </form>
                                            </div>
                                    </div>


                </div>
            </div>
        </div> <!--./row-->                 
    </div>
</div>



<input type="hidden" id="mesest">
<input type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
</div>
<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>


<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                   <center>
                       ¿Estás segur@ que deseas programar tu campaña?
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

<div class="modal fade" id="confirm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <center>
            ¿Estás segur@ que deseas eliminar los envíos programados?
        </center>
      </div>
      <div class="modal-footer">
        <center>
            <button type="button" data-dismiss="modal" class="btn btn-primary" id="yes2">Aceptar</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
        </center>
      </div>
    </div>
  </div>
</div>


<script src="../html/es/js/bootstrap-datetimepicker.js"></script>
<script src="../html/es/js/bootstrapValidator2.js" type="text/javascript"></script>
    
<script type="text/javascript">

function cuenta(){ 
                    var txt = document.getElementById('msgtxt');
                    var div = document.getElementById('caracteres');
                    div.value = txt.value.length;

                    if(txt.value.length == 10){
                      document.getElementById("msgtxt").style.fontSize = "20px";
                      document.getElementById("msgtxt").style.lineHeight = "15px";
                    }

                    if(txt.value.length == 30){
                      document.getElementById("msgtxt").style.fontSize = "15px";
                    }
            } 


    $(document).ready(function() {
        $('#datetimepickerw').datetimepicker({
                    startDate: new Date(),
                    format: 'yyyy-mm-dd',
                    language:  'es',
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                }).on('changeDate', function(e) {
            // Revalidate the date field
            $('#demo-form').bootstrapValidator('revalidateField', 'fechaenvio');
        });
    });


    /*function pregunta(){ 
                if (confirm('¿Estás seguro que desees hacer el envío?')){ 
                   document.demoform.submit() 
                }else{
                    event.preventDefault();
                    return false;
                } 
            } */


            $(document).ready(function () {
                find_preparation();
            });


            function removeParam(key, sourceURL) {
			    var rtn = sourceURL.split("?")[0],
			        param,
			        params_arr = [],
			        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
			    if (queryString !== "") {
			        params_arr = queryString.split("&");
			        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
			            param = params_arr[i].split("=")[0];
			            if (param === key) {
			                params_arr.splice(i, 1);
			            }
			        }
			        rtn = rtn + "?" + params_arr.join("&");
			    }
			    return rtn;
			}


            function find_preparation(){

              selector = $('#categoria').val();


              $.ajax({
                     type: "POST",
                     url: "programmed.php", 
                     data: {accion: "buscar", selector: selector},
                     dataType: "JSON",  
                     cache:false,
                     success: 
                          function(data){
                            var preparation = data.info;


                                $( "#costo" ).val(preparation.costo);
                                $( "#costo2" ).val(preparation.costo2);
                                $( "#costo3" ).val(preparation.costo3);
                              
                              
                              preparation.total = parseFloat(preparation.total);
                              preparation.dinero = parseFloat(preparation.dinero);

                              /*alert(preparation.dinero); 
                              alert(preparation.total)*/ 

                              $( "#retenido" ).val(preparation.total);

                              if(preparation.total>preparation.dinero){

                                $( "#guardar" ).prop( "disabled", true );
                                document.getElementById("sin").style.display = "block";

                              }else{
                                $( "#guardar" ).prop( "disabled", false );
                                document.getElementById("sin").style.display = "none";
                              }
                              
                            
                          }
                      });// you have missed this bracket
                 return false;
            }

    /*$('button[id="guardar"]').on('click', function(e) {
                  var $form = $(this).closest('form');
                  e.preventDefault();
                  $('#confirm').modal({
                      backdrop: 'static',
                      keyboard: false
                    })
                    .one('click', '#yes', function(e) {
                      document.demoform.submit();
                    });
                });*/


    $('#confirm').on('hide.bs.modal', function () {
                $("#demo-form").bootstrapValidator('resetForm', true);
                $("#caracteres").val(0);
            });

            $('#yes').on('click', function () {
                document.demoform.submit();
            });

    $('button[id="cancelaa5"]').on('click', function(e) {
                  var $form = $(this).closest('form');
                  e.preventDefault();
                  $('#confirm2').modal({
                      backdrop: 'static',
                      keyboard: false
                    })
                    .one('click', '#yes2', function(e) {
                      document.otroform.submit();
                    });
                });

    $('#demo-form').bootstrapValidator({
            feedbackIcons: {
                               valid: 'glyphicon glyphicon-ok',
                               invalid: 'glyphicon glyphicon-remove',
                               validating: 'glyphicon glyphicon-refresh'
                           },
            submitHandler: function(validator, form, submitButton) {
                // Do nothing
            },
            fields: {
               categoria: {
                           validators: {
                                callback: {
                                    message: 'Escoge una opción',
                                    callback: function(value, validator) {
                                        // Get the selected options
                                        var options = validator.getFieldElements('categoria').val();
                                        return (options != null && options.length >= 1 && options.length <= 100);
                                    }
                                }
                             }
               },

               fechaenvio: {
                           validators: {
                                notEmpty: {
                                    message: 'La FECHA de envío no puede ser vacía'
                                    }
                             }
               },

               horaenvio: {
                           validators: {
                                callback: {
                                    message: 'Escoge una opción',
                                    callback: function(value, validator) {
                                        // Get the selected options
                                        var options = validator.getFieldElements('horaenvio').val();
                                        return (options != null && options.length >= 1 && options.length <= 100);
                                    }
                                }
                             }
               },

                msgtxt: {
                           validators: {
                                    notEmpty: {
                                    message: 'El MENSAJE no puede ser vacío'
                                    },
                                    regexp: {
                                    regexp: /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,:/$;()!¡¿?]+$/,
                                    message: 'Los caracteres sólo pueden ser alfanúmericos'
                                    }
                           }
               }
            }
            }).on('success.form.bv', function(e) {

                                    e.preventDefault();
                                    var $form     = $(e.target);

                                      var $form = $(this).closest('form');
                                      e.preventDefault();
                                      $('#confirm').modal({
                                          backdrop: 'static',
                                          keyboard: false
                                        })
                                        /*.one('click', '#delete', function(e) {
                                          $form.trigger('submit');
                                        }); */       
                                        });

</script>

<script type="text/javascript">

        $('form').submit(function () {
            $(this).find('input[type="checkbox"]').each( function () {
                var checkbox = $(this);
                if( checkbox.is(':checked')) {
/*                    checkbox.attr('value','1');*/
                } else {
                    checkbox.after().append(checkbox.clone().attr({type:'hidden', value:"NO"}));
                    checkbox.prop('disabled', true);
                }
            })
        });
    </script>

    <script type="text/javascript" src="../html/es/js/dataTable.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#tabla2').DataTable({
                      "scrollY": "100px"
                    });
                    $('#tabla1').DataTable();
                });
            </script>

    

</body>

</html>