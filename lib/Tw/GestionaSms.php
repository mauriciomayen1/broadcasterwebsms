<?php

//MENSAJERIA

//PARTNER ID: PA00000645
//PASSWORD: c0nc3pT0m3ns4j3



Class GestionaSms{	
	
	function enviaSMS($msisdn, $content, $senderName){			
		
		$params 	=  Zend_Registry::get('params');
		
	//	$wsdl	="https://187.141.14.122:8091/asg/services/SendSmsService";
		//$password = 'kaiser2307';
		
		$wsdl 		= $params['wsdl'].'SendSmsService';
		$password	= $params['password'];
		
		
		$logger = new Zend_Log();
		$filename = date('Ymd');
		$filename = "/home/hub.cm-operations.com/pub_html/logs/enviaSMSHub_$filename.log";
		$writer = new Zend_Log_Writer_Stream($filename, 'ab');
		$logger->addWriter($writer);
		$hora = date('Y/m/d H:i:s');
		$logger->log("****************************************", Zend_Log::INFO);
		$logger->log("****************************************", Zend_Log::INFO);
		$logger->log("****************************************", Zend_Log::INFO);				
		$logger->log("****************************************FUNCION enviaSMS: $hora", Zend_Log::INFO);		
		
		
		$nonce = rand(0,9).uniqid().rand(0,9); 
		$created=date('Y-md').'T'.date('h:m:s').'Z';
		$digest = sha1(($nonce.utf8_encode($created).$password), TRUE);
		$password2 = base64_encode ($digest);
		
		$logger->log("************password*****".print_r($password,true), Zend_Log::INFO);
		
		$post_string="<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">
   <soapenv:Header>
      <tns:RequestSOAPHeader soapenv:mustUnderstand=\"0\" xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <tns:AppId>c</tns:AppId>
         <tns:TransId>20091224123056000</tns:TransId>
         <tns:token/>
         <tns:OA>aaa86</tns:OA>
         <tns:FA>uuu</tns:FA>
      </tns:RequestSOAPHeader>
      <wsse:Security xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\">
         <wsse:UsernameToken xmlns:wsu=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd\">
            <wsse:Username>PA00000536</wsse:Username>
            <wsse:Password Type=\"...#PasswordDigest\">$password2</wsse:Password>
            <wsse:Nonce>$nonce</wsse:Nonce>
            <wsse:Created>$created</wsse:Created>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <sendSms xmlns=\"http://www.csapi.org/schema/parlayx/sms/send/v2_2/local\">
         <addresses>tel:52$msisdn</addresses>
         <senderName>$senderName</senderName>
         <message>$content</message>
      </sendSms>
   </soapenv:Body>
</soapenv:Envelope>";
		
		
		
		$soap_do = curl_init(); 
		curl_setopt($soap_do, CURLOPT_URL,            $wsdl );   
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST,           true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $post_string); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) ));
		
		$logger->log("last request".print_r($post_string,true), Zend_Log::INFO);
		
		
		$lastRequest = curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);  
		//curl_setopt($soap_do, CURLOPT_USERPWD,$user.":".'kaiser2307');
		
		$result = curl_exec($soap_do);
		$err = curl_error($soap_do);  
		
		$logger->log("FIN", Zend_Log::INFO);	
		return $result;
		
	}
	
	
	function MO($endpoint,$ServiceActivationNumber){
		
		
		$params 	=  Zend_Registry::get('params');

		$password	= $params['password'];
				
		
//		$password = 'kaiser2307';
		$nonce = rand(0,9).uniqid().rand(0,9);
	
		$created=date('Y-md').'T'.date('h:m:s').'Z';


	
		$digest = sha1(($nonce.utf8_encode($created).$password), TRUE);
	
	
		$password2 = base64_encode ($digest);
		
		
	//$wsdl="https://187.141.14.122:8091/asg/services/SmsNotificationManagerService";
	
		$wsdl 		= $params['wsdl'].'SmsNotificationManagerService';
	
	
	$post_string="<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">
   <soapenv:Header>
      <tns:RequestSOAPHeader xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <AppId>N</AppId>
         <TransId>2009122412305610064</TransId>
         <tns:token/>
         <tns:OA>aaa86</tns:OA>
         <tns:FA>uuu</tns:FA>
      </tns:RequestSOAPHeader>
      <wsse:Security xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\">
         <wsse:UsernameToken xmlns:wsu=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd\">
            <wsse:Username>PA00000536</wsse:Username>
            <wsse:Password Type=\"...#PasswordDigest\">$password2</wsse:Password>
            <wsse:Nonce>$nonce</wsse:Nonce>
            <wsse:Created>$created</wsse:Created>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <ns3:startSmsNotification xmlns:ns3=\"http://www.csapi.org/schema/parlayx/sms/notification_manager/v2_3/local\">
         <ns3:reference>
            <endpoint>$endpoint</endpoint>
            <interfaceName>startSmsNotification</interfaceName>
            <correlator>101232</correlator>
         </ns3:reference>
         <ns3:smsServiceActivationNumber>$ServiceActivationNumber</ns3:smsServiceActivationNumber>
         <ns3:criteria></ns3:criteria>
      </ns3:startSmsNotification>
   </soapenv:Body>
</soapenv:Envelope>";
	
	
		
		$soap_do = curl_init(); 
		curl_setopt($soap_do, CURLOPT_URL,            $wsdl );   
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST,           true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $post_string); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) ));
		
		
		$lastRequest = curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);  
		//curl_setopt($soap_do, CURLOPT_USERPWD,$user.":".'kaiser2307');
		
		$result = curl_exec($soap_do);
		$err = curl_error($soap_do);  

		return $result;

	}
	
	
	function realizaCobro ($msisdn, $currencyAmount, $serviceType, $contentId, $retailPrice ){
			//
			$params 	=  Zend_Registry::get('params');
			
			$providerId = $params['providerId'];
			
			$logger = new Zend_Log();
			$filename = date('Ymd');
			$filename = "/home/hub.cm-operations.com/pub_html/logs/realizaCobro_$filename.log";
			$writer = new Zend_Log_Writer_Stream($filename, 'ab');
			$logger->addWriter($writer);
			$hora = date('Y/m/d H:i:s');
			$logger->log("****************************************", Zend_Log::INFO);
			$logger->log("****************************************", Zend_Log::INFO);
			$logger->log("****************************************", Zend_Log::INFO);				
			$logger->log("****************************************FUNCION realizaCobro: $hora", Zend_Log::INFO);
		
			
		//	$wsdl		="https://187.141.14.122:8091/asg/services/AmountChargingService";
			//$password 	= 'kaiser2307';
			//$profile=$this->getProfile($msisdn);
			//$profile=$profile['pago'];
			$logger->log("profile: ".print_r($profile,true), Zend_Log::INFO);
			$wsdl 		= $params['wsdl'].'AmountChargingService';
			$password	= $params['passwordSMS'];		
			
			$logger->log("WSDL: ".print_r($wsdl,true), Zend_Log::INFO);
			$logger->log("PASSWORD: ".print_r($password,true), Zend_Log::INFO);
			
			
			$nonce = rand(0,9).uniqid().rand(0,9);
		
			$created=date('Y-md').'T'.date('h:m:s').'Z';
			
			$suscdate=date("dmY");
			$descripcion=$params['suscripcion'];
			$descripcionDescarga=$params['descripcionDescarga'];
			$descripcionCreditos=$params['descripcionCreditos'];
			$iddescripcion=$params['idsuscripcion'];
			$urlunsuscribe=$params['urlunsuscribe'];
			/*$serviceType=$params['serviceType'];
			$contentId=$params['contentId'];*/
			$suscripcionCategoriaId=$params['suscripcionCategoriaId'];
	
	        $logger->log("MSISDN: ".print_r($msisdn,true), Zend_Log::INFO);
		
			$digest = sha1(($nonce.utf8_encode($created).$password), TRUE);
		
		
			$password2 = base64_encode ($digest);
		
			if ($serviceType == '50000687' || $serviceType == '50000783') {
				$contentDescription = "$descripcion,$suscdate,$iddescripcion,$urlunsuscribe";
				return '';
				exit();
			} else if ($serviceType =='50000594') {
				$contentDescription = "$descripcionDescarga,$suscdate,$iddescripcion,CBD";
			}else if ($serviceType =='50000124') {
				$contentDescription = "$descripcionCreditos,$suscdate,$iddescripcion,CBD";
			}else{
				$contentDescription=$descripcion;
			}
			
	//  amount = retailprice +downloadfee +calculatetax - promo;
	
	$post_string="<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:loc=\"http://www.csapi.org/schema/parlayx/payment/amount_charging/v2_1/local\">
   <soapenv:Header>
      <tns:RequestSOAPHeader xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <AppId>N</AppId>
         <TransId>8768797841274982</TransId>
         <tns:token/>
         <tns:OA>513123412</tns:OA>
         <tns:FA/>
      </tns:RequestSOAPHeader>
      <tns:Security xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <tns:UsernameToken>
            <tns:Username>PA00000536</tns:Username> 
            <tns:Password Type=\"...#PasswordDigest\">$password2</tns:Password>
            <tns:Nonce>$nonce</tns:Nonce>
            <tns:Created>$created</tns:Created>
         </tns:UsernameToken>
      </tns:Security>
   </soapenv:Header>
   <soapenv:Body>
      <loc:chargeAmount>
         <loc:endUserIdentifier>tel:52$msisdn</loc:endUserIdentifier>
         <loc:charge>
            <description>description</description>
            <currency>MXN</currency>
            <amount>$currencyAmount</amount>
            <code>123</code>
         </loc:charge>
         <loc:extraParams>
            <param>
               <name>providerId</name>
               <value>$providerId</value>
                 </param>
            <param>
               <name>serviceType</name>
               <value>$serviceType</value>
                    </param>
            <param>
               <name>contentId</name>
               <value>9122009</value>
            </param>
            <param>
               <name>contentDescription</name>
               <value>$contentDescription</value>
            </param>
            <param>
               <name>retailPrice</name>
               <value>$currencyAmount</value>
            </param>
            <param>
               <name>calculatedTax</name>
               <value>0</value>
            </param>
            <param>
               <name>calculatedPromo</name>
               <value>0</value>
            </param>
            <param>
               <name>downloadFee</name>
               <value>0</value>
            </param>
         </loc:extraParams>
         <loc:referenceCode>123</loc:referenceCode>
      </loc:chargeAmount>
   </soapenv:Body>
</soapenv:Envelope>
";
	
		
		$soap_do = curl_init(); 
		curl_setopt($soap_do, CURLOPT_URL,            $wsdl );   
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST,           true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $post_string); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) ));
		
		
		$lastRequest = curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);  
		//curl_setopt($soap_do, CURLOPT_USERPWD,$user.":".'kaiser2307');
		 $logger->log("last request".print_r($post_string,true), Zend_Log::INFO);
		$result = curl_exec($soap_do);
		$err = curl_error($soap_do);  
        $logger->log("Result".print_r($result,true), Zend_Log::INFO);
		return $result;
		
		
	}
	
	
	
	function startSmsNotification(){
			//
			$params 	=  Zend_Registry::get('params');
			
			$providerId = $params['providerId'];
			
			//$providerId='6040';
			
			$logger = new Zend_Log();
			$filename = date('Ymd');
			$filename ="/home/hub.cm-operations.com/pub_html/logs/startSms_$filename.log";
			$writer = new Zend_Log_Writer_Stream($filename, 'ab');
			$logger->addWriter($writer);
			$hora = date('Y/m/d H:i:s');
			$logger->log("****************************************", Zend_Log::INFO);
			$logger->log("****************************************", Zend_Log::INFO);
			$logger->log("****************************************", Zend_Log::INFO);				
			$logger->log("****************************************FUNCION realizaCobro: $hora", Zend_Log::INFO);
			
			$wsdl 		= $params['wsdl'].'SMSNotificationManagerService';
			//$wsdl		= "https://187.141.14.122:8091/asg/services/SmsNotificationManagerService";
			$password	= $params['passwordSMS'];
					
			//$password	= "c0nc3pT0m3ns4j3";
			//$password='c0nc3pT0';

			$logger->log("WSDL: ".print_r($wsdl,true), Zend_Log::INFO);
			$logger->log("PASSWORD: ".print_r($password,true), Zend_Log::INFO);
			
			
			$nonce = rand(0,9).uniqid().rand(0,9);
		
			$created=date('Y-md').'T'.date('h:m:s').'Z';
			
			
	
	        $logger->log("MSISDN: ".print_r($msisdn,true), Zend_Log::INFO);
		
			$digest = sha1(($nonce.utf8_encode($created).$password), TRUE);
		
		
			$password2 = base64_encode ($digest);
			
			//$marcacion = 9826;
			$marcacion='22722';
			$endPoint = "http://hub.conceptomovil.com/hub/bin/moConnector.php";



	
	$post_string="<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">
   <soapenv:Header>
      <tns:RequestSOAPHeader xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <AppId>N</AppId>
         <TransId>2009122412305610064</TransId>
         <tns:token/>
         <tns:OA>513123412</tns:OA>
         <tns:FA>uuu</tns:FA>
      </tns:RequestSOAPHeader>
      <wsse:Security xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\">
         <wsse:UsernameToken xmlns:wsu=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd\">
      <wsse:Username>PA00000536</wsse:Username>
            <wsse:Password Type=\"...#PasswordDigest\">$password2</wsse:Password>
            <wsse:Nonce>$nonce</wsse:Nonce>
            <wsse:Created>$created</wsse:Created>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <ns3:startSmsNotification xmlns:ns3=\"http://www.csapi.org/schema/parlayx/sms/notification_manager/v2_3/local\">
         <ns3:reference>
            <endpoint>$endPoint</endpoint>
            <interfaceName>startSmsNotification</interfaceName>
            <correlator>101</correlator>
         </ns3:reference>
         <ns3:smsServiceActivationNumber>$marcacion</ns3:smsServiceActivationNumber>
         <ns3:criteria></ns3:criteria>
      </ns3:startSmsNotification>
   </soapenv:Body>
</soapenv:Envelope>
";
	

		$soap_do = curl_init(); 
		curl_setopt($soap_do, CURLOPT_URL,            $wsdl );   
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST,           true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $post_string); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) ));
		
		
		$lastRequest = curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);  
		//curl_setopt($soap_do, CURLOPT_USERPWD,$user.":".'kaiser2307');
		 $logger->log("last request".print_r($post_string,true), Zend_Log::INFO);
		$result = curl_exec($soap_do);
		$err = curl_error($soap_do);  
        $logger->log("Result".print_r($result,true), Zend_Log::INFO);
		return $result;
		
		
	}	

	function stopSmsNotification(){
			//
			$params 	=  Zend_Registry::get('params');

			$logger = new Zend_Log();
			$filename = date('Ymd');
			$filename = "/home/hub.cm-operations.com/pub_html/logs/stopSms_$filename.log";
			$writer = new Zend_Log_Writer_Stream($filename, 'ab');
			$logger->addWriter($writer);
			$hora = date('Y/m/d H:i:s');
			$logger->log("****************************************", Zend_Log::INFO);
			$logger->log("****************************************", Zend_Log::INFO);
			$logger->log("****************************************", Zend_Log::INFO);				
			$logger->log("****************************************FUNCION realizaCobro: $hora", Zend_Log::INFO);
			
			$wsdl 		= $params['wsdl'].'SMSNotificationManagerService';
			$wsdl		= "https://187.141.14.122:8091/asg/services/SmsNotificationManagerService";
			//$password	= $params['password'];
					
			$password	= "c0nc3pT0m3ns4j3";


			$logger->log("WSDL: ".print_r($wsdl,true), Zend_Log::INFO);
			$logger->log("PASSWORD: ".print_r($password,true), Zend_Log::INFO);
			
			
			$nonce = rand(0,9).uniqid().rand(0,9);
		
			$created=date('Y-md').'T'.date('h:m:s').'Z';
			
			
	
	        $logger->log("MSISDN: ".print_r($msisdn,true), Zend_Log::INFO);
		
			$digest = sha1(($nonce.utf8_encode($created).$password), TRUE);
		
		
			$password2 = base64_encode ($digest);
			
			$marcacion = '9826';
			$endPoint = "http://hub.conceptomovil.com/hub/bin/moConnector.php";



	
	$post_string="<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">
	<soapenv:Header>
	<tns:RequestSOAPHeader xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
	<AppId>N</AppId>
	<TransId>20091224123056100014</TransId>
	<tns:token/>
	<tns:OA>aaa86</tns:OA>
	<tns:FA>uuu</tns:FA>
	</tns:RequestSOAPHeader>
	<wsse:Security xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\">
	<wsse:UsernameToken xmlns:wsu=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd\">
	<wsse:Username>PA00000645</wsse:Username>
	<wsse:Password Type=\"...#PasswordDigest\">$password2</wsse:Password>
	<wsse:Nonce>$nonce</wsse:Nonce>
	<wsse:Created>$created</wsse:Created>
	</wsse:UsernameToken>
	</wsse:Security>
	</soapenv:Header>
	<soapenv:Body>
	<ns3:stopSmsNotification xmlns:ns3=\"http://www.csapi.org/schema/parlayx/sms/notification_manager/v2_3/local\">
	<ns3:correlator>101</ns3:correlator>
	</ns3:stopSmsNotification>
	</soapenv:Body>
	</soapenv:Envelope>";
	

		$soap_do = curl_init(); 
		curl_setopt($soap_do, CURLOPT_URL,            $wsdl );   
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST,           true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $post_string); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) ));
		
		
		$lastRequest = curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);  
		//curl_setopt($soap_do, CURLOPT_USERPWD,$user.":".'kaiser2307');
		 $logger->log("last request".print_r($post_string,true), Zend_Log::INFO);
		$result = curl_exec($soap_do);
		$err = curl_error($soap_do);  
        $logger->log("Result".print_r($result,true), Zend_Log::INFO);
		return $result;
		
		
	}	
	
	
	function getProfile($msisdn){
		
		//		Partner ID
		//		PA00000625
		//		Password
		//		Admin111		
		

		$params = Zend_Registry::get ( 'params' );
		$logger = new Zend_Log ();
		$filename = date ( 'Ymd' );
		$filename = "/home/hub.cm-operations.com/pub_html/logs/getProfile_$filename.log";
		$writer = new Zend_Log_Writer_Stream ( $filename, 'ab' );
		$logger->addWriter ( $writer );
		$hora = date ( 'Y/m/d H:i:s' );
		$logger->log ( "****************************************", Zend_Log::INFO );
		$logger->log ( "****************************************", Zend_Log::INFO );
		$logger->log ( "****************************************", Zend_Log::INFO );
		$logger->log ( "****************************************FUNCION realizaCobro: $hora", Zend_Log::INFO );

		$wsdl = $params ['wsdl'] . 'UserProfileService';
		//$wsdl = "https://187.141.14.122:8091/asg/services/UserProfileService";
		//$password = "kaiser2307";
		
		$password=$params['passwordSMS'];
		$logger->log ( "WSDL: " . print_r ( $wsdl, true ), Zend_Log::INFO );
		$logger->log ( "PASSWORD: " . print_r ( $password, true ), Zend_Log::INFO );
		$nonce = rand ( 0, 9 ) . uniqid () . rand ( 0, 9 );
		$created = date ( 'Y-md' ) . 'T' . date ( 'h:m:s' ) . 'Z';
		$logger->log ( "MSISDN: " . print_r ( $msisdn, true ), Zend_Log::INFO );
		$digest = sha1 ( ($nonce . utf8_encode ( $created ) . $password), TRUE );	
		$password2 = base64_encode ( $digest );
		
		$post_string = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:loc=\"http://www.csapi.org/schema/userprofile/local\">
   <soapenv:Header>
      <tns:RequestSOAPHeader xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <AppId>AP00000001</AppId>
         <TransId>fRjnBsEgsVYAAFAArUsuAS+VnqlyHxkv2xs$</TransId>
         <tns:token/>
         <tns:OA>N</tns:OA>
         <tns:FA/>
      </tns:RequestSOAPHeader>
      <tns:Security xmlns:tns=\"http://www.huawei.com/schema/osg/common/v2_1\">
         <tns:UsernameToken>
            <tns:Username>PA00000536</tns:Username>
            <tns:Password Type=\"...#PasswordDigest\">$password2</tns:Password>
            <tns:Nonce>$nonce</tns:Nonce>
            <tns:Created>$created</tns:Created>
         </tns:UsernameToken>
      </tns:Security>
   </soapenv:Header>
   <soapenv:Body>
      <loc:obtainProfileRequest>
         <loc:msisdn>52$msisdn</loc:msisdn>
      </loc:obtainProfileRequest>
   </soapenv:Body>
</soapenv:Envelope>";
		
		$post_string1 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:loc="http://www.csapi.org/schema/parlayx/subscribeproduct/v1_0/local">
	                   <soapenv:Header>
	                      <RequestSOAPHeader soapenv:mustUnderstand="0" xmlns="http://www.huawei.com.cn/schema/common/v2_1">
	                         <AppId>AP00000068</AppId>
	                         <TransId>2010032416450000004</TransId>
	                         <OA>tel:8613607551001</OA>
	                         <FA>tel:8613607551002</FA>
	                      </RequestSOAPHeader>
	                      <Security soapenv:mustUnderstand="0" xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	                         <UsernameToken>
	                            <Username>PA00000770</Username>
	                            <Password>s50qUJJ3oKr9fv+nCwF6wDR5ul0=</Password>
	                            <Nonce>WScqanjCEAC4mQoBE07sAQ==</Nonce>
	                            <Created>2010-03-22T20:03:49</Created>
	                         </UsernameToken>
	                      </Security>
	                   </soapenv:Header>
	                   <soapenv:Body>
	                      <loc:obtainProfileRequest>
					         <loc:msisdn>52' . $msisdn . '</loc:msisdn>
					      </loc:obtainProfileRequest>
					      </soapenv:Body>
					   </soapenv:Envelope>';
		
		$soap_do = curl_init ();
		curl_setopt ( $soap_do, CURLOPT_URL, $wsdl );
		curl_setopt ( $soap_do, CURLOPT_CONNECTTIMEOUT, 10 );
		curl_setopt ( $soap_do, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $soap_do, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $soap_do, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $soap_do, CURLOPT_POST, true );
		curl_setopt ( $soap_do, CURLOPT_POSTFIELDS, $post_string );
		curl_setopt ( $soap_do, CURLOPT_HTTPHEADER, array ('Content-Type: text/xml; charset=utf-8', 'Content-Length: ' . strlen ( $post_string ) ) );
		
		$lastRequest = curl_setopt ( $soap_do, CURLOPT_RETURNTRANSFER, true );
		//curl_setopt($soap_do, CURLOPT_USERPWD,$user.":".'kaiser2307');
		$result = curl_exec ( $soap_do );
		$err = curl_error ( $soap_do );
		$logger->log ( "Result" . print_r ( $result, true ), Zend_Log::INFO );
		$logger->log ( "last request" . print_r ( $post_string, true ), Zend_Log::INFO );
		$obtieneParametros = new UrlString();
		$xml = $obtieneParametros->parseaXML($result);
		
		$resultadoTransaccion=$xml ["soapenv:Body"]["ns1:obtainProfileResponse"]["ns1:userProfile"];
		$logger->log("Resultado**".print_r($resultadoTransaccion,true), Zend_Log::INFO);
		
		
		
		$logger->log("MO**".print_r($mo,true), Zend_Log::INFO);
		
		if(!empty($resultadoTransaccion)){
			
			$data=array('msisdn'=>$resultadoTransaccion['ns1:msisdn'], 'pago'=>$resultadoTransaccion['ns1:pago'],'region'=>$resultadoTransaccion['ns1:region'], 'iva'=>$resultadoTransaccion['ns1:iva']);
			
			return $data;
		}else{
			
			$resultado=0;
			
			$logger->log("error result**".print_r($xml ["soapenv:Body"]["soapenv:Fault"]["detail"]['ns2:ServiceException']['text'],true), Zend_Log::INFO);
			$resultadoTransaccion=$xml ["soapenv:Body"]["soapenv:Fault"]["detail"]['ns2:ServiceException']['text'];
		
			
			
			return $resultadoTransaccion;
			
		}
		
		
		
		
	
		return $result;
		
		
	}	


}
?>	
		
		
		
		
	
