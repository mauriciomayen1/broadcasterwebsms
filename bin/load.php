<?php
 require_once ("../etc/config.php");
require_once ("/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/lib/phpMailer/class.phpmailer.php");
set_time_limit(95);

if ($auth->hasIdentity()) { 
	$acciones = array(
		'listar'	 => 'listar',
		'agregar'	 => 'actualizar',
		'editar'	 => 'actualizar',
		'editar'     => 'editar',
		'cargar'     => 'cargar',
		'eliminar'	 => 'eliminar',
		'guardar'	 => 'guardar',
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

    $querycampaign = "SELECT DISTINCT(usuario_categoria) FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_id_fk='".$ide."' ORDER BY usuario_categoria ASC";
    $resultcampaign = $db->fetchAll($querycampaign);
    $smarty->assign('campanas', $resultcampaign);

	$smarty->assign('application', $config->application);
	$smarty->assign('activo',$_SESSION["activo"]);
    $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001431626-Broadcaster-Crear-una-campa%C3%B1a-");
    $smarty->assign('help2',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001590566-Broadcaster-Eliminar-campa%C3%B1a-s-");
    $smarty->assign('help3',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001432566-Broadcaster-Actualizar-una-campa%C3%B1a-");
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
} else {
    header("Location: login.php");
}

function listar() {
	$config  = Zend_Registry::get('config');
	$db 	 = Zend_Registry::get('db');
	$session = Zend_Registry::get('session'); 
	$smarty  = Zend_Registry::get('smarty');
	$params  = Zend_Registry::get('params');

    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    $categoria = $db->select();
    $categoria->from('fuentes_usuarios_toolbox','usuario_categoria, count(usuario_categoria) as total, count(usuario_operador) as total2');
    $categoria->where("usuario_id_fk ='".$ide."' AND usuario_activo='1'");
    $categoria->group("usuario_categoria");
    $categorias = $db->fetchAll($categoria);


    $smarty->assign('rows', $categorias);    

	$smarty->display('load.html');	
 }

 function cargar1() {
	$config   = Zend_Registry::get('config');
	$db 	  = Zend_Registry::get('db');
	$session  = Zend_Registry::get('session'); 
	$smarty   = Zend_Registry::get('smarty');
	$params   = Zend_Registry::get('params'); 

	$logger   = new Zend_Log ();
	$filename = date ( 'Ymd' );
	$filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Carga_$filename.log";
	$writer   = new Zend_Log_Writer_Stream ( $filename, 'ab' );
	$logger->addWriter ( $writer );
	$filter = new Zend_Log_Filter_Priority ( Zend_Log::INFO );
	$logger->addFilter ( $filter );

	$hora = date ( 'Y/m/d H:i:s' );
	$logger->log ( "----------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "----------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "----------------------------------------------------", Zend_Log::INFO );
    $logger->log ( "---- USUARIOS CARGAR XLS - FN CARGAR ---------------", Zend_Log::INFO );
	$logger->log ( "REQUEST" . print_r ( $_REQUEST, true ), Zend_Log::INFO );

	$logger->log("FILES: ". print_r($_FILES, true), Zend_Log::INFO);

    $banderabase = 0;
    $banderahub  = 0;
    $banderadata = 0;
    $bandera     = 0;
    $procesar    = 0;
    $bandera_operador_valido = 0;
    $cont_perfilados = 0;


    $usuarios = $db->select();
	$usuarios->from('usuario','usuario_id');
	$usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
	$usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    //exit();

    /*if(filter_var($_REQUEST['correo'], FILTER_VALIDATE_EMAIL)){*/
       
        $target_path = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/usuarios/";
        if(!empty($_FILES['usuarios']['name'])){
            $nombreArchivoServidor = rand(0,9). uniqid().rand(0,9);
            $target_path = $target_path . basename( "CargaXls_".$nombreArchivoServidor."Entrada.xls");
            $logger->log("TARGET: ". print_r($target_path, true), Zend_Log::INFO);
    
            if($_FILES['usuarios']["type"] == "application/octet-stream" || $_FILES['usuarios']["type"] == "application/vnd.ms-excel"){
                if(move_uploaded_file($_FILES['usuarios']['tmp_name'], $target_path)) {
                    $mensaje1 =  "El Archivo ".  basename( $_FILES['usuarios']['name']). " ha sido subido correctamente";
                    $procesar = 1;
                } else{
                    $mensaje2 = "Hubo un error en la subida del archivo";
                    $respuesta = "false";
                }
            }else{
                $mensaje2 = "El archivo no es valido, recuerda que debe ser un archivo con la ext .xls";
                $respuesta = "false";
                $procesar = 0;
            }
        }else{
            $mensaje2 = "Necesitas seleccionar un archivo para ser cargado.";
        }
        try{
            $datos = array( "mktArchivo_nombre"         => $_FILES['usuarios']['name'],
                            "mktArchivo_nombreServidor" => "CargaXls_".$nombreArchivoServidor."Entrada.xls",
                            "mktArchivo_fecha"          => date("Y-m-d H:i:s"),
                            "mktArchivo_procesado"      => $procesar,
                            "mktArchivo_mensaje"        => $mensaje,
                            "mktArchivo_correo"         => $_REQUEST['correo'],
                            "mktArchivo_archivoSalida"  => ''
                        );
        
            $insertar = $db -> insert("fuentes_mktArchivo", $datos);
            $logger->log("INSERTO:: ". print_r($insertar, true), Zend_Log::INFO);
        }catch(Exception $e){
            $logger->log("EXCEPTION:: ". print_r($e, true), Zend_Log::INFO);
        }
        
    /*}elseif(empty($_REQUEST['correo'])){
        $mensaje2 = "Es necesario ingresar un correo electrónico.";
    }else{    
        $mensaje2 = "Debes ingresar un correo valido.";
    }*/

    $logger->log("MENSAJE 1:: ". print_r($mensaje1, true), Zend_Log::INFO);
    $logger->log("MENSAJE 2:: ". print_r($mensaje2, true), Zend_Log::INFO);

    if(!empty($mensaje1)){
        $smarty->assign('mensaje1', $mensaje1); 
    }else{
        $smarty->assign('mensaje2', $mensaje2);         
    }
       
    $logger->log("FIN DE LA PRIMERA PARTE DE LA CARGA DE ARCHIVOS::::::::::..........", Zend_Log::INFO);

    /*********INICIO CODIGO AGREGADO***********/
    $select = $db -> select();
    $select -> from("fuentes_mktArchivo", "*");
    $select -> where("mktArchivo_procesado=1");
    $select -> order("mktArchivo_fecha ASC");
    $select -> limit(1);
    $result = $db -> fetchAll($select);
    
    $logger->log ( "RESULTADO QUERY PARA VER EL ULTIMO ARCHIVO SUBIDO: ". print_r($result, true), Zend_Log::INFO );
    
    $update = $db -> update("fuentes_mktArchivo", array("mktArchivo_procesado" => 0), "mktArchivo_id='". $result[0]['mktArchivo_id']."'");
    $logger->log ( "SE HIZO EL UPDATE: ". print_r($update, true), Zend_Log::INFO );

    $archivo = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/usuarios/". $result[0]['mktArchivo_nombreServidor'];
    $logger->log ( "PATH ARMADO DE ARCHIVO ENTRADA: ". $archivo, Zend_Log::INFO );

    $archivoSalida = str_replace("Entrada", "Salida", $archivo);
    $logger->log ( "PATH ARMADO DE ARCHIVO SALIDA: ". $archivoSalida, Zend_Log::INFO );

    //$filas = file($archivo);
    //$i = 0;
    //$logger->log ( "ARRAY: ". print_r($filas, true), Zend_Log::INFO );
    //$banderaCorreo = 0;

    /*$usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];*/

    if($procesar == 1){
        $logger->log ( "LECTURA DEL ARCHIVO XLS.", Zend_Log::INFO );
        /*****PARA LEER EXCEL*/
        $file = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/usuarios/". $result[0]['mktArchivo_nombreServidor'];
        chmod($file, 0777);
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($file);
        $numRows = $data->sheets[0]['numRows'];

        if($_REQUEST['nombrec']){
           $categoria = $_REQUEST['nombrec'];
        }elseif($_REQUEST['nombrec1']){
           $categoria = $_REQUEST['nombrec1'];
        }else{
            $categoria = $_SESSION["activo"];
        }


        for($i=1; $i <= $numRows; $i++){
                                        $logger->log ( "--------------------------->", Zend_Log::INFO );

                                        $banderabase = 0;
                                        $banderahub  = 0;
                                        $banderadata = 0;
                                        $bandera     = 0;

                                        $msisdn      = $data->sheets[0]['cells'][$i][1];

                                        $logger->log ( "QUE TRAE MSISDN: ". print_r($msisdn, true), Zend_Log::INFO );
                                        /*$logger->log ( "QUE TRAE OPERADOR: ". print_r($operador, true), Zend_Log::INFO );*/
                                        $logger->log ( "QUE TRAE CATEGORIA: ". print_r($categoria, true), Zend_Log::INFO );
                                        

                                        $fp = fopen($archivoSalida, 'a+');
            
                                        if(strlen($msisdn) == 10){
                                            $logger->log ( "SI TRAE MSISDN", Zend_Log::INFO );


                                            $select = $db->select();
                                            $select->from('mt_sms','mt_operador');
                                            $select->where("mt_msisdn ='".$msisdn."'");
                                            $select->limit(1, 0);
                                            $total = $db->fetchAll($select);


                                            $operador = $total[0]['mt_operador'];

                                            $medioperfil = "Base";
                                            $bandera_operador_valido = 1;

                                            //echo $operador;

                                            if(count($total) <= 0){
                                                $select = $db->select();
                                                $select->from('motherbase','operador');
                                                $select->where("msisdn ='".$msisdn."'");
                                                $select->limit(1, 0);
                                                $total = $db->fetchAll($select);


                                                $operador = $total[0]['operador'];

                                                $medioperfil = "BaseMadre";
                                                $bandera_operador_valido = 1;

                                            }

                                            if(count($total) <= 0){

                                                        /*$logger->log("ENTRO A DATA24", Zend_Log::INFO); 
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
                                                            $medioperfil = 'Data24';
                                                            $bandera_operador_valido = 1;
                                                        }elseif($idoperador == '138746'){
                                                            $operador = 'Movistar';
                                                            $medioperfil = 'Data24';
                                                            $bandera_operador_valido = 1;
                                                        }elseif($idoperador == '115405'){
                                                            $operador = 'Iusacell';
                                                            $medioperfil = 'Data24';
                                                            $bandera_operador_valido = 1;
                                                        }elseif($idoperador == '158062'){
                                                            $operador = 'Nextel';
                                                            $medioperfil = 'Data24';
                                                            $bandera_operador_valido = 1;
                                                        }elseif($idoperador != '134533' && $idoperador != '138746' && $idoperador != '115405' && !empty($idoperador)){
                                                        }

                                                        echo "hola"; die();*/


                                                        $operador = 'Telcel';
                                                            $medioperfil = 'Data24';
                                                            $bandera_operador_valido = 1;

                                            }



                                            if(!empty($operador)){
                                                $logger->log ( "SI TRAE OPERADOR", Zend_Log::INFO );
                                                /*if($operador == 'TELCEL' || $operador == 'Telcel' || $operador == 'telcel' || $operador == 'telce'){
                                                   $operador = 'Telcel';
                                                   $bandera_operador_valido = 1;
                                                }
                                                if($operador == 'MOVISTAR' || $operador == 'Movistar' || $operador == 'movistar' || $operador == 'movi'){
                                                   $operador = 'Movistar';
                                                   $bandera_operador_valido = 1;
                                                }
                                                if($operador == 'IUSACELL' || $operador == 'Iusacell' || $operador == 'iusacell' || $operador == 'iusa'){
                                                   $operador = 'Iusacell';
                                                   $bandera_operador_valido = 1;
                                                }
                                                if($operador == 'UNEFON' || $operador == 'Unefon' || $operador == 'unefon'){
                                                   $operador = 'Unefon';
                                                   $bandera_operador_valido = 1;
                                                }
                                                if($operador == 'NEXTEL' || $operador == 'Nextel' || $operador == 'nextel'){
                                                   $operador = 'Nextel';
                                                   $bandera_operador_valido = 1;
                                                }
                                                if($operador == 'ATT' || $operador == 'att' || $operador == 'at&t'){
                                                   $operador = 'ATT';
                                                   $bandera_operador_valido = 1;
                                                }*/
                                                if($bandera_operador_valido == 1){
                                                    $logger->log ( "SI ES UN OPERADOR VALIDO", Zend_Log::INFO );
                                                    $bandera_operador_valido = 0;
                                                    if(!empty($categoria)){
                                                        $logger->log ( "SI SE ENCUENTRA CATEGORIZADO", Zend_Log::INFO );
                                                        $q = "SELECT usuario_msisdn FROM fuentes_usuarios_toolbox WHERE usuario_msisdn = '$msisdn' AND usuario_operador LIKE '$operador' AND usuario_categoria = '$categoria' AND usuario_activo = 1 AND usuario_id_fk='".$ide."' LIMIT 1";

                                                        $logger->log ( "QUERY DE BUSQUEDA EN BASE DE USUARIOS: " . print_r ( $q, true ), Zend_Log::INFO );
                                                        $resultado = $db->fetchAll($q);

                                                        $logger->log ( "RESULTADO - QUERY DE BUSQUEDA EN BASE DE USUARIOS: " . print_r ( $resultado, true ), Zend_Log::INFO );

                                                        /*echo $categoria; die();*/

                                                        if(count($resultado)<=0){
                                                            $logger->log ( "NO HAY USUARIO PREVIAMENTE REGISTRADO CON ESA CATEGORIA", Zend_Log::INFO );
                                                            $logger->log ( "SE VA INSERTAR EN USUARIOS DEMO PERU", Zend_Log::INFO );

                                                            try{

                                                                    $data_usuarios = array(
                                                                                                'usuario_msisdn'       => $msisdn,
                                                                                                'usuario_operador'     => $operador,
                                                                                                'usuario_categoria'    => $categoria,
                                                                                                'usuario_enviado'      => 1,
                                                                                                'usuario_alta'         => date('Y-m-d H:i:s'),
                                                                                                'usuario_activo'       => 1,
                                                                                                'usuario_id_fk'       => $ide
                                                                                            );
                                                                    $logger->log('ARRAY DATOS USUARIO:: '.print_r($data_usuarios,true), Zend_Log::INFO);
                                                                    $insert = $db->insert('fuentes_usuarios_toolbox',$data_usuarios);
                                                                    $logger->log('INSERTO:: '.print_r($insert,true), Zend_Log::INFO);
                                                                    $cont_perfilados ++;        
                                                            }catch(Exception $e){
                                                                $logger->log("Exception". print_r($e, true), Zend_Log::INFO);
                                                            }
                                                        }else{
                                                            $logger->log ( "YA SE ENCUENTRA UN ARCHIVO CON ESAS MISMAS CARACTERISTICAS", Zend_Log::INFO ); 
                                                            $cadena = $msisdn . " ES UN REGISTRO REPETIDO.\n";
                                                            $logger->log ( "MENSAJE ENVIADO A REPORTE XLS:: ". print_r($cadena, true), Zend_Log::INFO );
                                                            fwrite($fp, $cadena);     
                                                        }
                                                    }else{
                                                        $logger->log ( "NO VIENE CON CATEGORIA", Zend_Log::INFO );
                                                        $cadena = $msisdn . " NO TRAE CATEGORIA.\n";
                                                        $logger->log ( "MENSAJE ENVIADO A REPORTE XLS:: ". print_r($cadena, true), Zend_Log::INFO );

                                                                       /*$categoria = $result[0]['nombre'];*/
                                                                       $data_usuarios = array(
                                                                                                'usuario_msisdn'       => $msisdn,
                                                                                                'usuario_operador'     => $operador,
                                                                                                'usuario_categoria'    => $categoria,
                                                                                                'usuario_enviado'      => 1,
                                                                                                'usuario_alta'         => date('Y-m-d H:i:s'),
                                                                                                'usuario_activo'       => 1,
                                                                                                'usuario_id_fk'       => $ide
                                                                                            );
                                                                        $logger->log('ARRAY DATOS USUARIO:: '.print_r($data_usuarios,true), Zend_Log::INFO);
                                                                        $insert = $db->insert('fuentes_usuarios_toolbox',$data_usuarios);
                                                                        $logger->log('INSERTO:: '.print_r($insert,true), Zend_Log::INFO);
                                                                        $cont_perfilados ++; 
                                                                        fwrite($fp, $cadena);
                                                                

                                                    }
                                                    
                                                }else{
                                                    $logger->log ( "OPERADOR INVALIDO", Zend_Log::INFO );
                                                    $cadena = $msisdn . " CONTIENE UN OPERADOR INVALIDO.\n";
                                                    $logger->log ( "MENSAJE ENVIADO A REPORTE XLS:: ". print_r($cadena, true), Zend_Log::INFO );
                                                    fwrite($fp, $cadena);
                                                }
                                            }else{
                                                $logger->log ( "NO TRAE OPERADOR", Zend_Log::INFO );
                                                $cadena = $msisdn . " NO CONTIENE UN OPERADOR.\n";
                                                $logger->log ( "MENSAJE ENVIADO A REPORTE XLS:: ". print_r($cadena, true), Zend_Log::INFO );
                                                fwrite($fp, $cadena);
                                            }                                             
                                        }else{
                                            $logger->log ( "LA LONGITUD NO CORRESPONDE A UN MSISDN VALIDO", Zend_Log::INFO );
                                            $cadena = $msisdn . " LA LONGITUD NO CORRESPONDE A UN NUMERO CELULAR.\n";
                                            $logger->log ( "MENSAJE ENVIADO A REPORTE XLS:: ". print_r($cadena, true), Zend_Log::INFO );
                                            fwrite($fp, $cadena);
                                        }
                                        


                                        fclose($fp);
        }

        if($procesar == 1){
            $smarty->assign('mensaje3', 'Se registraron '.$cont_perfilados.' usuarios.'); 
        }
    }

    $categoria = $db->select();
    $categoria->from('fuentes_usuarios_toolbox','usuario_categoria, count(usuario_categoria) as total');
    $categoria->where("usuario_id_fk ='".$ide."' AND usuario_activo='1'");
    $categoria->group("usuario_categoria");
    $categorias = $db->fetchAll($categoria);

    $smarty->assign('rows', $categorias); 
    
    $logger->log("FIN:::::::::::..........", Zend_Log::INFO);
    $smarty->display("load.html");  



 }



  function cargar() {
    $config     = Zend_Registry::get('config');
    $db         = Zend_Registry::get('db');
    $session    = Zend_Registry::get('session');
    $smarty     = Zend_Registry::get('smarty');
    $params     = Zend_Registry::get('params');
    
    $logger = new Zend_Log();
    $filename = date('Ymd');
    $filename = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Carga_$filename.log";
    $writer = new Zend_Log_Writer_Stream($filename, 'ab');
    $logger->addWriter($writer);
    $hora = date('Y/m/d H:i:s');
    $logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
    $logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
    $logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
    $logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>INICIO: $hora", Zend_Log::INFO);
    $logger->log("REQUEST: ". print_r($_REQUEST, true), Zend_Log::INFO);
    $logger->log("FILES: ". print_r($_FILES, true), Zend_Log::INFO);

    $campania = $_REQUEST["campania"];

    if($_REQUEST['nombrec']){
       $campania = $_REQUEST['nombrec'];
    }elseif($_REQUEST['nombrec1']){
       $campania = $_REQUEST['nombrec1'];
    }else{
       $campania = $_SESSION["activo"];
    }

    $usuarios = $db->select();
    $usuarios->from('usuario','usuario_id');
    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
    $usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

    ini_set('auto_detect_line_endings',TRUE);

    if (is_uploaded_file($_FILES['usuarios']['tmp_name'])){
     $nombreDirectorio = "/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/usuarios/";
     $nombreFichero = $_FILES['usuarios']['name'];
     //$nombreCompleto = $nombreDirectorio . $nombreFichero;
     //if (is_file($nombreCompleto)){
         $idUnico = time();
         $nombreFichero = $idUnico . "-" . $nombreFichero;


     if (move_uploaded_file($_FILES['usuarios']['tmp_name'], $nombreDirectorio.$nombreFichero)) {

        $i=1;

        // Cargo la hoja de cálculo
        $objPHPExcel = PHPExcel_IOFactory::load($nombreDirectorio.$nombreFichero);

        //Asigno la hoja de calculo activa
        $objPHPExcel->setActiveSheetIndex(0);
        //Obtengo el numero de filas del archivo
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        $a = 0;

        while($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()!= NULL){

                $msisdn = eregi_replace("[\n|\r|\n\r]", '', $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
                $msisdn = eregi_replace(" ", '', $msisdn);
                $logger->log(" msisdn ---->".print_r($msisdn,true),Zend_Log::INFO);


                    
                    try{
                        $alta = array(
                            'usuario_msisdn'        => $msisdn,
                            'usuario_operador'       => NULL,
                            'usuario_categoria'      => $campania,
                            'usuario_enviado'      => 1,
                            'usuario_alta'            => date("Y-m-d H:i:s"),
                            'usuario_activo'       => 1,
                            'usuario_id_fk'       => $ide

                        );
                        $logger->log ( "DATOS ALTA:: " . print_r ( $alta, true ), Zend_Log::INFO );
                        $inserto_alta = $db->insert('fuentes_usuarios_toolbox', $alta);
                        $logger->log("INSERTO ALTA:: ".print_r($inserto_alta,true), Zend_Log::INFO);
                        $a++;


                        $smarty->assign("mensaje3", "Archivo subido correctamente, se subio: $a  de : $i registros.");


                    }catch(Exception $e){
                        $logger->log ( "ERROR BM : ".print_r($e,true), Zend_Log::INFO );
                       $smarty->assign("mensaje2", "Ocurrio un error, inténtelo mas tarde");
                    }



                if ($a == 0) {
                    $smarty->assign("mensaje3", "Archivo subido correctamente, se subieron: 0  de : $i registros.");
                }
                $i++;
                
        }

        
     }else{
        $smarty->assign("mensaje2", "Ocurrio un error, inténtelo mas tarde.");
     }
        
    }
    else{
        $smarty->assign("mensaje2", "No se ha podido subir el fichero.");
    }
    
    $categoria = $db->select();
    $categoria->from('fuentes_usuarios_toolbox','usuario_categoria, count(usuario_categoria) as total, count(usuario_operador) as total2');
    $categoria->where("usuario_id_fk ='".$ide."' AND usuario_activo='1'");
    $categoria->group("usuario_categoria");
    $categorias = $db->fetchAll($categoria);

    $smarty->assign('rows', $categorias); 
    $smarty->display("load.html");
 }


 

?>


