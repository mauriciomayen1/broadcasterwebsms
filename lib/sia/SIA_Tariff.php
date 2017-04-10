<?php

/**
 * The Tariff WebService is used to check the tariff in MXP given a Rating ID. This WebService can be called at any time.
 *
 */
class SIA_Tariff extends SOAP_Client
{
    //function __construct($path = 'http://148.235.151.131:9090/web2/services/Tariff')
    function __construct($path = 'http://mitelcel.itelcel.com:7004/sia/services/Tariff')    
    {
        $this->SOAP_Client($path, 0);
    }
    
    /**
     * Request price of a given Rating ID. The response string is formed by a major response code and the price, divided by a pipe..
     *
     * @param String $userId External provider’s unique username.
     * @param String $passwd External provider’s unique password.
     * @param Long $srsRatingId Identifier used by the SRS to bind a particular service, a provider, an application, an origin, commission information and price.
     * @return String The response string is formed by a major response code and the price, divided by a pipe.
     */
    function &getTariff($userId, $passwd, $srsRatingId)
    {
        $response = $this->call('getTariff',
                           $v = array('userId' => $userId, 'passwd' => $passwd, 'srsRatingId' => $srsRatingId),
                           array('namespace' => 'http://webservice.sia.sm.com',
                                 'soapaction' => '',
                                 'style' => 'rpc',
                                 'use' => 'encoded'));
        return $response;
    }

    function &getTariffInt($userId, $passwd, $srsRatingId)
    {
        $response = $this->call('getTariffInt',
                           $v = array('userId' => $userId, 'passwd' => $passwd, 'srsRatingId' => $srsRatingId),
                           array('namespace' => 'http://webservice.sia.sm.com',
                                 'soapaction' => '',
                                 'style' => 'rpc',
                                 'use' => 'encoded'));
        return $response;
    }

	/**
	 * The result code is a string containing the following values divided by a pipe: <ResponseCode>|[<Tariff>]
	 *
	 * @param String $method 
	 * @param String $code
	 * @return String code to string value
	 */
	function codeToString($method = 'getTariff', $code = '') {
		
		
		
		$codes['getTariff'] = array(
			'0' 	=> 'OK',
			'-1'	=> 'The user Id (userId) does not exist or password supplied is incorrect.',
			'-2'	=> 'Rating Id (ratingId) does not exist',
			'-3'	=> 'Rating ID is not active',
			'-4'	=> 'Unknown error',
			'-5'	=> 'One or more parameters are missing',
		);
						
		return $codes[$method][$code];
		
	}

}



?>