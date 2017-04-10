<?php /* Smarty version 2.6.13, created on 2015-03-03 18:36:59
         compiled from marcaciones.html */ ?>
<body>


        <div id="wrapper">

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Marcaciones
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
                                <table id="example" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SERVICIO</th>
                                            <th>URL</th>
                                            <th>STATUS</th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                        <tr>
                                            <td align="center"><?php echo $this->_tpl_vars['row']['mktmo_msisdn']; ?>
&nbsp;</td>
                                            <td align="center"><?php echo $this->_tpl_vars['row']['url']; ?>
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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').dataTable( {
                "scrollY":        "200px",
                "scrollCollapse": true,
                "paging":         false
            } );
        } );
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../html/es/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../html/es/js/plugins/morris/raphael.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris-data.js"></script>
    <script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
   

</body>

</html>