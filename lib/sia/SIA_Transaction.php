<?php


class SIA_Transaction {
	
	public $config;
	public $client;
	public $wsdl;
	
	
	function __construct(){

		//$this->wsdl   = 'http://148.235.151.130:8088/sia/services/Transaction?wsdl';
		                   
		$this->wsdl = 'http://mitelcel.itelcel.com:7004/sia/services/Transaction?wsdl';
		/**
		 * DEFINICION DEL LLAMADO AL WS
		 */
		$this->client = new SoapClient("$this->wsdl",array( 
	    "trace"      => 1, 
	    "exceptions" => 0));
		
		
	}
	
	function &requestTransactionInt($userId, $passwd, $userTransactionId, $srsRatingId, $msisdn, $contentId, $contentName, $urlOk, $urlCancel, $urlError, $extraParam){
		/*
	 	$client = new SoapClient("$this->wsdl",array( 
	    "trace"      => 1, 
	    "exceptions" => 0));
	    */
		//ini_set('default_socket_timeout', 80000);
	    
	    $result = $this->client->requestTransactionInt($userId, $passwd, $userTransactionId, $srsRatingId, $msisdn, $contentId, $contentName, $urlOk, $urlCancel, $urlError, $extraParam);
	    
	    return $result;
	}
	
	function &getStatus($userId, $passwd, $transactionId){
		
		$result = $this->client->getStatus($userId, $passwd, $transactionId);
		
		return $result;
		
	}
}

?>
