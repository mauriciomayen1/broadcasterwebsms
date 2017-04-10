<?php /* Smarty version 2.6.20, created on 2017-04-05 11:13:50
         compiled from unique.html */ ?>
<style type="text/css">
  select {
      text-indent: 38% !important;
  }
</style>

<div class="right_col" role="main">
    <div class="">

        <div class="page-title2" style="padding: 35px 0;">
            <?php if ($this->_tpl_vars['mensaje1']): ?>
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h2><?php echo $this->_tpl_vars['mensaje1']; ?>
</h2>  <?php echo $this->_tpl_vars['numero']; ?>

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
            
        </div>
        
        <div class="clearfix"></div>

        <div class="col-md-12  row2">
            <div class="col-md-12 up">
            <div class="page-title">
                                    <div class="title_left">
                                        <h1>
                                            <b>Envío Único</b>
                                        </h1>
                                        <hr>
                                         <br>
                                    </div>
                            </div>
                <div class="col-md-12">
                    <div class="x_panel up2">
                        <!-- <div class="x_title"> -->
  
                        <!-- </div> -->
                        <!-- <div class="x_content">
                            <form id="demo-form" data-parsley-validate name="demoform" class="formu">
                            <p style="text-align: justify;">
                                En esta sección podrás enviar un SMS, introduce el número celular a 10 digitos y el contenido de tu mensaje (hasta 160 caracteres contando espacios.)
                            </p> 

                            <div class="form-group margen">
                                 <label class="col-md-12 control-label">Sin lada ni 044</label>
                                 <div class="col-md-12">
                                      <input type="text" id="msisdn" class="form-control" name="msisdn" required maxlength="10" minlength="10" />
                                 </div>
                             </div>

                             <div class="form-group margen">
                                 <label class="col-md-12 control-label">Mensaje (1 caracter min, 160 max) :</label>
                                 <div class="col-md-12">
                                      <textarea id="message" required="required" class="form-control" name="message" minlength="1" maxlength="160" onchange="find_preparation();" onKeyDown="cuenta();" onKeyUp="cuenta();"></textarea>
                                 </div>
                             </div>  
                                 
                                <div class="col-md-12"><br></div>
                                <input type="text" name="caracteres" id="caracteres" size="4">Caracteres<br>
                                <input type="text" name="costo" id="costo" readonly="" placeholder="Costo Telcel del envío">Costo Telcel a pagar por el envío<br>
                                <input type="text" name="costo2" id="costo2" readonly="" placeholder="Costo Movistar del envío">Costo Movistar a pagar por el envío<br>
                                <input type="text" name="costo3" id="costo3" readonly="" placeholder="Costo AT&T del envío">Costo AT&T a pagar por el envío<br>
                                <input type="hidden" name="accion" value="enviar">

                                <br><br>
                                <button type="submit" class="btn btn-dark" name="accion" value="enviar" id="accion">Enviar</button>

                            </form>
 

                                </div> -->

                                <div class="row x_igual">
                                <form id="demo-form" data-parsley-validate name="demoform" class="formu">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel tile fixed_height_320 griseaso">
                                            <div class="col-md-12">
                                                <center>
                                                  <h1># Celular</h1>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                               <div class="form-group margen enorme">
                                                   <label class="col-md-12 control-label"></label>
                                                   <div class="col-md-12">
                                                        <input type="text" id="msisdn" class="form-control" name="msisdn" required maxlength="10" minlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                                   </div>
                                               </div>
                                            </div>

                                            <p style="text-align: center; font-size: 15px;">
                                              * El número a ingresar debe ser a 10 dígitos<br>EJEMPLO: 5538888843
                                            </p>
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
                                                        <textarea id="message" required="required" class="form-control" name="message" minlength="1" maxlength="160" onchange="find_preparation();" onKeyDown="cuenta();" onKeyUp="cuenta();"></textarea>
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
                                       <button type="submit" class="btn btn-dark" name="accion" value="enviar" id="accion">Enviar</button>
                                    </div>
                                  </form>
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

<!-- <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<div id="confirm" class="modal hide fade">
  <div class="modal-body">
    Are you sure?
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
  </div>
</div> -->


<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <center>¿Estás segur@ que deseas hacer el envío?</center>
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


            function cuenta(){ 
                    var txt = document.getElementById('message');
                    var div = document.getElementById('caracteres');
                    div.value = txt.value.length;

                    if(txt.value.length == 10){
                      document.getElementById("message").style.fontSize = "20px";
                      document.getElementById("message").style.lineHeight = "15px";
                    }

                    if(txt.value.length == 30){
                      document.getElementById("message").style.fontSize = "15px";
                    }
            } 


            /*function pregunta(){ 
                $( "#dialog-confirm" ).dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                  "Delete all items": function() {
                    $( this ).dialog( "close" );
                  },
                  Cancel: function() {
                    $( this ).dialog( "close" );
                  }
                }
              });
                if (confirm('¿Estás seguro que desees hacer el envío?')){ 
                   document.demoform.submit() 
                }else{
                    event.preventDefault();
                    return false;
                } 
            }*/ 



            $(document).ready(function () {
                find_preparation();
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


              $.ajax({
                     type: "POST",
                     url: "unique.php", 
                     data: {accion: "buscar", selector: selector},
                     dataType: "JSON",  
                     cache:false,
                     success: 
                          function(data){
                            var preparation = data.info;

                              if(preparation.costo){

                                $( "#costo" ).val(preparation.costo);
                                $( "#costo2" ).val(preparation.costo2);
                                $( "#costo3" ).val(preparation.costo3);

                              }else{
                              }
                              
                            
                          }
                      });// you have missed this bracket
                 return false;
            }


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
                        }
               }
   },

    message: {
               validators: {
                        notEmpty: {
                        message: 'El MENSAJE no puede ser vacío'
                        },
                        regexp: {
                        regexp: /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,:/$;()¡!¿?]+$/,
                        message: 'Los caracteres sólo pueden ser alfanúmericos'
                        }
               }
   }
}
}).on('success.form.bv', function(e) {

                        e.preventDefault();
                        var $form     = $(e.target);

                          /*var $form = $(this).closest('form');
                          e.preventDefault();*/
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