<?php

require_once ("../etc/config.php");
ini_set('memory_limit', '-1');
$config  = Zend_Registry::get('config');

if($auth->hasIdentity()){ 
	$acciones = array(
						'listar'	=> 'listar',
		                'agregar'	=> 'actualizar',
		                'editar'	=> 'actualizar',
		                'eliminar'	=> 'eliminar'
	                 );

	$smarty->assign('application', $config->application);
	$smarty->display('header.html');

	if(!isset($_REQUEST['accion'])){ 
		listar();
	}else{ //Si hay una accion, ejecutarla
		while( list($k, $v) = each($acciones) ){
			    if($k == $_REQUEST['accion']){
				     $v();
			    }
		}
	}
	//$smarty->display('footer.html');
}else{
    header("Location: login.php");
}


function listar() {
	$config     = Zend_Registry::get('config');
	$db 	    = Zend_Registry::get('db');
	$session    = Zend_Registry::get('session'); 
	$smarty 	= Zend_Registry::get('smarty');
	$params 	= Zend_Registry::get('params'); 

	$logger   = new Zend_Log ();
	$filename = date ( 'Ymd' );
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/EnvioProg_$filename.log";
	$writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
	$logger->addWriter ( $writer );
	$filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
	$logger->addFilter ( $filter );

	$hora = date ( 'Y/m/d H:i:s' );
	$logger->log ( "---------------------------------------------------", Zend_Log::INFO );
	$logger->log ( "---------------------------------------------------", Zend_Log::INFO );
	$logger->log ( "---------------------------------------------------", Zend_Log::INFO );
	$logger->log ( "----REPORTE ENVIOS PROGRAMADOS - FN LISTAR---------", Zend_Log::INFO );

	$logger->log ( "REQUEST: " . print_r ( $_REQUEST, true ), Zend_Log::INFO );

	$fechaInicial = $_REQUEST['fechaInicial'];
	$fechaFinal   = $_REQUEST['fechaFinal'];

	if(empty($fechaInicial)){
		$fechaInicial = date('Y-m-d');	
	}
	
	if(empty($fechaFinal)){
		$fechaFinal = date('Y-m-d 23:59:59');
        $fechaFinal2 = date('Y-m-d');
	}else{
		$fechaFinal2 = $fechaFinal;
		$fechaFinal = $fechaFinal.' 23:59:59';
	}
	
	$smarty->assign('fechaInicial', $fechaInicial);	
	$smarty->assign('fechaFinal', $fechaFinal2);

	$q = "SELECT * FROM fuentes_mensajes_programados_toolbox WHERE mensaje_fechaalta BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' ORDER BY mensaje_fechaalta DESC";
	$result = $db->fetchAll($q);
	$smarty->assign('rows', $result);
	$smarty->display('sendp.html');
	
 }

 function eliminar(){
 	$config     = Zend_Registry::get('config');
	$db 	    = Zend_Registry::get('db');
	$session    = Zend_Registry::get('session'); 
	$smarty 	= Zend_Registry::get('smarty');
	$params 	= Zend_Registry::get('params'); 

	$config  = Zend_Registry::get('config');
	$db 	 =  Zend_Registry::get('db');
	$session = Zend_Registry::get('session'); 
	$smarty 	= Zend_Registry::get('smarty'); 

	$logger   = new Zend_Log ();
	$filename = date ( 'Ymd' );
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/EnvioProg_$filename.log";
	$writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
	$logger->addWriter ( $writer );
	$filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
	$logger->addFilter ( $filter );

	$hora = date ( 'Y/m/d H:i:s' );
	$logger->log ( "---------------------------------------------------", Zend_Log::INFO );
	$logger->log ( "---------------------------------------------------", Zend_Log::INFO );
	$logger->log ( "---------------------------------------------------", Zend_Log::INFO );
	$logger->log ( "----REPORTE ENVIOS PROGRAMADOS - FN ELIMINAR---------", Zend_Log::INFO );

	$logger->log ( "REQUEST: " . print_r ( $_REQUEST, true ), Zend_Log::INFO );

	$idEliminar = $_REQUEST['idEliminar'];
	$logger->log ( "EL ID A ELIMINAR ES::.. " . print_r ( $idEliminar, true ), Zend_Log::INFO );

	$query = "SELECT * FROM fuentes_mensajes_programados_toolbox WHERE mensaje_id = '$idEliminar'";
    $result = $db->fetchAll($query);
    $procesado = $result[0]['mensaje_procesado'];

    $logger->log ( "RESULTADO DEL QUERY::.. " . print_r ( $result, true ), Zend_Log::INFO );
    $logger->log ( "MENSAJE PROCESADO::.. " . print_r ( $procesado, true ), Zend_Log::INFO );

    if($procesado == '1'){
    	$logger->log ( "SI ESTA ACTIVO Y SE PUEDE ELIMINAR", Zend_Log::INFO );
    	$data = array(
					'mensaje_procesado'    => 2,	
				);
		$where = 'mensaje_id = "'.$idEliminar.'"';

		$delete = $db->update('fuentes_mensajes_programados_toolbox',$data,$where);

		$logger->log("DATOS A UPDATE EN LA BASE DE MENSAJE PROGRAMADOS: ".print_r($data,true), Zend_Log::INFO);

		$logger->log ( "SE BORRO: ". print_r($delete, true), Zend_Log::INFO );

    }elseif ($procesado == '0') {
    	$logger->log ( "NO SE PUEDE ELIMINAR PORQUE YA ESTA ELIMINADO", Zend_Log::INFO );
    }


	

	$logger->log ( "Fin: $hora", Zend_Log::INFO );
	listar();


 }


?>