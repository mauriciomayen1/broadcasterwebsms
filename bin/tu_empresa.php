<?php
	ini_set("display_errors","1");
	error_reporting(E_ALL & ~E_NOTICE);
	require_once ('../etc/config.php');

	$config     = Zend_Registry::get('config');
	$db         = Zend_Registry::get('db');

    $logger   = new Zend_Log();
    $filename = date('Ymd');
    $filename = '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/enviosWS_'.$filename.'.log';
    $writer   = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);

    $hora = date('Y/m/d H:i:s');
    $logger->log("->->->->->->->->->->->->->->->->->->->->", Zend_Log::INFO);
    $logger->log("->->->->->->->->->->->->->->->->->->->->", Zend_Log::INFO);
    $logger->log("->->->->->->->->->->->->->->->->->->->->", Zend_Log::INFO);               
    $logger->log("->->->->->->->->->->->->->->->->->->->-> FUNCION URL MT WS: $hora", Zend_Log::INFO);
    $logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);
    $banderabd = 0;
    $banderaenvio = 0;

    $ip = $_SERVER['REMOTE_ADDR'];
    $logger->log ( "IP::: ". print_r($ip, true), Zend_Log::INFO );
    
    $msisdn   = $_REQUEST['msisdn'];
	$sms      = trim($_REQUEST['message']);
	$tag	  = $_REQUEST['tag'];
	$idu	  = $_REQUEST['idu'];
	$usuario     = $_REQUEST['user'];

	$sms = (string)strip_tags($sms);
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöúûýý';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnooooouuyy';
    $sms = utf8_decode($sms);

    $sms = strtr($sms, utf8_decode($originales), $modificadas);

	$logger->log ( "MSISDN::: ". print_r($msisdn, true), Zend_Log::INFO );
	$logger->log ( "SMS::: ". print_r($sms, true), Zend_Log::INFO );
	$logger->log ( "TAG::: ". print_r($tag, true), Zend_Log::INFO );
	$logger->log ( "USER::: ". print_r($usuario, true), Zend_Log::INFO );

	/*BUSCAMOS SI EL USUARIO SE ENCUENTRA EN LA BASE Y ADEMAS ACTIVO*/
	$query1 = "Select count(*) as total from clientes_demo where cliente_usuario like '$usuario' and cliente_activo = 1";
	$logger->log ( "QUERY BUSQUEDA::: ". print_r($query1, true), Zend_Log::INFO );
	$result = $db->fetchAll($query1);
	$cantidad = $result[0]['total'];
	$logger->log ( "LAS COINCIDENCIAS QUE SE ENCONTRARON EN clientes_demo FUERON::: ". print_r($cantidad, true), Zend_Log::INFO );
	/* FIN DE BUSCAR EN LA BASE*/
	/*echo $usuario."hola"; die();*/ 
	if($cantidad > 0){
		$logger->log("SI ES UN USUARIO ACTIVO.", Zend_Log::INFO);

		$usuarios = $db->select();
	    $usuarios->from('usuario','usuario_id');
	    $usuarios->where("usuario_nombre ='".$usuario."'");
	    $usuario = $db->fetchAll($usuarios);
	    $ide = $usuario[0]['usuario_id'];

		$creditos = $db->select();
	    $creditos->from('credito','credito_valor,(credito_valor-credito_retenido) as creditovalor');
	    $creditos->where("usuario_id ='".$ide."'");
	    $credito = $db->fetchAll($creditos);
	    $valor = $credito[0]['credito_valor'];
	    $valor2 = $credito[0]['creditovalor'];

        /*$gasto = (0.58*$cantidad);*/

		/*if(isset($valor) && $valor>=$gasto){*/

			/*INICIO - PROCESO PARA EL ENVIO DE MENSAJES*/
			/*inicio - eN busca del operador para no pasar por data24*/
			/*BUSCAMOS SI YA SE ENCUENTRA EN BASE DE DATOS*/
			$query1 = "Select count(*) as total from mt_sms where mt_msisdn = '$msisdn'";
			$result = $db->fetchAll($query1);
			$cantidad = $result[0]['total'];
			$logger->log ( "LAS COINCIDENCIAS QUE SE ENCONTRARON EN SMS DEL NUMERO FUERON::: ". print_r($cantidad, true), Zend_Log::INFO );

			$select = $db -> select();
			$select -> from("mt_sms", "*");
			$select -> where("mt_msisdn = '$msisdn'");
			$select -> order("mt_fecha ASC");
			$select -> limit(1);
			$result2 = $db -> fetchAll($select);

			/*if($cantidad > 0){
			   $logger->log("SI SE ENCONTRO EN BASE::..", Zend_Log::INFO);
			   $banderabd = 1;
			   $operador = $result2[0]['mt_operador'];
			   $logger->log ( "Operador::: ". print_r($operador, true), Zend_Log::INFO );

			   $medio = 'Base';
		    }else{*/

		    	$select2 = $db -> select();
				$select2 -> from("motherbase", "*");
				$select2 -> where("msisdn = '$msisdn'");
				$select2 -> limit(1);
				$result3 = $db -> fetchAll($select2);

				if(count($result3)>0){
					$banderabd = 1;
					$operador = $result3[0]['operador'];
					 $medio='BaseMadre';
					 $logger->log("SI SE ENCONTRO EN BASE MOTHERBASE::..", Zend_Log::INFO);
				}

		    /*}*/


			/*if($cantidad > 0 && $banderabd!=1){
			   $logger->log("SI SE ENCONTRO EN BASE MOTHERBASE::..", Zend_Log::INFO);
			   $banderabd = 1;
			   $operador = $result3[0]['operador'];
			   $logger->log ( "Operador::: ". print_r($operador, true), Zend_Log::INFO );

		    }*/
    		/*BUSCAMOS SI YA SE ENCUENTRA EN BASE DE DATOS*/

    		if($banderabd == 0){

		    	$logger->log("ENTRO A DATA 24.", Zend_Log::INFO);
				$medio = 'Data24';

				$username = "miguel.pacheco";
				$password = "operations2015"; 

				$urldata24 = "https://api.data24-7.com/v/2.0?api=C&user=$username&pass=$password&p1=52".$msisdn;
				$logger->log("URL ARMADA   ::".$urldata24 	 , Zend_Log::INFO);
				$xml = simplexml_load_file($urldata24) or die("feed not loading");
				$logger->log("XML ARMADO   ::".$xml 	 , Zend_Log::INFO);

				$client = curl_init();
						  curl_setopt($client, CURLOPT_URL, $urldata24); 
						  curl_setopt($client, CURLOPT_RETURNTRANSFER, 1); 
						  $output = curl_exec($client); 
						  curl_close($client);

				$logger->log("RESPUESTA: ". print_r($output, true), Zend_Log::INFO);
				$id_operador = $xml->results->result->carrier_id;

				$logger->log("NOMBRE DE LA EMPRESA   ::".$xml->results->result->carrier_name 	 , Zend_Log::INFO);
				$logger->log("ID OPERADOR   ::".$id_operador 	 , Zend_Log::INFO);

				$banderabd = 1;

				if($banderabd == 1){
			    	$logger->log("SE ENCONTRO EN BASE DE DATOS.", Zend_Log::INFO);
			    	if($id_operador == '134533'){
			    		$operador = 'telcel';
			    	}
			    	if($id_operador == '138746'){
			    		$operador = 'movistar';
			    	}
			    	if($id_operador == '115405'){
			    		$operador = 'iusacell';
			    	}
			    }


			    /*$url = 'http://administrador.cm-operations.com/mother_base/mx/router/perfila.php?msisdn='.$msisdn;                                                                      
                $req =& new HTTP_Request($url);
                if(!PEAR::isError($req->sendRequest())){
                    $resultado = $req->getResponseBody();

                    $resultados = explode(",", $resultado);

                    $operador = $resultados['1'];
                    $medio = $resultados['0'];
                }else{
                    $operador = "Telcel";
                    $medio = "Perfilado";     
                }*/
    		}


		    $contenido    = urlencode($sms);

			if($operador == 'telcel' || $operador == 'Telcel' || $operador == 'TELCEL'){
				$user = 'sendsmsmt_26262';
		        $smscId = 'telcel_26262';
		        /*$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
		        $url    = sprintf($url, $msisdn, $contenido);*/

		        $url = "http://administrador.cm-operations.com/telcel/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=WS&username=sendsmsmt_26262";
		       
		        $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
				$banderaenvio = 1;	

				$queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
			    $resultc2 = $db->fetchAll($queryc2);

			    if(isset($resultc2[0]['costo_valor'])){
			        $gasto = $resultc2[0]['costo_valor'];
			    }else{
			        $gasto = 0.58;
			    }

			    if(isset($resultc2[0]['costo_perfil']) && ( $medio=="BaseMadre" || $medio=="Data24")){
                        $perfil= $resultc2[0]['costo_perfil'];
                    }else{
                        $perfil = 0.00;

                    } 

                $gasto = ($gasto+$perfil);
			}
			if($operador == 'movistar' || $operador == 'Movistar' || $operador == 'MOVISTAR' || $operador == 'Virgin' || $operador == 'VIRGIN'){
		       /* $operador = 'movistar';
		        $user = 'sendsmsmovistar_26262';
		        $smscId = 'movistar_26262';
		        $url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

                $marcacion = '26262';
                $user = 'sendsmsmovistar_26262';
                $smscId = 'movistar_26262';

                /*$url = "http://administrador.cm-operations.com/movistar/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=CODEREMAIL&username=sendsmsmovistar_26262";*/
                /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

                $service = "WEBSMSWS";

                $url = sprintf("http://administrador.cm-operations.com/movistar/router/router_mt.php?"."username=%s&message=%s&dial=%s&SOA=%s&service=%s", $user, $contenido, "26262", $msisdn, $service);
     
		        $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
		        $banderaenvio = 1;	

		        $queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
			    $resultc2 = $db->fetchAll($queryc2);

			    if(isset($resultc2[0]['costo_valor2'])){
			        $gasto = $resultc2[0]['costo_valor2'];
			    }else{
			        $gasto = 0.58;
			    }


			    if(isset($resultc2[0]['costo_perfil2']) && ( $medio=="BaseMadre" || $medio=="Data24")){
                        $perfil= $resultc2[0]['costo_perfil2'];
                    }else{
                        $perfil = 0.00;

                    } 

                $gasto = ($gasto+$perfil);
			}
			if($operador == 'iusacell' || $operador == 'Iusacell' || $operador == 'IUSACELL' || $operador == 'Unefon' || $operador == 'UNEFON' || $operador == 'AT&T' || $operador == 'ATT' || $operador == 'Att' || $operador == 'att'){
				$operador = 'Att';
		        $user = 'sendsmsatt_26262';
		        $smscId = 'iusacell_26262';
		        /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

		        /*$url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=EMAIL2SMS&subservice=EMAIL2SMSWS&username=sendsmsatt_26262";*/

		        $url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=WS&username=sendsmsatt_26262";
		        $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
				$banderaenvio = 1;

				$queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
			    $resultc2 = $db->fetchAll($queryc2);

			    if(isset($resultc2[0]['costo_valor3'])){
			        $gasto = $resultc2[0]['costo_valor3'];
			    }else{
			        $gasto = 0.58;
			    }	

			    if(isset($resultc2[0]['costo_perfil3']) && ( $medio=="BaseMadre" || $medio=="Data24")){
                        $perfil= $resultc2[0]['costo_perfil3'];
                    }else{
                        $perfil = 0.00;

                    } 

                $gasto = ($gasto+$perfil);
			}


			if(isset($valor2) && $valor2>=$gasto){

				if($banderaenvio == 1){
		    	try{
		    		
					$client = curl_init();
					curl_setopt($client, CURLOPT_URL, $url); 
					curl_setopt($client, CURLOPT_RETURNTRANSFER, 1); 
					$output = curl_exec($client); 
					curl_close($client);
					$logger->log("RESPUESTA: ". print_r($output, true), Zend_Log::INFO);


					$datos = array( 
                                        'mt_marcacion'   => '26262',
                                        'mt_operador'    => $operador,
                                        'mt_msisdn'      => $msisdn,
                                        'mt_medio'       => $medio,
                                        'mt_folio'      => rand(0,9).uniqid().rand(0,9),
                                        'mt_contenido'   => urldecode($sms),
                                        'mt_fecha'       => date('Y-m-d H:i:s'),
                                        'mt_tag'      => $tag,
                                        'mt_categoria'      => 'WS',
                                        'usuario_id'      => $ide
                                      );
                    $logger->log ( "INSERTA MT: ". print_r($datos, true), Zend_Log::INFO ); 
                    $insert = $db -> insert("mt_sms", $datos);


					$logger->log('Se inserto:: '.print_r($insert,true), Zend_Log::INFO);
					$msg =  "Mensaje enviado"; 

					$resto = ($valor-$gasto);

		              $data_cr=array(
		                          'credito_valor'      => $resto
		                         );

		              $logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
		              $update = $db->update('credito',$data_cr,"usuario_id ='".$ide."'");
		              $logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO);		

				}catch(Exception $e){
						$logger->log("Exception". print_r($e, true), Zend_Log::INFO);
						$msg =  "Error al enviar el mensaje. favor de contactar a su administrador";
				} 

		    }

			}else{
				$msg = "No tienes crédito suficiente";
			}

		   

			/*fin - eN busca del operador*/

			/*FIN - PROCESO PARA EL ENVIO DE MENSAJES*/

		/*}else{
			echo "No tienes crédito suficiente";
		}*/

	}elseif ($cantidad == 0) {
		$logger->log("NO ES UN USUARIO ACTIVO.", Zend_Log::INFO);
		$msg = "NO ERES UN USUARIO ACTIVO, COMUNICATE CON TU AGENTE DE VENTAS.";
	}


  $response   = array( 'success' => true );

  $response['info']=$msg;
  echo json_encode( $response );
  exit();
	  
 $logger->log("Fin", Zend_Log::INFO);

?>