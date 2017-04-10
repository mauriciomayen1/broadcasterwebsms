<?php
ini_set("display_errors","1");
ini_set('max_execution_time', 600); //600 seconds = 10 minutes
set_time_limit(0); 
error_reporting(E_ALL & ~E_NOTICE);
require_once ('/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/etc/config.php');

$config     = Zend_Registry::get('config');
$db         = Zend_Registry::get('db');


$logger   = new Zend_Log();
$filename = date('Ymd');
$filename = '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Programado_'.$filename.'.log';
$writer   = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);

$hora = date('Y/m/d H:i:s');
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);               
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>FUNCION CODERE: $hora", Zend_Log::INFO);
$logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);

$fecha = date('Y-m-d').' 00:00:00'; 
$fecha2 = date('Y-m-d').' 23:59:59'; 
$paso = date('H:i:s'); 
$hora = date('H:i');

$select = $db->select();
$select->from('fuentes_mensajes_programados_toolbox');
$select->where("mensaje_fechaenvio >= '$fecha' AND mensaje_fechaenvio <= '$fecha2' AND mensaje_horarionombre <= '$paso'  AND mensaje_procesado = '1' AND bandera_masivo='1' AND mensaje_activo = 1");
$select->group("mensaje_ocupacion");
$select->limit(10,0);
$data = $db->fetchAll($select);





$j =0;

