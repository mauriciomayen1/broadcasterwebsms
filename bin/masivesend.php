 <?php
require_once ("../etc/config.php");
set_time_limit(90);

if($auth->hasIdentity()){ 
    $acciones = array(
                      'listar'    => 'listar',
                      'agregar'   => 'actualizar',
                      'editar'    => 'actualizar',
                      'eliminar'  => 'eliminar',
                      'preparar'  => 'preparar',
                      'enviar'    => 'enviar',
                      'buscar'    => 'buscar'
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
    $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001388503-Broadcaster-Hacer-un-env%C3%ADo-masivo-");
    $smarty->display('header.html');

    if(!isset($_REQUEST['accion'])){ //Si no se ha enviado una accion
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
}else{
    header("Location: login.php");
}

function listar(){
  $config  = Zend_Registry::get('config');
  $db      = Zend_Registry::get('db');
  $session = Zend_Registry::get('session'); 
  $smarty  = Zend_Registry::get('smarty');  

  $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id']; 

  $query = "SELECT DISTINCT(usuario_categoria), count(usuario_categoria) as total, count(usuario_operador) as total2 FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."'  GROUP BY usuario_categoria ORDER BY usuario_categoria ASC";

  $result = $db->fetchAll($query);


   $querym = "SELECT DISTINCT(mensaje_region) FROM fuentes_mensajes_programados_toolbox WHERE mensaje_procesado = '1' AND bandera_masivo = '0' GROUP BY mensaje_region ORDER BY mensaje_region ASC";

  $resultm = $db->fetchAll($querym);

  $cuenta = count($resultm);


  foreach ($result as $key => $value) {

    for ($i=0; $i < $cuenta; $i++) { 
       if($value['usuario_categoria'] == $resultm[$i]['mensaje_region']){

        unset($result[$key]);

       }
    }

  }


  $smarty->assign('rows', $result);

  $flag = $_REQUEST['flag'];
  $msg = $_REQUEST['msg'];

  if($flag != NULL && $msg != NULL){
      $smarty->assign($flag, $msg);
  }

  $smarty->display("masivesend.html");
} 

function enviar1(){
  $config  = Zend_Registry::get('config');
  $db      = Zend_Registry::get('db');
  $session = Zend_Registry::get('session'); 
  $smarty  = Zend_Registry::get('smarty'); 

  $logger   = new Zend_Log();
  $filename = date('Ymd');
  $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/EnvioMasivo_$filename.log";
  $writer   = new Zend_Log_Writer_Stream($filename, 'ab');
  $logger->addWriter($writer);
  $hora = date('Y/m/d H:i:s');

  $logger->log ( "------------------------------------------------", Zend_Log::INFO );
  $logger->log ( "------------------------------------------------", Zend_Log::INFO );
  $logger->log ( "------------------------------------------------", Zend_Log::INFO );
  $logger->log ( "---- ENVIO MASIVO ENVIAR - FN ENVIAR -----------", Zend_Log::INFO );
  $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);

  $bandera = 0;

  $categoria = $_REQUEST['selectCategoria'];
  $sms       = $_REQUEST['sms'];
  $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
  $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
  $sms = utf8_decode($sms);
  $sms = strtr($sms, utf8_decode($originales), $modificadas);

  $logger->log("CATEGORIA:: ". print_r($categoria, true), Zend_Log::INFO);
  $logger->log("MENSAJE:: ". print_r($sms, true), Zend_Log::INFO);

  if(!empty($sms)){
      $logger->log("SI SELECCIONO CATEGORIA Y ESCRIBIO UN MENSAJE", Zend_Log::INFO);

      $usuarios = $db->select();
      $usuarios->from('usuario','usuario_id');
      $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
      $usuario = $db->fetchAll($usuarios);
      $ide = $usuario[0]['usuario_id'];


      if($categoria=="0"){
        $query1 = "SELECT COUNT(usuario_msisdn) AS numtel FROM fuentes_usuarios_toolbox WHERE usuario_enviado = 0 AND usuario_activo = 1 AND usuario_id_fk='".$ide."'";
      }else{
        $query1 = "SELECT COUNT(usuario_msisdn) AS numtel FROM fuentes_usuarios_toolbox WHERE usuario_enviado = 0 AND usuario_activo = 1 AND usuario_categoria='$categoria' AND usuario_id_fk='".$ide."'";
      }

      
              
      $cantidad = $db->fetchAll($query1);


      $logger->log("QUERY :: ". print_r($query1, true), Zend_Log::INFO);
      $logger->log("CANTIDAD DE ENVIOS QUE SE REALIZARAN: ". print_r($cantidad[0]['numtel'], true), Zend_Log::INFO);

      if($cantidad[0]['numtel'] > 0){
          $logger->log("SI SE ENCONTRARON NUMEROS PARA REALIZAR EL ENVIO", Zend_Log::INFO);

          if($categoria=="0"){
	        $query2 = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_enviado = 0 AND usuario_activo = 1 AND usuario_id_fk='".$ide."'";
	      }else{
	        $query2 = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_enviado = 0 AND usuario_activo = 1 AND usuario_categoria='$categoria' AND usuario_id_fk='".$ide."'";
	      }

          
                  
          $numeros = $db->fetchAll($query2);
          $logger->log("QUERY 2: ". print_r($query2, true), Zend_Log::INFO);
          $logger->log("RESULTADO DE LA CONSULTA A USUARIOS  FILTRADO POR CATEGORIA, ENVIADO 0 Y ACTIVO 1: ". print_r($numeros, true), Zend_Log::INFO);

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


          /*$creditos = $db->select();
          $creditos->from('credito','credito_valor');
          $creditos->where("usuario_id ='".$ide."'");
          $credito = $db->fetchAll($creditos);
          $valor = $credito[0]['credito_valor'];
          $gasto = ($gasto*$cantidad[0]['numtel']);*/


          $creditos = $db->select();
    $creditos->from('credito','credito_valor');
    $creditos->where("usuario_id ='".$ide."'");
    $credito = $db->fetchAll($creditos);
    $valor = $credito[0]['credito_valor'];

    if($categoria=="0"){
      $queryt = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_operador='Telcel'";

      $resultt = $db->fetchAll($queryt);

      $numt = count($resultt);

      $querym = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_operador='Movistar'";

      $resultm = $db->fetchAll($querym);

      $numm= count($resultm);

      $querya = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."'AND (usuario_operador='Nextel' or usuario_operador='Iusacell' OR usuario_operador='Unefon')";

      $resulta = $db->fetchAll($querya);

      $numa = count($resulta);


      $costos = $db->select();
      $costos->from('costo');
      $costos->where("usuario_id ='".$ide."'");
      $costo = $db->fetchAll($costos);
      $valort = $costo[0]['costo_valor'];
      $valorm = $costo[0]['costo_valor2'];
      $valora = $costo[0]['costo_valor3'];

      if(isset($valort) && $valort != NULL){
          $costot = ($valort * $numt);
      }else{
          $costot = 0.58;
      }

      if(isset($valorm) && $valorm != NULL){
          $costom = ($valorm * $numm);
      }else{
          $costom = 0.58;
      }

      if(isset($valora) && $valora != NULL){
          $costoa = ($valora * $numa);
      }else{
          $costoa = 0.58;
      }

      /*$supertotal = ($costot + $costom + $costoa);

      echo "<br>".$cantidad[0]['numtel']." Total<br>";*/

      $gasto = ($costot + $costom + $costoa);

    }else{
      $queryt = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$categoria."' AND usuario_operador='Telcel'";

      $resultt = $db->fetchAll($queryt);

      $numt = count($resultt);

      $querym = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$categoria."' AND usuario_operador='Movistar'";

      $resultm = $db->fetchAll($querym);

      $numm= count($resultm);

      $querya = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$categoria."' AND (usuario_operador='Nextel' or usuario_operador='Iusacell' OR usuario_operador='Unefon')";

      $resulta = $db->fetchAll($querya);

      $numa = count($resulta);


      $costos = $db->select();
      $costos->from('costo');
      $costos->where("usuario_id ='".$ide."'");
      $costo = $db->fetchAll($costos);
      $valort = $costo[0]['costo_valor'];
      $valorm = $costo[0]['costo_valor2'];
      $valora = $costo[0]['costo_valor3'];

      if(isset($valort) && $valort != NULL){
          $costot = ($valort * $numt);
      }else{
          $costot = 0.58 * $numt;
      }

      if(isset($valorm) && $valorm != NULL){
          $costom = ($valorm * $numm);
      }else{
          $costom = 0.58 * $numm;
      }

      if(isset($valora) && $valora != NULL){
          $costoa = ($valora * $numa);
      }else{
          $costoa = 0.58 * $numa;
      }

      /*$supertotal = ($costot + $costom + $costoa);

      echo "<br>".$cantidad[0]['numtel']." Total<br>";*/

      $gasto = ($costot + $costom + $costoa);
    }

    /*echo $gasto; die();*/

          if(count($numeros) > 1500){
          	$logger->log("No se pueden enviar más de 1500 mensajes", Zend_Log::INFO);
            $smarty->assign('error', "Oops! No se pueden enviar más de 1500 mensajes");
            $query = "SELECT DISTINCT(usuario_categoria) as categoria FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
		        $result = $db->fetchAll($query);

		        $opciones = array();

      	    foreach ($result as $key => $value) {
      	    	$opciones2[$key] = array(
      					        $value['categoria'] => $value['categoria']
      					    );

      	    	$resultado[$key] = array_merge($opciones, $opciones2[$key]);
      	    }

		        $resultado = call_user_func_array('array_merge', $resultado);


    		    $smarty->assign('opciones', $resultado);
    		    $smarty->assign('selecta', $categoria);
            $smarty->display("masivesend.html");

            exit();

          }

       /*echo $gasto; die();*/

       if(isset($valor) && $valor>=$gasto){

          for($i=0; !empty($numeros[$i]); $i++  ){
              $logger->log("-------------------------------------->", Zend_Log::INFO);
              $logger->log("CONTADOR i: ". $i, Zend_Log::INFO);

              $id        = $numeros[$i]['usuario_id'];
              $msisdn    = $numeros[$i]['usuario_msisdn'];
              $operador  = $numeros[$i]['usuario_operador'];

              $logger->log("ID:: ". $id, Zend_Log::INFO);
              $logger->log("MSISDN:: ". $msisdn, Zend_Log::INFO);
              $logger->log("OPERADOR:: ". $operador, Zend_Log::INFO);
                      
              $contenido    = urlencode($sms);
              $logger->log("MENSAJE A ENVIAR::..". $sms, Zend_Log::INFO);


            $medioperfil = "Base";


            if($operador == 'telcel' || $operador == 'Telcel' || $operador == 'TELCEL'){
                $operador = $operador;
                $marcacion = '26262';
                $user = 'sendsmsmt_26262';
                $smscId = 'telcel_26262';
                $url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
                $url    = sprintf($url, "52".$msisdn, $contenido);
                $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO ); 
                $bandera = 1;
            }elseif($operador == 'movistar' || $operador == 'Movistar' || $operador == 'MOVISTAR' || $operador == 'Virgin' || $operador == 'VIRGIN'){
                /*$operador = $operador;
                $marcacion = '26262';
                $user = 'sendsmsmovistar_26262';
                $smscId = 'movistar_26262';*/

                $operador = $operador;
                $marcacion = '2126';
                $user = 'sendsmsmovistar_2126';
                $smscId = 'movistar_2126';

                /*$url = "http://administrador.cm-operations.com/movistar/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=CODEREMAIL&username=sendsmsmovistar_26262";*/
                /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

                $service = "EMAIL2SMSMASIVE";

                $url = sprintf("http://administrador.cm-operations.com/movistar/router/router_mt.php?"."username=%s&message=%s&dial=%s&SOA=%s&service=%s", $user, $contenido, "2126", "52".$msisdn, $service);
                $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO ); 
                $bandera = 1;
            }elseif($operador == 'iusacell' || $operador == 'Iusacell' || $operador == 'IUSACELL' || $operador == 'Unefon' || $operador == 'UNEFON' || $operador == 'AT&T' || $operador == 'Nextel' || $operador == 'ATT' || $operador == 'Att' || $operador == 'att'){
                $operador = $operador;
                $marcacion = '26262';
                $user = 'sendsmsatt_26262';
                $smscId = 'iusacell_26262';
                /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

                $url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=EMAIL2SMS&subservice=EMAIL2SMSMASIVE&username=sendsmsatt_26262";
                $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO );   
                $bandera = 1;
            }


              
              //$bandera = 0;                              
              if($bandera == 1){
                  $logger->log("SI SE ARMO LA URL, SE VA A EJECUTAR", Zend_Log::INFO);
                  try{
                        $req =& new HTTP_Request($url);              
                                                         
                        if (!PEAR::isError($req->sendRequest())){
                            $response1 = $req->getResponseBody();
                        }else{
                            $response1 = "";     
                        }

                        $logger->log("RESPUESTA::.. ".print_r($response1,true), Zend_Log::INFO);
                        $XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                        $XMLFILE .= "<status>OK</status>";
                        $logger->log("return: ".$XMLFILE, Zend_Log::INFO);
                        $logger->log("SE ENVIO", Zend_Log::INFO);


                        $datos = array( 
                                        'mt_marcacion'   => $marcacion,
                                        'mt_operador'    => $operador,
                                        'mt_msisdn'      => $msisdn,
                                        'mt_medio'       => $medioperfil,
                                        'mt_folio'      => rand(0,9).uniqid().rand(0,9),
                                        'mt_contenido'   => $contenido,
                                        'mt_fecha'       => date('Y-m-d H:i:s'),
                                        'mt_tag'      => 'MASIVO',
                                        'mt_categoria'      => $categoria,
                                        'usuario_id'      => $ide
                                      );
                        $logger->log ( "INSERTA MT: ". print_r($datos, true), Zend_Log::INFO ); 
                        $insert = $db -> insert("mt_sms", $datos);
                        $logger->log ( "SE INSERTO: ". print_r($insert, true), Zend_Log::INFO );
                        $bandera = 0;
                        /***FIN INSERTAMOS EN BASE DE DATOS****** EL ENVIO*****/

                  }catch(Exception $e){
                        $logger->log("Exception". print_r($e, true), Zend_Log::INFO);
                  }
              }

          }//FIN DEL FOR

          $data = array(
                                      'usuario_enviado'    => 1
                                      );

                        if($categoria!="0"){
                          $where = 'usuario_categoria = "'.$categoria.'" AND usuario_id_fk="'.$ide.'"';
                        }else{
                          $where = 'usuario_id_fk = "'.$ide.'"';
                        }
                       /* $where = 'usuario_id = "'.$id.'"';*/


                        $update = $db->update('fuentes_usuarios_toolbox',$data,$where);
                        $logger->log("DATOS A UPDATE EN LA BASE DEMO PERU: ".print_r($data,true), Zend_Log::INFO);
                        $logger->log ( "SE ACTUALIZO: ". print_r($update, true), Zend_Log::INFO );

              $resto = ($valor-$gasto);

              $data_cr=array(
                          'credito_valor'      => $resto
                         );

              $logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
              $update = $db->update('credito',$data_cr,"usuario_id ='".$ide."'");
              $logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO); 

              $smarty->assign('mensaje10', 'Operacion exitosa!, se enviaron '); 
          $smarty->assign('cantidad10', $i);
          $smarty->assign('mensaje50', 'registros de ');
          $smarty->assign('cantidad20', $cantidad[0]['numtel']);
          $smarty->assign('mensaje60', 'encontrados en la base de datos'); 

          $msg = "¡Operación exitosa!, se enviaron ".$i." registros de ".$cantidad[0]['numtel']." encontrados en la base de datos";
           $flag = 'mensaje10';

        }else{
           $logger->log("No tiene crédito suficiente", Zend_Log::INFO);
           $smarty->assign('error', "Oops! No tienes crédito suficiente. Si deseas hacer una recarga da click <a href='payment.php'>aquí</a>"); 

           $msg = 'Oops! No tienes crédito suficiente. Si deseas hacer una recarga da click <a href="payment.php">aquí</a>';
           $flag = 'error';
        }
   
                  
      }else{
          $logger->log("NO HAY NUMEROS A ENVIAR EL MENSAJE, SE VA A EJECUTAR UN EXIT::..", Zend_Log::INFO);
          /*$smarty->assign('error', 'Oops! Ocurrio un error, no se encontraron registros preparados para el envío, te recomendamos preparar la base de datos o verificar que existan usuarios con la categoría seleccionada');*/

          $msg = "Oops! Ocurrio un error, no se encontraron registros preparados para el envío, te recomendamos preparar la base de datos o verificar que existan usuarios con la categoría seleccionada";
          $flag = 'error';
      }
  }else{
      $logger->log("NO ESCRIBIO EL MENSAJE", Zend_Log::INFO);
      /*$smarty->assign('error', 'Oops! Ocurrio un error, para enviar un mensaje debes al menos escribir el mensaje');*/

      $msg = "Oops! Ocurrio un error, para enviar un mensaje debes al menos escribir el mensaje";
      $flag = 'error';
  }
  $logger->log("FIN::::::::........", Zend_Log::INFO);

  /*$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id']; 

  $query = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
  $result = $db->fetchAll($query);
  $smarty->assign('rows', $result);*/


  echo "<script type='text/javascript'>
                   window.location = 'http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/masivesend.php?accion=listar&flag=".$flag."&msg=".$msg."';
              </script>";

  /*$smarty->display("masivesend.html");*/
}

