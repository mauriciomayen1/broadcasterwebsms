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
function listar($flag=0){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');

	$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

	$costo = $db->select();
	$costo->from('costo');
    $costo->where("usuario_activo ='1'");
	$costo->joinRight('usuario','costo.usuario_id=usuario.usuario_id');
    $costo->order("usuario.usuario_id");
    $costo->group("usuario_login");
	$costos = $db->fetchAll($costo);

	$smarty->assign('costos',$costos);

	$smarty -> display("approve.html");

    if($flag == 1){

        echo "<div class='page-title2' style='padding: 35px 0;'>
                   <div class='alert alert-success alert-dismissible fade in' role='alert' style='top: -375px; position: absolute; width: 100%;'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                        <h2>¡Éxito! Se han guardado los nuevos costos.</h2>
                    </div>
              </div>
            ";
    }

    if($flag == 2){

        echo "<div class='page-title2' style='padding: 35px 0;'>
                   <div class='alert alert-ERROR alert-dismissible fade in' role='alert' style='top: -375px; position: absolute; width: 100%;'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                        <h2>¡Error! No se han podido guardar los nuevos costos.</h2>
                    </div>
              </div>
              ";
    }
}

function guardar($flag=0) {
    
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session');
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    
    $logger = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/GuardadoCostos_$filename.log";
    $writer = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("**********************************INICIO: $hora", Zend_Log::INFO);
    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);



    foreach ($_REQUEST['ide'] as $key => $v) {


            if($v>"0.01"){
                $datos = array( "costo_valor"         => $v,
                );

               $update = $db -> update("costo", $datos, "usuario_id='".$key."'");
               $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

               if($update==0){
                    if(isset($v) && !empty($v)){
                        $datosi = array( "costo_valor"         => $v,
                                        "costo_valor2"         => "0.58",
                                        "costo_valor3"         => "0.58",
                                        "usuario_id"          => $key
                        );

                        $insert = $db -> insert("costo",$datosi);
                        $logger->log("INSERTAR: ". print_r($insert, true), Zend_Log::INFO);
                    }
               }
            }else{
               }


             $bandera = 1;

    }




    foreach ($_REQUEST['ide2'] as $key => $v) {
    

               if($v>"0.01"){
                $datos = array( "costo_valor2"         => $v,
                );

               $update = $db -> update("costo", $datos, "usuario_id='".$key."'");
               $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

               if($update==0){
                    if(isset($v) && !empty($v)){
                        $datosi = array( "costo_valor2"         => $v,
                                        "costo_valor"         => "0.58",
                                        "costo_valor3"         => "0.58",
                                        "usuario_id"          => $key
                        );

                        $insert = $db -> insert("costo",$datosi);
                        $logger->log("INSERTAR: ". print_r($insert, true), Zend_Log::INFO);
                    }
               }
            }else{

               }


             $bandera = 1;

    }



    foreach ($_REQUEST['ide3'] as $key => $v) {


            if($v>"0.01"){
                $datos = array( "costo_valor3"         => $v,
                );

               $update = $db -> update("costo", $datos, "usuario_id='".$key."'");
               $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

               if($update==0){
                    if(isset($v) && !empty($v)){
                        $datosi = array( "costo_valor3"         => $v,
                                        "costo_valor"         => "0.58",
                                        "costo_valor2"         => "0.58",
                                        "usuario_id"          => $key
                        );

                        $insert = $db -> insert("costo",$datosi);
                        $logger->log("INSERTAR: ". print_r($insert, true), Zend_Log::INFO);
                    }
               }
            }else{
               }


             $bandera = 1;

    }


    foreach ($_REQUEST['ide4'] as $key => $v) {


            if($v>"0.01"){
                $datos = array( "costo_perfil"         => $v,
                );

               $update = $db -> update("costo", $datos, "usuario_id='".$key."'");
               $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

               if($update==0){
                    if(isset($v) && !empty($v)){
                        $datosi = array( "costo_perfil"         => $v,
                                        "costo_valor"         => "0.58",
                                        "costo_valor2"         => "0.58",
                                        "costo_valor3"         => "0.58",
                                        "usuario_id"          => $key
                        );

                        $insert = $db -> insert("costo",$datosi);
                        $logger->log("INSERTAR: ". print_r($insert, true), Zend_Log::INFO);
                    }
               }
            }else{
               }


             $bandera = 1;

    }


    foreach ($_REQUEST['ide5'] as $key => $v) {


            if($v>"0.01"){
                $datos = array( "costo_perfil2"         => $v,
                );

               $update = $db -> update("costo", $datos, "usuario_id='".$key."'");
               $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

               if($update==0){
                    if(isset($v) && !empty($v)){
                        $datosi = array( "costo_perfil2"         => $v,
                                        "costo_valor"         => "0.58",
                                        "costo_valor2"         => "0.58",
                                        "costo_valor3"         => "0.58",
                                        "usuario_id"          => $key
                        );

                        $insert = $db -> insert("costo",$datosi);
                        $logger->log("INSERTAR: ". print_r($insert, true), Zend_Log::INFO);
                    }
               }
            }else{
               }


             $bandera = 1;

    }


    foreach ($_REQUEST['ide6'] as $key => $v) {


            if($v>"0.01"){
                $datos = array( "costo_perfil3"         => $v,
                );

               $update = $db -> update("costo", $datos, "usuario_id='".$key."'");
               $logger->log("ACTUALIZAR: ". print_r($update, true), Zend_Log::INFO);

               if($update==0){
                    if(isset($v) && !empty($v)){
                        $datosi = array( "costo_perfil3"         => $v,
                                        "costo_valor"         => "0.58",
                                        "costo_valor2"         => "0.58",
                                        "costo_valor3"         => "0.58",
                                        "usuario_id"          => $key
                        );

                        $insert = $db -> insert("costo",$datosi);
                        $logger->log("INSERTAR: ". print_r($insert, true), Zend_Log::INFO);
                    }
               }
            }else{
               }


             $bandera = 1;

    }




    $smarty->assign('accion', 'guardar');   
    $hora = date('Y/m/d H:i:s');
    $logger->log("FIN: $hora", Zend_Log::INFO);

    if($bandera==1){
      listar(1);
    }else{
      listar(2);
    }
   
 }
?>