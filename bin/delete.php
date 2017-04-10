<?php
require_once ("../etc/config.php");
ini_set('memory_limit', '-1');
$config  = Zend_Registry::get('config');

/*        if ($auth->hasIdentity()) 
           { */
  $acciones = array(
                     'listar'	=> 'listar',
                     'agregar'	=> 'agregar',
                     'editar'	=> 'actualizar',
                     'eliminar'	=> 'eliminar'
                   );

  $smarty->assign('application', $config->application);

  if (!isset($_REQUEST['accion'])) { //Si no se ha enviado una accion
		listar();
	} else { //Si hay una accion, ejecutarla
		while( list($k, $v) = each($acciones) ){
			if( $k == $_REQUEST['accion'] ){
				$v();
			}
		}
	}
/*} else {
    header("Location: login.php");
}*/




function eliminar(){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');


    $usuarios = $db->select();
	$usuarios->from('usuario','usuario_id');
	$usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
	$usuario = $db->fetchAll($usuarios);
    $id = $usuario[0]['usuario_id'];

       if($_REQUEST['campanas']=="Todos"){
          $data=array(
	        		'usuario_activo'		=> 0
				  );
	      $update = $db->update('fuentes_usuarios_toolbox',$data,"usuario_id_fk ='".$id."'");
       }else{
          $data=array(
	        		'usuario_activo'		=> 0
				  );
	      $update = $db->update('fuentes_usuarios_toolbox',$data,"usuario_id_fk ='".$id."' AND usuario_categoria='".$_REQUEST['campanas']."'");
       }

       echo '<script type="text/javascript">


        alert("Se ha eliminado la base de datos")
	               setTimeout(function(){ window.location = "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/mt.php"; }, 100);
		      </script>';
/*
	   header("Location: mt.php");*/
 }

?>