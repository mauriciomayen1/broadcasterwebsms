<?php
        require_once ("../etc/config.php");
        ini_set('memory_limit', '-1');
        $config  = Zend_Registry::get('config');

        if ($auth->hasIdentity()) 
           { 
	          $acciones = array(
		                         'listar'	=> 'listar',
		                         'agregar'	=> 'actualizar',
		                         'editar'	=> 'actualizar',
		                         'eliminar'	=> 'eliminar'
	                           );

	          $smarty->assign('application', $config->application);
	          $smarty -> display("header.html");

	          if (!isset($_REQUEST['accion'])) { //Si no se ha enviado una accion
					listar();
				} else { //Si hay una accion, ejecutarla
					while( list($k, $v) = each($acciones) ){
						if( $k == $_REQUEST['accion'] ){
							$v();
						}
					}
				}
} else {
    header("Location: login.php");
}
function listar(){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');

	$smarty -> display("index.html");
}
?>