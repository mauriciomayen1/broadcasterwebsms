<?php /* Smarty version 2.6.20, created on 2017-02-20 10:16:25
         compiled from sendp.html */ ?>
<!-- page content -->
<div class="right_col" role="main">
    <br/>
    <div class="">
        <div class="row top_tiles"></div>

        <div class="row">
            <!-- fechas -->
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2></h2>
                        <div class="row">
                            <div class="form-inline" style="vertical-align:baseline;">
                                <form method="POST">
                                <div class="form-group">
                                    <label>DE :</label>
                                    <div class='input-group date' id='datetimepicker6'>
                                        <input type='text' class="form-control" value="<?php echo $this->_tpl_vars['fechaInicial']; ?>
" name="fechaInicial" id="fechaInicial" />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>HASTA :</label>
                                    <div class='input-group date' id='datetimepicker7'>
                                        <input type='text' class="form-control" value="<?php echo $this->_tpl_vars['fechaFinal']; ?>
" name="fechaFinal" id="fechaFinal" />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                                <button type="submit" id="enviar" class="btn btn-success" style="margin-bottom: 10px;">Generar</button>
                                </form>
                            </div>
                        </div> <!--./row-->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- TABLA -->
            <div class="animated flipInY col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Reporte<small>ENVIOS PROGRAMADOS</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="example" class="table table-striped dt-responsive jambo_table cell-border nowrap" width="100%">
                            <thead>
                                <tr class="headings">
                                    <th>Id</th>
                                    <th>Mensaje</th>
                                    <th>Categoria</th>
                                    <th>Fecha de envío</th>
                                    <th>Hora de envío</th>
                                    <th>Fecha Registro</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <tr>
                                  <form method="POST">
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_id']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_mensaje']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_region']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_fechaenvio']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_horarionombre']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_fechaalta']; ?>
&nbsp;</td>
                                    <td class="center">
                                      <?php if ($this->_tpl_vars['row']['mensaje_procesado'] == '0'): ?>
                                        <button type="button" class="btn btn-success btn-xs">Procesado</button>
                                      <?php endif; ?>
                                      <?php if ($this->_tpl_vars['row']['mensaje_procesado'] == '2'): ?>
                                        <button type="button" class="btn btn-warning btn-xs">Eliminado</button>
                                      <?php endif; ?>
                                      <?php if ($this->_tpl_vars['row']['mensaje_procesado'] == '1'): ?>
                                        <button type="button" class="btn btn-info btn-xs">Pendiente</button>
                                      <?php endif; ?>
                                      <button type="submit" class="btn btn-danger btn-xs" name="accion" value="eliminar" onclick="return pregunta()">Eliminar</button>
                                              <input type="hidden" name="idEliminar" value="<?php echo $this->_tpl_vars['row']['mensaje_id']; ?>
"/></td>
                                    </form>
                                </tr>
                                <?php endforeach; endif; unset($_from); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>                 
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

<script src="../html/es/js/bootstrap.min.js"></script>
<script src="../html/es/js/nicescroll/jquery.nicescroll.min.js"></script>

<!-- chart js -->
<script src="../html/es/js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="../html/es/js/progressbar/bootstrap-progressbar.min.js"></script>
<!-- icheck -->
<script src="../html/es/js/icheck/icheck.min.js"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="../html/es/js/moment.min2.js"></script>
<script type="text/javascript" src="../html/es/js/datepicker/daterangepicker.js"></script>
<!-- sparkline -->
<script src="../html/es/js/sparkline/jquery.sparkline.min.js"></script>
<script src="../html/es/js/custom.js"></script>

<!-- flot js -->
<!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="../html/es/js/flot/date.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.spline.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.stack.js"></script>
<script type="text/javascript" src="../html/es/js/flot/curvedLines.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.resize.js"></script>

<script src="../html/es/js/echart/echarts-all.js"></script>
<script src="../html/es/js/echart/green.js"></script>

<!-- flot js -->
<!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="../html/es/js/flot/date.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.spline.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.stack.js"></script>
<script type="text/javascript" src="../html/es/js/flot/curvedLines.js"></script>
<script type="text/javascript" src="../html/es/js/flot/jquery.flot.resize.js"></script>

<!-- skycons -->
<script src="../html/es/js/skycons/skycons.js"></script>

<!-- HIGHCHARTS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<!-- select or dropdown enhancer -->
<script src="../html/es/js/chosen.jquery.js"></script>
<!-- select multiple -->
<script src="../html/es/js/bootstrap-multiselect.js"></script>
<!-- date time picker -->
<script src="../html/es/js/bootstrap-datetimepicker.js"></script>

<!-- Datatables -->
<script src="../html/es/js/jquery.dataTables.js"></script>
<script src="../html/es/js/datatables/tools/js/dataTables.tableTools.js"></script>
<script src="../html/es/js/responsive-tables.js"></script>
<script src="../html/es/js/dataTables.responsive.js"></script>

    
<script type="text/javascript">

     function pregunta(){
            if (confirm('¿Estas seguro de eliminar este registro?')){ 
                document.getElementById ('tuformulario').submit() 
            }else{
                return false;
            }
        }


        $(document).ready(function() {
            $('#datetimepicker7').datetimepicker({
                        format: 'yyyy-mm-dd',
                        language:  'es',
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        minView: 2,
                        forceParse: 0
                    });

            $('#datetimepicker6').datetimepicker({
                        format: 'yyyy-mm-dd',
                        language:  'es',
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        minView: 2,
                        forceParse: 0
                    });
    });
        
        

    var asInitVals = new Array();
            $(document).ready(function () {
                var oTable = $('#example').dataTable({
                    "oLanguage": {
                        "sSearch": "Search all columns:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0,1,2]
                        } //disables sorting for column one
            ],    
                    "order": [[ 1, "asc" ]],
                    'iDisplayLength': 5,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "../html/es/js/datatables/tools/swf/copy_csv_xls_pdf.swf"
                    }
                });
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });
            });


</script>