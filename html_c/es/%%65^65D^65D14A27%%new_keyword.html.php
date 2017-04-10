<?php /* Smarty version 2.6.13, created on 2015-03-03 11:39:29
         compiled from new_keyword.html */ ?>
<body>

    <div id="wrapper">

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Nuevo Keyword
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Page Heading -->
              

                <div class="row">
                    <div class="col-lg-12">
                      <form  method="POST" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label for="kw" class="col-lg-2 control-label">Keyword</label>
                            <div class="col-lg-10">
                              <input name="kw" type="text" class="form-control" id="kw"
                                     placeholder="Nombre del Keyword" required="required" value="<?php echo $this->_tpl_vars['kw']; ?>
">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="url" class="col-lg-2 control-label" >Servicio</label>
                            <div class="col-lg-10">
                            <!-- Build your select: -->
                              <select id="servicio-started" name="servicio">
                                  <option value="cheese">Seleccione un Servicio</option>
                                  <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                    <option value="<?php echo $this->_tpl_vars['row']['s_id']; ?>
"  ><?php echo $this->_tpl_vars['row']['s_nombre']; ?>
&nbsp;</option>
                                  <?php endforeach; endif; unset($_from); ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="url" class="col-lg-2 control-label">Marcación</label>
                            <div class="col-lg-10">
                            <!-- Build your select: -->
                              <select id="marcacion-started" name="marcacion">
                                  <option value="cheese">Seleccione una Marcación</option>
                                  <?php $_from = $this->_tpl_vars['rows2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row2']):
?>
                                    <option value="<?php echo $this->_tpl_vars['row2']['marcacion']; ?>
" <?php if ("{{".($this->_tpl_vars['row2']).".marcacion"): ?> == <?php echo $this->_tpl_vars['marcacion']; ?>
}}selected<?php endif; ?>><?php echo $this->_tpl_vars['row2']['marcacion']; ?>
&nbsp;</option>
                                  <?php endforeach; endif; unset($_from); ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="url" class="col-lg-2 control-label">Operador(es)</label>
                            <div class="col-lg-10">
                             <!-- Build your select: -->
                              <select id="operador-started" multiple="multiple" name="operador[]">
                                  <option value="Telcel">Telcel</option>
                                  <option value="Movistar">Movistar</option>
                                  <option value="Iusacell">Iusacell</option>
                                  <option value="Unefon">Unefon</option>
                                  <option value="Nextel">Nextel</option>
                              </select>
                            </div>
                          </div>

                         
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
                              <button type="submit" class="btn btn-success" name="accion" value="guardar">Guardar</button>
                            </div>
                          </div>
                        </form>
                    </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../html/es/js/jquery.js"></script>

    <!-- Include the plugin's CSS and JS: -->
    <script type="text/javascript" src="../html/es/js/bootstrap-multiselect.js"></script>


    <!-- Initialize the plugin: -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#servicio-started').multiselect({
                enableFiltering: true,
            });
        });
        $(document).ready(function() {
            $('#marcacion-started').multiselect({
                enableFiltering: true,
            });

        });
         $(document).ready(function() {
            $('#operador-started').multiselect({
            });
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../html/es/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../html/es/js/plugins/morris/raphael.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris-data.js"></script>

</body>

</html>