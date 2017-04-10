<?php
require_once ("../etc/config.php");




if($_REQUEST['username'] != null || $_REQUEST['username'] != '')
{
	$authAdapter  = new Ns_Auth_Adapter_DbTable($db);
	$authAdapter->setIdentity($_REQUEST['username']);
	$authAdapter->setCredential($_REQUEST['password']);
	$result = $auth->authenticate($authAdapter);
	$db      = Zend_Registry::get('db');

	//echo $_REQUEST['username']; die();
	
/*	Zend_Debug::dump($result, 'RESULT');
	Zend_Debug::dump($result->getIdentity(), 'IDENTITY');*/

	if ($result->isValid()) { 
		 $storage = $auth->getStorage();
		 $storage->write($authAdapter->getResultRowObject());

		session_start();
		$_SESSION["activo"]=$_REQUEST['username'];

		$usuarios = $db->select();
	    $usuarios->from('usuario','usuario_id');
	    $usuarios->where("usuario_nombre ='".$_SESSION["activo"]."'");
	    $usuario = $db->fetchAll($usuarios);
	    $ide = $usuario[0]['usuario_id'];

	    $mts = $db->select();
	    $mts->from('mt_sms','usuario_id');
	    $mts->where("usuario_id ='".$ide."' AND mt_servicio is NULL");
	    $mt = $db->fetchAll($mts);


       /*if(count($mt)>0){
         header("Location: home.php");
       }else{
         header("Location: tutorial.php");
       }*/

       header("Location: home.php");

	} else {
	
		switch ($result->getCode()) {
			case 0:
				$smarty->assign('errorLogin','FAILURE');
				break;
			case -1:
				$smarty->assign('errorLogin','DATOS INCORRECTOS');
				break;
			case -2:
				$smarty->assign('errorLogin','FAILURE_IDENTITY_AMBIGUOUS');
				break;
			case -3:
				$smarty->assign('errorLogin','FAILURE_CREDENTIAL_INVALID');
				break;
			case -4:
				$smarty->assign('errorLogin','FAILURE_UNCATEGORIZED');
				break;
		}

        echo "<div class='alert alert-error' style='position: absolute; top: 0; width: 100%;'>
		      <center>
			    <strong>¡Error!</strong> Usuario o contraseña incorrectos.
			  </center>
			  </div>";

		$smarty->display('login.html');
	}
} else {
		$smarty->display('login.html');
}

?>
