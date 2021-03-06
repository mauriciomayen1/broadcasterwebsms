<?php /* Smarty version 2.6.20, created on 2017-04-05 11:38:38
         compiled from masivesend.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'masivesend.html', 88, false),)), $this); ?>
<style type="text/css">
  select {
      text-indent: 38% !important;
  }
</style>

<div class="right_col" role="main">
    <div class="">

       <div class="page-title2" style="padding: 35px 0;">
            <?php if ($this->_tpl_vars['mensaje10']): ?>
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h2><?php echo $this->_tpl_vars['mensaje10']; ?>
  <?php echo $this->_tpl_vars['cantidad10']; ?>
 <?php echo $this->_tpl_vars['mensaje50']; ?>
 <?php echo $this->_tpl_vars['cantidad20']; ?>
 <?php echo $this->_tpl_vars['mensaje60']; ?>
</h2>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['mensaje30']): ?>
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h2><?php echo $this->_tpl_vars['mensaje30']; ?>
</h2>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['error0']): ?>
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h2><?php echo $this->_tpl_vars['error0']; ?>
</h2>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['mensaje1']): ?>
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h2>Operación Exitosa! <?php echo $this->_tpl_vars['mensaje']; ?>
 <?php echo $this->_tpl_vars['base']; ?>
 <?php echo $this->_tpl_vars['mensaje1']; ?>
 <?php echo $this->_tpl_vars['update']; ?>
 <?php echo $this->_tpl_vars['mensaje2']; ?>
</h2>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['mensaje3']): ?>
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h2><?php echo $this->_tpl_vars['mensaje3']; ?>
</h2>
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
                                    <h2>No tienes crédito suficiente para hacer el envío. Si deseas hacer una recarga da click <a href="payment.php">aquí</a></h2>
                                </div>
            
        </div>
        
        <div class="clearfix"></div>

        <div class="col-md-12  row2">
            <div class="col-md-12 up">
                <div class="page-title">
                                    <div class="title_left">
                                        <h1>
                                            <b>Envío Masivo</b>
                                        </h1>
                                        <hr>
                                         <br>
                                    </div>
                            </div>
                <div class="col-md-12">
                    <div class="x_panel up2">
                        <div class="x_content">
                            <!-- <form id="demo-form" data-parsley-validate name="demoform">
                            <p style="text-align: justify;">
                                Para realizar un envío masivo primero debes carar tu base de datos a la cuál se realizará el envío. Si ya lo hiciste:
                                <ol>
                                    <li>Selecciona tu campaña</li>
                                    <li>Da click en preparar</li>
                                    <li>Introduce el contenido de tu SMS</li>
                                    <li>Da click en enviar</li>
                                </ol>
                            </p> 
                                <label for="msisdn">Campaña a enviar :</label>
                                <select name="selectCategoria" id="selectCategoria" class="form-control" data-rel="chosen" onchange="find_preparation();">
                                    <optgroup label="Selecciona categoria">
                                      <option value="0">Todas las campañas</option>

                                      <?php if ($this->_tpl_vars['selecta']): ?>
                                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['opciones'],'selected' => $this->_tpl_vars['selecta']), $this);?>

                                        <?php else: ?>
                                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                              <option value="<?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
"><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        <?php endif; ?>
                                    </optgroup>
                                  </select>

                                

                                <label for="sms">Mensaje (1 caracter min, 158 max) :</label>
                                <textarea id="sms" class="form-control" name="sms" minlength="1" maxlength="158" onKeyDown="cuenta()" onKeyUp="cuenta()"></textarea>

                                <br/>
                                <input type="text" name="caracteres" id="caracteres" size="4">Caracteres<br>
                                <input type="text" name="costo" id="costo" readonly="" placeholder="Costo Telcel del envío">Costo Telcel a pagar por el envío<br>
                                <input type="text" name="costo2" id="costo2" readonly="" placeholder="Costo Movistar del envío">Costo Movistar a pagar por el envío<br>
                                <input type="text" name="costo3" id="costo3" readonly="" placeholder="Costo AT&T del envío">Costo AT&T a pagar por el envío<br>
                                <input type="hidden" name="accion" value="enviar">

                                <br><br>
                                <button type="submit" class="btn btn-dark" name="accion" value="preparar" id="preparar">Preparar</button>
                                <button type="submit" class="btn btn-dark" name="accion" value="enviar" id="enviar">Enviar</button>

                            </form> -->


                                <div class="row x_igual">
                                <form id="demo-form" data-parsley-validate name="demoform" class="formu">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel tile fixed_height_320 griseaso">
                                            <div class="col-md-12">
                                                <center>
                                                  <h1>Selecciona tu campaña</h1>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                               <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <select name="selectCategoria" id="selectCategoria" class="form-control" data-rel="chosen" onchange="find_preparation();">
                                                    <optgroup label="Selecciona categoria">
                                                      <!-- <option value="0">Todas las campañas</option> -->

                                                      <?php if ($this->_tpl_vars['selecta']): ?>
                                                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['opciones'],'selected' => $this->_tpl_vars['selecta']), $this);?>

                                                        <?php else: ?>
                                                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                              <?php if ($this->_tpl_vars['row']['total'] == $this->_tpl_vars['row']['total2']): ?>
                                                                   <option value="<?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
"><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                                              <?php else: ?>
                                                                    
                                                              <?php endif; ?>
                                                          
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        <?php endif; ?>
                                                    </optgroup>
                                                  </select>
                                               </div>
                                            </div>

                                             <center>
                                                <a href="load.php"><h4>¿Campaña nueva?</h4></a>
                                            </center>

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel tile fixed_height_320 overflow_hidden griseaso">
                                            <div class="col-md-12">
                                               <center>
                                                 <h1>Tu mensaje...</h1>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                                <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <div class="col-md-12">
                                                        <textarea id="sms" class="form-control" name="sms" minlength="1" maxlength="160" onKeyDown="cuenta();" onKeyUp="cuenta();"></textarea>
                                                   </div>
                                               </div>

                                               <div class="col-md-12">
                                                 &nbsp;
                                               </div>
                                               <div class="col-md-12 linea">
                                                 <center>
                                                  <input type="text" name="caracteres" id="caracteres" size="4"><h5>CARACTERES</h5>
                                                </center>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 botonzote">
                                      <input type="hidden" name="accion" value="enviar">
                                      <input type="hidden" name="retenido" id="retenido"/>
                                       <!-- <button type="submit" class="btn btn-dark" name="accion" value="preparar" id="preparar">PREPARAR ENVÍO</button> -->
                                <button type="submit" class="btn btn-dark" name="accion" value="enviar" id="enviar">ENVIAR</button>
                                    </div>
                                  </form>

                                   <form id="demo-form2" data-parsley-validate class="formu" style="display: none;">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel tile fixed_height_320 griseaso">
                                            <div class="col-md-12">
                                                <center>
                                                  <h1>Selecciona tu campaña</h1>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                               <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <select name="selectCategoria2" id="selectCategoria2" class="form-control" data-rel="chosen" onchange="find_preparation2();">
                                                    <optgroup label="Selecciona categoria">
                                                      <!-- <option value="0">Todas las campañas</option> -->

                                                      <?php if ($this->_tpl_vars['selecta']): ?>
                                                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['opciones'],'selected' => $this->_tpl_vars['selecta']), $this);?>

                                                        <?php else: ?>
                                                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                              <?php if ($this->_tpl_vars['row']['total'] == $this->_tpl_vars['row']['total2']): ?>
                                                                   <option value="<?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
"><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                                              <?php else: ?>
                                                                    
                                                              <?php endif; ?>
                                                          
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        <?php endif; ?>
                                                    </optgroup>
                                                  </select>
                                               </div>
                                            </div>

                                             <center>
                                                <a href="load.php"><h4>¿Campaña nueva?</h4></a>
                                            </center>

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel tile fixed_height_320 overflow_hidden griseaso">
                                            <div class="col-md-12">
                                               <center>
                                                 <h1>Tu mensaje...</h1>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                                <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <div class="col-md-12">
                                                        <textarea id="sms2" class="form-control" name="sms" minlength="1" maxlength="160" onKeyDown="cuenta();" onKeyUp="cuenta();" readonly=""></textarea>
                                                   </div>
                                               </div>

                                               <div class="col-md-12">
                                                 &nbsp;
                                               </div>
                                               <div class="col-md-12 linea">
                                                 <center>
                                                </center>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 botonzote">
                                      <input type="hidden" name="accion" value="enviar">
                                      <input type="hidden" name="retenido" id="retenido"/>
                                       <button type="submit" class="btn btn-dark" name="accion" value="preparar" id="preparar">PREPARAR ENVÍO</button>
                               <!--  <button type="submit" class="btn btn-dark" name="accion" value="enviar" id="enviar">ENVIAR</button> -->
                                    </div>
                                  </form>
                                </div>

                                </div>
                            </div>
                </div>
            </div>
        </div>

    </div>
</div>

    

</div><!-- /page content -->
</div>
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
                      ¿Estás segur@ que deseas hacer el envío?
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


<!-- Latest compiled JavaScript -->
<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<script src="../html/es/js/bootstrapValidator2.js" type="text/javascript"></script>

<script type="text/javascript">

            function cuenta(){
                    var txt = document.getElementById('sms');
                    var div = document.getElementById('caracteres');
                    div.value = txt.value.length;

                    if(txt.value.length == 10){
                      document.getElementById("sms").style.fontSize = "20px";
                      document.getElementById("sms").style.lineHeight = "15px";
                    }

                    if(txt.value.length == 30){
                      document.getElementById("sms").style.fontSize = "15px";
                    }
            }

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
                find_preparation2();
            });

            $('#confirm').on('hide.bs.modal', function () {
                $("#demo-form").bootstrapValidator('resetForm', true);
                $("#caracteres").val(0);
            });

            $('#yes').on('click', function () {
                document.demoform.submit();
            });


            function find_preparation(){

              selector = $('#selectCategoria').val();

              /*alert(selector);*/


              $.ajax({
                     type: "POST",
                     url: "masivesend.php", 
                     data: {accion: "buscar", selector: selector},
                     dataType: "JSON",  
                     cache:false,
                     success: 
                          function(data){
                            var preparation = data.info;

                            /*alert(preparation.preparada);*/

                            /*$('#selectCategoria').val(selector);*/

                              if(preparation.preparada=='preparada'){
                                /*$( "#preparar" ).hide();
                                $( "#enviar" ).show();*/

                                $( "#demo-form2" ).hide();
                                $( "#demo-form" ).show();

                                $( "#costo" ).val(preparation.costo);
                                $( "#costo2" ).val(preparation.costo2);
                                $( "#costo3" ).val(preparation.costo3);

                                  preparation.total = parseFloat(preparation.total);
                                  preparation.dinero = parseFloat(preparation.dinero);

                                  /*alert(preparation.dinero); 
                                  alert(preparation.total)*/ 

                                  $( "#retenido" ).val(preparation.total);

                                  if(preparation.total>preparation.dinero){

                                    $( "#enviar" ).prop( "disabled", true );
                                    document.getElementById("sin").style.display = "block";

                                  }else{
                                    $( "#enviar" ).prop( "disabled", false );
                                    document.getElementById("sin").style.display = "none";

                                  }

                              }else{
                                /*$( "#preparar" ).show();
                                $( "#enviar" ).hide();*/

                                $( "#demo-form2" ).show();
                                $( "#demo-form" ).hide();
                              }
                              
                            
                          }
                      });// you have missed this bracket
                 return false;
            }


            function find_preparation2(){

              selector = $('#selectCategoria2').val();

              /*alert(selector);*/


              $.ajax({
                     type: "POST",
                     url: "masivesend.php", 
                     data: {accion: "buscar", selector: selector},
                     dataType: "JSON",  
                     cache:false,
                     success: 
                          function(data){
                            var preparation = data.info;

                            /*alert(preparation.preparada);*/

                            /*$('#selectCategoria').val(selector);*/

                              if(preparation.preparada=='preparada'){
                                /*$( "#preparar" ).hide();
                                $( "#enviar" ).show();*/

                                $( "#demo-form2" ).hide();
                                $( "#demo-form" ).show();

                                $( "#costo" ).val(preparation.costo);
                                $( "#costo2" ).val(preparation.costo2);
                                $( "#costo3" ).val(preparation.costo3);

                                  preparation.total = parseFloat(preparation.total);
                                  preparation.dinero = parseFloat(preparation.dinero);

                                  /*alert(preparation.dinero); 
                                  alert(preparation.total)*/ 

                                  $( "#retenido" ).val(preparation.total);

                                  if(preparation.total>preparation.dinero){

                                    $( "#enviar" ).prop( "disabled", true );
                                    document.getElementById("sin").style.display = "block";

                                  }else{
                                    $( "#enviar" ).prop( "disabled", false );
                                    document.getElementById("sin").style.display = "none";

                                  }

                              }else{
                                /*$( "#preparar" ).show();
                                $( "#enviar" ).hide();*/

                                $( "#demo-form2" ).show();
                                $( "#demo-form" ).hide();
                              }
                              
                            
                          }
                      });// you have missed this bracket
                 return false;
            }


            /*$('button[id="enviar"]').on('click', function(e) {
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
										   selectCategoria: {
										               validators: {
									                        callback: {
									                            message: 'Escoge una opción',
									                            callback: function(value, validator) {
									                                // Get the selected options
									                                var options = validator.getFieldElements('selectCategoria').val();
									                                return (options != null && options.length >= 1 && options.length <= 100);
									                            }
									                        }
									                     }
										   },

										    sms: {
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

</body>

</html>