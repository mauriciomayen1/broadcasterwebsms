<?php
Class Connector{
	
	public $msisdn;
	public $smscid;
	public $contenido;
	
	
	function __construct($msisdn, $smscid, $contenido) 
	{
		$this->msisdn 		= $msisdn;
		$this->smscid		= $smscid;
		$this->contenido	= $contenido;	
	} 
		

	public function mt($tipo, $canalventaid){		
		$db 	= Zend_Registry::get('db');
				
		$marcacionid =  $this->obtienemarcacionid();
		
		if ($marcacionid){
			$datos = array(
				'mt_id' 			=> md5(uniqid(rand())),
			   	'canalventa_id' 	=> $canalventaid,
			  	'marcacion_id' 		=> $marcacionid,
				'mt_mensaje'		=> $this->contenido,
				'mt_fecha'			=> date("Y/m/d H:i:s"),
				'mt_msisdn'			=> $this->msisdn,
				'mt_activo'			=> 1
			);
			if($canalventaid!='test')
			{					   
				$db->insert('mt', $datos);
			}
			
			/**
			 * Envia Mensaje
			 */
			if ($tipo == 'wap'){
				return $this->enviawappush();				
			}else{
				return $this->enviasms();
			}
		}else {
			return FALSE;
		}
	}
	
	public function mo(){
		$db 	= Zend_Registry::get('db');
		$marcacionid =  $this->obtienemarcacionid();
		
		if ($marcacionid){
			$datos = array(
				'mo_id' 			=> md5(uniqid(rand())),
			  	'marcacion_id' 		=> $marcacionid,
				'mo_mensaje'		=> $this->contenido,
				'mo_fecha'			=> date("Y/m/d H:i:s"),
				'mo_msisdn'			=> $this->msisdn,
				'mo_activo'			=> 1
			);						   
			return $db->insert('mo', $datos);

		}else {
			return FALSE;
		}
	}
	
	private function obtienemarcacionid(){
		$db = Zend_Registry::get('db');
		
		$select = $db->select();
		$select->from('marcacion', 'marcacion_id');
		$select->where("marcacion_smscid = '$this->smscid'");
		$select->where("marcacion_activo = 1");			
		$result 		= $db->fetchAll($select);
		
		$marcacionid 	= $result[0]['marcacion_id'];
		
		if (!empty($marcacionid)){
			return  $marcacionid;
		}else{
			return FALSE;
		}
	}
	
	private function enviasms(){
		$params	= Zend_Registry::get('params');
		
		
//		sendsmstelcel_33433

		$marcacion = explode('_', $this->smscid);
		$carrier = $marcacion[0];
		
		//Zend_Debug::dump($carrier, 'CARRIER');
		
		if ($carrier == 'telcel'){
			$url 			= $params['url'];
			$smsuser 		= 'sendsms'.$this->smscid;
			$password		= $params['password'];
		}elseif ($carrier == 'movistar'){
//			sendsmstelefonica_52152
			$url 			= $params['urlmovistar'];
			$marcacion 		= $marcacion[1];
			$smsuser 		= 'sendsmstelefonica_'.$marcacion;
			$password		= $params['password'];
		}elseif ($carrier == 'iusacell'){
//			sendsmsiusacell_33433
			$url 			= $params['urliusacell'];
			$marcacion 		= $marcacion[1];
			$smsuser 		= 'sendsmsiusacell_'.$marcacion;
			$password		= $params['password'];
		}elseif ($carrier == 'nextel'){
//			sendsmsiusacell_33433
			$url 			= $params['urlnextel'];
			$marcacion 		= $marcacion[1];
			$smsuser 		= 'sendsmsnextel_'.$marcacion;
			$password		= $params['password'];
		}
		$contenidoTexto = urlencode($this->contenido);
		$url 			= sprintf($url."username=$smsuser&password=$password&to=%s&text=%s", $this->msisdn, $contenidoTexto);	
		//Zend_Debug::dump($url, 'URL CONNECTOR');	

		
		$client = new Zend_Http_Client($url);	
		$response = $client->request();					

		return $response;		
	}
	
	private function enviawappush(){
		$params	= Zend_Registry::get('params');


		$marcacion = explode('_', $this->smscid);
		$carrier = $marcacion[0];
		
		//Zend_Debug::dump($carrier, 'CARRIER');
		
		//$parametros['url'] 						= 'http://sec.mvs.com:13013/cgi-bin/sendsms?';
		//$parametros['password'] 				= 'buzzito';
		
		if ($carrier == 'telcel'){
			$parametros['url']  		= $params['url'];
			$parametros['username']		= 'sendsms'.$this->smscid;
			$parametros['password'] 	= $params['password'];
		}elseif ($carrier == 'movistar'){
//			sendsmstelefonica_52152
			$parametros['url'] 			= $params['urlmovistar'];
			$marcacion 					= $marcacion[1];
			$parametros['username'] 	= 'sendsmstelefonica_'.$marcacion;
			$parametros['password']		= $params['password'];
		}elseif ($carrier == 'iusacell'){
//			sendsmsiusacell_33433
			$parametros['url'] 			= $params['urliusacell'];
			$marcacion 					= $marcacion[1];
			$parametros['username'] 	= 'sendsmsiusacell_'.$marcacion;
			$parametros['password']		= $params['password'];
		}elseif ($carrier == 'nextel'){
//			sendsmsiusacell_33433
			$parametros['url']			= $params['urlnextel'];
			$marcacion 					= $marcacion[1];
			$parametros['username'] 	= 'sendsmsnextel_'.$marcacion;
			$parametros['password']		= $params['password'];
		}		
		
		$gestorSMS = new GestorSMS();
		$urlFinal = $gestorSMS->envia_WAPPUSH($this->msisdn, $this->contenido, $parametros, 'Conectate');			
		Zend_Debug::dump($urlFinal, 'URL FINAL MULTIMEDIA');

		$client = new Zend_Http_Client($urlFinal);	
		$response = $client->request();					

		return $response;		
	}
	
}	
?>