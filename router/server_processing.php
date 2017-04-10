<?php
header('Access-Control-Allow-Origin: *');
require_once("../etc/config.php");

ini_set('memory_limit', '-1');

$smarty = Zend_Registry::get('smarty');
$config = Zend_Registry::get('config');
$db 	=  Zend_Registry::get('db');

$logger   = new Zend_Log();
$filename = date('Ymd');
$filename = '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/server_processing_'.$filename.'.log';
$writer   = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);

$hora = date('Y/m/d H:i:s');
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);               
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>FUNCION Navegador.php: $hora", Zend_Log::INFO);
$logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);

$fechainicio = $_REQUEST["fechaInicial"];
$fechafinal  = $_REQUEST["fechaFinal"];
/*echo $fechainicio;
echo $fechafinal; die();
*/

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'mt_sms';

// Table's primary key
$primaryKey = 'mt_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'mt_msisdn', 'dt' => 0 ),
	array( 'db' => 'mt_operador',  'dt' => 1 ),
	array( 'db' => 'mt_categoria',  'dt' => 2 ),
	array( 'db' => 'mt_contenido',   'dt' => 3 ),
	array( 'db' => 'mt_fecha',   'dt' => 4 ),


);

// SQL server connection information
$sql_details = array(
	'user' => 'comex',
	'pass' => 'comex123',
	'db'   => 'proyectemail',
	'host' => '172.16.27.16'
);


$usuarios = $db->select();
	$usuarios->from('usuario','usuario_id');
	$usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
	$usuario = $db->fetchAll($usuarios);
    $ide = $usuario[0]['usuario_id'];

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

$fecha = " mt_fecha BETWEEN '$fechainicio 00:00:00' AND '$fechafinal 23:59:59' AND usuario_id=".$ide;
$logger->log('WHERE:: '.print_r($fecha,true), Zend_Log::INFO);

echo json_encode(
	SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $fecha)
);


