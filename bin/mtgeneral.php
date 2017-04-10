<?php
 require_once ("../etc/config.php");
ini_set('memory_limit', '-1');
$config  = Zend_Registry::get('config');

if ($auth->hasIdentity()) { 
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

    $smarty->assign('logotipo', $usuario[0]['foto']);

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

	$querycampaign = "SELECT * FROM usuario WHERE usuario_activo = 1 ORDER BY usuario_nombre ASC";
    $resultcampaign = $db->fetchAll($querycampaign);
    $smarty->assign('rows', $resultcampaign);

	$smarty->assign('application', $config->application);
	$smarty->assign('activo',$_SESSION["activo"]);
	$smarty->display('header.html');
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



function listar() {
	$config  = Zend_Registry::get('config');
	$db 	 =  Zend_Registry::get('db');
	$session = Zend_Registry::get('session'); 
	$smarty 	= Zend_Registry::get('smarty');
	$params 	= Zend_Registry::get('params'); 


	
	$fechaInicial 	= $_REQUEST['fechaInicial'];
	$fechaFinal 	= $_REQUEST['fechaFinal'];

	if (empty($fechaInicial)){
		$fechaInicial = date('Y-m-d');	
	}
	
	if(empty($fechaFinal)){
		$fechaFinal = date('Y-m-d 23:59:59');

		$fechaFinal2 = date('Y-m-d');
	}else {
		$fechaFinal2 = $fechaFinal;
		$fechaFinal = $fechaFinal.' 23:59:59';
		
	}


	
	$smarty->assign('fechaInicial', $fechaInicial);	
	$smarty->assign('fechaFinal', $fechaFinal2);

	$smarty->assign('escogido', $_REQUEST['user']);

	if(isset($_REQUEST['user']) && $_REQUEST['user']!=''){

	    $id = $_REQUEST['user'];

	    $formas = array();
	    $formas2 = array();

		$mo = $db->select();
		$mo->from('mo_sms');
		$mo->where("contenido='sms ".$id."'");
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
		$facil->where("usuari_id = '".$id."'");
		$faciles = $db->fetchAll($facil);

		foreach ($faciles as $key => $v) {
			$formas[$llave+1] = array('forma' => 'Tarjeta', 
				                    'monto' => "$".$v['cantidad'],
				                    'fecha' => $v['fecha']
				                    );
		}


		foreach ($formas as $key => $row)
		{
			$formas2[$key]['fecha'] = $row['fecha'];
		}

		array_multisort($formas2, SORT_DESC, $formas);

		$formas = array_slice($formas, 0, 5);

		/*print_r($formas); die();*/

		$smarty->assign('formas',$formas);

	    $general = $db->select();
		$general->from('mt_sms');
		$general->where("mt_sms.usuario_id ='".$id."' AND mt_servicio IS NULL");
		$general->order('mt_fecha DESC');
		$general->limit(5, 0);
		$bigtotal = $db->fetchAll($general);
	    $smarty->assign('todos', $bigtotal);


		$select = $db->select();
		$select->from('mt_sms','count(*) as total');
		$select->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND usuario_id ='".$id."' AND mt_servicio IS NULL ");
		$total = $db->fetchAll($select);
	    $smarty->assign('total', $total[0]['total']);
		
		$select2 = $db->select();
		$select2->from('mt_sms','count(*) as total');
		$select2->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_operador='Telcel' AND usuario_id ='".$id."' AND mt_servicio IS NULL");
		$total_telcel = $db->fetchAll($select2);
	    $smarty->assign('total_telcel', $total_telcel[0]['total']);


	    $select3 = $db->select();
		$select3->from('mt_sms','count(*) as total');
		$select3->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_operador='Movistar' AND usuario_id ='".$id."' AND mt_servicio IS NULL");
		$total_movistar = $db->fetchAll($select3);
	    $smarty->assign('total_movistar', $total_movistar[0]['total']);

	    $select4 = $db->select();
		$select4->from('mt_sms','count(*) as total');
		$select4->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_operador='Att' AND usuario_id ='".$id."' AND mt_servicio IS NULL");
		$total_iusacell = $db->fetchAll($select4);
	    $smarty->assign('total_iusacell', $total_iusacell[0]['total']);


	    if($total[0]['total']>0){

	    	$porcentaje_telcel = ($total_telcel[0]['total']*100)/$total[0]['total'];
			$porcentaje_movistar = ($total_movistar[0]['total']*100)/$total[0]['total'];
			$porcentaje_iusacell = ($total_iusacell[0]['total']*100)/$total[0]['total'];


			$smarty->assign('porcentaje_iusacell', round($porcentaje_iusacell,0));
			$smarty->assign('porcentaje_movistar', round($porcentaje_movistar,0));
			$smarty->assign('porcentaje_telcel', round($porcentaje_telcel,0));

	    }else{

	    	$porcentaje_telcel = 0;
			$porcentaje_movistar = 0;
			$porcentaje_iusacell = 0;


			$smarty->assign('porcentaje_iusacell', $porcentaje_iusacell);
			$smarty->assign('porcentaje_movistar', $porcentaje_movistar);
			$smarty->assign('porcentaje_telcel', $porcentaje_telcel);
	    }


	    $select5 = $db->select();
		$select5->from('mt_sms','*');
		$select5->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND usuario_id ='".$id."' AND mt_servicio IS NULL");

		


		$smarty->assign('query',  base64_encode($select5->__toString()));



		$selectmo = $db->select();
		$selectmo->from('mt_sms','count(*) as total');
		$selectmo->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND usuario_id='".$id."' AND mt_servicio IS NULL");
		$totals = $db->fetchAll($selectmo);
	    $smarty->assign('totals', $totals[0]['total']);
		
		$selectmo2 = $db->select();
		$selectmo2->from('mt_sms','count(*) as total');
		$selectmo2->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='UNICO' AND usuario_id='".$id."' AND mt_servicio IS NULL");
		$totalsu = $db->fetchAll($selectmo2);
	    $smarty->assign('totalsu', $totalsu[0]['total']);


	    $selectmo3 = $db->select();
		$selectmo3->from('mt_sms','count(*) as total');
		$selectmo3->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='MASIVO' AND usuario_id='".$id."' AND mt_servicio IS NULL");
		$totalsm = $db->fetchAll($selectmo3);
	    $smarty->assign('totalsm', $totalsm[0]['total']);

	    $selectmo4 = $db->select();
		$selectmo4->from('mt_sms','count(*) as total');
		$selectmo4->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='PROGRAMADO' AND usuario_id='".$id."' AND mt_servicio IS NULL");
		$totalsp = $db->fetchAll($selectmo4);
	    $smarty->assign('totalsp', $totalsp[0]['total']);


	    $selectmo5 = $db->select();
		$selectmo5->from('mt_sms','count(*) as total');
		$selectmo5->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='WS' AND usuario_id='".$id."' AND mt_servicio IS NULL");
		$totalws = $db->fetchAll($selectmo5);
	    $smarty->assign('totalws', $totalws[0]['total']);

	    $selectmo6 = $db->select();
		$selectmo6->from('mt_sms','count(*) as total');
		$selectmo6->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='MAIL' AND usuario_id='".$id."' AND mt_servicio IS NULL");
		$totalse = $db->fetchAll($selectmo6);
	    $smarty->assign('totalse', $totalse[0]['total']);


	    if($totalmo[0]['total']>0){

	    	$porcentaje_telcelmo = ($total_telcelmo[0]['total']*100)/$totalmo[0]['total'];
			$porcentaje_movistarmo = ($total_movistarmo[0]['total']*100)/$totalmo[0]['total'];
			$porcentaje_iusacellmo = ($total_iusacellmo[0]['total']*100)/$totalmo[0]['total'];


			$smarty->assign('porcentaje_iusacellmo', round($porcentaje_iusacellmo,0));
			$smarty->assign('porcentaje_movistarmo', round($porcentaje_movistarmo,0));
			$smarty->assign('porcentaje_telcelmo', round($porcentaje_telcelmo,0));

	    }else{

	    	$porcentaje_telcelmo = 0;
			$porcentaje_movistarmo = 0;
			$porcentaje_iusacellmo = 0;


			$smarty->assign('porcentaje_iusacellmo', $porcentaje_iusacellmo);
			$smarty->assign('porcentaje_movistarmo', $porcentaje_movistarmo);
			$smarty->assign('porcentaje_telcelmo', $porcentaje_telcelmo);
	    }
	}else{


	    $formas = array();
	    $formas2 = array();

		$mo = $db->select();
		$mo->from('mo_sms');
		$mo->where('contenido LIKE ?', 'sms%');;
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
		$faciles = $db->fetchAll($facil);

		foreach ($faciles as $key => $v) {
			$formas[$llave+1] = array('forma' => 'Tarjeta', 
				                    'monto' => "$".$v['cantidad'],
				                    'fecha' => $v['fecha']
				                    );
		}


		foreach ($formas as $key => $row)
		{
			$formas2[$key]['fecha'] = $row['fecha'];
		}

		array_multisort($formas2, SORT_DESC, $formas);

		$formas = array_slice($formas, 0, 5);

		/*print_r($formas); die();*/

		$smarty->assign('formas',$formas);

	    $general = $db->select();
		$general->from('mt_sms');
		$general->where("mt_servicio IS NULL");
		$general->order('mt_fecha DESC');
		$general->limit(5, 0);
		$bigtotal = $db->fetchAll($general);
	    $smarty->assign('todos', $bigtotal);


		$select = $db->select();
		$select->from('mt_sms','count(*) as total');
		$select->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_servicio IS NULL ");
		$total = $db->fetchAll($select);
	    $smarty->assign('total', $total[0]['total']);
		
		$select2 = $db->select();
		$select2->from('mt_sms','count(*) as total');
		$select2->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_operador='Telcel' AND mt_servicio IS NULL");
		$total_telcel = $db->fetchAll($select2);
	    $smarty->assign('total_telcel', $total_telcel[0]['total']);


	    $select3 = $db->select();
		$select3->from('mt_sms','count(*) as total');
		$select3->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_operador='Movistar' AND mt_servicio IS NULL");
		$total_movistar = $db->fetchAll($select3);
	    $smarty->assign('total_movistar', $total_movistar[0]['total']);

	    $select4 = $db->select();
		$select4->from('mt_sms','count(*) as total');
		$select4->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_operador='Att' AND mt_servicio IS NULL");
		$total_iusacell = $db->fetchAll($select4);
	    $smarty->assign('total_iusacell', $total_iusacell[0]['total']);


	    if($total[0]['total']>0){

	    	$porcentaje_telcel = ($total_telcel[0]['total']*100)/$total[0]['total'];
			$porcentaje_movistar = ($total_movistar[0]['total']*100)/$total[0]['total'];
			$porcentaje_iusacell = ($total_iusacell[0]['total']*100)/$total[0]['total'];


			$smarty->assign('porcentaje_iusacell', round($porcentaje_iusacell,0));
			$smarty->assign('porcentaje_movistar', round($porcentaje_movistar,0));
			$smarty->assign('porcentaje_telcel', round($porcentaje_telcel,0));

	    }else{

	    	$porcentaje_telcel = 0;
			$porcentaje_movistar = 0;
			$porcentaje_iusacell = 0;


			$smarty->assign('porcentaje_iusacell', $porcentaje_iusacell);
			$smarty->assign('porcentaje_movistar', $porcentaje_movistar);
			$smarty->assign('porcentaje_telcel', $porcentaje_telcel);
	    }


	    $select5 = $db->select();
		$select5->from('mt_sms','*');
		$select5->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_servicio IS NULL");

		


		$smarty->assign('query',  base64_encode($select5->__toString()));



		$selectmo = $db->select();
		$selectmo->from('mt_sms','count(*) as total');
		$selectmo->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_servicio IS NULL");
		$totals = $db->fetchAll($selectmo);
	    $smarty->assign('totals', $totals[0]['total']);
		
		$selectmo2 = $db->select();
		$selectmo2->from('mt_sms','count(*) as total');
		$selectmo2->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='UNICO' AND mt_servicio IS NULL");
		$totalsu = $db->fetchAll($selectmo2);
	    $smarty->assign('totalsu', $totalsu[0]['total']);


	    $selectmo3 = $db->select();
		$selectmo3->from('mt_sms','count(*) as total');
		$selectmo3->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='MASIVO' AND mt_servicio IS NULL");
		$totalsm = $db->fetchAll($selectmo3);
	    $smarty->assign('totalsm', $totalsm[0]['total']);

	    $selectmo4 = $db->select();
		$selectmo4->from('mt_sms','count(*) as total');
		$selectmo4->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='PROGRAMADO' AND mt_servicio IS NULL");
		$totalsp = $db->fetchAll($selectmo4);
	    $smarty->assign('totalsp', $totalsp[0]['total']);


	    $selectmo5 = $db->select();
		$selectmo5->from('mt_sms','count(*) as total');
		$selectmo5->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='WS' AND mt_servicio IS NULL");
		$totalws = $db->fetchAll($selectmo5);
	    $smarty->assign('totalws', $totalws[0]['total']);

	    $selectmo6 = $db->select();
		$selectmo6->from('mt_sms','count(*) as total');
		$selectmo6->where("mt_fecha BETWEEN '$fechaInicial 00:00:00' AND '$fechaFinal 23:59:59' AND mt_tag='MAIL' AND mt_servicio IS NULL");
		$totalse = $db->fetchAll($selectmo6);
	    $smarty->assign('totalse', $totalse[0]['total']);


	    if($totalmo[0]['total']>0){

	    	$porcentaje_telcelmo = ($total_telcelmo[0]['total']*100)/$totalmo[0]['total'];
			$porcentaje_movistarmo = ($total_movistarmo[0]['total']*100)/$totalmo[0]['total'];
			$porcentaje_iusacellmo = ($total_iusacellmo[0]['total']*100)/$totalmo[0]['total'];


			$smarty->assign('porcentaje_iusacellmo', round($porcentaje_iusacellmo,0));
			$smarty->assign('porcentaje_movistarmo', round($porcentaje_movistarmo,0));
			$smarty->assign('porcentaje_telcelmo', round($porcentaje_telcelmo,0));

	    }else{

	    	$porcentaje_telcelmo = 0;
			$porcentaje_movistarmo = 0;
			$porcentaje_iusacellmo = 0;


			$smarty->assign('porcentaje_iusacellmo', $porcentaje_iusacellmo);
			$smarty->assign('porcentaje_movistarmo', $porcentaje_movistarmo);
			$smarty->assign('porcentaje_telcelmo', $porcentaje_telcelmo);
	    }
	}

	


	$smarty->display('mtgeneral.html');
	$smarty->display('footer.html');
	
 }





?>