foreach ($data as $key => $value) {
    $j++;
    $count = 0;

    echo "---------------------------------------------------------------------------------------------<br>";

    echo $value['mensaje_ocupacion']." ".$value['mensaje_mensaje']."<br>";
    $horario = substr ($value['mensaje_horarionombre'], 0, 5);

    if($horario<=$hora){

       $query1 = "SELECT COUNT(usuario_msisdn) AS numtel FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1  AND usuario_programado != '1' AND usuario_categoria='".$value['mensaje_ocupacion']."' AND usuario_id_fk='".$value['mensaje_usuario']."' AND usuario_veces != '0'";

    $cantidad = $db->fetchAll($query1);


    if($cantidad[0]['numtel'] <= 0){

      echo "<br>".$cantidad[0]['numtel']."# Por enviar <br>";

      $data1 = array(
                    'mensaje_procesado'    => 0
                    );
      $where1 = 'mensaje_usuario = "'.$value['mensaje_usuario'].'" AND mensaje_mensaje = "'.$value['mensaje_mensaje'].'" AND mensaje_nombre = "'.$value['mensaje_nombre'].'"';

      $update1 = $db->update('fuentes_mensajes_programados_toolbox',$data1,$where1);


      $data = array(
                      'usuario_programado'    => 0
                      );
      $where = 'usuario_categoria = "'.$value['mensaje_region'].'"  AND usuario_id_fk ='.$value['mensaje_usuario'];

      $update = $db->update('fuentes_usuarios_toolbox',$data,$where);

    }else{

        $query2 = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = 1 AND usuario_programado != '1' AND usuario_categoria='".$value['mensaje_ocupacion']."' AND usuario_id_fk='".$value['mensaje_usuario']."'";

        $numeros = $db->fetchAll($query2);

        $usuarios = $db->select();
        $usuarios->from('usuario','usuario_id');
        $usuarios->where("usuario_id ='".$value['mensaje_usuario']."'");
        $usuario = $db->fetchAll($usuarios);
        $ide = $usuario[0]['usuario_id'];


        $creditos = $db->select();
        $creditos->from('credito','credito_valor');
        $creditos->where("usuario_id ='".$ide."'");
        $credito = $db->fetchAll($creditos);
        $valor = $credito[0]['credito_valor'];

        $queryt = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_programado != '1' AND usuario_id_fk='".$value['mensaje_usuario']."' AND usuario_categoria='".$value['mensaje_ocupacion']."' AND usuario_operador='Telcel' LIMIT 50";


        $resultt = $db->fetchAll($queryt);

        $numt = count($resultt);

        $querym = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_programado != '1' AND usuario_id_fk='".$value['mensaje_usuario']."' AND usuario_categoria='".$value['mensaje_ocupacion']."' AND usuario_operador='Movistar' LIMIT 50";

        $resultm = $db->fetchAll($querym);


        $numm= count($resultm);

        $querya = "SELECT * FROM fuentes_usuarios_toolbox WHERE usuario_activo = '1' AND usuario_programado != '1' AND usuario_id_fk='".$value['mensaje_usuario']."' AND usuario_categoria='".$value['mensaje_ocupacion']."' AND (usuario_operador='Nextel' or usuario_operador='Iusacell' OR usuario_operador='Unefon') LIMIT 50";

        $resulta = $db->fetchAll($querya);


        $numa = count($resulta);

        $nototales = ($numa + $numt + $numm);

        echo "<br>".$nototales." envíos totales<br>";


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
            $costot =  (0.58 * $numt);
        }

        if(isset($valorm) && $valorm != NULL){
            $costom = ($valorm * $numm);
        }else{
            $costom = (0.58 * $numm);
        }

        if(isset($valora) && $valora != NULL){
            $costoa = ($valora * $numa);
        }else{
            $costoa = (0.58 * $numa);
        }

        /*$supertotal = ($costot + $costom + $costoa);

        echo "<br>".$cantidad[0]['numtel']." Total<br>";*/

        $gasto = ($costot + $costom + $costoa);

        echo "<br>".$gasto." Gasto<br>"; 



        if(isset($valor) && $valor>=$gasto && $gasto != 0){


              for($i=0; $i<$nototales; $i++  ){
                  $logger->log("-------------------------------------->", Zend_Log::INFO);
                  $logger->log("CONTADOR i: ". $i, Zend_Log::INFO);

                  $id        = $numeros[$i]['usuario_id'];
                  $msisdn    = $numeros[$i]['usuario_msisdn'];
                  $operador  = $numeros[$i]['usuario_operador'];
                  $categoria  = $numeros[$i]['usuario_categoria'];

                  $logger->log("ID:: ". $id, Zend_Log::INFO);
                  $logger->log("MSISDN:: ". $msisdn, Zend_Log::INFO);
                  $logger->log("OPERADOR:: ". $operador, Zend_Log::INFO);

                  $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýý';
                    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyy';
                    $value['mensaje_mensaje'] = utf8_decode($value['mensaje_mensaje']);
                    $value['mensaje_mensaje'] = strtr($value['mensaje_mensaje'], utf8_decode($originales), $modificadas);
                          
                  $contenido    = urlencode($value['mensaje_mensaje']);
                  $logger->log("MENSAJE A ENVIAR::..". $sms, Zend_Log::INFO);


                $medioperfil = "Base";



                if($operador == 'telcel' || $operador == 'Telcel' || $operador == 'TELCEL'){
                    $marcacion = '26262';
                    $user = 'sendsmsmt_26262';
                    $smscId = 'telcel_26262';
                    /*$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
                    $url    = sprintf($url, "52".$msisdn, $contenido);*/

                    $url = "http://administrador.cm-operations.com/telcel/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=PROGRAMADO&username=sendsmsmt_26262";
                    $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO ); 
                    $bandera = 1;
                }elseif($operador == 'movistar' || $operador == 'Movistar' || $operador == 'MOVISTAR' || $operador == 'Virgin' || $operador == 'VIRGIN'){
                    $marcacion = '26262';
                    $user = 'sendsmsmovistar_26262';
                    $smscId = 'movistar_26262';
                    $service = "WEBSMSPROGRAMADO";

                    $url = sprintf("http://administrador.cm-operations.com/movistar/router/router_mt.php?"."username=%s&message=%s&dial=%s&SOA=%s&service=%s", $user, $contenido, "26262", $msisdn, $service);
                    $logger->log ( "URL: ". print_r($url, true), Zend_Log::INFO ); 
                    $bandera = 1;
                }elseif($operador == 'iusacell' || $operador == 'Iusacell' || $operador == 'IUSACELL' || $operador == 'Unefon' || $operador == 'UNEFON' || $operador == 'AT&T' || $operador == 'ATT' || $operador == 'Att' || $operador == 'att' || $operador == 'nextel' || $operador == 'Nextel'){
                    $operador = "Att";
                    $marcacion = '26262';
                    $user = 'sendsmsatt_26262';
                    $smscId = 'iusacell_26262';
                    /*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

                    $url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=PROGRAMADO&username=sendsmsatt_26262";
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
                                            'mt_contenido'   => urldecode($contenido),
                                            'mt_fecha'       => date('Y-m-d H:i:s'),
                                            'mt_tag'      => 'PROGRAMADO',
                                            'mt_categoria'      =>  $categoria,
                                            'usuario_id'      => $ide
                                          );
                            $logger->log ( "INSERTA MT: ". print_r($datos, true), Zend_Log::INFO ); 
                            $insert = $db -> insert("mt_sms", $datos);
                            $logger->log ( "SE INSERTO: ". print_r($insert, true), Zend_Log::INFO );
                            $bandera = 0;
                            /***FIN INSERTAMOS EN BASE DE DATOS****** EL ENVIO*****/

                            $count = ($count + 1);

                            /*$veces0 = "SELECT usuario_veces FROM fuentes_usuarios_toolbox WHERE  usuario_categoria = '".$categoria."' AND usuario_id=".$id;
                            $vez0 = $db->fetchAll($veces0);


                            $vez02 = (int) $vez0[0]['usuario_veces'];

                            /*echo $vez02." VECES INCIAL <br>";

                            if($vez02<=1){*/
                               $data = array(
                                              'usuario_programado'    => 1
                                              );
                                $where = 'usuario_categoria = "'.$categoria.'"  AND usuario_id ='.$id;

                                $update = $db->update('fuentes_usuarios_toolbox',$data,$where);
                            /*}*/



                      }catch(Exception $e){
                            $logger->log("Exception". print_r($e, true), Zend_Log::INFO);
                      }
                  }



              }//FIN DEL FOR

              $resto = ($valor-$gasto);

              echo $resto." Resto<br>";

              $check = "SELECT credito_retenido FROM credito WHERE usuario_id = '".$ide."'";
               $checks = $db->fetchAll($check);

              $retenme = ($checks[0]['credito_retenido'] - $gasto);

                  $data_cr=array(
                              'credito_valor'      => $resto,
                              'credito_retenido'      => $retenme
                             );

                  $logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
                  $update = $db->update('credito',$data_cr,"usuario_id ='".$ide."'");
                  $logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO); 


                  echo $count." Enviados<br>";

                    $veces1 = "SELECT usuario_veces FROM fuentes_usuarios_toolbox WHERE  usuario_categoria = '".$value['mensaje_ocupacion']."' AND usuario_id_fk =".$ide;
                    $vez1 = $db->fetchAll($veces1);

                    echo $veces1." <br>"; 

                    $vez12 = (int) $vez1[0]['usuario_veces'];
            
                    echo $vez12." las veces<br>"; 


                    echo $cantidad[0]['numtel']." ".$count." <br>";


                    if(($vez12 > 0) && ($cantidad[0]['numtel']<=$count)){

                      $vezmenos = ($vez12 - 1);

                      echo $vezmenos."veces menos <br>";
                      echo $value['mensaje_ocupacion']." categoria <br>";

                      $datav = array(
                                  'usuario_veces'    => $vezmenos
                                  );
                      $wherev = 'usuario_categoria = "'.$value['mensaje_ocupacion'].'"  AND usuario_id_fk ='.$ide;

                      $updatev = $db->update('fuentes_usuarios_toolbox',$datav,$wherev);

                    }






            }else{
               $logger->log("No tiene crédito suficiente", Zend_Log::INFO);
               echo "No hay dinero o no hay registros a enviar";
            }

    }


    }else{
        /*echo $horario." Horario base<br>";
        echo $hora." hora<br>";*/
    }




    echo "----------------------------------------------------------------------------";

}






$logger->log("Fin::..", Zend_Log::INFO);
  
?>