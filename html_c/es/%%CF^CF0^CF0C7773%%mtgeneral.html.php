<?php /* Smarty version 2.6.20, created on 2017-04-10 11:37:01
         compiled from mtgeneral.html */ ?>
            <!-- page content -->
<style type="text/css">
    #tabla1_length, #tabla1_filter, #tabla1_info, #tabla1_paginate{
        display: none;
    }
</style>
            <div class="right_col" role="main">

               <div class="page-title">
                        <div class="title_left">
                            <h1>
                                <b>Dashboard</b>
                            </h1>
                            <hr>
                             <br>
                        </div>
                </div>
                    <div class="clearfix"></div>

                <div align="left" style="vertical-align:baseline;" class="form-inline">
                        <form  method="post"  >
                        <label class="arriba">DE:</label>
                        <div class="input-group date form_date col-md-2" data-date-format="yyyy-mm-dd " data-link-field="dtp_input1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <input class="form-control" size="16" type="text" readonly name="fechaInicial" value="<?php echo $this->_tpl_vars['fechaInicial']; ?>
"/>
                        </div>
                        

                        <input type="hidden" id="dtp_input1"  value="" />
                        
                        <label class="arriba">HASTA:</label>
                        <div class="input-group date form_date col-md-2"  data-date-format="yyyy-mm-dd " data-link-field="dtp_input2">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <input class="form-control" size="16" type="text" readonly name="fechaFinal" value="<?php echo $this->_tpl_vars['fechaFinal']; ?>
"/>
                        </div>
                        

                        <input type="hidden" id="dtp_input2"  value="" />

                        <label class="arriba">USUARIO</label>
                        <select name="user" id="user" class="form-control" style="margin-top: -10px;">
                        <option value="">Todos</option>
                            <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                              <?php if ($this->_tpl_vars['row']['usuario_id'] == $this->_tpl_vars['escogido']): ?>
                                <option value="<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
" selected=""><?php echo $this->_tpl_vars['row']['usuario_nombre']; ?>
</option>
                              <?php else: ?>
                                <option value="<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
"><?php echo $this->_tpl_vars['row']['usuario_nombre']; ?>
</option>
                              <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>


                        

                        <button  class="btn btn-primary" id="consultar" name="consultar" style="background-color:rgb(38, 185, 154);">
                            Consultar
                        </button>
                      </form>
                            <!-- <form action="reportMT_excel.php" method="post" target="_blank">
                            <button  class="btn btn-primary"  name="exportar" value="<?php echo $this->_tpl_vars['query']; ?>
" style="background-color:#ec9a21; border-color:#ec9a21;" >
                            <i class="glyphicon glyphicon-download-alt icon-white"></i>
                             Exportar
                            </button>
                            </form> -->

                </div>

                <!-- top tiles -->
                <div class="row tile_count">
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Total MT</span>
                            <div class="count"><?php echo $this->_tpl_vars['total']; ?>
</div>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Total Telcel</span>
                            <div class="count blue"><?php echo $this->_tpl_vars['total_telcel']; ?>
</div>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Total Movistar</span>
                            <div class="count green"><?php echo $this->_tpl_vars['total_movistar']; ?>
</div>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Total AT&T</span>
                            <div class="count blue2"><?php echo $this->_tpl_vars['total_iusacell']; ?>
</div>
                        </div>
                    </div>

                    <!-- <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"> Crédito</span>
                            <div class="count red"><h3><?php echo $this->_tpl_vars['credito']; ?>
</h3></div>
                        </div>
                    </div> -->
                </div>
                <!-- /top tiles -->



                                            <?php if ($this->_tpl_vars['logotipo']): ?>
                                                <div class="circle">
                                                    <img src="../html/es/images/<?php echo $this->_tpl_vars['logotipo']; ?>
" width="100%;">
                                                </div>
                                            <?php else: ?>
                                                <div class="circle">
                                                    <img src="../html/es/images/alias.png" width="100%;">
                                                </div>

                                            <?php endif; ?>


                <div class="row x_igual">


                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel tile fixed_height_320">
                            <div class="x_title">
                                <h2>Tipos de envío</h2>
                                <!-- <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul> -->
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Único</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $this->_tpl_vars['porcentaje_telcelmo']; ?>
" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $this->_tpl_vars['totalsu']; ?>
%;">
                                                <span class="sr-only"><?php echo $this->_tpl_vars['totalsu']; ?>
</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $this->_tpl_vars['totalsu']; ?>
</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Masivo</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $this->_tpl_vars['porcentaje_movistarmo']; ?>
" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $this->_tpl_vars['totalsm']; ?>
%;">
                                                <span class="sr-only"><?php echo $this->_tpl_vars['totalsm']; ?>
</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $this->_tpl_vars['totalsm']; ?>
</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Programado</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $this->_tpl_vars['porcentaje_iusacellmo']; ?>
" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $this->_tpl_vars['totalsp']; ?>
%;">
                                                <span class="sr-only"><?php echo $this->_tpl_vars['totalsp']; ?>
