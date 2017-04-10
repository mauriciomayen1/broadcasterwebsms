<?php
class CobraSiaWap{
	
	
	public $config;
	public $userId;
	public $password;
	public $serviceId;
	public $msisdn;
	public $contentId;
	public $contentName;	
	public $userAgent;	
	public $urlOk;
	public $urlCancel;
	public $urlError;
	public $extraParam;
	public $canalVenta;
	public $recipients;
	public $extension;
		
	
	function __construct($config, $userId, $password, $serviceId, $msisdn, $contentId, $contentName, $userAgent, $urlOk, $urlCancel, $urlError, $extraParam, $canalVenta, $recipients, $extension){
		$this->config = $config;
		$this->userId = $userId;
		$this->password = $password;
		$this->serviceId = $serviceId;
		$this->msisdn = $msisdn;
		$this->contentId = $contentId;
		$this->contentName = $contentName;
		$this->userAgent = $userAgent;
		$this->urlOk = $urlOk;
		$this->urlCancel = $urlCancel;
		$this->urlError = $urlError;
		$this->extraParam = $extraParam;
		$this->canalVenta = $canalVenta;
		$this->recipients = $recipients;
		//$this->noSolicitud = $noSolicitud;
		$this->extension = $extension;
	}
	
	function cobra(){
		$siaTransaction  = new SIA_Transaction();
		$config = $this->config;

		$siaDescargaWapId = rand(0,9) . uniqid() . rand(0,9);	
		$siaDescargaWap = new Ns_QueryTool($config->application['db'][0]['dburl'], 'siadescargawap');
		$siaDescargaWap->reset();
		
		
		  $siaDescargaWapFecha = date('Y/m/d H:i:s');		

		$data = array(
		'siadescargawap_id'				=> $siaDescargaWapId,
		'contenidomul_id'				=> $this->contentId,		
		'canalventa_id'					=> $this->canalVenta,
		'siadescargawap_fecha'			=> $siaDescargaWapFecha,
		'siadescargawap_msisdn'			=> $this->msisdn,
		'siadescargawap_extension'		=> $this->extension,				
		'siadescargawap_useragent'		=> $this->userAgent,		
		'siadescargawap_confirmacion'	=> '0',
		'siadescargawap_activo'			=> '1'		
		);					
		$siaDescargaWap->add($data);
		
		
		//Zend_Debug::dump($siaDescargaWap->_lastQuery);
		$operationId = $siaDescargaWapId;
		
		
		//Zend_Debug::dump('*******************COBRASIAWAP.PHP*************************');
		/*
		Zend_Debug::dump($this->userId, 'USER ID');
		Zend_Debug::dump($this->password, 'PASSWORD');
		Zend_Debug::dump($operationId, 'OPERATIONID');
		Zend_Debug::dump($this->serviceId, 'SERVICEID');
		Zend_Debug::dump($this->msisdn, 'MSISDN');
		Zend_Debug::dump($this->contentId, 'CONTENT ID');
		Zend_Debug::dump($this->contentName, 'CONTENT NAME');
		Zend_Debug::dump($this->urlOk, 'URL OK');		
		Zend_Debug::dump($this->urlCancel, 'URL CANCEL');
		Zend_Debug::dump($this->urlError, 'URL ERROR');		
		Zend_Debug::dump($this->extraParam, 'EXTRAPARAM');
		*/
   
		$url = "http://sms.conceptomovil.com/wap/bin/entregacontenido.php?siaId=$operationId";
		
		$result = $siaTransaction->requestTransactionInt($this->userId, $this->password, $operationId, $this->serviceId, $this->msisdn, $this->contentId, $this->contentName, $url, $this->urlCancel, $this->urlError, $this->extraParam);
		
		Zend_Debug::dump($result, 'RESULT');

		/**
		 * ACTUALIZA CON EL RESULTADO QUE REGRESA EL SIA
		 */
		
		$resultArray = explode('|', $result);
		$cobroResult = $resultArray[0];
		$transaccion = $resultArray[1];
		
		$siaDescargaWap = new Ns_QueryTool($config->application['db'][0]['dburl'], 'siadescargawap');
		$siaDescargaWap->reset();		
		$data = array(
		'siadescargawap_resultado'		=> $cobroResult,
		//'siadescargawap_useragent'		=> $url,		
		'siadescargawap_transaccion'	=> $transaccion
		);
		$siaDescargaWap->setWhere("siadescargawap_id = '".$siaDescargaWapId."'");	
		$siaDescargaWap->update($data);		
	
		
		$resultado['sia']   = $cobroResult;
		$resultado['transactionId'] = $operationId;
		$resultado['siaId'] = $transaccion;
		$resultado['url']	= $url;
		
		//Zend_Debug::dump($result, 'RESULT');		
		
		//return $resultado;
		return $transaccion;
	}
	
	function cobraCostoDescarga($operationId){
		$siaTransaction  = new SIA_Transaction();
		
   
		$url = "http://sms.conceptomovil.com/wap/bin/entregaSuscripcion.php?siaId=$operationId";
	
		$result = $siaTransaction->requestTransactionInt($this->userId, $this->password, $operationId, $this->serviceId, $this->msisdn, $this->contentId, $this->contentName, $url, $this->urlCancel, $this->urlError, $this->extraParam);
		
		Zend_Debug::dump($result, 'RESULT');

		/**
		 * ACTUALIZA CON EL RESULTADO QUE REGRESA EL SIA
		 */
		
		$resultArray = explode('|', $result);
		$cobroResult = $resultArray[0];
		$transaccion = $resultArray[1];

		return $transaccion;
	}
	
}
?>