<?php /* Smarty version 2.6.20, created on 2017-04-07 10:32:35
         compiled from approve.html */ ?>

            <div class="right_col" role="main">

                <div class="page-title">
                        <div class="title_left">
                            <h1>
                                <b>Costos</b>
                            </h1>
                            <hr>
                             <br>
                        </div>
                </div>
                    <div class="clearfix"></div>


                <div class="row x_igual">


                    <div class="col-md-12">
                        <div class="x_panel tile fixed_height_320 bigger">
                            <div class="x_content">
                                <form role="form" action="approve.php" method="POST">
                       <button class="btn btn-default submit" type="submit">
                                Guardar
                        </button>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive order" style="font-size:9px;" align="center" id="tabla1">
                            <thead>
                            <tr class="info">
                                <th style="color: #FFF;background: #989898;">Usuario</th>
                                <th style="color: #FFF;background: #989898;">Costo SMS TELCEL</th>
                                <th style="color: #FFF;background: #989898;">Costo SMS MOVISTAR</th>
                                <th style="color: #FFF;background: #989898;">Costo SMS AT&T</th>
                                <th style="color: #FFF;background: #989898;">Costo Perfil TELCEL</th>
                                <th style="color: #FFF;background: #989898;">Costo Perfil MOVISTAR</th>
                                <th style="color: #FFF;background: #989898;">Costo Perfil AT&T</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_tpl_vars['costos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <tr>
                                    <td class="center"><?php echo $this->_tpl_vars['row']['usuario_nombre']; ?>
&nbsp;</td>
                                    <td class="center"><input type="text" name="ide[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_valor']; ?>
"></td>
                                    <td class="center"><input type="text" name="ide2[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_valor2']; ?>
"></td>
                                    <td class="center"><input type="text" name="ide3[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_valor3']; ?>
"></td>
                                    <td class="center"><input type="text" name="ide4[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_perfil']; ?>
"></td>
                                    <td class="center"><input type="text" name="ide5[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_perfil2']; ?>
"></td>
                                    <td class="center"><input type="text" name="ide6[<?php echo $this->_tpl_vars['row']['usuario_id']; ?>
]" value="<?php echo $this->_tpl_vars['row']['costo_perfil3']; ?>
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

                            <div class="col-md-12">
                                <br>
                            </div>
                        </div>
                    </div>

                </div>




            </div>

   <script type="text/javascript" src="../html/es/js/dataTable.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    /*$('#tabla2').DataTable();*/
                    $('#tabla1').DataTable();
                });
            </script>

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