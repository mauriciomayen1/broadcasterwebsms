<?php
require_once ("../etc/config.php");
Zend_Auth::getInstance()->clearIdentity();
Zend_Session::namespaceUnset($config->application['session']['nameSpace']);

session_destroy ();
header("Location: login.php");
?>
