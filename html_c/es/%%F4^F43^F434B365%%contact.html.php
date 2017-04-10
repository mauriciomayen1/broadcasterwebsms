<?php /* Smarty version 2.6.20, created on 2017-04-05 12:05:02
         compiled from contact.html */ ?>

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h1>Contacto</h1>
                            <hr>
                             <br>
                        </div>

                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12 row2 up5">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="clearfix"></div>
                                      <div class="row x_igual">

                                            <?php if ($this->_tpl_vars['logotipo']): ?>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="x_panel tile fixed_height_320 griseaso">
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                    <div class="col-md-12">
                                                       <center>
                                                        <div class="circle2">
                                                         <img src="../html/es/images/<?php echo $this->_tpl_vars['logotipo']; ?>
" width="100%;">
                                      
                                                         </div>
                                                       </center>
                                            
                                                    </div>
                                            

                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                            

                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                               

                                                    <div class="col-md-12">
                                                        <center>
                                                            <h1><?php echo $this->_tpl_vars['usuario']; ?>
</h1>
                                                        </center>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php else: ?>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="x_panel tile fixed_height_320 griseaso">
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                    <div class="col-md-12">
                                                       <center>
                                                        <div class="circle2">
                                                             <center>
                                                        <div class="circle2">
                                                         <img src="../html/es/images/alias.png" width="100%;">
                                      
                                                         </div>
                                                       </center>
                                                            
                                                         </div>
                                                       </center>
                                            
                                                    </div>
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                            

                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>

                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                               

                                                    <div class="col-md-12">
                                                        <center>
                                                            <h1><?php echo $this->_tpl_vars['usuario']; ?>
</h1>
                                                        </center>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php endif; ?>
              

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="x_panel tile fixed_height_320 overflow_hidden griseaso">
                                                    <div class="x_content">
                                                        

                                                    <form id="signup" data-parsley-validate name="demoform" class="formu todo">

                                                    <div class="form-group margen enorme">
                                                       <label class="col-md-12 control-label"></label>
                                                       <div class="col-md-12">
                                                            <textarea id="message" required="required" class="form-control" name="message" minlength="1" onchange="find_preparation();" onKeyDown="cuenta();" onKeyUp="cuenta();"></textarea>
                                                       </div>
                                                   </div>

                                                   <div class="col-md-12">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>

                                                     <div class="col-md-12 botonzote">
                                                           <button type="submit" class="btn btn-dark" name="accion" value="enviar" id="accion">ENVIAR</button>
                                                     </div>

                                                    </form>

                                                    </div>
                                                </div>
                                            </div>
                           
                                        </div>

                                        <div class="col-md-12">

                                                <br>
                                                <center>
                                                    <h4>Comunícate con nosotros al <b> (+52) (55) 11 01 56 30 EXT 1011 / 1009 / 9014</b></h4>
                                                </center>
                                            </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>

<script src="../html/es/js/bootstrapValidator2.js" type="text/javascript"></script>

    <script type="text/javascript">


    function cuenta(){ 
                    var txt = document.getElementById('message');


                    if(txt.value.length == 10){
                      document.getElementById("message").style.fontSize = "20px";
                      document.getElementById("message").style.lineHeight = "15px";
                    }

                    if(txt.value.length == 30){
                      document.getElementById("message").style.fontSize = "15px";
                    }
            }


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
   
   message: {
               validators: {
                        notEmpty: {
                        message: 'El mensaje no puede ser vacío'
                        }
               }
   }
}
});
});




</script>