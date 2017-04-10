<?php 
	require_once ("/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/etc/config.php");
	
	$config  = Zend_Registry::get('config');
	$db 	 = Zend_Registry::get('db');
	$params = Zend_Registry::get('params');

	$logger = new Zend_Log();
	$filename = date('Ymd');
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/perfil_$filename.log";
	$writer = new Zend_Log_Writer_Stream($filename, 'ab');
	$logger->addWriter($writer);
	$date = date('Y/m/d H:i:s');
	$logger->log("****************************************", Zend_Log::INFO);
	$logger->log("****************************************", Zend_Log::INFO);
	$logger->log("****************************************", Zend_Log::INFO);				
	$logger->log("****************************************FUNCION NOTIFICACIONES.php: $date", Zend_Log::INFO);
	$logger->log("REQUEST: ".print_r($_REQUEST,true),  Zend_Log::INFO);


		$query= "SELECT usuario_msisdn, usuario_id FROM fuentes_usuarios_toolbox WHERE  usuario_operador IS NULL AND usuario_activo='1' LIMIT 100";
        $result = $db->fetchAll($query);

        $logger->log("Resultado query".print_r($result,true), Zend_Log::INFO);

        $cont_perfilados = 0;

        foreach ($result as $key => $value) {
        	$msisdn = $value['usuario_msisdn'];

        	/*$select = $db->select();
            $select->from('mt_sms','mt_operador');
            $select->where("mt_msisdn ='".$msisdn."'");
            $select->limit(1, 0);
            $total = $db->fetchAll($select);


            $operador = $total[0]['mt_operador'];*/

            /*$medioperfil = "Base";*/


            /*if(count($total) <= 0){*/
                $select = $db->select();
                $select->from('motherbase','operador');
                $select->where("msisdn ='".$msisdn."'");
                $select->limit(1, 0);
                $total = $db->fetchAll($select);


                $operador = $total[0]['operador'];

            /*}*/


            if(count($total) <= 0){

                        $logger->log("ENTRO A DATA24", Zend_Log::INFO); 
                        $username = "miguel.pacheco";
                        $password = "operations2015"; 

                        $urldata24 = "https://api.data24-7.com/v/2.0?api=C&user=$username&pass=$password&p1=52".$msisdn;
                        $logger->log("URL ARMADA   ::".$urldata24    , Zend_Log::INFO);
                        $xml = simplexml_load_file($urldata24) or die("feed not loading");


                        $logger->log("Respuesta del Consumo URL: ".print_r($xml,true), Zend_Log::INFO);

                        $XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                        $XMLFILE .= "<status>OK</status>";
                        $logger->log("return: ".$XMLFILE, Zend_Log::INFO);

                        $idoperador = $xml->results->result->carrier_id;
                        $empresa = $xml->results->result->carrier_name;

                        $logger->log("NOMBRE DE LA EMPRESA DATA24   ::".$empresa   , Zend_Log::INFO);
                        $logger->log("ID OPERADOR DATA24  ::".$operador     , Zend_Log::INFO);


                        if($idoperador == '134533'){
                            $operador = 'Telcel';
                        }elseif($idoperador == '138746'){
                            $operador = 'Movistar';
                        }elseif($idoperador == '115405'){
                            $operador = 'Iusacell';
                        }elseif($idoperador == '158062'){
                            $operador = 'Nextel';
                        }


                        /*$url = 'http://administrador.cm-operations.com/mother_base/mx/router/perfila_quiubas.php?msisdn='.$msisdn;                                                                      
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

            if (!isset($operador) || $medioperfil == "Número no encontrado" || $operador == "Invalido" || empty($operador)) {
            	$operador = "Telcel";
            }

            try{

                                $data_usuarios = array(
                                                            'usuario_operador'     => $operador,
                                                        );
                                $logger->log('ARRAY DATOS USUARIO:: '.print_r($data_usuarios,true), Zend_Log::INFO);
                                $insert = $db->update('fuentes_usuarios_toolbox',$data_usuarios, 'usuario_id='.$value['usuario_id']);
                                $logger->log('ACTUALIZO:: '.print_r($insert,true), Zend_Log::INFO);
                                $cont_perfilados ++;        
                        }catch(Exception $e){
                            $logger->log("Exception". print_r($e, true), Zend_Log::INFO);
                        }

        }

        echo $cont_perfilados;
        




	

	

?>