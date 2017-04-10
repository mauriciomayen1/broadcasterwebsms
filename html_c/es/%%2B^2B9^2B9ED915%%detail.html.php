<?php /* Smarty version 2.6.20, created on 2017-04-04 13:03:03
         compiled from detail.html */ ?>
            <!-- page content -->
            <div class="right_col" role="main">

                <div class="page-title">
                        <div class="title_left">
                            <h1>
                                <b>Reporte detallado</b>
                            </h1>
                            <hr>
                             <br>
                        </div>
                </div>
                    <div class="clearfix"></div>

                <div align="left" style="vertical-align:baseline;" class="form-inline">
                        <form  method="post"  style="width: 1000px;">
                        <label class="arriba">DE:</label>
                        <div class="input-group date form_date col-md-2" data-date-format="yyyy-mm-dd " data-link-field="dtp_input1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <input class="form-control" size="16" type="text" readonly name="fechaInicial" value="<?php echo $this->_tpl_vars['fechaInicial']; ?>
" id="inicio"/>
                        </div>
                        

                        <input type="hidden" id="dtp_input1"  value="" />
                        
                        <label class="arriba">HASTA:</label>
                        <div class="input-group date form_date col-md-2"  data-date-format="yyyy-mm-dd " data-link-field="dtp_input2">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <input class="form-control" size="16" type="text" readonly name="fechaFinal" value="<?php echo $this->_tpl_vars['fechaFinal']; ?>
" id="fin"/>
                        </div>
                        

                        <input type="hidden" id="dtp_input2"  value="" />
                        

                        <button  class="btn btn-primary" id="consultar" name="consultar" style="background-color:rgb(38, 185, 154);">
                            Consultar
                        </button>
                      </form>
                            <form action="reportMT_excel.php" method="post" target="_blank">
                            <button  class="btn btn-primary"  name="exportar" value="<?php echo $this->_tpl_vars['query']; ?>
" style="background-color:rgb(38, 185, 154);/* border-color:#ec9a21; */position: absolute;top: 176px;left: 758px;border-radius: 0px;" >
                            <i class="glyphicon glyphicon-download-alt icon-white"></i>
                             Exportar
                            </button>
                            </form>

                </div>




                <div class="row x_igual">


                    <div class="col-md-12">
                        <div class="x_panel tile fixed_height_320 bigger">
                            <div class="x_content">
                                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive order" style="font-size:12px; width: 100%;" align="center" id="tabla1">
                                    <thead>
                                    <tr class="info">
                                        <th style="color: #FFF;background: #26B99A; text-align: center">No. Telef&oacute;nico</th>
                                        <th style="color: #FFF;background: #26B99A; text-align: center">Operador</th>
                                        <th style="color: #FFF;background: #26B99A; text-align: center">Campaña</th>
                                        <th style="color: #FFF;background: #26B99A; text-align: center">Contenido</th>
                                        <th style="color: #FFF;background: #26B99A; text-align: center">Fecha</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                        <tr>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_msisdn']; ?>
&nbsp;</td>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_operador']; ?>
&nbsp;</td>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_categoria']; ?>
&nbsp;</td>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_contenido']; ?>
&nbsp;</td>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_fecha']; ?>
&nbsp;</td>  
                                        </tr>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <br>
                            </div>
                        </div>
                    </div>

                </div>




            </div>

            <script type="text/javascript" src="../html/es/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>


            <script type="text/javascript" src="../html/es/js/dataTable.js"></script>
            <script type="text/javascript">

                $(document).ready(function() { 
                    tabla();
                });

                $("#consultar").click(function(){
                    tabla();
                });

                function tabla(){
                    /*alert($('#inicio').val());
                      alert($('#fin').val());*/


                      fechaInicial = $('#inicio').val();
                      fechaFinal = $('#fin').val();

                      var asInitVals = new Array();
                      var oTable;

                        if ( $.fn.dataTable.isDataTable( '#tabla1' ) ) {
                            oTable = $('#tabla1').DataTable();
                            oTable.destroy();
                        }
                            
                             oTable = $('#tabla1').DataTable({
                                "scrollX": "100%",
                                "retrieve": false,
                                "responsive": true,
                                "oLanguage": {
                                    "sSearch": "Search all columns:",
                                },
                                "processing": true,
                                "serverSide": true,
                                "ajax": "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/router/server_processing.php?fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal,
                                "aoColumnDefs": [
                                    {
                                        'bSortable': false,
                                        'aTargets': [0,1]
                                    } //disables sorting for column one
                                ],    

                                "order": [[ 3, "asc" ]],
                                'iDisplayLength': 10,
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
                }
            </script>

            <script type="text/javascript">
        
                $('.form_date').datetimepicker({
                    language:  'fr',
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });
                
            </script>
            <!-- /page content -->