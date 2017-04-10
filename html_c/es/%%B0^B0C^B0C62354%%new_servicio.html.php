<?php /* Smarty version 2.6.13, created on 2015-03-03 16:30:45
         compiled from new_servicio.html */ ?>
<body>

    <div id="wrapper">

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Nuevo Servicio</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Page Heading -->
              

                <div class="row">
                    <div class="col-lg-12">
                      <form  method="POST" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label for="servicio" class="col-lg-2 control-label">Servicio</label>
                            <div class="col-lg-10">
                              <input name="servicio" type="text" class="form-control" id="servicio"
                                     placeholder="Nombre del Servicio" required="required" value="<?php echo $this->_tpl_vars['servicio']; ?>
">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="url" class="col-lg-2 control-label">Url</label>
                            <div class="col-lg-10">
                              <input name="url" type="text" class="form-control" id="url"
                                     placeholder="Ejemplo: http://geos.cm-operations.com/router/router.php" required="required" value="<?php echo $this->_tpl_vars['url']; ?>
">
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../html/es/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../html/es/js/plugins/morris/raphael.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris-data.js"></script>

</body>

</html>