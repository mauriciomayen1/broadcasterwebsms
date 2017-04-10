<?php
   ini_set("display_errors","1");
	ini_set('max_execution_time', 600); //600 seconds = 10 minutes
	set_time_limit(0); 
	error_reporting(E_ALL & ~E_NOTICE);
	require_once ('/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/etc/config.php');

	$config     = Zend_Registry::get('config');
	$db         = Zend_Registry::get('db');


	$logger   = new Zend_Log ();
	$filename = date ( 'Ymd' );	
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Recarga_" . "$filename.log";
	$writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
	$logger->addWriter ( $writer );
	$hora = date ( 'Y/m/d H:i:s' );
	$dia  = date ('Y-m-d');
	$logger->log ("-----------------------------------------------------------------------------", Zend_Log::INFO );
	$logger->log ("-----------------------------------------------------------------------------", Zend_Log::INFO );
	$logger->log ("--------------- INICIO DE RECARGA-----------------------", Zend_Log::INFO );
	$logger->log ("INICIO: $hora", Zend_Log::INFO );
	$logger->log ("REQUEST: ".print_r($_REQUEST,true), Zend_Log::INFO);	


	$msisdn 	  = $_REQUEST['SOA']; 
	$carrier	  = $_REQUEST['carrier'];
	$smscid	      = $_REQUEST['smscId'];
	$contenido    = explode(' ', $_REQUEST['Content']);
	$ide = $contenido[1];

	///////////INSERTANDO MO
    try{
    	$mo = array(
				        'msisdn'     => $msisdn,
				        'fecha'      => date("Y-m-d H:i:s"),
				        'contenido'  => $_REQUEST['Content'],
				        'operador'   => $carrier
				    );
		$logger->log ( "DATOS MO:: " . print_r ( $mo, true ), Zend_Log::INFO );
		$inserto_mo = $db->insert('mo_sms', $mo);
		$logger->log("INSERTO MO:: ".print_r($inserto_mo,true), Zend_Log::INFO);	
	}catch(Exception $e){
		$logger->log("EXCEPCION CAPTURADA INSERCION MO:: ".print_r($e,true), Zend_Log::INFO);
	}



    $select = $db->select();
	$select->from('usuario','usuario_id');
	$select->where("usuario_id ='".$ide."'");
	$data = $db->fetchAll($select);
    $id = $data[0]['usuario_id'];

    $select2 = $db->select();
	$select2->from('credito','credito_valor');
	$select2->where("usuario_id ='".$id."'");
	$data2 = $db->fetchAll($select2);
    $credito = $data2[0]['credito_valor'];

    $credito = ($credito+5.22);

    if(isset($id) && isset($credito)){
    	$data_cr=array(
		        		'credito_valor'      => $credito
		    		   );

		$logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
		$update = $db->update('credito',$data_cr,"usuario_id ='".$id."'");
		$logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO); 

		$url = 'http://localhost:13013/cgi-bin/sendsms?username=%s&password=kaiser&to=%s&text=%s';
		$url    = sprintf($url, "sendsmstelcel_77700", "52".$msisdn, urlencode("La recarga de su credito fue existosa. Se han añadido 5.22 MXN a tu saldo\nhttp://www.broadcastersms.com"));
		$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );

		try{
			$req =& new HTTP_Request($url);
			if (!PEAR::isError($req->sendRequest())) {
			     $response1 = $req->getResponseBody();
			} else {
			     $response1 = "";     
			}

			$logger->log("response:: ".print_r($response1,true), Zend_Log::INFO);

			$response1 = '0: Accepted for delivery';

			if ($response1 == '0: Accepted for delivery') {
				$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
				$XMLFILE .= "<status>OK</status>";
				
				$logger->log("return: ".$XMLFILE, Zend_Log::INFO);

				#INSERTA MT 
				$data_mt=array(
			        		'mt_servicio'	=> "RECARGA",
			        		'mt_marcacion' 	=> "77700",
			        		'mt_operador' 	=> $carrier,
			        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
			        		'mt_msisdn'     => $msisdn,
			        		'mt_contenido'  => "La recarga de su crédito fue existosa",
			        		'mt_fecha'      => date('Y-m-d H:i:s'),
			        		'mt_tag'		=> "mail",
			        		'usuario_id'    => $ide
			    		   );
				$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
				$insert = $db->insert('mt_sms',$data_mt);
				$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);    
				echo "200";


			
			}else{
				$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
				$XMLFILE .= "<status>ERROR</status>";
				echo "500"; 
				$logger->log("return: ".$XMLFILE, Zend_Log::INFO);
			}
			//echo $XMLFILE
			 		
		}catch(Exception $e){
			$logger->log("Exception". print_r($e, true), Zend_Log::INFO);
			echo "500"; 
		}
    }else{

    	$url = 'http://localhost:13013/cgi-bin/sendsms?username=%s&password=kaiser&to=%s&text=%s';
		$url    = sprintf($url, "sendsmstelcel_77700", "52".$msisdn, urlencode("La recarga no se pudo hacer. Contacte a su administrador\nhttp://www.broadcastersms.com"));
		$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );

		try{
			$req =& new HTTP_Request($url);
			if (!PEAR::isError($req->sendRequest())) {
			     $response1 = $req->getResponseBody();
			} else {
			     $response1 = "";     
			}

			$logger->log("response:: ".print_r($response1,true), Zend_Log::INFO);

			$response1 = '0: Accepted for delivery';

			if ($response1 == '0: Accepted for delivery') {
				$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
				$XMLFILE .= "<status>OK</status>";
				
				$logger->log("return: ".$XMLFILE, Zend_Log::INFO);

				#INSERTA MT 
				$data_mt=array(
			        		'mt_servicio'	=> "RECARGA",
			        		'mt_marcacion' 	=> "77700",
			        		'mt_operador' 	=> $carrier,
			        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
			        		'mt_msisdn'     => $msisdn,
			        		'mt_contenido'  => "La recarga no se pudo hacer. Contacte a su administrador",
			        		'mt_fecha'      => date('Y-m-d H:i:s'),
			        		'mt_tag'		=> "mail",
			        		'usuario_id'    => $ide
			    		   );
				$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
				$insert = $db->insert('mt_sms',$data_mt);
				$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);    
				echo "200";


			
			}else{
				$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
				$XMLFILE .= "<status>ERROR</status>";
				echo "500"; 
				$logger->log("return: ".$XMLFILE, Zend_Log::INFO);
			}
			//echo $XMLFILE
			 		
		}catch(Exception $e){
			$logger->log("Exception". print_r($e, true), Zend_Log::INFO);
			echo "500"; 
		}
    }

	$logger->log ("FIN::::::... ", Zend_Log::INFO);

?>