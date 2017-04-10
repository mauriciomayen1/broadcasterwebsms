<?php
ini_set("display_errors","1");
ini_set('max_execution_time', 600); //600 seconds = 10 minutes
set_time_limit(0); 
error_reporting(E_ALL & ~E_NOTICE);
require_once ('/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/etc/config.php');

$config     = Zend_Registry::get('config');
$db         = Zend_Registry::get('db');


$logger   = new Zend_Log();
$filename = date('Ymd');
$filename = '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/mail_'.$filename.'.log';
$writer   = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);

$hora = date('Y/m/d H:i:s');
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);               
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>FUNCION CODERE: $hora", Zend_Log::INFO);
$logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);

/* Configuracion del servidor IMAP */

$hostname = '{imap.gmail.com:993/ssl/novalidate-cert}INBOX';
$logger->log("HOSTNAME: ". print_r($hostname, true), Zend_Log::INFO);

$username = 'sms@conceptomovil.com';
$logger->log("USERNAME: ". print_r($username, true), Zend_Log::INFO);

$password = 'macSAX27%';

/* Intento de conexión */

$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* Recuperamos los emails */
//$emails = imap_search($inbox,'UNSEEN SUBJECT "Smart AdServer - Reportes Big data - CENAM - Reporte Clientes SmartAd Server AYER"');
$emails = imap_search($inbox,'UNSEEN');
$logger->log("EMAILS: ". print_r($emails, true), Zend_Log::INFO);



/* Si obtenemos los emails, accedemos uno a uno... */

