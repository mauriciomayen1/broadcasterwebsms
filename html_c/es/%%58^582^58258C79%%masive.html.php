<?php /* Smarty version 2.6.20, created on 2017-03-03 12:57:37
         compiled from masive.html */ ?>
<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="row">
                                <?php if ($this->_tpl_vars['mensaje1']): ?>
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <strong>Operación Exitosa!</strong> <?php echo $this->_tpl_vars['mensaje']; ?>
 <?php echo $this->_tpl_vars['base']; ?>
 <?php echo $this->_tpl_vars['mensaje1']; ?>
 <?php echo $this->_tpl_vars['update']; ?>
 <?php echo $this->_tpl_vars['mensaje2']; ?>

                                    </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['mensaje3']): ?>
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <strong><?php echo $this->_tpl_vars['mensaje3']; ?>
</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['error']): ?>
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <strong><?php echo $this->_tpl_vars['error']; ?>
</strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h2>Envío <small>MÁSIVO</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form id="validateForm" data-toggle="validator" role="form" class="form-horizontal form-label-left">
                            <!-- <form method="post" class="form-horizontal form-label-left"> -->
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoría a preparar</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="selectcategoria" id="selectcategoria" class="form-control">
                                        <option>Todos</option>
                                        <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>            
                                          <option value="<?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
"><?php echo $this->_tpl_vars['row']['usuario_categoria']; ?>
</option>
                                        <?php endforeach; endif; unset($_from); ?> 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-dark" name="accion" value="enviar">Preparar</button>
                                    <a href="masivesend.php" class="btn btn-success" role="button">Ir a Envio</a>
                                </div>
                            </div>
                            </form>
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

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<!-- chart js -->
<script src="../html/es/js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="../html/es/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="../html/es/js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="../html/es/js/icheck/icheck.min.js"></script>

<script src="../html/es/js/custom.js"></script>

<!-- moris js -->
<script src="../html/es/js/moris/raphael-min.js"></script>
<script src="../html/es/js/moris/morris.js"></script>
<script src="../html/es/js/moris/example.js"></script>

</body>

</html>