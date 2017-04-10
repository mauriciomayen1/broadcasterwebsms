<?php

require_once ("../etc/config.php");
ini_set('memory_limit', '-1');

$config  = Zend_Registry::get('config');
$db 	 = Zend_Registry::get('db');
$session = Zend_Registry::get('session');
$logger = new Zend_Log();
$filename = date('Ymd');

$myFile = "/home/codere.cm-operations.com/pub_html/dashboard/router/txt/subir.txt";

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
		$row = explode("-", $row);
		$logger->log("ROW: ". print_r($row, true), Zend_Log::INFO);
		$logger->log("***************************", Zend_Log::INFO);
		

		$msisdn = $row[0];
		$operador = $row[1];

		$data_mt=array(
			        		'mt_medio'      => "Data24",
			        		'mt_servicio'	=> $_SERVER['HTTP_USER_AGENT'],
			        		'mt_marcacion' 	=> "26262",
			        		'mt_operador' 	=> $operador,
			        		'mt_folio'      => $i,
			        		'mt_msisdn'     => $msisdn,
			        		'mt_fecha'      => date('Y-m-d H:i:s'),
			        		'mt_tag'		=> "Perfilado"
			    		   );
		$logger->log('Array data_mt:: '.print_r($data_mt,true), Zend_Log::INFO);
		$insert = $db->insert('mt_codere_bc',$data_mt);
		$logger->log('SE INSERTO:: '.print_r($insert,true), Zend_Log::INFO); 
		

		/*$query = "SELECT msisdn FROM base_maestra where msisdn = '$row'";
		$logger->log("QUERY : ".print_r($query,true), Zend_Log::INFO);
		$result = $db->fetchAll($query);


		if (empty($result)) {
			$logger->log("NO EXISTE EN BASE: ", Zend_Log::INFO);
			$data = array(
				'msisdn' 	=> $row,
			);
			$insert = $db->insert('base_maestra',$data);
			$logger->log("ACTUALIZACION : ".print_r($insert,true), Zend_Log::INFO);
		}else{
			$logger->log("EXISTE EN BASE: ", Zend_Log::INFO);
		}*/

}
?>	