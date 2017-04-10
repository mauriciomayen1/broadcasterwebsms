<?php
ini_set("display_errors","1");
error_reporting(E_ALL & ~E_NOTICE);

set_include_path('/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/lib' . PATH_SEPARATOR . '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/lib/Pear' . PATH_SEPARATOR . '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/lib/Smarty'. PATH_SEPARATOR .'/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/lib/Zend');


require_once('Auth.php');
require_once('Smarty/Smarty.class.php');
require_once('Zend/Loader.php');
Zend_Loader::registerAutoload();

require_once('Ns/Smarty.php');
require_once('Ns/Pageable.php');
require_once('Ns/Paging.php');
require_once('Ns/Auth.php');
require_once('Ns/Table.php');
require_once('HTTP/Request.php');


$application['os']					= 'LINUX';
$application['rdbm']				= 'MYSQL';
$application['type']				= 'APACHE';
$application['documentRoot']		= '/home/broadcaster.cm-operations.com/pub_html/dashboard/';
$application['name'] 				= 'BROADCASTERWEBSMS';
$application['description'] 		= 'Sistema de Correo-Email';
$application['version']				= '1.0';
$application['directory'] 			= 'broadcasterwebsms';
$application['templateDir'] 		= $application['documentRoot']	. DIRECTORY_SEPARATOR . $application['directory'] . DIRECTORY_SEPARATOR . 'html';
$application['compileDir'] 			= $application['documentRoot']	. DIRECTORY_SEPARATOR . $application['directory'] . DIRECTORY_SEPARATOR . 'html_c';
$application['configDir'] 			= $application['documentRoot']	. DIRECTORY_SEPARATOR . $application['directory'] . DIRECTORY_SEPARATOR . 'etc';
$application['cacheDir'] 			= $application['documentRoot']	. DIRECTORY_SEPARATOR . $application['directory'] . DIRECTORY_SEPARATOR . 'cache';
$application['debuging'] 			= false;
$application['caching'] 			= false;
$application['leftDelimiter'] 		= '{{';
$application['rightDelimiter'] 		= '}}';
$application['lang']				= 'es';


$application['db']['driver']		= 'PDO_Mysql';											
$application['db']['host'] 			= '172.16.27.16';
$application['db']['dbname']		= 'proyectemail';
$application['db']['username']		= 'comex';
$application['db']['password']		= 'comex123';
$application['db']['schema']		= '';
$application['db']['profile']		= true;


$application['auth']['tableName']			= 'usuario';
$application['auth']['identityColumn']		= 'usuario_nombre';
$application['auth']['credentialColumn']	= 'usuario_password';
$application['auth']['credentialTreatment']	= "MD5(?)";

$application['session']['nameSpace']		= 'smsmarketingsession';
$application['session']['lifetime']			= '10000';

//Variables del conector
$params['url']                           	= 'http://http://tecnomovil.conceptomovil.com:13013/cgi-bin/sendsms?';
$params['password']                      	= 'kaiser';
$params['urlmt']                         	= 'http://http://tecnomovil.conceptomovil.com/sec/router/send.php';


$config = new Ns_Config();
$config->application = $application;
$db =  Zend_Db::factory($application['db']['driver'], $application['db']);


Zend_Registry::set('config', $config);
Zend_Registry::set('db', $db);
Zend_Registry::set('smarty', $smarty = new Ns_Smarty());
Zend_Registry::set('session', new Zend_Session_Namespace($application['session']['nameSpace']));
//para el conector
Zend_Registry::set('params', $params);

$session	= Zend_Registry::get('session');
$config		= Zend_Registry::get('config');
$db			= Zend_Registry::get('db');
$auth		= Zend_Auth::getInstance();
$smarty		= Zend_Registry::get('smarty');

$auth->setStorage(new Zend_Auth_Storage_Session($config->application['session']['nameSpace']));

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

$usuarioid = $session->storage->aptriviabusuario_id;
$select = $db->select();
$select->from('aptriviabusuario', '*');
$select->join(array('p'=>'aptriviabpermiso'),'aptriviabusuario.aptriviabpermiso_id=p.aptriviabpermiso_id',array('aptriviabpermiso_permiso'));
$select->where('aptriviabusuario_activo = 1');
$select->where('aptriviabpermiso_activo = 1');
$select->where("aptriviabusuario_id = '$usuarioid'");

$perfildescripcion = $result[0]['aptriviabpermiso_permiso'];
$session->descripcion = $perfildescripcion;

?>