function enviar() {
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session'); 
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    $logger   = new Zend_Log ();
    $filename = date ( 'Ymd' );
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/EnvioMasivo_$filename.log";
    $writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
    $logger->addWriter ( $writer );
    $filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
    $logger->addFilter ( $filter );

    $hora = date ( 'Y/m/d H:i:s' );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO MASIVO - FN GUARDAR ------------", Zend_Log::INFO );
    $logger->log ( "REQUEST" . print_r ( $_REQUEST, true ), Zend_Log::INFO ); 

    /**RECUPERANDO ARGUNMENTOS PARA EL GUARDADO*/
    $categoria   = $_REQUEST['selectCategoria'];
    $hora        = date('H:i:s');
    $fecha_envio = date('Y-m-d H:i:s');
    $mensaje     = $_REQUEST['sms'];
    $campania    = $_SESSION["activo"];



    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $mensaje = utf8_decode($mensaje);
    $mensaje = strtr($mensaje , utf8_decode($originales), $modificadas);
    /*FIN DE RECUPERACION PARA EL GUARDADO*/


    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];


    /*echo $query; die();*/

    /*Impresion de los argumentos recuperados*/
    $logger->log("CATEGORIA: ". print_r($categoria, true), Zend_Log::INFO);
    $logger->log("HORA DE ENVIO: ". print_r($hora, true), Zend_Log::INFO);
    $logger->log("FECHA DE ENVIO: ". print_r($fecha_envio, true), Zend_Log::INFO);
    $logger->log("MENSAJE: ". print_r($mensaje, true), Zend_Log::INFO);
    $logger->log("CAMPANIA: ". print_r($campania, true), Zend_Log::INFO);
    /*Fin de impresion de argumentos recuperados*/
    if(!empty($categoria) && !empty($hora) && !empty($fecha_envio) && !empty($mensaje) && !empty($campania)){
        $logger->log ( "SI REQUESITO TODOS LOS CAMPOS", Zend_Log::INFO );

            $repetido = "SELECT * FROM fuentes_mensajes_programados_toolbox WHERE mensaje_fechaenvio = '$fecha_envio' AND mensaje_horario = '$hora' AND mensaje_mensaje = '$mensaje' AND mensaje_nombre='$campania' and mensaje_activo ='1' AND bandera_masivo = '0'";
            $repetidos = $db->fetchAll($repetido);

            if(count($repetidos)>0){
               $logger->log ( "Ya está repetido la programación de ese envío", Zend_Log::INFO );
               /*$smarty->assign('error', '¡Oops! Ya está repetido la programación de ese envío');*/

               $msg = '¡Oops! Ya está repetido la programación de ese envío';
              $flag = 'error';
            }else{
               try {

                        $datos=array(
                                            'mensaje_horario'           => md5($hora),
                                            'mensaje_horarionombre'     => $hora,
                                            'mensaje_mensaje'           => $mensaje,
                                            'mensaje_nombre'            => $campania,
                                            'mensaje_fechaenvio'        => $fecha_envio,
                                            'mensaje_descripcion'       => $campania,
                                            'mensaje_fechaalta'         => date("Y/m/d H:i:s"),
                                            'mensaje_activo'            => 1,
                                            'mensaje_region'            => $categoria,
                                            'mensaje_ocupacion'         => $categoria,
                                            'mensaje_procesado'         => 1,
                                            'bandera_masivo'         => '0',
                                            'mensaje_usuario'                => $ide
                                        );
                    
                        $logger->log("DATOS A INSERTAR EN LA BASE MENSAJES PROGRAMADOS: ".print_r($datos,true), Zend_Log::INFO);
                        $insert = $db -> insert("fuentes_mensajes_programados_toolbox", $datos);
                        $logger->log ( "SE INSERTO: ". print_r($insert, true), Zend_Log::INFO );
                        /*$smarty->assign('mensaje', 'Registro exitoso');*/

                        $data = array(
                                      'usuario_enviado'    => '0'
                                      );
                        $where = 'usuario_categoria = "'.$categoria.'"';

                        $update = $db->update('fuentes_usuarios_toolbox',$data,$where);

                        $check = "SELECT credito_retenido FROM credito WHERE usuario_id = '".$ide."'";
                         $checks = $db->fetchAll($check);

                        $retenme = ($_REQUEST['retenido'] + $checks[0]['credito_retenido']);


                        $retenido = array(
                                      'credito_retenido'    => $retenme
                                      );
                        $wherere = 'usuario_id = "'.$ide.'"';

                        $updatere = $db->update('credito',$retenido,$wherere);



                        $msg = 'Registro exitoso, comienza el envío';
                        $flag = 'mensaje10';
                } catch (Exception $e) {
                         $msg = '¡Oops! Ocurrio un error. Intentelo mas tarde si el problema persiste contacta al administrador';
            $flag = 'error';
                }
            }

        
    }else{
       $logger->log ( "NO LLENO TODOS O ALGUNOS DE LOS CAMPOS", Zend_Log::INFO );
       /*$smarty->assign("error","¡Oops! Ocurrio un problema. Todos los campos son requeridos"); */

           $msg = '¡Oops! Ocurrio un problema. Todos los campos son requeridos';
           $flag = 'error';
    }


    $logger->log ( "FIN:::...", Zend_Log::INFO );
 

    echo "<script type='text/javascript'>
                   window.location = 'http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/masivesend.php?accion=listar&flag=".$flag."&msg=".$msg."';
              </script>";

}


 function preparar(){

    $config  = Zend_Registry::get('config');
    $db      = Zend_Registry::get('db');
    $session = Zend_Registry::get('session'); 
    $smarty  = Zend_Registry::get('smarty');  
    
    $logger   = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Masivos_$filename.log";
    $writer   = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');

    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO MASIVO PREPARAR - FN PREPARAR -------", Zend_Log::INFO );

    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);

    $categoria = $_REQUEST['selectCategoria2'];


    $logger->log ( "LA CATEGORIA A PREPARAR ES: ". print_r($categoria, true), Zend_Log::INFO );


    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    
        $logger->log("SI SELECCIONO CATEGORIA", Zend_Log::INFO);
        try{
            $data = array(
                                 'usuario_enviado'      => 0
                          );
            //$where = 'usuario_categoria LIKE "'.$categoria.'"';


            if($categoria=="0"){
            	$update = $db->update('fuentes_usuarios_toolbox',$data,"usuario_activo='1' AND usuario_id_fk=".$ide);
            }else{
            	$update = $db->update('fuentes_usuarios_toolbox',$data,"usuario_activo='1' AND  usuario_id_fk=".$ide." AND usuario_categoria='".$categoria."'");
            }

            /*print_r($update, true); die();*/

            $logger->log("DATOS A UPDATE EN LA BASE: ".print_r($data,true), Zend_Log::INFO);
            $logger->log("WHERE: ".print_r($where,true), Zend_Log::INFO);
            $logger->log ( "SE ACTUALIZARON: ". print_r($update, true), Zend_Log::INFO );

            if($update == 0){
                $smarty->assign('mensaje', 'La base ');
                $smarty->assign('base',$categoria);
                $smarty->assign('mensaje1', ' ya se encontraba preparada, total de registros preparados: ');
                $smarty->assign('update', $update);
            }else{
                $smarty->assign('mensaje', 'La base ');
                $smarty->assign('base',$categoria);
                $smarty->assign('mensaje1', ' se preparó correctamente, con un total de ');
                $smarty->assign('update', $update);
                $smarty->assign('mensaje2', ' registros preparados ');
            }
    
        }catch(Exception $e){
            $logger->log("EXCEPTION:: ". print_r($e, true), Zend_Log::INFO);
            $smarty->assign('mensaje3', 'Oops! Ocurrio un error, intentalo mas tarde, si los problema persisten ponte en contacto con el administrador.');
        } 

    

     

     

     //$select = $db->select();

     //LLENA EL COMBO
     $query = "SELECT DISTINCT(usuario_categoria) as categoria FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk=".$ide." ORDER BY usuario_categoria ASC";
     $result = $db->fetchAll($query);

    $opciones = array();

    foreach ($result as $key => $value) {
    	$opciones2[$key] = array(
				        $value['categoria'] => $value['categoria']
				    );

    	$resultado[$key] = array_merge($opciones, $opciones2[$key]);
    }

    $resultado = call_user_func_array('array_merge', $resultado);


    $querym = "SELECT DISTINCT(mensaje_region) FROM fuentes_mensajes_programados_toolbox WHERE mensaje_procesado = '1' AND bandera_masivo = '0' GROUP BY mensaje_region ORDER BY mensaje_region ASC";

    $resultm = $db->fetchAll($querym);

    $cuenta = count($resultm);


    foreach ($resultado as $key => $value) {

      for ($i=0; $i < $cuenta; $i++) { 
         if($key == $resultm[$i]['mensaje_region']){

          unset($resultado[$key]);

         }
      }

    }



     $smarty->assign('opciones', $resultado);
     $smarty->assign('selecta', $categoria);

     
      $smarty->display("masivesend.html");  
     //listar(); 
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

  $credito = $db->select();
    $credito->from('credito','credito_valor');
    $credito->where("usuario_id='".$ide."'");
    $creditos = $db->fetchAll($credito);
    $dinero = $creditos[0]['credito_valor'];


    $query = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_enviado = '0' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."'";

    $result = $db->fetchAll($query);


  	$queryt = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_enviado = '0' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."' AND usuario_operador='Telcel'";

  	$resultt = $db->fetchAll($queryt);

    $numt = count($resultt);

    $querym = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_enviado = '0' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."' AND usuario_operador='Movistar'";

    $resultm = $db->fetchAll($querym);

    $numm= count($resultm);

    $querya = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_enviado = '0' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."' AND (usuario_operador='Nextel' or usuario_operador='Iusacell' OR usuario_operador='Unefon')";

    $resulta = $db->fetchAll($querya);

    $numa = count($resulta);



  if(count($result)<=0){
     $result = array('preparada' => 'no' );
  }else{
    $queryc = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
    $resultc = $db->fetchAll($queryc);

    /*$queryc2 = "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check2='SI'";
    $resultc2 = $db->fetchAll($queryc2);*/

    $queryc2 = "SELECT (credito_valor - credito_retenido) as credito_valor FROM credito WHERE usuario_id='".$ide."'";
    $resultc2 = $db->fetchAll($queryc2);

    $credito = $resultc2[0]['credito_valor'];

    if($resultc[0]['costo_valor']>0){
      $costo = ($resultc[0]['costo_valor']*$numt);
    }else{
      $costo = (0.58*$numt);
    }

    if($resultc[0]['costo_valor']>0){
      $costo2 = ($resultc[0]['costo_valor2']*$numm);
    }else{
      $costo2 = (0.58*$numm);
    }


    if($resultc[0]['costo_valor']>0){
      $costo3 = ($resultc[0]['costo_valor3']*$numa);
    }else{
      $costo3 = (0.58*$numa);
    }

    $costo = str_replace(',','.',$costo);
    $costo2 = str_replace(',','.',$costo2);
    $costo3 = str_replace(',','.',$costo3);

    $supertotal = ($costo+$costo2+$costo3);


  	$result = array('preparada' => 'preparada',
                    'costo' => $costo,
                    'costo2' => $costo2,
                    'costo3' => $costo3);

    $result = array('preparada' => 'preparada',
                    'costo' => $costo,
                    'costo2' => $costo2,
                    'costo3' => $costo3,
                    'dinero' => $credito,
                    'total' => $supertotal);
  }

  $response   = array( 'success' => true );

  $response['info']=$result;
  echo json_encode( $response );
  exit();
  
}

?>

