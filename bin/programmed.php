<?php
    require_once ("../etc/config.php");
    ini_set('memory_limit', '-1');
    $config  = Zend_Registry::get('config');

    if($auth->hasIdentity()){
        $acciones = array(
                            'listar'    => 'listar',
                            'agregar'   => 'actualizar',
                            'editar'    => 'actualizar',
                            'buscar'    => 'buscar',
                            'eliminar'  => 'eliminar',
                            'guardar'   => 'guardar'
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
        $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001554066-Broadcaster-Hacer-un-env%C3%ADo-programado-");
        $smarty->display('header.html');

     if(!isset($_REQUEST['accion'])){ //Si no se ha enviado una accion
        listar();
     }else{ //Si hay una accion, ejecutarla
        while(list($k, $v) = each($acciones) ){
                if( $k == $_REQUEST['accion'] ){
                    $v();
                }
        }
     }
     //$smarty->display('footer.html');
    } else {
         header("Location: login.php");
    }

    

function listar() {
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session'); 
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params'); 

    $logger   = new Zend_Log ();
    $filename = date ( 'Ymd' );
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Programados_$filename.log";
    $writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
    $logger->addWriter ( $writer );
    $filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
    $logger->addFilter ( $filter );

    $hora = date ( 'Y/m/d H:i:s' );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO PROGRAMADOS - FN LISTAR -------------", Zend_Log::INFO );
    $logger->log ( "REQUEST" . print_r ( $_REQUEST, true ), Zend_Log::INFO ); 

    $fechaInicial   = $_REQUEST['fechaInicial'];
    $fechaFinal     = $_REQUEST['fechaFinal'];

    $flag = $_REQUEST['flag'];
    $msg = $_REQUEST['msg'];

    if (empty($fechaInicial)){
        $fechaInicial = date ( 'Y/m/d H:i:s' ); 
    }
    
    $smarty->assign('fechaInicial', $fechaInicial); 

    //LLENA EL COMBO de DESTINATARIOS
    $select = $db->select();
    $query = "SELECT * FROM fuentes_mkthorario WHERE mkthorario_activo = 1 ORDER BY mkthorario_hora";
    $result = $db->fetchAll($query);
    $smarty->assign('rows', $result);

    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001554066-Broadcaster-Hacer-un-env%C3%ADo-programado-");
    $smarty->assign('help2',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001554126-Broadcaster-Cancelar-un-env%C3%ADo-programado-");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    //LLENA EL COMBO de DESTINATARIOS
    $select = $db->select();
    $query = "SELECT DISTINCT(usuario_categoria), count(usuario_categoria) as total, count(usuario_operador) as total2 FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' GROUP BY usuario_categoria ORDER BY usuario_categoria ASC";
    $result = $db->fetchAll($query);
    $smarty->assign('rows2', $result);

    if($flag != NULL && $msg != NULL){
        $smarty->assign($flag, $msg);
    }

    $fecha = date('Y-m-d')." 00:00:00";
    $horario = date('H');
    $horas = date('H:i;s');

    $programado = $db->select();
    $programado->from('fuentes_mensajes_programados_toolbox','mensaje_region,DATE_FORMAT(mensaje_fechaenvio,"%d/%m/%Y") mensaje_fechaenvio, mensaje_horarionombre, mensaje_id');
    $programado->join('usuario','mensaje_usuario=usuario.usuario_id');
    $programado->where("usuario_activo ='1' AND mensaje_activo='1' AND mensaje_usuario='$ide' AND ((mensaje_fechaenvio = '$fecha' AND mensaje_horarionombre >= '$horas') OR (mensaje_fechaenvio > '$fecha')) AND mensaje_procesado = '1'  AND bandera_masivo = '1'");
    $programados = $db->fetchAll($programado);


    $smarty->assign('programados',$programados);

    $smarty->display('programmed.html');
 }


function guardar() {
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session'); 
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    $logger   = new Zend_Log ();
    $filename = date ( 'Ymd' );
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/ProgramadoGuardar_$filename.log";
    $writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
    $logger->addWriter ( $writer );
    $filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
    $logger->addFilter ( $filter );

    $hora = date ( 'Y/m/d H:i:s' );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO PROGRAMADOS - FN GUARDAR ------------", Zend_Log::INFO );
    $logger->log ( "REQUEST" . print_r ( $_REQUEST, true ), Zend_Log::INFO ); 

    /**RECUPERANDO ARGUNMENTOS PARA EL GUARDADO*/
    $categoria   = $_REQUEST['categoria'];
    $hora        = $_REQUEST['horaenvio'];
    $fecha_envio = $_REQUEST['fechaenvio'];
    $mensaje     = $_REQUEST['msgtxt'];
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



    $select = $db->select();
    $query  = "SELECT mkthorario_hora FROM fuentes_mkthorario WHERE mkthorario_id = '$hora'";
    $result = $db->fetchAll($query);

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

        $dia_actual = date ( 'Y-m-d' );
        $diferencia = compararFechas($fecha_envio, $dia_actual);
        $logger->log ( "DIFERENCIA: ". print_r($diferencia, true), Zend_Log::INFO );

        if($diferencia >= 0){
            $logger->log ( "ES UNA FECHA VALIDAD, AUN NO HA PASADO", Zend_Log::INFO );
            $repetido = "SELECT * FROM fuentes_mensajes_programados_toolbox WHERE mensaje_fechaenvio = '$fecha_envio' AND mensaje_horario = '$hora' AND mensaje_mensaje = '$mensaje' AND mensaje_nombre='$campania' and mensaje_activo ='1'";
            $repetidos = $db->fetchAll($repetido);

            if(count($repetidos)>0){
               $logger->log ( "Ya está repetido la programación de ese envío", Zend_Log::INFO );
               /*$smarty->assign('error', '¡Oops! Ya está repetido la programación de ese envío');*/

               $msg = '¡Oops! Ya está repetido la programación de ese envío';
              $flag = 'error';
            }else{
               try {
                        $veces = "SELECT usuario_veces FROM fuentes_usuarios_toolbox WHERE usuario_categoria = '".$categoria."' AND usuario_id_fk =".$ide;
                        $vez = $db->fetchAll($veces);

                        $vezmas = ($vez[0]['usuario_veces'] + 1);

                        $datos=array(
                                            'mensaje_horario'           => $hora,
                                            'mensaje_horarionombre'     => $result[0]['mkthorario_hora'],
                                            'mensaje_mensaje'           => $mensaje,
                                            'mensaje_nombre'            => $campania,
                                            'mensaje_fechaenvio'        => $fecha_envio,
                                            'mensaje_descripcion'       => $campania,
                                            'mensaje_fechaalta'         => date("Y/m/d H:i:s"),
                                            'mensaje_activo'            => 1,
                                            'mensaje_region'            => $categoria,
                                            'mensaje_ocupacion'         => $categoria,
                                            'mensaje_procesado'         => 1,
                                            'mensaje_usuario'                => $ide
                                        );
                    
                        $logger->log("DATOS A INSERTAR EN LA BASE MENSAJES PROGRAMADOS: ".print_r($datos,true), Zend_Log::INFO);
                        $insert = $db -> insert("fuentes_mensajes_programados_toolbox", $datos);
                        $logger->log ( "SE INSERTO: ". print_r($insert, true), Zend_Log::INFO );
                        /*$smarty->assign('mensaje', 'Registro exitoso');*/

                        $data = array(
                                      'usuario_programado'    => '0',
                                      'usuario_veces'    => $vezmas
                                      );
                        $where = 'usuario_categoria = "'.$categoria.'"  AND usuario_id_fk ='.$ide;

                        $update = $db->update('fuentes_usuarios_toolbox',$data,$where);

                        $check = "SELECT credito_retenido FROM credito WHERE usuario_id = '".$ide."'";
                         $checks = $db->fetchAll($check);

                        $retenme = ($_REQUEST['retenido'] + $checks[0]['credito_retenido']);


                        $retenido = array(
                                      'credito_retenido'    => $retenme
                                      );
                        $wherere = 'usuario_id = "'.$ide.'"';

                        $updatere = $db->update('credito',$retenido,$wherere);



                        $msg = 'Registro exitoso';
                        $flag = 'mensaje';
                } catch (Exception $e) {
                         $msg = '¡Oops! Ocurrio un error. Intentelo mas tarde si el problema persiste contacta al administrador';
            $flag = 'error';
                }
            }

        }else{
            $logger->log ( "SELECCIONO UNA FECHA QUE YA PASO", Zend_Log::INFO );
            /*$smarty->assign('error', '¡Oops! Ocurrio un error. La fecha que seleccionaste como fecha de envio no puede ser anterior al dia de hoy');*/

            $msg = '¡Oops! Ocurrio un error. La fecha que seleccionaste como fecha de envio no puede ser anterior al dia de hoy';
            $flag = 'error';
        }

        
    }else{
       $logger->log ( "NO LLENO TODOS O ALGUNOS DE LOS CAMPOS", Zend_Log::INFO );
       /*$smarty->assign("error","¡Oops! Ocurrio un problema. Todos los campos son requeridos"); */

           $msg = '¡Oops! Ocurrio un problema. Todos los campos son requeridos';
           $flag = 'error';
    }

    /*//LLENA EL COMBO de DESTINATARIOS
    $select = $db->select();
    $query = "SELECT * FROM fuentes_mkthorario WHERE mkthorario_activo = 1 ORDER BY mkthorario_hora";
    $result = $db->fetchAll($query);
    $smarty->assign('rows', $result);

    //LLENA EL COMBO de DESTINATARIOS
    $select = $db->select();
    $query = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='$ide' ORDER BY usuario_categoria";
    $result = $db->fetchAll($query);
    $smarty->assign('rows2', $result);*/

    /*$smarty->display('programmed.html');*/
    $logger->log ( "FIN:::...", Zend_Log::INFO );
 

    echo "<script type='text/javascript'>
                   window.location = 'http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/programmed.php?accion=listar&flag=".$flag."&msg=".$msg."';
              </script>";


    /*listar($flag,$msg);*/
}



function compararFechas($primera, $segunda){
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session'); 
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    $logger   = new Zend_Log ();
    $filename = date ( 'Ymd' );
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Comparar_$filename.log";
    $writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
    $logger->addWriter ( $writer );
    $filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
    $logger->addFilter ( $filter );

    $hora = date ( 'Y/m/d H:i:s' );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO PROGRAMADOS - FN COMPARAR FECHAS ----", Zend_Log::INFO );
    $logger->log ( "REQUEST" . print_r ( $_REQUEST, true ), Zend_Log::INFO ); 

    $logger->log ( "PRIMERA FECHA:: " . print_r ( $primera, true ), Zend_Log::INFO ); 
    $logger->log ( "SEGUNDA FECHA:: " . print_r ( $segunda, true ), Zend_Log::INFO ); 

    $valoresPrimera = explode ("-", $primera);   
    $valoresSegunda = explode ("-", $segunda); 

    $diaPrimera    = $valoresPrimera[2];  
    $mesPrimera    = $valoresPrimera[1];  
    $anyoPrimera   = $valoresPrimera[0]; 

    $diaSegunda   = $valoresSegunda[2];  
    $mesSegunda   = $valoresSegunda[1];  
    $anyoSegunda  = $valoresSegunda[0];

    $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
    $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     

    if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
        // "La fecha ".$primera." no es v&aacute;lida";
        return 0;
    }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
        // "La fecha ".$segunda." no es v&aacute;lida";
        return 0;
    }else{
        return  $diasPrimeraJuliano - $diasSegundaJuliano;
    } 

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


    $query = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."'";

    $result = $db->fetchAll($query);


    $queryt = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."' AND usuario_operador='Telcel'";

    $resultt = $db->fetchAll($queryt);

    $numt = count($resultt);

    $querym = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."' AND usuario_operador='Movistar'";

    $resultm = $db->fetchAll($querym);

    $numm= count($resultm);

    $querya = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$_REQUEST['selector']."' AND (usuario_operador='Nextel' or usuario_operador='Iusacell' OR usuario_operador='Unefon')";

    $resulta = $db->fetchAll($querya);

    $numa = count($resulta);

    /*$num = count($result);*/


        $queryc = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
        $resultc = $db->fetchAll($queryc);

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


            $result = array('costo' => $costo,
                            'costo2' => $costo2,
                            'costo3' => $costo3,
                            'dinero' => $credito,
                            'total' => $supertotal);

  $response   = array( 'success' => true );

  $response['info']=$result;
  echo json_encode( $response );
  exit();
  
}

?>