<?php
require_once ("../etc/config.php");

if ($auth->hasIdentity()) { 
    $acciones = array(
        'listar'    => 'listar',
        'agregar'   => 'actualizar',
        'editar'    => 'actualizar',
        'eliminar'  => 'eliminar',
        'enviar'    => 'enviar'
    );

    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    $querycampaign = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
    $resultcampaign = $db->fetchAll($querycampaign);
    $smarty->assign('campanas', $resultcampaign);

    $smarty->assign('application', $config->application);
    $smarty->assign('activo',$_SESSION["activo"]);
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
    //$smarty->display('footer.html');
} else {
    header("Location: login.php");
}

function listar() {
    $config  = Zend_Registry::get('config');
    $db      = Zend_Registry::get('db');
    $session = Zend_Registry::get('session'); 
    $smarty  = Zend_Registry::get('smarty');   

    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];
    
   $query = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
     $result = $db->fetchAll($query);
     $smarty->assign('rows', $result);
    $smarty->display("masive.html");

 } 

 function enviar(){

    $config  = Zend_Registry::get('config');
    $db      = Zend_Registry::get('db');
    $session = Zend_Registry::get('session'); 
    $smarty  = Zend_Registry::get('smarty');  
    
    $logger   = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Masivs_$filename.log";
    $writer   = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');

    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- ENVIO MASIVO PREPARAR - FN PREPARAR -------", Zend_Log::INFO );

    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);

    $categoria = $_REQUEST['selectcategoria'];

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
            $update = $db->update('fuentes_usuarios_toolbox',$data,"usuario_id_fk=".$ide);
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
                $smarty->assign('mensaje1', ' se preparo correctamente, con un total de ');
                $smarty->assign('update', $update);
                $smarty->assign('mensaje2', ' registros preparados ');
            }
    
        }catch(Exception $e){
            $logger->log("EXCEPTION:: ". print_r($e, true), Zend_Log::INFO);
            $smarty->assign('mensaje3', 'Oops! Ocurrio un error, intentalo mas tarde, si los problema persisten ponte en contacto con el administrador.');
        } 

    

     

     

     //$select = $db->select();

     //LLENA EL COMBO
     $query = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk=".$ide." ORDER BY usuario_categoria ASC";
     $result = $db->fetchAll($query);
     $smarty->assign('rows', $result);
     
      $smarty->display("masive.html");  
     //listar(); 
 } 

 
?>

