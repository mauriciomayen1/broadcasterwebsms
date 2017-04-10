<?php

/**
 * The User WebService is used to retrieve the user’s account profile (prepaid or postpaid).
 *
 */
class SIA_User extends SOAP_Client
{
    //function __construct($path = 'http://148.235.151.131:9090/web2/services/User?wsdl')
    function __construct($path = 'http://mitelcel.itelcel.com:7004/sia/services/User?wsdl')
    {
        $this->SOAP_Client($path, 0);
    }
    
    /**
     * Returns PRE for prepaid accounts, Returns POS for postpaid accounts.
     *
     * @param String $userId External provider’s unique username.
     * @param String $passwd External provider’s unique password.
     * @param String $msisdn Identity of the subscriber’s account (end user).
     * @return String returns POS or PRE 
     */
    function &getProfile($userId, $passwd, $msisdn)
    {
         $response = $this->call('getProfile',
                           $v = array('userId' => $userId, 'passwd' => $passwd, 'msisdn' => $msisdn),
                           array('namespace' => 'http://webservice.sia.sm.com',
                                 'soapaction' => '',
                                 'style' => 'rpc',
                                 'use' => 'encoded'));
        return $response;
    }
    
	/**
	 * The corresponding description of the result code is a String,Note: Negative response codes return 0.0 as price
	 *
	 * @param String $method 
	 * @param String $code
	 * @return String
	 */
	function codeToString($method = 'getProfile', $code = '') {
		
		$codes['getProfile'] = array(
			'PRE' 	=> 'For  prepaid user accounts.',
			'POS' 	=> 'For pospaid user accounts',			
			'-1'	=> 'The user Id (userId) does not exist or password supplied is incorrect',
			'-2'	=> 'Could not get profile',
			'-5'	=> 'One or more parameters are missing',
		
		);
		
		return $codes[$method][$code];
		
	}

}

?>