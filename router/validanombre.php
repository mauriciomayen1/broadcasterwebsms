<?php 
	require_once ("../etc/config.php");
	
	$config  = Zend_Registry::get('config');
	$db 	 = Zend_Registry::get('db');
	$params = Zend_Registry::get('params');

	$logger = new Zend_Log();
	$filename = date('Ymd');
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/valida_$filename.log";
	$writer = new Zend_Log_Writer_Stream($filename, 'ab');
	$logger->addWriter($writer);
	$date = date('Y/m/d H:i:s');
	$logger->log("****************************************", Zend_Log::INFO);
	$logger->log("****************************************", Zend_Log::INFO);
	$logger->log("****************************************", Zend_Log::INFO);				
	$logger->log("****************************************FUNCION NOTIFICACIONES.php: $date", Zend_Log::INFO);
	$logger->log("REQUEST: ".print_r($_REQUEST,true),  Zend_Log::INFO);

	$nombre		= $_REQUEST['nombre'];

	$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

	if(isset($ide)){
		$query= "SELECT * FROM usuario WHERE  usuario_nombre='".$nombre."' AND usuario_id !=".$ide.";";
        $result = $db->fetchAll($query);
        $logger->log("Resultado query".print_r($result,true), Zend_Log::INFO);

		if(count($result)<=0){
			echo json_encode(array(
			    'valid' => "true",
			));
		}  
	    else{
	    	echo json_encode(array(
			    'valid' => "false",
			));
	    }

	    exit();

	}

	if (!empty($nombre)) {
		$query= "SELECT * FROM usuario WHERE  usuario_nombre='".$nombre."';";
        $result = $db->fetchAll($query);
        $logger->log("Resultado query".print_r($result,true), Zend_Log::INFO);

		if(count($result)<=0){
			echo json_encode(array(
			    'valid' => "true",
			));
		}  
	    else{
	    	echo json_encode(array(
			    'valid' => "false",
			));
	    }
	       
	}
	

	

?>