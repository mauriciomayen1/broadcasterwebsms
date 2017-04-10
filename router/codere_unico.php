<?php
ini_set("display_errors","1");

error_reporting(E_ALL & ~E_NOTICE);
require_once ('../etc/config.php');

$config     = Zend_Registry::get('config');
$db         = Zend_Registry::get('db');


$logger   = new Zend_Log();
$filename = date('Ymd');
$filename = '/home/codere.cm-operations.com/pub_html/dashboard/logs/envioUnico_'.$filename.'.log';
$writer   = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);

$hora = date('Y/m/d H:i:s');
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);               
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>FUNCION CODERE: $hora", Zend_Log::INFO);
$logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);



$ip = $_SERVER['REMOTE_ADDR'];
$logger->log ( "IP::: ". print_r($ip, true), Zend_Log::INFO );

$msisdn = $_REQUEST["msisdn"];
$sms = $_REQUEST["content"];
$tag = "URL Unico";


		$sms = (string)strip_tags($sms);
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $sms = utf8_decode($sms);
	    $sms = strtr($sms, utf8_decode($originales), $modificadas);


		$blacklist = "SELECT msisdn FROM blacklist where msisdn = '$msisdn' and activo = 1";
		$resultblack = $db->fetchAll($blacklist);



		if(empty($resultblack)){
			
			$logger->log("ES UN USUARIO VALIDO.", Zend_Log::INFO);
			$longitud_msisdn = strlen($msisdn);
			$logger->log ( "LONGITUD DE MSISDN: ". print_r($longitud_msisdn, true), Zend_Log::INFO ); 
			if($longitud_msisdn < 10){
				$logger->log("ES UN MSISDN NO VALIDO MENOR DE 10.", Zend_Log::INFO);
				$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="" respuesta="Tamaño incorrecto en el msisdn del sms deber ser de 10 caracteres numéricos" status="6" />';
			}elseif ($longitud_msisdn > 10) {
				$logger->log("ES UN MSISDN NO VALIDO MAYOR DE 10.", Zend_Log::INFO);
				$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="" respuesta="Tamaño incorrecto en el msisdn del sms deber ser de 10 caracteres numéricos" status="6" />';
			}elseif ($longitud_msisdn == 10) {
				$logger->log("ES UN MSISDN VALIDO.", Zend_Log::INFO);
				
				if(empty($carrier)){
					$logger->log("NO TRAE OPERADOR.", Zend_Log::INFO); 

					//BUSCAMOS SI YA SE ENCUENTRA EN BASE DE DATOS
				    $query1 = "Select * from mt_codere_bc where mt_msisdn = '$msisdn'";
				    $result = $db->fetchAll($query1);
				    $logger->log ( "LAS COINCIDENCIAS QUE SE ENCONTRARON EN LA BASE MAESTRA FUERON::: ". print_r($result, true), Zend_Log::INFO );

					if(!empty($result)){
				    	$logger->log("SI SE ENCONTRO EN BASE::..", Zend_Log::INFO);

				    	$banderabd = 1;
				    	$carrier = $result[0]['mt_operador'];
				    	$logger->log ( "EL OPERADOR QUE ARROJO LA BASE DE DATOS ES::: ". print_r($operador, true), Zend_Log::INFO );
				    	$medioperfil = 'Base';
				    	$bandera = 1;
			        }
			        //BUSCAMOS SI YA SE ENCUENTRA EN BASE DE DATOS

			        //PASAMOS POR DATA 24 SI NO SE ENCONTRO EN BASE
			        if($banderabd == 0){
			        	//INICIO CODIGO PARA PERFILAR EL NUMERO TELEFONICO
				    	$logger->log("ENTRO A DATA24", Zend_Log::INFO); 
						$username = "miguel.pacheco";
						$password = "operations2015"; 

						$urldata24 = "https://api.data24-7.com/v/2.0?api=C&user=$username&pass=$password&p1=52".$msisdn;
						$logger->log("URL ARMADA   ::".$urldata24 	 , Zend_Log::INFO);


						$client = curl_init();
						curl_setopt($client, CURLOPT_URL, $urldata24); 
						curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($client, CURLOPT_CONNECTTIMEOUT ,0); 
						curl_setopt($client, CURLOPT_TIMEOUT, 1); //timeout in seconds
						curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false); 
						$output = curl_exec($client); 
						curl_close($client);

						
						$logger->log("Respuesta del Consumo URL: ".print_r($output,true), Zend_Log::INFO);

						if (empty($output)) {
							$id_operador = "134533";
							$empresa = "Radiomovil Dipsa, S.A. de C.V. (America Movil)";
							$data_status = "OK";
						} else {
							$response =simplexml_load_string($output);
							$id_operador = (string)$response->results->result->carrier_id;
							$empresa = (string)$response->results->result->carrier_name;
							$data_status = (string)$response->results->result->status;
						}
						
						

						$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
						$XMLFILE .= "<status>OK</status>";
						$logger->log("return: ".$XMLFILE, Zend_Log::INFO);


						$logger->log("NOMBRE DE LA EMPRESA DATA24   ::".$empresa 	 , Zend_Log::INFO);
						$logger->log("ID OPERADOR DATA24  ::".$id_operador 	 , Zend_Log::INFO);
						//FIN CODIGO PARA PERFILAR EL NUMERO TELEFONICO

						//PASAMOS POR DATA 24 SI NO SE ENCONTRO EN BASE
				        if($id_operador == '134533'){
							$carrier = 'Telcel';
							$bandera = 1;
							$medioperfil = 'Data24';
						}
				        if($id_operador == '138746'){
							$carrier = 'Movistar';
							$bandera = 1;
							$medioperfil = 'Data24';
						}
						if($id_operador == '115405'){
							$carrier = 'Iusacell';
							$bandera = 1;
							$medioperfil = 'Data24';
						}
						if($id_operador == '158062'){
							$carrier = 'Nextel';
							$bandera = 0;
							$medioperfil = 'Data24';
						}

						if($id_operador != '134533' && $id_operador != '138746' && $id_operador != '115405' && !empty($id_operador)){
							$logger->log("DATA24 ARROJO UN OPERADOR QUE NO ES VALIDO EN MX O EN EL SERVICIO", Zend_Log::INFO);

							$operador = 'Invalido';
							$medioperfil = 'Data24';
							
							$data_mt=array(
								        		'mt_medio'      => $medioperfil,
								        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
								        		'mt_marcacion' 	=> "26262",
								        		'mt_operador' 	=> $operador,
								        		'mt_folio'      => $id,
								        		'mt_msisdn'     => $msisdn,
								        		'mt_contenido'  => urldecode($sms),
								        		'mt_fecha'      => date('Y-m-d H:i:s'),
								        		'mt_tag'		=> $tag
								    		   );
							$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
							$insert = $db->insert('mt_codere_bc',$data_mt);
							$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO); 
							
						}
						if ($data_status == "D247_INVALID_PHONE") {

								$operador = 'Invalido';
								$medioperfil = 'Data24';

								$data_mt=array(
								        		'mt_medio'      => $medioperfil,
								        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
								        		'mt_marcacion' 	=> "26262",
								        		'mt_operador' 	=> $operador,
								        		'mt_folio'      => $id,
								        		'mt_msisdn'     => $msisdn,
								        		'mt_contenido'  => urldecode($sms),
								        		'mt_fecha'      => date('Y-m-d H:i:s'),
								        		'mt_tag'		=> $tag
								    		   );
							$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
							$insert = $db->insert('mt_codere_bc',$data_mt);
							$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO); 
						}
			        }

			        

				}else{
					$logger->log("SI TRAE OPERADOR.", Zend_Log::INFO); 

					if($carrier == 'telcel' || $carrier == 'Telcel' || $carrier == 'TELCEL'){
						$carrier == 'Telcel';
						$bandera_operador = 1;
						$medioperfil = 'Usuario';
						$bandera = 1;
					}

					if($carrier == 'movistar' || $carrier == 'Movistar' || $carrier == 'MOVISTAR'){
						$carrier == 'Movistar';
						$bandera_operador = 1;
						$medioperfil = 'Usuario';
						$bandera = 1;
					}

					if($carrier == 'iusacell' || $carrier == 'Iusacell' || $carrier == 'IUSACELL'){
						$carrier == 'Iusacell';
						$bandera_operador = 1;
						$medioperfil = 'Usuario';
						$bandera = 1;
					}

					if($carrier == 'virgin' || $carrier == 'Virgin' || $carrier == 'VIRGIN'){
						$carrier == 'Virgin';
						$bandera_operador = 1;
						$medioperfil = 'Usuario';
						$bandera = 1;
					}

					if($carrier == 'unefon' || $carrier == 'Unefon' || $carrier == 'UNEFON'){
						$carrier == 'Unefon';
						$bandera_operador = 1;
						$medioperfil = 'Usuario';
						$bandera = 1;
					}
					if($bandera_operador == 0){
						$logger->log("OPERADOR NO VALIDO  ::".$bandera_operador, Zend_Log::INFO);
						$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'"  operador="INVALIDO" respuesta="Número inválido" status="1" />';

					}
				} 

				//$id     = rand(0,9).uniqid().rand(0,9);
				$contenido    = urlencode($sms);

				$logger->log("CARRIER  ::".$carrier 	 , Zend_Log::INFO);

				if($bandera == 1){
					if($carrier == 'Telcel'){
						$operador = $carrier;
						$marcacion = '26262';
						$user = 'sendsmsmt_26262';
						$smscId = 'telcel_26262';
						$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
						$url    = sprintf($url, $msisdn, $contenido);
						$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
						$banderaenvio = 1;	
					}
					elseif($carrier == 'Movistar' || $carrier== 'Virgin'){
				        $operador = $carrier;
				        $marcacion = '2125';
						$user = 'sendsmsmovistar_2125';
						//$user = 'sendsmsmovistar_41414';
						$smscId = 'movistar_2125';
						$msisdn2 = "52".$msisdn;
						/*$url = "http://administrador.cm-operations.com/movistar/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=CODEREUNICO&username=sendsmsmovistar_26262";*/
						$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn2&text=$contenido";
						$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
				        $banderaenvio = 1;	
					}
					elseif($carrier == 'Iusacell' || $carrier== 'Unefon'){
						$operador = $carrier;
						$marcacion = '26262';
						$user = 'sendsmsiusacell_26262';
						$smscId = 'iusacell_26262';
						$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";
						$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
						$banderaenvio = 1;	
					}else{
						$banderaenvio = 0;
						$logger->log("INVALIDO.", Zend_Log::INFO);
						$operador = 'Invalido';
						
						#INSERTA MT 
						$data_mt=array(
					        		'mt_medio'      => $medioperfil,
					        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
					        		'mt_marcacion' 	=> $marcacion,
					        		'mt_operador' 	=> $operador,
					        		'mt_folio'      => $id,
					        		'mt_msisdn'     => $msisdn,
					        		'mt_contenido'  => urldecode($contenido),
					        		'mt_fecha'      => date('Y-m-d H:i:s'),
					        		'mt_tag'		=> $tag
					    		   );
						$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
						$insert = $db->insert('mt_codere_bc',$data_mt);
						$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);

						$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="INVALIDO" respuesta="Número inválido" status="1" />';
					}


					if($banderaenvio == 1){
				    	try{
							$req =& new HTTP_Request($url);
							if (!PEAR::isError($req->sendRequest())) {
							     $response1 = $req->getResponseBody();
							} else {
							     $response1 = "";     
							}
							$response1 = '0: Accepted for delivery';

							$logger->log("response:: ".print_r($response1,true), Zend_Log::INFO);

							if ($response1 == '0: Accepted for delivery') {
								$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
								$XMLFILE .= "<status>OK</status>";
								
								$logger->log("return: ".$XMLFILE, Zend_Log::INFO);

								#INSERTA MT 
								$data_mt=array(
							        		'mt_medio'      => $medioperfil,
							        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
							        		'mt_marcacion' 	=> $marcacion,
							        		'mt_operador' 	=> $operador,
							        		'mt_folio'      => $id,
							        		'mt_msisdn'     => $msisdn,
							        		'mt_contenido'  => urldecode($contenido),
							        		'mt_fecha'      => date('Y-m-d H:i:s'),
							        		'mt_tag'		=> $tag
							    		   );
								$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
								$insert = $db->insert('mt_codere_bc',$data_mt);
								$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);   
								$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="'.$operador.'" respuesta="Mensaje enviado" status="0" />';



							
							}else{
								$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
								$XMLFILE .= "<status>ERROR</status>";
								$logger->log("return: ".$XMLFILE, Zend_Log::INFO);
								$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="'.$operador.'" respuesta="Número inválido" status="1" />';
							}
							//echo $XMLFILE
							 		
						}catch(Exception $e){
							$logger->log("Exception". print_r($e, true), Zend_Log::INFO);
							$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="'.$operador.'"  respuesta= "Error en el servidor de Concepto Móvil" status="4" />'; 
						} 
			    	}

				}else{
					$logger->log("INVALIDO.", Zend_Log::INFO);
					$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="INVALIDO" respuesta="Número inválido" status="1" />';
				}
			}		
		}else{
			$logger->log("LISTA NEGRA.", Zend_Log::INFO);
			$resultb .= '<smsCall id="'.$id.'" msisdn="'.$msisdn.'" operador="BLACKLIST" respuesta="Número en lista negra" status="2" />';
		}




$fecharesponse = date('Y-m-d H:i:s');
$response = '<?xml version="1.0" encoding="UTF-8"?><replyBatch timestamp="'.$fecharesponse.'" total="1">'. $resultb ."</replyBatch>
";

//ALERTA
/*$resultb .= '<Servicios respuesta="Proveedor no reconocido, favor de contactar a su área comercial." status="0" tipo="Servicio Comercial"/>';
$fecharesponse = date('Y-m-d H:i:s');
$response = '<?xml version="1.0" encoding="UTF-8"?><ALERTA timestamp="'.$fecharesponse.'" >'. $resultb ."</ALERTA>";
$logger->log("RESPONSE XML CODERE : ".print_r($response,true), Zend_Log::INFO);
*/
//return $response;
header("Content-Type: application/xml; charset=utf-8");
print_r($response);

$logger->log("Fin::..", Zend_Log::INFO);
  
?>