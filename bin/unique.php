<?php
require_once ("../etc/config.php");

if ($auth->hasIdentity()) { 
    $acciones = array(
        'listar'    => 'listar',
        'agregar'   => 'actualizar',
        'editar'    => 'actualizar',
        'eliminar'  => 'eliminar',
        'buscar'  => 'buscar',
        'enviar'    => 'enviar'
    );

    if($_REQUEST['accion'] == 'buscar'){
      buscar();
    }


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

    $querycampaign = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
    $resultcampaign = $db->fetchAll($querycampaign);
    $smarty->assign('campanas', $resultcampaign);

    $smarty->assign('application', $config->application);
    $smarty->assign('activo',$_SESSION["activo"]);
    $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001432666-Broadcaster-Hacer-un-env%C3%ADo-%C3%BAnico-");
    $smarty->display('header.html');


    if (!isset($_REQUEST['accion'])) { //Si no se ha enviado una accion
        listar();
    } 

    if($_REQUEST['accion'] == 'enviar'){
        enviar();
    }
    if($_REQUEST['accion'] == 'preparar'){
        preparar();
    }

    if($_REQUEST['accion'] == 'listar'){
        listar();
    }
    //$smarty->display('footer.html');
} else {
    header("Location: login.php");
}

function listar() {
    $config  = Zend_Registry::get('config');
    $db      = Zend_Registry::get('db');
    $session = Zend_Registry::get('session'); 
    $smarty  = Zend_Registry::get('smarty');   

    $flag = $_REQUEST['flag'];
    $msg = $_REQUEST['msg'];

    if($flag != NULL && $msg != NULL){
        $smarty->assign($flag, $msg);
    }
    
    $smarty->display("unique.html");
 } 

 function enviar(){

    $config  = Zend_Registry::get('config');
    $db      = Zend_Registry::get('db');
    $session = Zend_Registry::get('session'); 
    $smarty  = Zend_Registry::get('smarty');  
    
    $logger   = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Unico_$filename.log";
    $writer   = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');

    $logger->log ( "----------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "----------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "----------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO UNICO - FN ENVIAR -----------------------", Zend_Log::INFO );
    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);

    $msisdn = $_REQUEST['msisdn'];
    $sms    = $_REQUEST['message'];

    $sms = (string)strip_tags($sms);
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöúûýý';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnooooouuyy';
    $sms = utf8_decode($sms);

    $sms = strtr($sms, utf8_decode($originales), $modificadas);

    /*echo $sms; die();*/

    $logger->log ( "MSISDN: ". print_r($msisdn, true), Zend_Log::INFO );
    $logger->log ( "SMS: ". print_r($sms, true), Zend_Log::INFO );

    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];


    $creditos = $db->select();
    $creditos->from('credito','credito_valor,(credito_valor-credito_retenido) as creditovalor');
    $creditos->where("usuario_id ='".$ide."'");
    $credito = $db->fetchAll($creditos);
    $valor = $credito[0]['credito_valor'];
    $valor2 = $credito[0]['creditovalor'];

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
    }*/

   /*echo $valor." hola ".$valor2; die();*/


    /*if(isset($valor) && $valor>=$gasto){*/
       if(!empty($msisdn) && !empty($sms)){
            $logger->log("SI PUSO UN MSISDN Y UN MENSAJE", Zend_Log::INFO);
            if(strlen($msisdn) == 10){
                $logger->log("SI ES UN MSISDN VALIDO", Zend_Log::INFO);


                $pos = strpos($sms, '$');
                $logger->log ( "POSICON SIGNO DE PESOS: ". print_r($pos, true), Zend_Log::INFO );
                $DA  = str_replace("$", "", $sms);
                $logger->log ( "SUSTITUYENDO EL SIGNO DE PESOS: ". print_r($DA, true), Zend_Log::INFO );
                $logger->log(".", Zend_Log::INFO);
                $logger->log(".", Zend_Log::INFO);
                $logger->log(".", Zend_Log::INFO);


                $contenido = urlencode($sms);
                $logger->log ( "CONTENIDO A ENVIAR SIN CODIFICAR: ". print_r($sms, true), Zend_Log::INFO );
                $logger->log ( "CONTENIDO A ENVIAR CODIFICADO: ". print_r($contenido, true), Zend_Log::INFO );
                //$contenido = $sms;
                //$contenido = utf8_encode($sms);
                //$contenido = rawurlencode($sms);

                // $url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
                // $url    = sprintf($url, $msisdn, $contenido);
                // $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );
                // $marcacion = "26262";

                //exit();

                
                $select = $db->select();
                $select->from('motherbase');
                $select->where("msisdn ='".$msisdn."'");
                $total = $db->fetchAll($select);


                $operador = $total[0]['operador'];

                $medioperfil = "BaseMadre";

                if(count($total) <= 0){
                }else{
                  /*$gasto = ($gasto + $perfil);*/
                }

                if(count($total) <= 0){
                            /**INICIO CODIGO PARA PERFILAR EL NUMERO TELEFONICO****/
                            $logger->log("ENTRO A DATA24", Zend_Log::INFO); 
                            $username = "miguel.pacheco";
                            $password = "operations2015"; 

                            $urldata24 = "https://api.data24-7.com/v/2.0?api=C&user=$username&pass=$password&p1=52".$msisdn;
                            $logger->log("URL ARMADA   ::".$urldata24    , Zend_Log::INFO);
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

                            $idoperador = $xml->results->result->carrier_id;
                            $empresa = $xml->results->result->carrier_name;

                            $logger->log("NOMBRE DE LA EMPRESA DATA24   ::".$empresa   , Zend_Log::INFO);
                            $logger->log("ID OPERADOR DATA24  ::".$operador     , Zend_Log::INFO);
                            /**FIN CODIGO PARA PERFILAR EL NUMERO TELEFONICO****/

                            /*$gasto = ($gasto + $perfil);*/

                            if($idoperador == '134533'){
                                $operador = 'Telcel';
                                $medioperfil = 'Data24';
                            }elseif($idoperador == '138746'){
                                $operador = 'Movistar';
                                $medioperfil = 'Data24';
                            }elseif($idoperador == '115405'){
                                $operador = 'Iusacell';
                                $medioperfil = 'Data24';
                            }elseif($idoperador == '158062'){
                                $operador = 'Nextel';
                                $medioperfil = 'Data24';
                            }elseif($idoperador != '134533' && $idoperador != '138746' && $idoperador != '115405' && !empty($idoperador)){
                            }                                                                                   
                                                                                                                                                 
                            /*$url = 'http://administrador.cm-operations.com/mother_base/mx/router/perfila.php?msisdn='.$msisdn;                                                                      
                            $req =& new HTTP_Request($url);
                            if(!PEAR::isError($req->sendRequest())){
                                $resultado = $req->getResponseBody();

                                $resultados = explode(",", $resultado);

                                $operador = $resultados['1'];
                                $medioperfil = $resultados['0'];
                            }else{
                                $operador = "Telcel";
                                $medioperfil = "Perfilado";     
                            }*/

                }

                //$marcacion = "727";
                /*$marcacion = "26262";
                //sendsmstelcel_727

                $url = 'http://localhost:13013/cgi-bin/sendsms?';
                $url = sprintf($url."username=sendsmsmt_26262&password=kaiser&charset=UTF-8&coding=0&to=52%s&text=%s", $msisdn, $contenido);
                $logger->log("URL: ".print_r($url,true), Zend_Log::INFO);*/



                if($operador == 'telcel' || $operador == 'Telcel' || $operador == 'TELCEL'){
                    $operador = $operador;
                    $marcacion = '26262';
                    $user = 'sendsmsmt_26262';
                    $smscId = 'telcel_26262';
                    /*$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
                    $url    = sprintf($url, $msisdn, $contenido);
                    $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );*/


                    $url = "http://administrador.cm-operations.com/telcel/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=UNICO&username=sendsmsmt_26262";
                    $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO ); 

                    $queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
				    $resultc2 = $db->fetchAll($queryc2);

				    if(isset($resultc2[0]['costo_valor'])){
				        $gasto = $resultc2[0]['costo_valor'];
				    }else{
				        $gasto = 0.58;

				    }

                    if(isset($resultc2[0]['costo_perfil']) && ( $medioperfil=="BaseMadre" || $medioperfil=="Perfilado")){
                        $perfil= $resultc2[0]['costo_perfil'];
                    }else{
                        $perfil = 0.00;

                    } 


                    $gasto = ($gasto+$perfil);


                }elseif($operador == 'movistar' || $operador == 'Movistar' || $operador == 'MOVISTAR' || $operador == 'Virgin' || $operador == 'VIRGIN'){
                    $operador = $operador;
                    $marcacion = '26262';
                    $user = 'sendsmsmovistar_26262';
                    $smscId = 'movistar_26262';

                    /*$url = "http://administrador.cm-operations.com/movistar/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=CODEREMAIL&username=sendsmsmovistar_26262";*/
                    /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

                    $service = "WEBSMSUNICO";

                    $url = sprintf("http://administrador.cm-operations.com/movistar/router/router_mt.php?"."username=%s&message=%s&dial=%s&SOA=%s&service=%s", $user, $contenido, "26262", $msisdn, $service);
                    $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO ); 


                    $queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
				    $resultc2 = $db->fetchAll($queryc2);

				    if(isset($resultc2[0]['costo_valor2'])){
				        $gasto = $resultc2[0]['costo_valor2'];
				    }else{
				        $gasto = 0.58;
				    } 


                    if(isset($resultc2[0]['costo_perfil2']) && ( $medioperfil=="BaseMadre" || $medioperfil=="Perfilado")){
                        $perfil= $resultc2[0]['costo_perfil2'];
                    }else{
                        $perfil = 0.00;

                    } 


                    $gasto = ($gasto+$perfil);

                }elseif($operador == 'iusacell' || $operador == 'Iusacell' || $operador == 'IUSACELL' || $operador == 'Unefon' || $operador == 'UNEFON' || $operador == 'AT&T' || $operador == 'ATT' || $operador == 'Att' || $operador == 'att' || $operador == 'nextel' || $operador == 'Nextel'){
                    $operador = $operador;
                    $marcacion = '26262';
                    $user = 'sendsmsatt_26262';
                    $smscId = 'iusacell_26262';
                    /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/
                    $url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=UNICO&username=sendsmsatt_26262";
                    $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );  


                    $queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
				    $resultc2 = $db->fetchAll($queryc2);

				    if(isset($resultc2[0]['costo_valor3'])){
				        $gasto = $resultc2[0]['costo_valor3'];
				    }else{
				        $gasto = 0.58;
				    } 

                    if(isset($resultc2[0]['costo_perfil3']) && ( $medioperfil=="BaseMadre" || $medioperfil=="Perfilado")){
                        $perfil= $resultc2[0]['costo_perfil3'];
                    }else{
                        $perfil = 0.00;

                    } 


                    $gasto = ($gasto+$perfil);
                }

                //echo $url;


                if(isset($valor2) && $valor2>=$gasto){

                	$logger->log("SE SE ARMO LA URL SE VA A EJECUTAR", Zend_Log::INFO);

		                try{
		                    $req =& new HTTP_Request($url);
		                    if(!PEAR::isError($req->sendRequest())){
		                        $response1 = $req->getResponseBody();
		                    }else{
		                        $response1 = "";     
		                    }
		                    //$response1 = '0: Accepted for delivery';
		                    $logger->log("response:: ".print_r($response1,true), Zend_Log::INFO);

		                    if($response1 == '0: Accepted for delivery'){
		                        $XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		                        $XMLFILE .= "<status>OK</status>";
		                                
		                        $logger->log("return: ".$XMLFILE, Zend_Log::INFO);

		                        $bandera_base = 1;
		                        $logger->log("SE VA A GUARDAR EN BASE DE DATOS:::...", Zend_Log::INFO);

		                        $data_mt=array(
		                                    'mt_marcacion'   => $marcacion,
		                                    'mt_operador'    => $operador,
		                                    'mt_msisdn'      => $msisdn,
		                                    'mt_medio'       => $medioperfil,
		                                    'mt_folio'      => rand(0,9).uniqid().rand(0,9),
		                                    'mt_contenido'   => urldecode($contenido),
		                                    'mt_fecha'       => date('Y-m-d H:i:s'),
		                                    'mt_tag'      => 'UNICO',
		                                    'usuario_id'      => $ide
		                                );
		                        $logger->log('DATOS MT:: '.print_r($data_mt,true), Zend_Log::INFO);
		                        $insert = $db->insert('mt_sms',$data_mt);
		                        $logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO);

		                        /*$smarty->assign('mensaje1', 'Envío Exitoso!, se realizo el envío al número '); 
		                        $smarty->assign('numero', $msisdn);*/


		                        $msg = "¡Envío Exitoso!, se realizo el envío al número ".$msisdn;
		                        $flag = 'mensaje1';
		                        
		                    }else{
		                        $XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		                        $XMLFILE .= "<status>ERROR</status>";
		                                
		                        $logger->log("return: ".$XMLFILE, Zend_Log::INFO);
		                        //echo "500";
		                    }
		                    $logger->log("CODIGO DE RESPUESTA 200", Zend_Log::INFO);

		                    $resto = ($valor-$gasto);

		                    $data_cr=array(
		                                'credito_valor'      => $resto
		                               );

		                    $logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
		                    $update = $db->update('credito',$data_cr,"usuario_id ='".$ide."'");
		                    $logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO); 
		                    //echo "200";
		                }catch(Exception $e){
		                    $logger->log("Exception". print_r($e, true), Zend_Log::INFO);
		                    $logger->log("CODIGO DE RESPUESTA 500", Zend_Log::INFO);
		                    //echo "500";
		                }

                }else{ 
				        $logger->log("No tiene crédito suficiente", Zend_Log::INFO);

				        $msg = '¡Oops! No tienes crédito suficiente. Si deseas hacer una recarga da click <a href="payment.php">aquí</a>';
				        $flag = 'error';

				    }


 
                

             
            }else{
                $logger->log("LA LONGITUD NO CORRESPONDE A UN MSISDN VALIDO", Zend_Log::INFO);
                /*$smarty->assign('error', 'Oops! Ocurrio un error, la longitud del teléfono no es valida.'); */

                $msg = "Oops! Ocurrio un error, la longitud del teléfono no es valida";
                $flag = 'error';
            }

        }else{
            $logger->log("NO PUSO NI MENSAJE NI MSISDN", Zend_Log::INFO);
            $smarty->assign('error', 'Oops! Ocurrio un error, es necesario ingrese el msisdn y el mensaje.');

            $msg = "Oops! Ocurrio un error, es necesario ingrese el msisdn y el mensaje.";
            $flag = 'error';     
        }
    /*}else{
        $logger->log("No tiene crédito suficiente", Zend_Log::INFO);

        $msg = "¡Oops! No tienes crédito suficiente. Si deseas hacer una recarga da click <a href='payment.php'>aquí</a>";
        $flag = 'error';
    }*/

    echo "<script type='text/javascript'>
                   window.location = 'http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/unique.php?accion=listar&flag=".$flag."&msg=".$msg."';
              </script>";

    $smarty->display("unique.html");

    
    
 } 

 function buscar(){

      $config  = Zend_Registry::get('config');
      $db      = Zend_Registry::get('db');
      $session = Zend_Registry::get('session'); 
      $smarty  = Zend_Registry::get('smarty');  

        $usuarios = $db->select();
        $usuarios->from('usuario','usuario_id');
        $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
        $usuario = $db->fetchAll($usuarios);
        $ide = $usuario[0]['usuario_id'];

        $queryc = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
        $resultc = $db->fetchAll($queryc);

        $queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check2='SI'";
        $resultc2 = $db->fetchAll($queryc2);

        if(count($resultc)>0){
          $costo = $resultc[0]['costo_valor'];
        }else{
          $costo = 0.58;
        }

        if(count($resultc)>0){
          $costo2 = $resultc[0]['costo_valor2'];
        }else{
          $costo2 = 0.58;
        }

        if(count($resultc)>0){
          $costo3 = $resultc[0]['costo_valor3'];
        }else{
          $costo3 = 0.58;
        }

        $costo = str_replace(',','.',$costo);
        $costo2 = str_replace(',','.',$costo2);
        $costo3 = str_replace(',','.',$costo3);


        $result = array('costo' => $costo,
        	            'costo2' => $costo2,
        	            'costo3' => $costo3
        	            );

      $response   = array( 'success' => true );

      $response['info']=$result;
      echo json_encode( $response );
      exit();

 }

 
?>

