<?php /* Smarty version 2.6.20, created on 2017-04-07 11:26:15
         compiled from webservice.html */ ?>


<div class="right_col" role="main">
    <div class="">

    <div class="page-title2" style="padding: 35px 0;">
            <?php if ($this->_tpl_vars['alerta'] == '1'): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h2>Ya puedes consumir la URL generada para tu servicio.</h2>.
                                </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['alerta'] == '2'): ?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h2>Revisa las siguientes advertencias:</h2><br>
                                    <h2><?php echo $this->_tpl_vars['mensaje2']; ?>
</h2><br>
                                    <h2><?php echo $this->_tpl_vars['mensaje3']; ?>
</h2><br>
                                    <h2><?php echo $this->_tpl_vars['mensaje4']; ?>
</h2><br>
                                    <h2><?php echo $this->_tpl_vars['mensaje5']; ?>
</h2>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['alerta'] == '3'): ?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h2>Ya existe un servicio web asignado</h2>
                                </div>
                                <?php endif; ?>
            
        </div>
        
        <div class="clearfix"></div>

        <div class="col-md-12  row2">
            <div class="col-md-12 up">
                <div class="page-title">
                                    <div class="title_left">
                                        <h1>API</h1>
                                        <hr>
                                         <br>
                                    </div>
                            </div>
                <div class="col-md-12">
                    <div class="x_panel up2">
                        <div class="x_content">

                            <!-- <form id="validateForm" data-toggle="validator" role="form">
                            <a href="http://repositorio.cm-operations.com/proyectemail/downloads/ws.pdf" target="_blank">Ver manual</a>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nombre del cliente</label>
                                            <input name="nombrecliente" id="idNombreCliente" type="text" class="form-control" value="<?php echo $this->_tpl_vars['nombrecliente']; ?>
">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Descripci&oacute;n</label>
                                            <input name="descripcion" id="idDescripcion" type="text" class="form-control" placeholder="Descripción" maxlength="160">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input name="usuario" id="idUsuario" type="text" class="form-control" value="<?php echo $this->_tpl_vars['usuariogenerado']; ?>
">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-12">
                                        <h5 class="page-header">Datos Asignados</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Usuario del cliente</label>
                                            <input name="usuariocliente" id="idUsuarioCliente" type="text" class="form-control" placeholder="Usuario para envio de mt" maxlength="160" value="<?php echo $this->_tpl_vars['usuariogenerado']; ?>
" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Url Asignada</label>
                                            <input name="usuarioURL" id="idUsuarioURL" type="text" class="form-control" placeholder="URL asignada al cliente para mt" value="<?php echo $this->_tpl_vars['urlgenerada']; ?>
">
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-lg-4">   
                                        <div class="control-group">
                                            <button type="submit" class="btn btn-info" name="accion" value="guardar">
                                            <i class="glyphicon glyphicon-save icon-white"></i>
                                                    GUARDAR
                                            </button>
                                            <input type="hidden" name="usuarioregistra" id="isUsuarioRegistra" value="<?php echo $_SESSION['smsmarketingsession']['nombre']; ?>
">
                                        </div>
                                    </div>
                                </div>

                            </form> -->

                            <div class="row x_igual">
                                <form id="demo-form" data-parsley-validate name="demoform" class="formu todo">
                                    <div class="col-md-12">
                                        <div class="x_panel tile fixed_height_320 griseaso2">
                                            <div class="col-md-12">
                                                <center>
                                                  <h4>&nbsp;</h4>
                                               </center>
                                            </div>
                                            <div class="x_content">
                                               <div class="form-group margen enorme3">
                                                   <label></label>
                                            <input name="usuarioURL" id="idUsuarioURL" type="text" class="form-control" placeholder="URL asignada al cliente para mt" value="<?php echo $this->_tpl_vars['urlgenerada']; ?>
">
                                               </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12 botonzote">
                                      <button type="submit" class="btn btn-info" name="accion" value="guardar" id="accion">
                                                    GENERAR API
                                      </button>

                                      <button type="button" class="btn btn-info" id="accion2" data-clipboard-text="<?php echo $this->_tpl_vars['urlgenerada']; ?>
