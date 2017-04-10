<!-- <?php

/*ini_set ( "display_errors", "1" );
error_reporting ( E_ALL & ~ E_NOTICE );

require_once ('../etc/config.php');

$config     = Zend_Registry::get('config');
$db         = Zend_Registry::get('db');


$logger   = new Zend_Log();
$filename = date('Ymd');
$filename = '/home/codere.cm-operations.com/pub_html/dashboard/logs/prueba'.$filename.'.log';
$writer   = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);

$hora = date('Y/m/d H:i:s');
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);               
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>FUNCION CODERE: $hora", Zend_Log::INFO);
$logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);

$headers = array(
  'Content-Type: text/xml; charset=utf-8',
);
$msisdn = "5561726324";

$username = "miguel.pacheco";
$password = "operations2015"; 

$urldata24 = "https://api.data24-7.com/v/2.0?api=C&user=$username&pass=$password&p1=52".$msisdn;
$logger->log("URL ARMADA   ::".$urldata24 	 , Zend_Log::INFO);
//$xml = simplexml_load_file($urldata24) or die("feed not loading");
//$logger->log("XML ARMADO   ::".$xml 	 , Zend_Log::INFO);

$client = curl_init();
curl_setopt($client, CURLOPT_URL, $urldata24); 
curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($client, CURLOPT_CONNECTTIMEOUT ,0); 
curl_setopt($client, CURLOPT_TIMEOUT, 1); //timeout in seconds
curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false); 
$output = curl_exec($client); 
curl_close($client);

$response =simplexml_load_string($output);

print_r($response);

if (empty($output)) {
	print_r("SE CORTO LA PETICION");
} else {
	print_r($output);
}




$logger->log ( "Response : ". print_r($output, true), Zend_Log::INFO ); */
?> -->



<?php

echo "<pre>";
print_r($_SERVER);
echo "</pre>";
/*if ($_SERVER['PHP_AUTH_USER']!="user" || $_SERVER['PHP_AUTH_PW']!="pass")
{
	header('WWW-Authenticate: Basic realm="Ingrese su usario y contraseña asignada"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Authorization Required To Server.';
	exit;
}
*/



?>


