<?php
/*
// AGREGAR ARCHIVO


	$params[0]['form'] 		= 'archivo1';
	$params[0]['directory']	= '\htdocs\zend\var';
	$params[0]['method']	= 'define';
	$params[0]['name']		= 'archivo_feliz.doc';

	$params[0]['form'] 		= 'archivo2';
	$params[0]['directory']	= '\htdocs\zend\var';
	$params[0]['method']	= 'real';
	
	
	$archivo = NS_Upload::upload($params);
	
	

// EDITAR ARCHIVO

	$params[0]['form'] 			= 'solicitudcredito';
	$params[0]['file'] 			= 'archivo_path';
	$params[0]['directory']		= $config->application['uploadDir']. DIRECTORY_SEPARATOR .'archivos';
	$params[0]['method']		= 'real';
	$params[0]['tableName']		= 'archivo';
	$params[0]['tableId']		= 'archivo_id';
	$params[0]['tableIdValue']	= $_SESSION[$config->application['session']]['datos_pagina_1']['archivo'][5];

	$archivo = NS_Upload::update($params);
	
*/
	


class Ns_Upload {

	function upload($args = array())
	{
		global $settings;
		$upload = & new HTTP_Upload();
		$i = 0;
		foreach($args as $params) {		
			$file = $upload->getFiles($params['form']);
			if($file->isValid()){
				
			switch ($params['method']) {
			 	case 'uniq':
			 		$fileName = $file->setName('uniq');
			 		break;
			 
			 	case 'real':
			 		$fileName = $file->setName('real');
			 		break;

			 	case 'define':
			 		$fileName = $file->setName($params['name']);
			 		break;

			 	default:
			 		$fileName = $file->setName('uniq');
			 		break;
			 } 
							 
			 	if ($params['method'] == '') {
					$result[$i]['method'] = 'uniq';	
				} else {
					
					$result[$i]['method'] = $params['method'];
				}
				
				$setName = $file->setName($fileName);
				
				$copyTo = $file->moveTo($params['directory']);

				if (PEAR::isError($copyTo)) {
					PEAR::raiseError($copyTo->getMessage());
				}
								 
				$result[$i]['real'] = $file->getProp('real');
				$result[$i]['file'] = $setName;
				$result[$i]['size'] = $file->getProp('size');
				$result[$i]['type'] = $file->getProp('type');				 
			} 
				$i++;
		} // foreach
		
	
		return $result;
	} // end function
	

	function update($args = array())
	{
		
	$config = Zend_Registry::get('config');
	$upload = & new HTTP_Upload();
	
		$i = 0;
		foreach($args as $params) {		
			
			$db = MDB2::connect($config->application['db'][0]['dburl']);
			if(PEAR::isError($db)) {
				die($db->getMessage());
			}

			$query = sprintf("SELECT %s FROM %s WHERE %s = '%s' ", $params['file'], $params['tableName'],$params['tableId'], $params['tableIdValue']);
			
			$res = $db->query($query);
			
			if(PEAR::isError($res)) {
				die($res->getMessage());
			}
			
			$row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
			
			$db->disconnect();
			
			$fileName = $row[$params['file']];
	
			$file = $upload->getFiles($params['form']);

			if($file->isValid()){

			NS_Upload::delete($params);
				
			switch ($params['method']) {
			 	case 'uniq':
			 		$fileName = $file->setName('uniq');
			 		break;
			 
			 	case 'real':
			 		$fileName = $file->setName('real');
			 		break;

			 	case 'define':
			 		$fileName = $file->setName($params['name']);
			 		break;

			 	default:
			 		$fileName = $file->setName('uniq');
			 		break;
			 } 
							 
			 	if ($params['method'] == '') {
					$result[$i]['method'] = 'uniq';	
				} else {
					
					$result[$i]['method'] = $params['method'];
				}
				
				$setName = $file->setName($fileName);
				
				$copyTo = $file->moveTo($params['directory']);
				//d($params['directory'], 'MOVIENDO ARCHIVO A:');
				
				if (PEAR::isError($copyTo)) {
					PEAR::raiseError($copyTo->getMessage());
				}
								
				$result[$i]['real'] = $file->getProp('real');
				$result[$i]['file'] = $setName;
				$result[$i]['size'] = $file->getProp('size');
				$result[$i]['type'] = $file->getProp('type');	
				
			} 
			$i++;
		} // foreach
		
		return $result;
	} // end function
	

	function delete($args = array())
	{
		$config = Zend_Registry::get('config');
		$db = MDB2::connect($config->application['db'][0]['dburl']);
		
		if(PEAR::isError($db)) {
			$db->getMessage();
		}		
		$query = sprintf("SELECT %s FROM %s WHERE %s ='%s'",
						$args['file'], 
						$args['tableName'], 
						$args['tableId'], 
						$args['tableIdValue']);
		$result = $db->query($query);

		if(PEAR::isError($result)) {
			$result->getMessage();
		}
		$row = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
		$db->disconnect();
		
        $file 	= $row[$args['file']];
        $directory	= $args['directory'];
        
        if ((file_exists($directory . DIRECTORY_SEPARATOR . $file)) && (strlen($file) > 3)){
				unlink($directory . DIRECTORY_SEPARATOR . $file);
				$result = true;
			} else {
				$result = false;
			}
			
		return $result;
	}
	
}

?>