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

            $usuarios = $db->select();
		    $usuarios->from('usuario');
		    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
		    $usuario = $db->fetchAll($usuarios);
		    $ide = $usuario[0]['usuario_id'];

		    $smarty->assign('correo', $usuario[0]['usuario_login']);

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
	          $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001430746-Broadcaster-Agregar-saldo-a-mi-cuenta-");
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

	$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    $smarty->assign('ide',$ide);

    $formas = array();

	$mo = $db->select();
	$mo->from('mo_sms');
	$mo->where("contenido='sms ".$ide."'");
	$mos = $db->fetchAll($mo);

	foreach ($mos as $key => $v) {
		$formas[$key] = array('forma' => 'SMS', 
			                    'monto' => '-',
			                    'fecha' => $v['fecha']
			                    );

		$llave = $key;
	}

	/*$smarty->assign('mos',$mos);*/

	$facil = $db->select();
	$facil->from('pago_facil');
	$facil->where("usuari_id = '".$ide."'");
	$faciles = $db->fetchAll($facil);

	foreach ($faciles as $key => $v) {
		$formas[$llave+1] = array('forma' => 'Tarjeta', 
			                    'monto' => "$".$v['cantidad'],
			                    'fecha' => $v['fecha']
			                    );
	}

	$smarty->assign('formas',$formas);

	$smarty -> display("payment.html");
}
?>