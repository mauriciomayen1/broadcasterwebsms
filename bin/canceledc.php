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


function guardar() {
    
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session');
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    
    $logger = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/GuardadoCanceladosCam_$filename.log";
    $writer = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("**********************************INICIO: $hora", Zend_Log::INFO);
    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);




    if(count($_REQUEST['ide'])>0){
      foreach ($_REQUEST['ide'] as $key => $v) {

          if(!empty($v)){
              $datos = array( "usuario_activo"         => "0",
                  );

                 $update = $db -> update("fuentes_usuarios_toolbox", $datos, "usuario_categoria='".$v."'");
                 $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

                 $bandera = 1;

           }

      }
    }



    $smarty->assign('accion', 'guardar');   
    $hora = date('Y/m/d H:i:s');
    $logger->log("FIN: $hora", Zend_Log::INFO);

    if($bandera==1){
      echo '<script type="text/javascript">
      alert("Se ha(n) eliminado la(s) campaña(s)")
                   setTimeout(function(){ window.location = "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/load.php"; }, 100);
              </script>';
    }else{
      echo '<script type="text/javascript">
      alert("No se ha(n) eliminado la(s) campaña(s). Contacte a su administrador")
                   setTimeout(function(){ window.location = "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/load.php"; }, 100);
              </script>';
    }
   
 }
?>