if($emails) {

    /* variable de salida */

    $output = '';

    /* Colocamos los nuevos emails arriba */

    rsort($emails);

    /* por cada email... */

    $i=0;

    foreach($emails as $email_number) {
        /* Obtenemos la información específica para este email */

        $overview = imap_fetch_overview($inbox,$email_number,0);
        $logger->log("OVERVIEW : ". print_r($overview, true), Zend_Log::INFO);

        $msisdn = $overview[0]->subject;

        $body = $overview[0]->body;

        $logger->log("OVERVIEW SUBJECT MSISDN : ". print_r($msisdn, true), Zend_Log::INFO);

        $sms = imap_fetchbody($inbox,$email_number,1);   


        $sms = (string)strip_tags($sms);



        $originales = 'ÀÁÂÃÄÅÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜàáâãäåèéêëìíîïñòóôõöùúû';
    	$modificadas = 'aaaaaaeeeeiiiinooooouuuuaaaaaaeeeeiiiinooooouuu';
	    /*$sms = utf8_decode($sms);*/
	    $sms = strtr($sms, utf8_decode($originales), $modificadas);

		$logger->log("MESAGE DECODE: ". print_r($sms, true), Zend_Log::INFO);
		/*$sms = urlencode($sms);

		echo $sms."<br>";*/
		$logger->log("MESAGE ENCODE: ". print_r($sms, true), Zend_Log::INFO);

		$sms = ereg_replace("%A0", "+", $sms);

		$sms = urldecode($sms);

		$numbers = explode ( ";" , $msisdn );

		$comodin = explode ( "-" , $sms );


		print_r($comodin);


		$comodin = (int)$comodin[0];
        
        $cadena = $sms; 
		$subcadena = "-"; 
		$posicionsubcadena = strpos ($cadena, $subcadena); 
		$sms = substr ($cadena, ($posicionsubcadena+1)); 

		echo $sms;


		$maximo = count($numbers);

		echo "<br>".$maximo."<br>";


		//print_r($numbers); die();

        /*echo $msisdn; die();*/

        
		$logger->log("MESAGE DECODE 2: ". print_r($sms, true), Zend_Log::INFO);


       $header = imap_header($inbox, $email_number);
	    $from = $header->from;
		foreach ($from as $id => $object) {
		    $fromname = $object->personal;
		    $fromaddress = $object->mailbox . "@" . $object->host;
		}

		if(count($maximo) > 1500){
          	$logger->log("No se pueden enviar más de 1500 mensajes", Zend_Log::INFO);
            
            $headers = "From: sms@conceptomovil.com" ;
	    	mail($fromaddress,"EMAILTOSMS","No se pueden hacer más de 1500 envíos en la misma ejecución", $headers); 

            exit();
            die();

          }

        $usuarios = $db->select();
		$usuarios->from('usuario','usuario_id');
		$usuarios->where("usuario_login ='".$fromaddress."'");
		$usuario = $db->fetchAll($usuarios);
	    $ide = $usuario[0]['usuario_id'];
        echo $fromaddress." <BR>";
	    echo $ide." <BR>";

        /*$queryc = "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check='SI'";
	    $resultc = $db->fetchAll($queryc);

	    $queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check2='SI'";
	    $resultc2 = $db->fetchAll($queryc2);

	    if(isset($resultc[0]['costo_valor'])){
	        $gasto = $resultc[0]['costo_valor'];
	    }else{
	        $gasto = 0.58;
	    }

	    if(isset($resultc2[0]['costo_perfil'])){
	        $perfil = $resultc2[0]['costo_perfil'];
	    }else{
	        $perfil = 0.20;
	    }


	    $gasto = ($gasto * $maximo);

		echo $gasto." <BR>";


		echo $gasto." <BR>";
		echo $perfil." <BR>";*/



	    /*$creditos = $db->select();
		$creditos->from('credito','credito_valor');
		$creditos->where("usuario_id ='".$ide."'");
		$credito = $db->fetchAll($creditos);
	    $valor = $credito[0]['credito_valor'];*/

	    $creditos = $db->select();
	    $creditos->from('credito','credito_valor,(credito_valor-credito_retenido) as creditovalor');
	    $creditos->where("usuario_id ='".$ide."'");
	    $credito = $db->fetchAll($creditos);
	    $valor = $credito[0]['credito_valor'];
	    $valor2 = $credito[0]['creditovalor'];

	    $gasto = 0.00;

	    $todos = array();

	    $todos[0] = array();


	    if(isset($valor2) && ($valor2>0.00)){

				    foreach ($numbers as $key => $msisdn) {
			        	$longitud_msisdn[$key] = strlen($msisdn);
						$logger->log ( "LONGITUD DE MSISDN: ". print_r($longitud_msisdn[$key], true), Zend_Log::INFO );

						if($longitud_msisdn[$key] < 10){
							$logger->log("ES UN MSISDN NO VALIDO MENOR DE 10.", Zend_Log::INFO);
							echo "300";
						}elseif ($longitud_msisdn[$key] > 10) {
							$logger->log("ES UN MSISDN NO VALIDO MAYOR DE 10.", Zend_Log::INFO);
							echo "400";
						}elseif ($longitud_msisdn[$key] == 10) {
							$logger->log("ES UN MSISDN VALIDO.", Zend_Log::INFO);
							
							if(empty($carrier[$key])){
								$logger->log("NO TRAE OPERADOR.", Zend_Log::INFO); 

								/*BUSCAMOS SI YA SE ENCUENTRA EN BASE DE DATOS*/
							    $query1[$key] = "SELECT count(1) AS total FROM mt_sms WHERE mt_msisdn = '$msisdn' AND mt_operador IS NOT NULL LIMIT 1";
							    $result[$key] = $db->fetchAll($query1[$key]);
							    $cantidad[$key] = $result[$key][0]['total'];
							    $logger->log ( "LAS COINCIDENCIAS QUE SE ENCONTRARON EN LA BASE mt_sms FUERON::: ". print_r($cantidad[$key], true), Zend_Log::INFO );

								/*if($cantidad[$key] > 0){
							    	$logger->log("SI SE ENCONTRO EN BASE::..", Zend_Log::INFO);

							    	$select = "SELECT * FROM mt_sms WHERE mt_msisdn = '$msisdn' AND mt_operador IS NOT NULL LIMIT 1";

									$result2[$key] = $db -> fetchAll($select);
									$logger->log ( "LAS COINCIDENCIAS  FUERON::: ". print_r($result2[$key], true), Zend_Log::INFO );

							    	$banderabd[$key] = 1;
							    	$carrier[$key] = $result2[$key][0]['mt_operador'];
							    	$logger->log ( "EL OPERADOR QUE ARROJO LA BASE DE DATOS ES::: ". print_r($carrier[$key], true), Zend_Log::INFO );
							    	$medioperfil[$key] = 'Base';
							    	$bandera[$key] = 1;
						        }*/
						        /*BUSCAMOS SI YA SE ENCUENTRA EN BASE DE DATOS*/

						        /*if($banderabd[$key] == 0){
				                    $select = $db->select();
				                    $select->from('motherbase');
				                    $select->where("msisdn ='".$msisdn."'");
				                    $total = $db->fetchAll($select);
                  
				                    $operador = $total[0]['operador'];

				                    $medioperfil = "BaseMadre";

				                    if(count($total) <= 0){
                                    	$banderabd[$key] = 0;
                                    }
				                }*/

				                /*if($banderabd[$key] == 0){*/
				                    $select = $db->select();
				                    $select->from('motherbase');
				                    $select->where("msisdn ='".$msisdn."'");
				                    $total = $db->fetchAll($select);


				                    $operador[$key] = $total[0]['operador'];

				                    $medioperfil[$key] = "BaseMadre";

				                   //

				                    if(count($total) <= 0){
                                    	$banderabd[$key] = 0;
                                    }else{
                                    	/*$gasto = ($gasto + $perfil);*/
                                    }
		/*		                }*/

						        /*PASAMOS POR DATA 24 SI NO SE ENCONTRO EN BASE*/
						        if($banderabd[$key] == 0){

							    	$logger->log("ENTRO A DATA24", Zend_Log::INFO); 
									$username = "miguel.pacheco";
									$password = "operations2015"; 

									$urldata24 = "https://api.data24-7.com/v/2.0?api=C&user=$username&pass=$password&p1=52".$msisdn;
									$logger->log("URL ARMADA   ::".$urldata24 	 , Zend_Log::INFO);
									$xml = simplexml_load_file($urldata24) or die("feed not loading");

									/*$req =& new HTTP_Request($urldata24);					
									if (!PEAR::isError($req->sendRequest())) {
									     $response1 = $req->getResponseBody();
									} else {
									     $response1 = "";     
									}*/

									$logger->log("Respuesta del Consumo URL: ".print_r($xml,true), Zend_Log::INFO);

									$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
									$XMLFILE .= "<status>OK</status>";
									$logger->log("return: ".$XMLFILE, Zend_Log::INFO);

									$id_operador[$key] = $xml->results->result->carrier_id;
									$empresa[$key] = $xml->results->result->carrier_name;

									$logger->log("NOMBRE DE LA EMPRESA DATA24   ::".$empresa[$key] 	 , Zend_Log::INFO);
									$logger->log("ID OPERADOR DATA24  ::".$id_operador[$key] 	 , Zend_Log::INFO);

									/*$gasto = ($gasto + $perfil);*/
									/**FIN CODIGO PARA PERFILAR EL NUMERO TELEFONICO****/

									/*$url = 'http://administrador.cm-operations.com/mother_base/mx/router/perfila.php?msisdn='.$msisdn;                                                                      
		                            $req =& new HTTP_Request($url);
		                            if(!PEAR::isError($req->sendRequest())){
		                                $resultado = $req->getResponseBody();

		                                $resultados = explode(",", $resultado);

		                                $carrier[$key] = $resultados['1'];
		                                $medioperfil[$key] = $resultados['0'];
		                            }else{
		                                $carrier[$key] = "Telcel";
		                                $medioperfil[$key] = "Perfilado";     
		                            }*/
						        }

						        /*PASAMOS POR DATA 24 SI NO SE ENCONTRO EN BASE*/
						        if($id_operador[$key] == '134533'){
									$carrier[$key] = 'Telcel';
									$bandera[$key] = 1;
									$medioperfil[$key] = 'Data24';
								}elseif($id_operador[$key] == '138746'){
									$carrier[$key] = 'Movistar';
									$bandera[$key] = 1;
									$medioperfil[$key]= 'Data24';
								}elseif($id_operador[$key] == '115405'){
									$carrier[$key] = 'Iusacell';
									$bandera[$key] = 1;
									$medioperfil[$key] = 'Data24';
								}elseif($id_operador[$key] == '158062'){
									$carrier[$key] = 'Nextel';
									$bandera[$key] = 1;
									$medioperfil[$key] = 'Data24';
								}elseif($id_operador[$key] != '134533' && $id_operador[$key] != '138746' && $id_operador[$key] != '115405' && !empty($id_operador[$key])){
									$logger->log("DATA24 ARROJO UN OPERADOR QUE NO ES VALIDO EN MX O EN EL SERVICIO", Zend_Log::INFO);
									//echo "600";
									$operador[$key] = 'Invalido';
									$medioperfil[$key] = 'Data24';


									$data_mt=array(
										        		'mt_medio'      => $medioperfil[$key],
										        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
										        		'mt_marcacion' 	=> "26262",
										        		'mt_operador' 	=> $operador[$key],
										        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
										        		'mt_msisdn'     => $msisdn,
										        		'mt_contenido'  => urldecode($sms),
										        		'mt_fecha'      => date('Y-m-d H:i:s'),
										        		'mt_tag'		=> "mail",
										        		'usuario_id'    => $comodin
										    		   );
									$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
									$insert = $db->insert('mt_sms',$data_mt);
									$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);

									exit();
								}

							}else{
								$logger->log("SI TRAE OPERADOR.", Zend_Log::INFO); 
								echo $carrier[$key]." hola<br>";

								if($carrier[$key] == 'telcel' || $carrier[$key] == 'Telcel' || $carrier[$key] == 'TELCEL'){
									$carrier[$key] = 'Telcel';
									$bandera_operador[$key] = 1;
									$bandera[$key] = 1;
								}elseif($carrier[$key] == 'movistar' || $carrier[$key] == 'Movistar' || $carrier[$key] == 'MOVISTAR' || $carrier[$key] == 'virgin' || $carrier[$key] == 'Virgin' || $carrier[$key] == 'VIRGIN'){
									$carrier[$key] = 'Movistar';
									$bandera_operador[$key] = 1;
									$bandera[$key] = 1;
								}elseif($carrier[$key] == 'unefon' || $carrier[$key] == 'Unefon' || $carrier[$key] == 'UNEFON' || $carrier[$key] == 'ATT' || $carrier[$key] == 'Att' || $carrier[$key] == 'att' || $carrier[$key] == 'iusacell' || $carrier[$key] == 'Iusacell' || $carrier[$key] == 'IUSACELL' || $carrier[$key] == 'Nextel' || $carrier[$key] == 'nextel'){
									$carrier[$key] = 'Att';
									$bandera_operador[$key] = 1;
									$bandera[$key] = 1;
								}else{
									$logger->log("OPERADOR NO VALIDO  ::".$carrier[$key], Zend_Log::INFO);
									echo "700";
									$operador[$key] = 'INVALIDO';
									
									$data_mt=array(
										        		'mt_medio'      => $medioperfil[$key],
										        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
										        		'mt_marcacion' 	=> "26262",
										        		'mt_operador' 	=> $operador[$key],
										        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
										        		'mt_msisdn'     => $msisdn,
										        		'mt_contenido'  => urldecode($sms),
										        		'mt_fecha'      => date('Y-m-d H:i:s'),
										        		'mt_tag'		=> "mail",
										        		'usuario_id'    => $comodin
										    		   );
									$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
									$insert = $db->insert('mt_sms',$data_mt);
									$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);

									exit();
								}

								if($bandera_operador[$key] == 0){
									$logger->log("OPERADOR NO VALIDO  ::".$bandera_operador[$key], Zend_Log::INFO);
									echo "700";
									$operador[$key] = 'INVALIDO';
									
									$data_mt=array(
										        		'mt_medio'      => $medioperfil[$key],
										        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
										        		'mt_marcacion' 	=> "26262",
										        		'mt_operador' 	=> $operador[$key],
										        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
										        		'mt_msisdn'     => $msisdn,
										        		'mt_contenido'  => urldecode($sms),
										        		'mt_fecha'      => date('Y-m-d H:i:s'),
										        		'mt_tag'		=> "mail",
										        		'usuario_id'    => $comodin
										    		   );
									$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
									$insert = $db->insert('mt_sms',$data_mt);
									$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);
									

									exit();
								}
							} 

							$id     = rand(0,9).uniqid().rand(0,9);
							$contenido    = urlencode($sms);

							$contenido;

							
							$logger->log("CARRIER  ::".$carrier[$key] 	 , Zend_Log::INFO);

							if($bandera[$key] == 1){
								echo $carrier[$key]."<br>";
								if($carrier[$key] == 'telcel' || $carrier[$key] == 'Telcel' || $carrier[$key] == 'TELCEL'){
									$operador[$key] = $carrier[$key];
									$marcacion = '26262';
									$user = 'sendsmsmt_26262';
									$smscId = 'telcel_26262';
									/*$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
									$url    = sprintf($url, "52".$msisdn, $contenido);*/


									$url = "http://administrador.cm-operations.com/telcel/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=MAIL&username=sendsmsmt_26262";
									$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
									$banderaenvio[$key] = 1;	

									$queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
					                $resultc2 = $db->fetchAll($queryc2);

					                 if(isset($resultc2[0]['costo_valor'])){
					                    $gast = $resultc2[0]['costo_valor'];
					                }else{
					                    $gast = 0.58;
					                }

					                $gasto =  ($gasto + $gast);

					                if(isset($resultc2[0]['costo_perfil']) && ( $medioperfil[$key]=="BaseMadre" || $medioperfil[$key]=="Perfilado")){
				                        $perfil= $resultc2[0]['costo_perfil'];
				                    }else{
				                        $perfil = 0.00;

				                    } 


				                    $gasto = ($gasto+$perfil);


					                $array = array('url' => $url, 'bandera' => $banderaenvio[$key], 'operador' => $operador[$key], 'medio' => $medioperfil[$key], 'msisdn' => $msisdn);

					                $todos[$key+1] = array_merge($todos[$key], $array);

								}elseif($carrier[$key] == 'movistar' || $carrier[$key] == 'Movistar' || $carrier[$key] == 'MOVISTAR' || $carrier[$key] == 'Virgin' || $carrier[$key] == 'VIRGIN'){
							        $operador[$key] = $carrier[$key];

									$marcacion = '26262';
					                $user = 'sendsmsmovistar_26262';
					                $smscId = 'movistar_26262';

									/*$url = "http://administrador.cm-operations.com/movistar/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=CODEREMAIL&username=sendsmsmovistar_26262";*/
									/*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

									$service = "WEBSMSMAIL";

                                    $url = sprintf("http://administrador.cm-operations.com/movistar/router/router_mt.php?"."username=%s&message=%s&dial=%s&SOA=%s&service=%s", $user, $contenido, "26262", $msisdn, $service);
									$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
							        $banderaenvio[$key] = 1;

							        if(isset($resultc2[0]['costo_valor2'])){
					                    $gast = $resultc2[0]['costo_valor2'];
					                }else{
					                    $gast = 0.58;
					                }

					                $gasto =  ($gasto + $gast);

					                if(isset($resultc2[0]['costo_perfil2']) && ( $medioperfil[$key]=="BaseMadre" || $medioperfil[$key]=="Perfilado")){
				                        $perfil= $resultc2[0]['costo_perfil2'];
				                    }else{
				                        $perfil = 0.00;

				                    } 


				                    $gasto = ($gasto+$perfil);

					                $array = array('url' => $url, 'bandera' => $banderaenvio[$key], 'operador' => $operador[$key], 'medio' => $medioperfil[$key], 'msisdn' => $msisdn);

					                $todos[$key+1] = array_merge($todos[$key], $array);

								}elseif($carrier[$key] == 'iusacell' || $carrier[$key] == 'Iusacell' || $carrier[$key] == 'IUSACELL' || $carrier[$key] == 'Unefon' || $carrier[$key] == 'UNEFON' || $carrier[$key] == 'AT&T' || $carrier[$key] == 'att' || $carrier[$key] == 'ATT' || $carrier[$key] == 'Att' || $carrier[$key] == 'Nextel' || $carrier[$key] == 'nextel'){
									$operador[$key] = "Att";
									$marcacion = '26262';
									$user = 'sendsmsatt_26262';
									$smscId = 'iusacell_26262';
									/*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

									$url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=MAIL&username=sendsmsatt_26262";
									$logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
									$banderaenvio[$key] = 1;	

									if(isset($resultc2[0]['costo_valor3'])){
					                    $gast = $resultc2[0]['costo_valor3'];
					                }else{
					                    $gast = 0.58;
					                }

					                $gasto =  ($gasto + $gast);

					                if(isset($resultc2[0]['costo_perfil3']) && ( $medioperfil[$key]=="BaseMadre" || $medioperfil[$key]=="Perfilado")){
				                        $perfil= $resultc2[0]['costo_perfil3'];
				                    }else{
				                        $perfil = 0.00;

				                    } 


				                    $gasto = ($gasto+$perfil);

					                $array = array('url' => $url, 'bandera' => $banderaenvio[$key], 'operador' => $operador[$key], 'medio' => $medioperfil[$key], 'msisdn' => $msisdn);

					                $todos[$key+1] = array_merge($todos[$key], $array);
								}else{
									$logger->log("OPERADOR NO VALIDO  ::".$carrier[$key], Zend_Log::INFO);
									echo "700";
									$operador[$key] = 'INVALIDO';
									
									$data_mt=array(
										        		'mt_medio'      => $medioperfil[$key],
										        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
										        		'mt_marcacion' 	=> "26262",
										        		'mt_operador' 	=> $operador[$key],
										        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
										        		'mt_msisdn'     => $msisdn,
										        		'mt_contenido'  => urldecode($contenido),
										        		'mt_fecha'      => date('Y-m-d H:i:s'),
										        		'mt_tag'		=> "mail",
										        		'usuario_id'    => $comodin
										    		   );
									$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
									$insert = $db->insert('mt_sms',$data_mt);
									$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);

									exit();
								}

			

							}
						}
			        }

			 /*print_r($todos); */     
            foreach ($todos as $key => $v) {

            	$gasto = str_replace(",", ".", $gasto);

            	echo "<br><br>".$gasto." ya".$valor2;

            	if ($gasto<=$valor2) {

            		if($v['bandera'] == 1){
							    	try{
										$req =& new HTTP_Request($v['url']);
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
										        		'mt_medio'      => $v['medio'],
										        		'mt_marcacion' 	=> "26262",
										        		'mt_operador' 	=> $v['operador'],
										        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
										        		'mt_msisdn'     => $v['msisdn'],
										        		'mt_contenido'  => urldecode($sms),
										        		'mt_fecha'      => date('Y-m-d H:i:s'),
										        		'mt_tag'		=> "mail",
										        		'mt_categoria'		=> "SIN CATEGORIA",
										        		'usuario_id'    => $comodin
										    		   );
											$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
											$insert = $db->insert('mt_sms',$data_mt);
											$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);    
											echo "200";

											$uno = 1;



											$resto = ($valor2-$gasto);

									        echo "<br><br> ".$resto." ".$valor2." Valor".$gasto;




																			$data_cr=array(
																		        		'credito_valor'      => $resto
																		    		   );

																			$logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
																			$update = $db->update('credito',$data_cr,"usuario_id ='".$ide."'");
																			$logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO); 


										
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
            	}else{

            		echo "no m";


                      $headers = "From: sms@conceptomovil.com\r\n";
					 $headers .= "MIME-Version: 1.0\r\n";
		             $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
					 /*$message = '<html><body>';
					 $message .= '<h1>Cuenta de email to SMS - Broadcaster</h1>';
					 $message .= '<h2>Se han agregado : '.$creditito.' pesos a tu cuenta.</h2><h3>Ya puedes utilizarlo para envíar tus mensajes.</h3><br><p>Gracias<br>
								El equipo de Broadcaster Web SMS - Broadcaster<br></p>
								<img src="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/html/es/images/banner.png" width="100%">';
					 $message .= '</body></html>';*/


					 $message = '<html>
		                     <head>
								<meta name="viewport" content="width=device-width" />
		       					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<title>Broadcaster | Equipo de asistencia Broadcaster
								</title>
									
								<style>
								* { 
									margin:0;
									padding:0;
								}
								* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

								img { 
									max-width: 100%; 
								}
								.collapse {
									margin:0;
									padding:0;
								}
								body {
									-webkit-font-smoothing:antialiased; 
									-webkit-text-size-adjust:none; 
									width: 100%!important; 
									height: 100%;
								}


								a { color: #2BA6CB;}

								.btn {
									text-decoration:none;
									color: #FFF;
									background-color: #666;
									padding:10px 16px;
									font-weight:bold;
									margin-right:10px;
									text-align:center;
									cursor:pointer;
									display: inline-block;
								}

								p.callout {
									padding:15px;
									background-color:#ECF8FF;
									margin-bottom: 15px;
								}
								.callout a {
									font-weight:bold;
									color: #2BA6CB;
								}

								table.social {
								/* 	padding:15px; */
									background-color: #ebebeb;
									
								}
								.social .soc-btn {
									padding: 3px 7px;
									font-size:12px;
									margin-bottom:10px;
									text-decoration:none;
									color: #FFF;font-weight:bold;
									display:block;
									text-align:center;
								}
								a.fb { background-color: #3B5998!important; }
								a.tw { background-color: #1daced!important; }
								a.gp { background-color: #DB4A39!important; }
								a.ms { background-color: #000!important; }

								.sidebar .soc-btn { 
									display:block;
									width:100%;
								}

								table.head-wrap { width: 100%;}

								.header.container table td.logo { padding: 15px; }
								.header.container table td.label { padding: 15px; padding-left:0px;}

								table.body-wrap { width: 100%;}

								table.footer-wrap { width: 100%;	clear:both!important;
								}
								.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
								.footer-wrap .container td.content p {
									font-size:10px;
									font-weight: bold;
									
								}

								h1,h2,h3,h4,h5,h6 {
								font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
								}
								h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

								h1 { font-weight:200; font-size: 24px;}
								h2 { font-weight:200; font-size: 22px;}
								h3 { font-weight:500; font-size: 20px;}
								h4 { font-weight:500; font-size: 18px;}
								h5 { font-weight:900; font-size: 16px;}
								h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

								.collapse { margin:0!important;}

								p, ul { 
									margin-bottom: 10px; 
									font-weight: normal; 
									font-size:14px; 
									line-height:1.6;
								}
								p.lead { font-size:17px; }
								p.last { margin-bottom:0px;}

								ul li {
									margin-left:5px;
									list-style-position: inside;
								}

								ul.sidebar {
									background:#ebebeb;
									display:block;
									list-style-type: none;
								}
								ul.sidebar li { display: block; margin:0;}
								ul.sidebar li a {
									text-decoration:none;
									color: #666;
									padding:10px 16px;
								/* 	font-weight:bold; */
									margin-right:10px;
								/* 	text-align:center; */
									cursor:pointer;
									border-bottom: 1px solid #777777;
									border-top: 1px solid #FFFFFF;
									display:block;
									margin:0;
								}
								ul.sidebar li a.last { border-bottom-width:0px;}
								ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

								.container {
									display:block!important;
									max-width:600px!important;
									margin:0 auto!important; /* makes it centered */
									clear:both!important;
								}

								.content {
									padding:15px;
									max-width:600px;
									margin:0 auto;
									display:block; 
								}

								.content table { width: 100%; }

								.column {
									width: 300px;
									float:left;
								}
								.column tr td { padding: 15px; }
								.column-wrap { 
									padding:0!important; 
									margin:0 auto; 
									max-width:600px!important;
								}
								.column table { width:100%;}
								.social .column {
									width: 280px;
									min-width: 279px;
									float:left;
								}

								@media only screen and (max-width: 600px) {
									
									a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

									div[class="column"] { width: auto!important; float:none!important;}
									
									table.social div[class="column"] {
										width:auto!important;
									}

								}
								</style>

								</head>
								 
								<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

								<!-- HEADER -->
								<table class="head-wrap" bgcolor="#fff">
									<tr>
										<td></td>
										<td class="header container" align="">
											
											<!-- /content -->
											<div class="content">
												<table bgcolor="#fff" >
													<tr>
														<td></td>
														<td align="right"><h6 class="collapse">Equipo de Asistencia de Broadcaster</h6></td>
													</tr>
												</table>
											</div><!-- /content -->
											
										</td>
										<td></td>
									</tr>
								</table><!-- /HEADER -->

								<!-- BODY -->
								<table class="body-wrap" bgcolor="ececec">
									<tr>
										<td></td>
										<td class="container" align="" bgcolor="#FFFFFF">
											
											<!-- content -->
											<div class="content">
												<table>
													<tr>
														<td>
																			
														
															
															<h2>No tienes suficiente saldo para enviar mensajes, por favor recarga tu saldo mediante un mensaje de texto con la palabra SMS '.$ide.' al 77700.</h3>

															
															<p>
												El equipo de Broadcaster Web SMS - Broadcaster<br></p>
															
															<h5 style="text-align: center; color: #00b7e3;"><strong>Gracias</strong></h5>
														</td>
													</tr>
												</table>
												
											</div><!-- /content -->

											
											<!-- content -->
											<div class="content">
												<table bgcolor="">
													<tr>
														<td>
															
															<!-- social & contact -->
															<table bgcolor="" class="social" width="100%">
																<tr>
																	<td>
																		
																		<!--- column 1 -->
																		<div class="column">
																			<table bgcolor="" cellpadding="" align="left">
																		<tr>
																			<td>				
																				
																				<h5 class="">Ir a sitio:</h5>
																				<p class=""><a href="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/login.php" class="soc-btn tw">Ir al sitio</a></p>
														
																				
																			</td>
																		</tr>
																	</table><!-- /column 1 -->
																		</div>
																		
																		<!--- column 2 -->
																		<div class="column">
																			<table bgcolor="" cellpadding="" align="left">
																		<tr>
																			<td>				
																											

																				<p>Tel:<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30</a><br />
																					<b>Ext.</b> 1009, 1010<br/>
								                 <a href="mailto:sury.nolasco@conceptomovil.com">sury.nolasco@conceptomovil.com</a></p>
								                
																			</td>
																		</tr>
																	</table><!-- /column 2 -->	
																		</div>
																		
																		<div class="clear"></div>
									
																	</td>
																</tr>
															</table><!-- /social & contact -->
															
														</td>
													</tr>
												</table>
											</div><!-- /content -->
											

										</td>
										<td></td>
									</tr>
								</table><!-- /BODY -->

									  
												

								<!-- FOOTER -->
								<table class="footer-wrap">
									<tr>
										<td></td>
										<td class="container">
											
												<!-- content -->
												<div class="content">
													<table>
														<tr>
															<td align="center">
																<p>
																	<a style="color: #000;" href="http://www.broadcastersms.com/">Broadcaster</a> |
																	<a style="color: #000;" href="#">Equipo de Asistencia</a> |
																	<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30   <b>Ext.</b> 1009, 1010</a> |
																	<a style="color: #000;" href="http://www.broadcastersms.com/">broadcastersms.com</a> |
																	
																</p>
															</td>
														</tr>
													</table>
												</div><!-- /content -->
												
										</td>
										<td></td>
									</tr>
								</table><!-- /FOOTER -->

								</body>
								</html>';
					 mail($fromaddress,"EMAILTOSMS", $message, $headers);
 

            	}
            }




	    }elseif(isset($valor2) && $valor2 == "0.00"){

	    	 $headers = "From: sms@conceptomovil.com\r\n";
			 $headers .= "MIME-Version: 1.0\r\n";
             $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
			 /*$message = '<html><body>';
			 $message .= '<h1>Cuenta de email to SMS - Broadcaster</h1>';
			 $message .= '<h2>Se han agregado : '.$creditito.' pesos a tu cuenta.</h2><h3>Ya puedes utilizarlo para envíar tus mensajes.</h3><br><p>Gracias<br>
						El equipo de Broadcaster Web SMS - Broadcaster<br></p>
						<img src="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/html/es/images/banner.png" width="100%">';
			 $message .= '</body></html>';*/


			 $message = '<html>
                     <head>
						<meta name="viewport" content="width=device-width" />
       					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Broadcaster | Equipo de asistencia Broadcaster
						</title>
							
						<style>
						* { 
							margin:0;
							padding:0;
						}
						* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

						img { 
							max-width: 100%; 
						}
						.collapse {
							margin:0;
							padding:0;
						}
						body {
							-webkit-font-smoothing:antialiased; 
							-webkit-text-size-adjust:none; 
							width: 100%!important; 
							height: 100%;
						}


						a { color: #2BA6CB;}

						.btn {
							text-decoration:none;
							color: #FFF;
							background-color: #666;
							padding:10px 16px;
							font-weight:bold;
							margin-right:10px;
							text-align:center;
							cursor:pointer;
							display: inline-block;
						}

						p.callout {
							padding:15px;
							background-color:#ECF8FF;
							margin-bottom: 15px;
						}
						.callout a {
							font-weight:bold;
							color: #2BA6CB;
						}

						table.social {
						/* 	padding:15px; */
							background-color: #ebebeb;
							
						}
						.social .soc-btn {
							padding: 3px 7px;
							font-size:12px;
							margin-bottom:10px;
							text-decoration:none;
							color: #FFF;font-weight:bold;
							display:block;
							text-align:center;
						}
						a.fb { background-color: #3B5998!important; }
						a.tw { background-color: #1daced!important; }
						a.gp { background-color: #DB4A39!important; }
						a.ms { background-color: #000!important; }

						.sidebar .soc-btn { 
							display:block;
							width:100%;
						}

						table.head-wrap { width: 100%;}

						.header.container table td.logo { padding: 15px; }
						.header.container table td.label { padding: 15px; padding-left:0px;}

						table.body-wrap { width: 100%;}

						table.footer-wrap { width: 100%;	clear:both!important;
						}
						.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
						.footer-wrap .container td.content p {
							font-size:10px;
							font-weight: bold;
							
						}

						h1,h2,h3,h4,h5,h6 {
						font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
						}
						h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

						h1 { font-weight:200; font-size: 24px;}
						h2 { font-weight:200; font-size: 22px;}
						h3 { font-weight:500; font-size: 20px;}
						h4 { font-weight:500; font-size: 18px;}
						h5 { font-weight:900; font-size: 16px;}
						h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

						.collapse { margin:0!important;}

						p, ul { 
							margin-bottom: 10px; 
							font-weight: normal; 
							font-size:14px; 
							line-height:1.6;
						}
						p.lead { font-size:17px; }
						p.last { margin-bottom:0px;}

						ul li {
							margin-left:5px;
							list-style-position: inside;
						}

						ul.sidebar {
							background:#ebebeb;
							display:block;
							list-style-type: none;
						}
						ul.sidebar li { display: block; margin:0;}
						ul.sidebar li a {
							text-decoration:none;
							color: #666;
							padding:10px 16px;
						/* 	font-weight:bold; */
							margin-right:10px;
						/* 	text-align:center; */
							cursor:pointer;
							border-bottom: 1px solid #777777;
							border-top: 1px solid #FFFFFF;
							display:block;
							margin:0;
						}
						ul.sidebar li a.last { border-bottom-width:0px;}
						ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

						.container {
							display:block!important;
							max-width:600px!important;
							margin:0 auto!important; /* makes it centered */
							clear:both!important;
						}

						.content {
							padding:15px;
							max-width:600px;
							margin:0 auto;
							display:block; 
						}

						.content table { width: 100%; }

						.column {
							width: 300px;
							float:left;
						}
						.column tr td { padding: 15px; }
						.column-wrap { 
							padding:0!important; 
							margin:0 auto; 
							max-width:600px!important;
						}
						.column table { width:100%;}
						.social .column {
							width: 280px;
							min-width: 279px;
							float:left;
						}

						@media only screen and (max-width: 600px) {
							
							a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

							div[class="column"] { width: auto!important; float:none!important;}
							
							table.social div[class="column"] {
								width:auto!important;
							}

						}
						</style>

						</head>
						 
						<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

						<!-- HEADER -->
						<table class="head-wrap" bgcolor="#fff">
							<tr>
								<td></td>
								<td class="header container" align="">
									
									<!-- /content -->
									<div class="content">
										<table bgcolor="#fff" >
											<tr>
												<td></td>
												<td align="right"><h6 class="collapse">Equipo de Asistencia de Broadcaster</h6></td>
											</tr>
										</table>
									</div><!-- /content -->
									
								</td>
								<td></td>
							</tr>
						</table><!-- /HEADER -->

						<!-- BODY -->
						<table class="body-wrap" bgcolor="ececec">
							<tr>
								<td></td>
								<td class="container" align="" bgcolor="#FFFFFF">
									
									<!-- content -->
									<div class="content">
										<table>
											<tr>
												<td>
																	
												
													
													<h2>No tienes saldo, por favor recarga tu saldo mediante un mensaje de texto con la palabra email espacio tu identificador al 77700.</h3>

													
													<p>
										El equipo de Broadcaster Web SMS - Broadcaster<br></p>
													
													<h5 style="text-align: center; color: #00b7e3;"><strong>Gracias</strong></h5>
												</td>
											</tr>
										</table>
										
									</div><!-- /content -->

									
									<!-- content -->
									<div class="content">
										<table bgcolor="">
											<tr>
												<td>
													
													<!-- social & contact -->
													<table bgcolor="" class="social" width="100%">
														<tr>
															<td>
																
																<!--- column 1 -->
																<div class="column">
																	<table bgcolor="" cellpadding="" align="left">
																<tr>
																	<td>				
																		
																		<h5 class="">Ir a sitio:</h5>
																		<p class=""><a href="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/login.php" class="soc-btn tw">Ir al sitio</a></p>
												
																		
																	</td>
																</tr>
															</table><!-- /column 1 -->
																</div>
																
																<!--- column 2 -->
																<div class="column">
																	<table bgcolor="" cellpadding="" align="left">
																<tr>
																	<td>				
																									

																		<p>Tel:<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30</a><br />
																			<b>Ext.</b> 1009, 1010<br/>
						                 <a href="mailto:sury.nolasco@conceptomovil.com">sury.nolasco@conceptomovil.com</a></p>
						                
																	</td>
																</tr>
															</table><!-- /column 2 -->	
																</div>
																
																<div class="clear"></div>
							
															</td>
														</tr>
													</table><!-- /social & contact -->
													
												</td>
											</tr>
										</table>
									</div><!-- /content -->
									

								</td>
								<td></td>
							</tr>
						</table><!-- /BODY -->

							  
										

						<!-- FOOTER -->
						<table class="footer-wrap">
							<tr>
								<td></td>
								<td class="container">
									
										<!-- content -->
										<div class="content">
											<table>
												<tr>
													<td align="center">
														<p>
															<a style="color: #000;" href="http://www.broadcastersms.com/">Broadcaster</a> |
															<a style="color: #000;" href="#">Equipo de Asistencia</a> |
															<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30   <b>Ext.</b> 1009, 1010</a> |
															<a style="color: #000;" href="http://www.broadcastersms.com/">broadcastersms.com</a> |
															
														</p>
													</td>
												</tr>
											</table>
										</div><!-- /content -->
										
								</td>
								<td></td>
							</tr>
						</table><!-- /FOOTER -->

						</body>
						</html>';
			 mail($fromaddress,"EMAILTOSMS", $message, $headers);
	    }

	    if($msisdn!="=?UTF-8?Q?Transacci=C3=B3n_Empresarial_en_PagoFacil.net?="){
			echo "YES";
			echo $email_number;
			imap_setflag_full($inbox, trim($email_number), '\\Seen');
		}else{
			echo "NO";
			echo $email_number;
			imap_clearflag_full($inbox,trim($email_number),'\\Seen');
		}


		if(isset($uno)){
	$headers = "From: sms@conceptomovil.com\r\n";
			 $headers .= "MIME-Version: 1.0\r\n";
             $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
			 /*$message = '<html><body>';
			 $message .= '<h1>Cuenta de email to SMS - Broadcaster</h1>';
			 $message .= '<h2>Se han agregado : '.$creditito.' pesos a tu cuenta.</h2><h3>Ya puedes utilizarlo para envíar tus mensajes.</h3><br><p>Gracias<br>
						El equipo de Broadcaster Web SMS - Broadcaster<br></p>
						<img src="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/html/es/images/banner.png" width="100%">';
			 $message .= '</body></html>';*/


			 $message = '<html>
                     <head>
						<meta name="viewport" content="width=device-width" />
       					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Broadcaster | Equipo de asistencia Broadcaster
						</title>
							
						<style>
						* { 
							margin:0;
							padding:0;
						}
						* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

						img { 
							max-width: 100%; 
						}
						.collapse {
							margin:0;
							padding:0;
						}
						body {
							-webkit-font-smoothing:antialiased; 
							-webkit-text-size-adjust:none; 
							width: 100%!important; 
							height: 100%;
						}


						a { color: #2BA6CB;}

						.btn {
							text-decoration:none;
							color: #FFF;
							background-color: #666;
							padding:10px 16px;
							font-weight:bold;
							margin-right:10px;
							text-align:center;
							cursor:pointer;
							display: inline-block;
						}

						p.callout {
							padding:15px;
							background-color:#ECF8FF;
							margin-bottom: 15px;
						}
						.callout a {
							font-weight:bold;
							color: #2BA6CB;
						}

						table.social {
						/* 	padding:15px; */
							background-color: #ebebeb;
							
						}
						.social .soc-btn {
							padding: 3px 7px;
							font-size:12px;
							margin-bottom:10px;
							text-decoration:none;
							color: #FFF;font-weight:bold;
							display:block;
							text-align:center;
						}
						a.fb { background-color: #3B5998!important; }
						a.tw { background-color: #1daced!important; }
						a.gp { background-color: #DB4A39!important; }
						a.ms { background-color: #000!important; }

						.sidebar .soc-btn { 
							display:block;
							width:100%;
						}

						table.head-wrap { width: 100%;}

						.header.container table td.logo { padding: 15px; }
						.header.container table td.label { padding: 15px; padding-left:0px;}

						table.body-wrap { width: 100%;}

						table.footer-wrap { width: 100%;	clear:both!important;
						}
						.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
						.footer-wrap .container td.content p {
							font-size:10px;
							font-weight: bold;
							
						}

						h1,h2,h3,h4,h5,h6 {
						font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
						}
						h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

						h1 { font-weight:200; font-size: 24px;}
						h2 { font-weight:200; font-size: 22px;}
						h3 { font-weight:500; font-size: 20px;}
						h4 { font-weight:500; font-size: 18px;}
						h5 { font-weight:900; font-size: 16px;}
						h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

						.collapse { margin:0!important;}

						p, ul { 
							margin-bottom: 10px; 
							font-weight: normal; 
							font-size:14px; 
							line-height:1.6;
						}
						p.lead { font-size:17px; }
						p.last { margin-bottom:0px;}

						ul li {
							margin-left:5px;
							list-style-position: inside;
						}

						ul.sidebar {
							background:#ebebeb;
							display:block;
							list-style-type: none;
						}
						ul.sidebar li { display: block; margin:0;}
						ul.sidebar li a {
							text-decoration:none;
							color: #666;
							padding:10px 16px;
						/* 	font-weight:bold; */
							margin-right:10px;
						/* 	text-align:center; */
							cursor:pointer;
							border-bottom: 1px solid #777777;
							border-top: 1px solid #FFFFFF;
							display:block;
							margin:0;
						}
						ul.sidebar li a.last { border-bottom-width:0px;}
						ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

						.container {
							display:block!important;
							max-width:600px!important;
							margin:0 auto!important; /* makes it centered */
							clear:both!important;
						}

						.content {
							padding:15px;
							max-width:600px;
							margin:0 auto;
							display:block; 
						}

						.content table { width: 100%; }

						.column {
							width: 300px;
							float:left;
						}
						.column tr td { padding: 15px; }
						.column-wrap { 
							padding:0!important; 
							margin:0 auto; 
							max-width:600px!important;
						}
						.column table { width:100%;}
						.social .column {
							width: 280px;
							min-width: 279px;
							float:left;
						}

						@media only screen and (max-width: 600px) {
							
							a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

							div[class="column"] { width: auto!important; float:none!important;}
							
							table.social div[class="column"] {
								width:auto!important;
							}

						}
						</style>

						</head>
						 
						<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

						<!-- HEADER -->
						<table class="head-wrap" bgcolor="#fff">
							<tr>
								<td></td>
								<td class="header container" align="">
									
									<!-- /content -->
									<div class="content">
										<table bgcolor="#fff" >
											<tr>
												<td></td>
												<td align="right"><h6 class="collapse">Equipo de Asistencia de Broadcaster</h6></td>
											</tr>
										</table>
									</div><!-- /content -->
									
								</td>
								<td></td>
							</tr>
						</table><!-- /HEADER -->

						<!-- BODY -->
						<table class="body-wrap" bgcolor="ececec">
							<tr>
								<td></td>
								<td class="container" align="" bgcolor="#FFFFFF">
									
									<!-- content -->
									<div class="content">
										<table>
											<tr>
												<td>
																	
												
													
													<h2>Se enviaron los mensajes correctamente</h3>

													
													<p>
										El equipo de Broadcaster Web SMS - Broadcaster<br></p>
													
													<h5 style="text-align: center; color: #00b7e3;"><strong>Gracias</strong></h5>
												</td>
											</tr>
										</table>
										
									</div><!-- /content -->

									
									<!-- content -->
									<div class="content">
										<table bgcolor="">
											<tr>
												<td>
													
													<!-- social & contact -->
													<table bgcolor="" class="social" width="100%">
														<tr>
															<td>
																
																<!--- column 1 -->
																<div class="column">
																	<table bgcolor="" cellpadding="" align="left">
																<tr>
																	<td>				
																		
																		<h5 class="">Ir a sitio:</h5>
																		<p class=""><a href="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/login.php" class="soc-btn tw">Ir al sitio</a></p>
												
																		
																	</td>
																</tr>
															</table><!-- /column 1 -->
																</div>
																
																<!--- column 2 -->
																<div class="column">
																	<table bgcolor="" cellpadding="" align="left">
																<tr>
																	<td>				
																									

																		<p>Tel:<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30</a><br />
																			<b>Ext.</b> 1009, 1010<br/>
						                 <a href="mailto:sury.nolasco@conceptomovil.com">sury.nolasco@conceptomovil.com</a></p>
						                
																	</td>
																</tr>
															</table><!-- /column 2 -->	
																</div>
																
																<div class="clear"></div>
							
															</td>
														</tr>
													</table><!-- /social & contact -->
													
												</td>
											</tr>
										</table>
									</div><!-- /content -->
									

								</td>
								<td></td>
							</tr>
						</table><!-- /BODY -->

							  
										

						<!-- FOOTER -->
						<table class="footer-wrap">
							<tr>
								<td></td>
								<td class="container">
									
										<!-- content -->
										<div class="content">
											<table>
												<tr>
													<td align="center">
														<p>
															<a style="color: #000;" href="http://www.broadcastersms.com/">Broadcaster</a> |
															<a style="color: #000;" href="#">Equipo de Asistencia</a> |
															<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30   <b>Ext.</b> 1009, 1010</a> |
															<a style="color: #000;" href="http://www.broadcastersms.com/">broadcastersms.com</a> |
															
														</p>
													</td>
												</tr>
											</table>
										</div><!-- /content -->
										
								</td>
								<td></td>
							</tr>
						</table><!-- /FOOTER -->

						</body>
						</html>';
			 mail($fromaddress,"EMAILTOSMS", $message, $headers);
}

    if($fromaddress!="apuestas@codere.com"){
			echo "YES";
			echo $email_number;
			imap_setflag_full($inbox, trim($email_number), '\\Seen');
		}else{
			echo "NO";
			echo $email_number;
			imap_clearflag_full($inbox,trim($email_number),'\\Seen');
		}

    }


} 




/* Cerramos la connexión */

imap_close($inbox);

exit;


$logger->log("Fin::..", Zend_Log::INFO);
  
?>