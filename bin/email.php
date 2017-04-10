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
		                         'eliminar'	=> 'eliminar',
		                         'enviar'	=> 'enviar'
	                           );

            $usuarios = $db->select();
		    $usuarios->from('usuario','usuario_id');
		    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
		    $usuario = $db->fetchAll($usuarios);
		    $ide = $usuario[0]['usuario_id'];

		    $smarty->assign('ide', $ide);

		    $smarty->assign('usuario', $_SESSION["activo"]);

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

			$querycampaign = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
		    $resultcampaign = $db->fetchAll($querycampaign);
		    $smarty->assign('campanas', $resultcampaign);

	          $smarty->assign('application', $config->application);
	          $smarty->assign('activo',$_SESSION["activo"]);
	          $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001554466-Broadcaster-Hacer-un-env%C3%ADo-por-medio-de-un-correo-electr%C3%B3nico-");
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


function listar($flag=0){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');

	$smarty -> display("email.html");
}

?>