<?php /* Smarty version 2.6.13, created on 2015-03-03 11:49:36
         compiled from keywords.html */ ?>
<body>


        <div id="wrapper">

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Keywords
                            </h1>
                        </div>
                    </div>

                    <form method="POST">
                        <div class="row">
                            <div class=" nav navbar-right top-nav">
                                <div class="panel-heading">
                                    <button class="btn btn-primary" type="submit" name="accion" value="nuevo">Agregar</button>
                                </div>     
                            </div>
                        </div>
                    </form>
                    <!-- /.row -->

                    <!-- Page Heading -->
                  

                    <div class="row">
                        <div class="col-lg-12">
                           <!--  <h2>Bordered Table</h2> -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>KEYWORD</th>
                                            <th>SERVICIO</th>
                                            <th>MARCACION</th>
                                            <th>OPERADOR</th>
                                            <th>STATUS</th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                        <tr>
                                            <td align="center"><?php echo $this->_tpl_vars['row']['k_kw']; ?>
&nbsp;</td>
                                            <td align="center"><?php echo $this->_tpl_vars['row']['s_nombre']; ?>
&nbsp;</td>
                                            <td align="center"><?php echo $this->_tpl_vars['row']['k_marcacion']; ?>
&nbsp;</td>
                                            <td align="center"><?php echo $this->_tpl_vars['row']['k_operador']; ?>
&nbsp;</td>
                                            <td align="center">
                                                <span class="label-info label">Activo</span>
                                            </td>
                                            <td align="center">
                                                 <form method="POST">
                                                    <button class="btn btn-success" type="submit" name="accion" value="update">Actualizar</button>
                                                    <button class="btn btn-danger"  type="submit" name="accion" value="eliminar">Eliminar</button>
                                                    <button class="btn btn-warning"  type="submit" name="accion" value="activar">Activar</button>

                                                    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['row']['id']; ?>
" />
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; unset($_from); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                <!-- /.container-fluid -->

                </div>
            <!-- /#page-wrapper -->

            </div>
        <!-- /#wrapper -->
        </div>


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