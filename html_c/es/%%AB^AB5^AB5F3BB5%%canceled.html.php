<?php /* Smarty version 2.6.20, created on 2017-03-24 12:42:29
         compiled from canceled.html */ ?>
<style type="text/css">
    #tabla1_paginate{
        margin-left: 550px;
        position: absolute;
    }
</style>
            <div class="right_col" role="main">

                <div class="">
                    <div class="clearfix"></div>





                    <div class="col-md-12  row2">
            <div class="col-md-12 up">
                <div class="page-title">
                                    <div class="title_left">
                                        <h1>
                                            <b>Envíos Programados</b>
                                        </h1>
                                        <hr>
                                         <br>
                                    </div>
                            </div>
                <div class="col-md-12">
                    <div class="x_panel up2">
                        <div class="x_content">
                    <form role="form" action="canceled.php" method="POST">
                       <button class="btn btn-danger submit" type="submit" id="cancelaa2">
                                Cancelar
                        </button>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive order" style="font-size:15px;" align="center" id="tabla1">
                            <thead>
                            <tr class="info">
                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Campaña</th>
                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Horario</th>
                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Fecha</th>
                                <th class="center" style="color: #FFF;background: #26B99A; text-align: center;">Cancelar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_tpl_vars['programados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <tr>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_region']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_horarionombre']; ?>
&nbsp;</td>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['mensaje_fechaenvio']; ?>
&nbsp;</td>
                                    <td class="center"><input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['mensaje_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['mensaje_id']; ?>
"></td>
                                    <!-- <td class="center">
                                <?php if ($this->_tpl_vars['row']['costo_check'] == 'SI'): ?>
                                     <input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
" checked>
                                <?php else: ?>
                                     <input type="checkbox" name="ide[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
">
                                     <input type='hidden' value='No' name='ide[]'>
                                <?php endif; ?>
                                </td> -->
                                <!-- <td class="center">
                                <?php if ($this->_tpl_vars['row']['costo_check2'] == 'SI'): ?>
                                     <input type="checkbox" name="ide2[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
" checked>
                                <?php else: ?>
                                     <input type="checkbox" name="ide2[<?php echo $this->_tpl_vars['row']['costo_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_id']; ?>
">
                                     <input type='hidden' value='No' name='ide2[]'>
                                <?php endif; ?>
                                    </td> -->
                                </tr>
                                <?php endforeach; endif; unset($_from); ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="accion" value="guardar"/>
                    </form>
                    </div>

                 </div>
                 </div>
                 </div>
                 </div>
                </div>


            </div>

    <script type="text/javascript">

        $('form').submit(function () {
            $(this).find('input[type="checkbox"]').each( function () {
                var checkbox = $(this);
                if( checkbox.is(':checked')) {
/*                    checkbox.attr('value','1');*/
                } else {
                    checkbox.after().append(checkbox.clone().attr({type:'hidden', value:"NO"}));
                    checkbox.prop('disabled', true);
                }
            })
        });
    </script>

    <script type="text/javascript" src="../html/es/js/dataTable.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#tabla2').DataTable({
                      "scrollY": "100px"
                    });
                    $('#tabla1').DataTable();
                });
            </script>