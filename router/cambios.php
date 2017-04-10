<?php

require_once ("../etc/config.php");
ini_set('memory_limit', '-1');

$config  = Zend_Registry::get('config');
$db 	 = Zend_Registry::get('db');
$session = Zend_Registry::get('session');
$logger = new Zend_Log();
$filename = date('Ymd');

$myFile = "/home/codere.cm-operations.com/pub_html/dashboard/router/txt/actualiza.txt";

$filename = "/home/codere.cm-operations.com/pub_html/dashboard/logs/sube_numeros_$filename.log";
$writer = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);
$filter = new Zend_Log_Filter_Priority(Zend_Log::INFO);
$logger->addFilter($filter);	

$hora = date('Y/m/d H:i:s');
$logger->log("****************************************", Zend_Log::INFO);
$logger->log("****************************************", Zend_Log::INFO);
$logger->log("****************************************", Zend_Log::INFO);				
$logger->log("****************************************FUNCION SEARS ", Zend_Log::INFO);

$filas=file($myFile);
	
	
$dia = date('Y-m-d H:i:s');



$i=0;
$numero_fila=0;
while($filas[$i]!=NULL){

		$row = $filas[$i];
		$logger->log("ROW---->".$row,Zend_Log::INFO);
		$i++;
		$row = eregi_replace("[\n|\r|\n\r]", '', $row);
		//$row = explode("-", $row);
		$logger->log("ROW: ". print_r($row, true), Zend_Log::INFO);
		$logger->log("***************************", Zend_Log::INFO);

		$query = "SELECT * FROM mt_codere_bc where mt_msisdn = '$row' AND mt_fecha BETWEEN '2016-07-31 00:00:00' AND '2016-07-31 23:59:59'";
		$logger->log("QUERY : ".print_r($query,true), Zend_Log::INFO);
		$result = $db->fetchAll($query);
		$logger->log("COINCIDENCIAS : ".print_r($result,true), Zend_Log::INFO);

		if (!empty($result)) {
			$data = array(
			    'mt_medio'      => 'Base',

			);
			 
			$update = $db->update('mt_codere_bc', $data, "mt_msisdn = '$row' AND mt_fecha BETWEEN '2016-08-01 00:00:00' AND '2016-08-01 23:59:59'");
			$logger->log("ACTUALIZACION : ".print_r($update,true), Zend_Log::INFO);
		}

		/*$query = "select * from `mt_codere_bc` where mt_msisdn = '$row' AND mt_fecha BETWEEN '2016-08-01 00:00:00' AND '2016-08-01 23:59:59';";
		$logger->log("QUERY : ".print_r($query,true), Zend_Log::INFO);
		$result = $db->fetchAll($query);

		$folio = $result[0]["mt_folio"];
		$folio2 = $result[1]["mt_folio"];

		$fecha = $result[0]["mt_fecha"];
		$fecha2 = $result[1]["mt_fecha"];

		$id = $result[0]["mt_id"];

		if ($folio == $folio2 && $fecha == $fecha2) {
			$data = array(
			    'mt_tag'      => 'elimina',

			);
			 
			$update = $db->update('mt_codere_bc', $data, "mt_id = '$id'");
			$logger->log("ACTUALIZACION : ".print_r($update,true), Zend_Log::INFO);
		}*/
}


		

		/*if (!empty($result)) {
			$data = array(
				'msisdn' 	=> $row,
			);
			$insert = $db->insert('base_maestra',$data);
			$logger->log("ACTUALIZACION : ".print_r($insert,true), Zend_Log::INFO);
		}

		$data_update=array(
			        		'mt_medio'      => "Base",
			    		   );
		$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
		$insert = $db->insert('mt_codere_bc',$data_mt);
		$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO); 
		*/


?>	