</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $this->_tpl_vars['totalsp']; ?>
</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>API</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $this->_tpl_vars['porcentaje_iusacellmo']; ?>
" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $this->_tpl_vars['totalws']; ?>
%;">
                                                <span class="sr-only"><?php echo $this->_tpl_vars['totalws']; ?>
</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $this->_tpl_vars['totalws']; ?>
</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Mail</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $this->_tpl_vars['porcentaje_iusacellmo']; ?>
" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $this->_tpl_vars['totalse']; ?>
%;">
                                                <span class="sr-only"><?php echo $this->_tpl_vars['totalse']; ?>
</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $this->_tpl_vars['totalse']; ?>
</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel tile fixed_height_320 overflow_hidden">
                            <div class="x_title">
                                <h2>Mensajes enviados</h2>
                                <!-- <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul> -->
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <table class="" style="width:100%">
                                    <tr>
                                        <th style="width:37%;">
                                            <p>Porcentajes</p>
                                        </th>
                                        <th>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <p class="">Operador</p>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <p class="">Progreso</p>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                        </td>
                                        <td>
                                            <table class="tile_info">
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square blue"></i>Telcel</p>
                                                    </td>
                                                    <td style="margin-left: -15px"><?php echo $this->_tpl_vars['porcentaje_telcel']; ?>
%</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square green"></i>Movistar </p>
                                                    </td>
                                                    <td style="margin-left: -15px"><?php echo $this->_tpl_vars['porcentaje_movistar']; ?>
%</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square blue2"></i>AT&T </p>
                                                    </td>
                                                    <td style="margin-left: -15px"><?php echo $this->_tpl_vars['porcentaje_iusacell']; ?>
%</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row x_igual minus">


                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel tile fixed_height_320 more">
                            <div class="x_title">
                                <h2>Últimos SMS enviados</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-striped bootstrap-datatable datatable responsive order" style="font-size:11.5px;" align="center" id="tabl1">
                                    <thead>
                                    <tr class="info">
                                        <th style="color: #FFF;background: #26B99A; text-align: center">No. Telef&oacute;nico</th>
                                        <!-- <th style="color: #FFF;background: #26B99A; text-align: center">Operador</th>
                                        <th style="color: #FFF;background: #26B99A; text-align: center">Campaña</th> -->
                                        <th style="color: #FFF;background: #26B99A; text-align: center">Contenido</th>
                                        <!-- <th style="color: #FFF;background: #26B99A; text-align: center">Fecha</th>  -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $_from = $this->_tpl_vars['todos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                        <tr>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_msisdn']; ?>
&nbsp;</td>
                                            <!-- <td class="center"><?php echo $this->_tpl_vars['row']['mt_operador']; ?>
&nbsp;</td>
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_categoria']; ?>
&nbsp;</td> -->
                                            <td class="center"><?php echo $this->_tpl_vars['row']['mt_contenido']; ?>
&nbsp;</td>
                                            <!-- <td class="center"><?php echo $this->_tpl_vars['row']['mt_fecha']; ?>
&nbsp;</td>   -->
                                        </tr>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel tile fixed_height_320 overflow_hidden more">
                            <div class="x_title">
                                <a href="payment.php"><h2>Últimos pagos</h2></a>
                                <!-- <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul> -->
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                               <table class="table table-striped bootstrap-datatable datatable responsive order" style="font-size:18.5px;" align="center" id="tabl2">
                            <thead>
                            <tr class="info">
                                <th style="color: #FFF;background: #26B99A; text-align: center;">Forma de Pago</th>
                                <th style="color: #FFF;background: #26B99A; text-align: center;">Monto</th>
                                <th style="color: #FFF;background: #26B99A; text-align: center;">Fecha transacción</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_tpl_vars['formas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <tr>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['forma']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['monto']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['fecha']; ?>
&nbsp;</td>  
                                </tr>
                                <?php endforeach; endif; unset($_from); ?>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>


                </div>




            </div>

            <script type="text/javascript" src="../html/es/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>


            <script type="text/javascript" src="../html/es/js/dataTable.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#tabla1').DataTable({
                      "scrollX": "100%"
                    });
                });

                $(document).ready(function() { 
                    tabla();
                });


                function tabla(){

                      var asInitVals = new Array();
                      var oTable;

                        if ( $.fn.dataTable.isDataTable( '#tabla2' ) ) {
                            oTable = $('#tabla2').DataTable();
                            oTable.destroy();
                        }
                            
                             oTable = $('#tabla2').DataTable({
                                "scrollY": "100px",
                                "retrieve": false,
                                "responsive": true,
                                "oLanguage": {
                                    "sSearch": "Search all columns:",
                                },
                                "processing": true,
                                "serverSide": true,
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