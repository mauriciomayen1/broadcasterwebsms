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
		                         'eliminar'	=> 'eliminar',
		                         'enviar'	=> 'enviar'
	                           );

            $usuarios = $db->select();
		    $usuarios->from('usuario');
		    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
		    $usuario = $db->fetchAll($usuarios);
		    $ide = $usuario[0]['usuario_id'];

		    $smarty->assign('usuario', $_SESSION["activo"]);
		    $smarty->assign('logotipo', $usuario[0]['foto']);



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

	$smarty -> display("contact.html");

	if($flag == 1){
		echo "<div class='page-title2' style='padding: 35px 0;'>
				    <div class='alert alert-success alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 100%;'>
		                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
		                <h2>Tu comentario ha sido enviado, pronto un agente se pondrá en contacto contigo...</h2>
		            </div>
              </div>
             ";
	}

	if($flag == 2){
		echo "<div class='page-title2' style='padding: 35px 0;'>
				    <div class='alert alert-error alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 100%;'>
		                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
		                <h2>¡Error! No se ha enviado su comentario, por favor contacte a su administrador.</h2>
		            </div>
              </div>
            ";
	}
}

function enviar() {
    
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session');
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');

    //print_r($_REQUEST); die();
    
    $logger = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/EnvioCorreo_$filename.log";
    $writer = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("***********************************************************", Zend_Log::INFO);
    $logger->log("**********************************INICIO: $hora", Zend_Log::INFO);
    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);


    $query = "SELECT * FROM usuario WHERE usuario_nombre = '".$_SESSION['activo']."';";
    $result = $db->fetchAll($query);



    $mensaje2 = $_REQUEST['message']."\r\n Correo: ".$result[0]['usuario_login']."\r\n Nombre: ".$result[0]['usuario_nombre']."\r\n Celular: ".$result[0]['usuario_msisdn'];
    $para = "operations@conceptomovil.zendesk.com;mauricio.mayen@conceptomovil.com";
    $headers = "From: sms@conceptomovil.com" ;
    

    $mensaje = mail($para,"Broadcaster WEB",$mensaje2, $headers); 



    $logger->log("MENSAJE: ". print_r($mensaje, true), Zend_Log::INFO);

    $smarty->assign('accion', 'enviar');
    $smarty->assign('mensaje', $mensaje);    
    $hora = date('Y/m/d H:i:s');
    $logger->log("FIN: $hora", Zend_Log::INFO);

    if($mensaje==1){
        listar(1);
    }else{
        listar(2);
    }
   
 }
?>