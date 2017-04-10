<?php


class SIA_Favorites {
	
	public $config;
	public $client;
	public $wsdl;
	
	
	function __construct(){
		// $this->wsdl = 'http://148.235.151.130:8088/sia/services/Favorites?wsdl';
		 			    
		               
		$this->wsdl = 'http://mitelcel.itelcel.com:7004/sia/services/Transaction?wsdl';
		/**
		 * DEFINICION DEL LLAMADO AL WS
		 */
		$this->client = new SoapClient("$this->wsdl",array( 
	    "trace"      => 1, 
	    "exceptions" => 0));
		
		
	}
	
	  function &askFav($userId, $passwd, $msisdn, $url, $title){	  	
		/*
	 	$client = new SoapClient("$this->wsdl",array( 
	    "trace"      => 1, 
	    "exceptions" => 0));
	    */
		
	    
	    $result = $this->client->askFav($userId, $passwd, $msisdn, $url, $title);
	    
	    return $result;
	}
	
}

?>