">
                                                    COPIAR
                                      </button>

                                    </div>
                                  </form>
                                </div>


                                </div>
                            </div>
                </div>
            </div>
        </div>

        <div class="col-md-12  row2 up3" id="desaparece">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div>
                                  <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">PHP</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">AJAX</a></li>
                                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">PYTHON</a></li>
                                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">JAVA</a></li>
                                  </ul>

                                  <!-- Tab panes -->
                                  <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        <div class="row x_igual">
                                        <div class="col-md-12">
<pre>
    $url = '<?php echo $this->_tpl_vars['urlgenerada']; ?>
';                                                                      
    $req =& new HTTP_Request($url);                                                                                
                                                                                                                         
    $ch = curl_init('<?php echo $this->_tpl_vars['urlgenerada']; ?>
');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                                                                                       
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json'))                                                                       
    );                                                                                                                   
                                                                                                                         
    $result = curl_exec($ch);

    $myArray = json_decode($result);

    $codigo = $myArray->info;
    
</pre>
                                </div>
                                </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        <div class="row x_igual">
                                        <div class="col-md-12">
<pre>

     $.ajax({
            url: "<?php echo $this->_tpl_vars['urlgenerada']; ?>
", 
            type: "GET",  
            dataType: "JSON",
            cache: false,
            success: 
                  function(data){
                    var enviado = data.info;

                    alert(enviado);    
                    
                  }           
        }); 
</pre>
                                </div>
                                </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="messages">
                                    <div class="row x_igual">
                                        <div class="col-md-12">
<pre>
    import requests
    url = '<?php echo $this->_tpl_vars['urlgenerada']; ?>
'

    # GET
    r = requests.get(url)

    # Response, status etc
    r.info

</pre>
                                    </div>
                            </div>
                                </div>
                                    <div role="tabpanel" class="tab-pane" id="settings">
                                    <div class="row x_igual">
                                        <div class="col-md-12">
<pre>
    try {
        URL myURL = new URL("<?php echo $this->_tpl_vars['urlgenerada']; ?>
");
        URLConnection myURLConnection = myURL.openConnection();
        myURLConnection.connect();
    } 
    catch (MalformedURLException e) { 
        // new URL() failed
        // ...
    } 
    catch (IOException e) {   
        // openConnection() failed
        // ...
    }

</pre>
                                    </div>
                                    </div>
                            </div>
                                  </div>

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

<!-- <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
 -->

    <script type="text/javascript" src="../html/es/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
   
    
    <!-- Include bootstrapValidator plugin -->
    <script type="text/javascript" src="../html/es/js/bootstrapValidator2.js"></script>
   

    <script type="text/javascript">

        $('.form_date').datetimepicker({
            language:  'fr',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            startDate: '+0d'
        });


        function numbers(e){
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true; 
            return /\d/.test(String.fromCharCode(keynum));
        }

        $(document).ready(function() {

            url = $('#idUsuarioURL').val();

            if(url.length<=0){
                $('#desaparece').hide();
                $('#accion2').hide();
                $('#accion').show();
            }else{
                $('#accion').hide();
                $('#accion2').show();
            }


            $('#validateForm').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    excluded: ':hidden',
                    fields: {
                        nombrecliente: {
                            validators: {
                                notEmpty: {
                                    message: 'Nombre del cliente es requerido.'
                                }
                            }
                        },
                        descripcion: {
                            validators: {
                                notEmpty: {
                                    message: 'La descripcion es requerido.'
                                } 
                            }
                        },
                        usuario: {
                            validators: {
                                notEmpty: {
                                    message: 'El usuario es requerido.'
                                } 
                            }
                        },
                       

                    }    
                });
                  
        });  

    function checaLength(){
        if (document.getElementById('apsuscripcioncontenido_texto').value.length > 160) 
        {
            document.getElementById('apsuscripcioncontenido_texto').value = document.getElementById('apsuscripcioncontenido_texto').value.substring(0, 160);
        }
        document.getElementById('length_apsuscripcioncontenido_texto').value=document.getElementById('apsuscripcioncontenido_texto').value.length;
    } 
       

       
        
    </script>

    <script src="../html/es/js/clipboard.min.js"></script>
    <script>
    var btns = document.querySelectorAll('button');
    var clipboard = new Clipboard(btns);

    clipboard.on('success', function(e) {
        alert("URL copiada");
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
    </script>

    </body>

</html>