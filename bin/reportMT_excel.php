<?php 

require_once ("../etc/config.php");

$config = Zend_Registry::get('config'); 
$db     = Zend_Registry::get('db'); 
$errorCode = 0; 
$select = $db->select(); 
$select->reset(); 
$result = $db->fetchAll(base64_decode($_REQUEST['exportar'])); 

//print_r($result); die();

$HTML.= "<table>
<tr>
<th>NUMERO TELEFONICO</th>
<th>OPERADOR</th>
<th>CONTENIDO</th>
<th>FECHA</th>
</tr>"; 

foreach($result as $key => $value)
{

	$HTML.="<tr>
	<td>".$value['mt_msisdn']."</td>
	<td>".$value['mt_operador']."</td>
	<td>".$value['mt_contenido']."</td>
	<td>".$value['mt_fecha']."</td>
	</tr>";
}

$HTML .="</table>"; 

$date = date('dmYHis'); 
$fp = fopen("/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/reportes/reporteMt_".$date.".xls", 'w+'); 
fwrite($fp, $HTML); 
fclose($fp); 
header("Location: /dashboard/broadcasterwebsms/reportes/reporteMt_".$date.".xls") 
?> 