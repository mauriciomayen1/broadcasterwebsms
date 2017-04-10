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
    $smarty->display('header.html');

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
	$costo->where("usuario_id ='".$ide."'");
	$costos = $db->fetchAll($costo);

	$conf = $db->select();
	$conf->from('categorias');
	$conf->where("usuario_id ='".$ide."' AND activo='1'");
	$confis = $db->fetchAll($conf);

    if(isset($costos[0]['costo_valor'])){
    	$smarty->assign('costo',$costos[0]['costo_valor']);
    }else{
        $smarty->assign('costo',NULL);
    }

    if(isset($costos[0]['costo_perfil'])){
    	$smarty->assign('costo2',$costos[0]['costo_perfil']);
    }else{
        $smarty->assign('costo2',NULL);
    }

    if(isset($costos[0]['costo_check'])){
    	$smarty->assign('aprobado',"APROBADO");
    }else{
        $smarty->assign('aprobado',NULL);
    }

    if(isset($costos[0]['costo_check2'])){
    	$smarty->assign('aprobado2',"APROBADO");
    }else{
        $smarty->assign('aprobado2',NULL);
    }

    if(isset($confis[0]['nombre'])){
    	$smarty->assign('cat',$confis[0]['nombre']);
    }else{
        $smarty->assign('cat',NULL);
    }

	$smarty -> display("configuration.html");

	if($flag == 1){

	    echo "<div class='alert alert-success alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 50%; left: 230px;'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <strong>¡Éxito!</strong> Se ha creado la configuración.
            </div>";
	}

	if($flag == 2){

	    echo "<div class='alert alert-success alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 50%; left: 230px;'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <strong>¡Éxito!</strong> Se ha actualizado la configuración.
            </div>";
	}

	if($flag == 3){

		echo "<div class='alert alert-success alert-dismissible fade in' role='alert' style='top: 0; position: absolute; width: 50%; left: 230px;'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <strong>¡Éxito!</strong> Se ha desactivado la configuración
            </div>";
	}

}


function agregar(){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');


	$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    if(isset($_REQUEST['answer']) && $_REQUEST['answer']=='Si' && $_REQUEST['name'] != NULL){
        $query= "SELECT * FROM categorias WHERE usuario_id='".$ide."' AND activo='1';";
	    $result = $db->fetchAll($query); 


	    if(count($result)<=0){
	       $data=array(
		        		'nombre' 	=> $_REQUEST['name'],
		        		'usuario_ID'		=> $ide
					  );
		   $insert = $db->insert('categorias',$data);
		   listar(1);
	    }else{
	    	$data=array(
		        		'nombre' 	=> $_REQUEST['name'],
					  );
		    $insert = $db->update('categorias',$data,"usuario_id =".$ide);
	        listar(2);
	    }
    }else{
    	$query= "SELECT * FROM categorias WHERE usuario_id='".$ide."' AND activo='1';";
	    $result = $db->fetchAll($query); 


	    if(count($result)>0){
	       $data=array(
		        		'activo' 	=> 0,
					  );
		    $insert = $db->update('categorias',$data,"usuario_id =".$ide);
	    }


	    /*if (!empty($_REQUEST['quantity']) && empty($_REQUEST['lookup'])) {
	    	$query= "SELECT * FROM costo WHERE usuario_id='".$ide."'";
		    $result = $db->fetchAll($query); 
              

		    if(count($result)>0){
		       $query2= "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check='SI' AND costo_valor !=".$_REQUEST['quantity'];

		       $result2 = $db->fetchAll($query2); 
		       if(count($result2)>0){
			       $data=array(
				        		'costo_valor' 	=> $_REQUEST['quantity'],
				        		'costo_check' 	=> NULL,
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }else{
			    	$data=array(
				        		'costo_valor' 	=> $_REQUEST['quantity'],
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }
		        listar(3);
		    }else{
		    	$data=array(
			        		'costo_valor' 	=> $_REQUEST['quantity'],
			        		'usuario_id'    => $ide
 						  );
			    $insert = $db->insert('costo',$data);
		        listar(3);
		    }
	    }*/


	    /*if (!empty($_REQUEST['lookup']) && empty($_REQUEST['quantity'])) {
	    	$query= "SELECT * FROM costo WHERE usuario_id='".$ide."'";
		    $result = $db->fetchAll($query); 



		    if(count($result)>0){
		       $query2= "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check2='SI' AND costo_perfil !=".$_REQUEST['lookup'];

		       $result2 = $db->fetchAll($query2); 
		       if(count($result2)>0){
			       $data=array(
				        		'costo_perfil' 	=> $_REQUEST['lookup'],
				        		'costo_check2' 	=> NULL,
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }else{
			    	$data=array(
				        		'costo_perfil' 	=> $_REQUEST['lookup'],
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }
		        listar(3);
		    }else{
		    	$data=array(
			        		'costo_perfil' 	=> $_REQUEST['lookup'],
			        		'usuario_id'    => $ide
 						  );
			    $insert = $db->insert('costo',$data);
		        listar(3);
		    }
	    }*/


	    /*if (!empty($_REQUEST['lookup']) && !empty($_REQUEST['quantity'])) {
	    	$query= "SELECT * FROM costo WHERE usuario_id='".$ide."'";
		    $result = $db->fetchAll($query); 


		    if(count($result)>0){
		       $query2= "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check2='SI' AND costo_perfil !=".$_REQUEST['lookup'];

		       $query3= "SELECT * FROM costo WHERE usuario_id='".$ide."' AND costo_check='SI' AND costo_valor !=".$_REQUEST['quantity'];

		       $result2 = $db->fetchAll($query2);

		       $result3 = $db->fetchAll($query3); 


		       if(count($result2)>0 && count($result3)>0){
			       $data=array(
				        		'costo_perfil' 	=> $_REQUEST['lookup'],
				        		'costo_valor' 	=> $_REQUEST['quantity'],
				        		'costo_check' 	=> NULL,
				        		'costo_check2' 	=> NULL,
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }elseif(count($result2)>0 && count($result3)<=0){
			       $data=array(
				        		'costo_perfil' 	=> $_REQUEST['lookup'],
				        		'costo_valor' 	=> $_REQUEST['quantity'],
				        		'costo_check2' 	=> NULL,
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }elseif(count($result2)<=0 && count($result3)>0){
			       $data=array(
				        		'costo_perfil' 	=> $_REQUEST['lookup'],
				        		'costo_valor' 	=> $_REQUEST['quantity'],
				        		'costo_check' 	=> NULL,
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }else{
			    	$data=array(
				        		'costo_perfil' 	=> $_REQUEST['lookup'],
				        		'costo_valor' 	=> $_REQUEST['quantity'],
							  );
				    $insert = $db->update('costo',$data,"usuario_id =".$ide);
			    }
		        listar(3);
		    }else{
		    	$data=array(
			        		'costo_perfil' 	=> $_REQUEST['lookup'],
			        		'costo_valor' 	=> $_REQUEST['quantity'],
			        		'usuario_id'    => $ide
 						  );
			    $insert = $db->insert('costo',$data);
		        listar(3);
		    }
	    }*/

        listar(3);

    }
 }

?>