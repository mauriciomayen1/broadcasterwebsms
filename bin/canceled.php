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
		                         'guardar'	=> 'guardar',
		                         'eliminar'	=> 'eliminar'
	                           );

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


	          $smarty->assign('application', $config->application);
	          $smarty->assign('activo',$_SESSION["activo"]);
              $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001554126-Broadcaster-Cancelar-un-env%C3%ADo-programado-");
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
function listar($flag=0){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');

	$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    $fecha = date('Y-m-d')." 00:00:00";
    $horario = date('H');
    $hora = date('H:i;s');

	$programado = $db->select();
	$programado->from('fuentes_mensajes_programados_toolbox','mensaje_region,DATE_FORMAT(mensaje_fechaenvio,"%d/%m/%Y") mensaje_fechaenvio, mensaje_horarionombre, mensaje_id');
	$programado->join('usuario','mensaje_usuario=usuario.usuario_id');
    $programado->where("usuario_activo ='1' AND mensaje_activo='1' AND mensaje_usuario='$ide' AND mensaje_fechaenvio >= '$fecha' AND mensaje_horarionombre >= '$hora' AND mensaje_procesado = '1' ");
	$programados = $db->fetchAll($programado);


	$smarty->assign('programados',$programados);

	$smarty -> display("canceled.html");

    if($flag == 1){

        echo "<div class='alert alert-success alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 50%; left: 230px;'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <strong>¡Éxito!</strong> Se han cancelados los envíos programados seleccionados.
            </div>";
    }

    if($flag == 2){

        echo "<div class='alert alert-error alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 50%; left: 230px;'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <strong>¡Error!</strong> No se han cancelados los envíos programados seleccionados o no se enviaron envíos a cancelar.
            </div>";
    }
}

function guardar() {
    
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session');
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    
    $logger = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/GuardadoCancelados_$filename.log";
    $writer = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("**********************************INICIO: $hora", Zend_Log::INFO);
    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);

    
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


    if(count($_REQUEST['ide'])>0){
      foreach ($_REQUEST['ide'] as $key => $v) {

          if(!empty($v) && $v!="NO"){
              $datos = array( "mensaje_activo"         => "0",
                  );

                 $update = $db -> update("fuentes_mensajes_programados_toolbox", $datos, "mensaje_id = '".$key."'");
                 $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

                 $bandera = 1;


                 $consulta = "SELECT mensaje_region FROM fuentes_mensajes_programados_toolbox WHERE mensaje_id = '".$key."'";

                 $resultado = $db->fetchAll($consulta);


                 /*print_r($resultado); die();*/


                 foreach ($resultado as $key2 => $value) {
                   $query = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$value['mensaje_region']."'";

                    $result = $db->fetchAll($query);


                    $queryt = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$value['mensaje_region']."' AND usuario_operador='Telcel'";

                    $resultt = $db->fetchAll($queryt);

                    $numt = count($resultt);

                    $querym = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$value['mensaje_region']."' AND usuario_operador='Movistar'";

                    $resultm = $db->fetchAll($querym);

                    $numm= count($resultm);

                    $querya = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_id_fk='".$ide."' AND usuario_categoria='".$value['mensaje_region']."' AND (usuario_operador='Nextel' or usuario_operador='Iusacell' OR usuario_operador='Unefon')";

                    $resulta = $db->fetchAll($querya);

                    $numa = count($resulta);

                    /*$num = count($result);*/


                        $queryc = "SELECT * FROM costo WHERE usuario_id='".$ide."'";
                        $resultc = $db->fetchAll($queryc);

                        $queryc2 = "SELECT credito_valor, credito_retenido FROM credito WHERE usuario_id='".$ide."'";
                        $resultc2 = $db->fetchAll($queryc2);

                        $credito = $resultc2[0]['credito_valor'];
                        $retenido = $resultc2[0]['credito_retenido'];

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

                            $final1 = ($credito + $supertotal);
                            $final2 = ($retenido - $supertotal);

                            $datosactual = array( "credito_valor"         => $final1,
                                            "credito_retenido"         => $final2,
                                          );


                            $updateactual = $db -> update("credito", $datosactual, "usuario_id='".$ide."'");
                            $logger->log("ACTUALIZAR: ". print_r($updateactual, true), Zend_Log::INFO);



                 }


           }

      }
    }




    $smarty->assign('accion', 'guardar');   
    $hora = date('Y/m/d H:i:s');
    $logger->log("FIN: $hora", Zend_Log::INFO);

    if($bandera==1){
      echo '<script type="text/javascript">
      alert("Se ha(n) eliminado el(los) envíos(s) programado(s)")
                   setTimeout(function(){ window.location = "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/programmed.php"; }, 100);
              </script>';
    }else{
      echo '<script type="text/javascript">
      alert("No ha(n) eliminado el(los) envíos(s) programado(s). Contacte a su administrador")
                   setTimeout(function(){ window.location = "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/programmed.php"; }, 100);
              </script>';
    }
   
 }
?>