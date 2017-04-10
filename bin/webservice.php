<?php
 	require_once ("../etc/config.php");
 	//require_once ("../phpMailer/class.phpmailer.php");
	ini_set('memory_limit', '-1');
	$config  = Zend_Registry::get('config');

	if ($auth->hasIdentity()) { 
		$acciones = array(
							'listar'	=> 'listar',
							'agregar'	=> 'actualizar',
							'editar'	=> 'actualizar',
							'eliminar'	=> 'eliminar',
							'guardar'	=> 'guardar'
						 );

		$usuarios = $db->select();
	    $usuarios->from('usuario','usuario_id');
	    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
	    $usuario = $db->fetchAll($usuarios);
	    $ide = $usuario[0]['usuario_id'];

	    $credito = $db->select();
	    $credito->from('credito','(credito_valor - credito_retenido) as credito_valor');
	    $credito->where("usuario_id='".$ide."'");
	    $creditos = $db->fetchAll($credito);
	    $dinero = $creditos[0]['credito_valor'];


	    if(isset($dinero)){
	      $smarty->assign('credito', $dinero);
	    }else{
	      $smarty->assign('credito', 0.00);
	    }


		$smarty->assign('application', $config->application);
		$smarty->assign('activo',$_SESSION["activo"]);
		$smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001507983-Broadcaster-Hacer-un-env%C3%ADo-por-medio-API-Web-Service");
		$smarty->display('header.html');

		if(!isset($_REQUEST['accion'])) { //Si no se ha enviado una accion
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

	/*
	$acciones = array(
							'listar'	=> 'listar',
							'agregar'	=> 'actualizar',
							'editar'	=> 'actualizar',
							'eliminar'	=> 'eliminar',
							'guardar'	=> 'guardar'
						 );

		$smarty->assign('application', $config->application);
	 	$smarty->display('header.html');

		


    if(!isset($_REQUEST['accion'])) { //Si no se ha enviado una accion
	 		listar();
	 	} else { //Si hay una accion, ejecutarla
	 		while( list($k, $v) = each($acciones) ){
	 			if( $k == $_REQUEST['accion'] ){
	 				$v();
	 			}
	 		}
	 	}*/


function listar() {
	$config  	= Zend_Registry::get('config');
	$db 	 	=  Zend_Registry::get('db');
	$session 	= Zend_Registry::get('session'); 
	$smarty 	= Zend_Registry::get('smarty');
	$params 	= Zend_Registry::get('params'); 

	$fechaInicial 	= $_REQUEST['fechaInicial'];
	$fechaFinal 	= $_REQUEST['fechaFinal'];

	if (empty($fechaInicial)){
		$fechaInicial = date ( 'Y/m/d H:i:s' );	
	}
	
	$smarty->assign('fechaInicial', $fechaInicial);	

	//LLENA EL COMBO de DESTINATARIOS
    // $select = $db->select();
    // $query = "Select * from mkthorario where mkthorario_activo = 1 order by mkthorario_nombre";
    // $result = $db->fetchAll($query);
    // $smarty->assign('rows', $result);

    $ws= $db->select();
    $ws->from('clientes_demo');
    $ws->where("cliente_agente ='".$_SESSION["activo"]."'");
    $wss = $db->fetchAll($ws);

    $smarty->assign('nombrecliente', $_SESSION["activo"]);
	$smarty->assign('usuariogenerado', $_SESSION["activo"]);
	$smarty->assign('urlgenerada', $wss[0]['cliente_url']);

	$smarty->display('webservice.html');
 }


 function guardar() {
	$config  	= Zend_Registry::get('config');
	$db 	 	=  Zend_Registry::get('db');
	$session 	= Zend_Registry::get('session'); 
	$smarty 	= Zend_Registry::get('smarty');
	$params 	= Zend_Registry::get('params');

	$logger = new Zend_Log ();
	$filename = date ( 'Ymd' );
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/registrarUsuarios_$filename.log";
	$writer = new Zend_Log_Writer_Stream ( $filename, 'ab' );
	$logger->addWriter ( $writer );
	$filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
	$logger->addFilter ( $filter );

	$hora = date ( 'Y/m/d H:i:s' );
	$logger->log ( ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO );
	$logger->log ( ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO );
	$logger->log ( ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO );
	$logger->log ( ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>INICIO REGISTRO DE USUARIOS: $hora", Zend_Log::INFO );
	$logger->log ( "REQUEST" . print_r ( $_REQUEST, true ), Zend_Log::INFO ); 
	$bandera = 0;

    /**RECUPERANDO ARGUNMENTOS PARA EL GUARDADO*/
    $nombre 		= $_SESSION["activo"];
    $descripcion    = " ";
    $user 			= $_SESSION["activo"];
    $registro 		= $_SESSION["activo"];
    /*FIN DE RECUPERACION PARA EL GUARDADO*/

    $tag = uniqid();


    $logger->log("NOMBRE: ".print_r($nombre,true), Zend_Log::INFO);
	$logger->log("DESCRIPCION: ".print_r($descripcion,true), Zend_Log::INFO);
	$logger->log("USUARIO".print_r($user,true), Zend_Log::INFO);


	$usuario = $user;
	$logger->log("USUARIO FORMADO: ".print_r($usuario,true), Zend_Log::INFO);

	//$urlgenerada = 'http://broadcaster.cm-operations.com/dashboard/demos/bin/login.php';
	$urlgenerada = 'http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/tu_empresa.php?msisdn=XXXXXXXXXX&message=MESSAGE&tag=EXAMPLE&idu='.$tag.'&user='.$usuario;
	$logger->log("URL GENERADA: ".print_r($urlgenerada,true), Zend_Log::INFO);

	$ws= $db->select();
    $ws->from('clientes_demo');
    $ws->where("cliente_agente ='".$_SESSION["activo"]."'");
    $wss = $db->fetchAll($ws);

    if(count($wss)<=0){
       try {
				$datos=array(
			        			'cliente_nombre'         	=> $nombre,
			        			'cliente_descripcion'		=> $descripcion,
			        			'cliente_url'				=> $urlgenerada,
			        			'cliente_usuario'         	=> $usuario,
			        			'cliente_agente'			=> $registro,
			        			'cliente_fecha'        		=> date("Y/m/d H:i:s"),
			        			'cliente_activo'       		=> 1
			     			);
	    
	    		$logger->log("DATOS A INSERTAR EN LA BASE CLIENTES DEMO: ".print_r($datos,true), Zend_Log::INFO);
	    		$insert = $db -> insert("clientes_demo", $datos);
				$logger->log ( "SE INSERTO: ". print_r($insert, true), Zend_Log::INFO );
				$smarty->assign('alerta', '1');
				$bandera = 1;
		} catch (Exception $e) {
					$smarty->assign('alerta', '2');
		}
    }else{
    	$smarty->assign('alerta', '3');
    }

 

	if($bandera == 1){
		$smarty->assign('nombrecliente', $nombre);
		$smarty->assign('descripcioncliente', $descripcion);
		$smarty->assign('usuariogenerado', $usuario);
		$smarty->assign('urlgenerada', $urlgenerada);
		$smarty->display('webservice.html');
	}else{
		$smarty->assign('nombrecliente', $nombre);
		$smarty->assign('descripcioncliente', $descripcion);
		$smarty->assign('usuariogenerado', $usuario);
		$smarty->assign('urlgenerada', $wss[0]['cliente_url']);
		$smarty->display('webservice.html');
	}
	


 
    //listar();
	//$smarty->display('programar_envio.html');
	$logger->log ( "Fin: $hora", Zend_Log::INFO );
 }





?>