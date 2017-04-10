<?php /* Smarty version 2.6.13, created on 2015-01-12 12:32:29
         compiled from mo.html */ ?>
		
	<div align="right" style="padding-right:140px; vertical-align:baseline;" class="form-inline">
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
			

			<button  class="btn btn-primary" id="consultar" name="consultar" style="background-color:#0074c8; border-color:#0074c8;">
			    Consultar
			</button>
		  </form>
				<form action="reporteMo_excel.php" method="post" target="_blank">
		  		<button  class="btn btn-primary"  name="exportar" value="<?php echo $this->_tpl_vars['query']; ?>
" style="background-color:#ec9a21; border-color:#ec9a21;" >
		  		<i class="glyphicon glyphicon-download-alt icon-white"></i>
		 		 Exportar
	     		</button>
				</form>

	</div>

<div class="datacontainer">
<div class="row">
	<div class="box col-md-12">
	  <h1>
	  <font color="#39a6f5">
          	Provoto - MO's
          </font>
	  </h1>
	
	<div class="box-inner">
	<div >
		<table class="table table-striped table-bordered bootstrap-datatable datatable responsive order" id="Exportar_a_Excel" style="font-size:12px;" align="center">
		    <thead>
		    <tr class="info">
		        <th style="color: #FFF;background: #989898;">Mensaje</th>
		        <th style="color: #FFF;background: #989898;">Fecha</th>
		        <th style="color: #FFF;background: #989898;">Msisdn</th>
		        <th style="color: #FFF;background: #989898;">Smscid</th>	
		    </tr>
		    </thead>
		    <tbody>
		    <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
		    <tr>
		        <td class="center"><?php echo $this->_tpl_vars['row']['mo_mensaje']; ?>
&nbsp;</td>
		        <td class="center"><?php echo $this->_tpl_vars['row']['mo_fecha']; ?>
&nbsp;</td>
		        <td class="center"><?php echo $this->_tpl_vars['row']['mo_msisdn']; ?>
&nbsp;</td>
		        <td class="center"><?php echo $this->_tpl_vars['row']['marcacion']; ?>
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
 </div>
</div>

<!-- jQuery UI -->
	<script src="../html/es/js/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="../html/es/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../html/es/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	
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

	<!-- transition / effect library -->
	<script src="../html/es/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="../html/es/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="../html/es/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="../html/es/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="../html/es/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="../html/es/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="../html/es/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="../html/es/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="../html/es/js/bootstrap-button.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="../html/es/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="../html/es/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="../html/es/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="../html/es/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='../html/es/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='../html/es/js/jquery.dataTables.min.js'></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="../html/es/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="../html/es/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="../html/es/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="../html/es/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="../html/es/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="../html/es/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="../html/es/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="../html/es/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="../html/es/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="../html/es/js/jquery.history.js"></script>

	<!-- select or dropdown enhancer -->
	<script src="../html/es/js/jquery.chosen.min.js"></script>
	<!-- application script for Charisma demo -->
	<script src="../html/es/js/charisma.js"></script>
</body>	
</html>