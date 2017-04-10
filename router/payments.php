<?php
ini_set("display_errors","1");
ini_set('max_execution_time', 600); //600 seconds = 10 minutes
set_time_limit(0); 
error_reporting(E_ALL & ~E_NOTICE);
require_once ('/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/etc/config.php');

$config     = Zend_Registry::get('config');
$db         = Zend_Registry::get('db');


$logger   = new Zend_Log();
$filename = date('Ymd');
$filename = '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/logs/Pago_'.$filename.'.log';
$writer   = new Zend_Log_Writer_Stream($filename, 'ab');
$logger->addWriter($writer);

$hora = date('Y/m/d H:i:s');
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", Zend_Log::INFO);               
$logger->log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>FUNCION CODERE: $hora", Zend_Log::INFO);
$logger->log('_REQUEST::'.print_r($_REQUEST,true), Zend_Log::INFO);

/* Configuracion del servidor IMAP */

$hostname = '{imap.gmail.com:993/ssl/novalidate-cert}INBOX';
$logger->log("HOSTNAME: ". print_r($hostname, true), Zend_Log::INFO);

$username = 'smspagos@conceptomovil.com';
$logger->log("USERNAME: ". print_r($username, true), Zend_Log::INFO);

$password = 'PAYMENT2017';

/* Intento de conexión */

$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* Recuperamos los emails */
//$emails = imap_search($inbox,'UNSEEN SUBJECT "Smart AdServer - Reportes Big data - CENAM - Reporte Clientes SmartAd Server AYER"');
$emails = imap_search($inbox,'UNSEEN');
$logger->log("EMAILS: ". print_r($emails, true), Zend_Log::INFO);



/* Si obtenemos los emails, accedemos uno a uno... */

if($emails) {

    /* variable de salida */

    $output = '';

    /* Colocamos los nuevos emails arriba */

    rsort($emails);

    /* por cada email... */

    $i=0;

    foreach($emails as $email_number) {
        /* Obtenemos la información específica para este email */

        $overview = imap_fetch_overview($inbox,$email_number,0);
        $logger->log("OVERVIEW : ". print_r($overview, true), Zend_Log::INFO);

        $subject = $overview[0]->subject;

        $body = $overview[0]->body;

        $logger->log("OVERVIEW SUBJECT MSISDN : ". print_r($subject, true), Zend_Log::INFO);

        $sms = imap_fetchbody($inbox,$email_number,1);   


        $sms = (string)strip_tags($sms);



        $originales = 'ÀÁÂÃÄÅÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜàáâãäåèéêëìíîïñòóôõöùúû';
    	$modificadas = 'aaaaaaeeeeiiiinooooouuuuaaaaaaeeeeiiiinooooouuu';
	    /*$sms = utf8_decode($sms);*/
	    $sms = strtr($sms, utf8_decode($originales), $modificadas);

	    $subject = strtr($subject, utf8_decode($originales), $modificadas);

		$logger->log("MESAGE DECODE: ". print_r($sms, true), Zend_Log::INFO);
		/*$sms = urlencode($sms);

		echo $sms."<br>";*/
		$logger->log("MESAGE ENCODE: ". print_r($sms, true), Zend_Log::INFO);

		$sms = ereg_replace("%A0", "+", $sms);

		$sms = urldecode($sms);


        echo $subject."<br>";

        echo $sms."<br>";


        
        $cadena = $sms; 
		$subcadena = "$"; 
		$posicionsubcadena = strpos ($cadena, $subcadena); 
		$sms = substr ($cadena, ($posicionsubcadena+2)); 


		$arr = explode("*mxn", $sms);
        $creditito = $arr[0];

		echo $creditito."<br>";


		$cadena2 = $sms; 
		$subcadena2 = "Email :"; 
		$posicionsubcadena2 = strpos ($cadena2, $subcadena2); 
		$sms2 = substr ($cadena2, ($posicionsubcadena2+7)); 


		$arr2 = explode("Tel", $sms2);
        $correo = $arr2[0];

        $correo = trim($correo);

        $correo = str_replace("=", "", $correo);

        $correo = str_replace(" ", "", $correo);

        $correo = urlencode($correo);

        $correo = str_replace("%0D%0A", "", $correo);

        $correo = urldecode($correo);

        echo $correo."<br>";


        $usuarios = $db->select();
		$usuarios->from('usuario');
		$usuarios->where("usuario_login ='".$correo."'");
		$usuario = $db->fetchAll($usuarios);
	    $ide = $usuario[0]['usuario_id'];

	    echo $usuarios."SELEC <br>";

	    print_r($usuario);


	    echo $ide."ID <br>";

	    $creditos = $db->select();
		$creditos->from('credito','credito_valor');
		$creditos->where("usuario_id ='".$ide."'");
		$credito = $db->fetchAll($creditos);
	    $valor = $credito[0]['credito_valor'];
        
        echo $creditito."<br>";

        echo $valor."Valor <br>";

        $creditito = (float)$creditito;

        echo $creditito."<br>";

	    $nuevo = ($valor+$creditito);

	    echo $nuevo."<br>";


	    $data_cr=array(
		        		'credito_valor'      => $nuevo
		    		   );

		$logger->log('Array data_cr:: '.print_r($data_cr,true), Zend_Log::INFO);
		$update = $db->update('credito',$data_cr,"usuario_id ='".$ide."'");
		$logger->log('SE ACTUALIZO:: '.print_r($update,true), Zend_Log::INFO); 

		if($update == 1){

			$data_pa=array(											        		
		        		'cantidad'  => $creditito,
		        		'fecha'      => date('Y-m-d H:i:s'),
		        		'usuari_id'    => $usuario[0]['usuario_id']
		    		   );
			$insert = $db->insert('pago_facil',$data_pa);


			 $headers = "From: sms@conceptomovil.com\r\n";
			 $headers .= "MIME-Version: 1.0\r\n";
             $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
			 /*$message = '<html><body>';
			 $message .= '<h1>Cuenta de Broadcaster Web SMS</h1>';
			 $message .= '<h2>Se han agregado : '.$creditito.' pesos a tu cuenta.</h2><h3>Ya puedes utilizarlo para envíar tus mensajes.</h3><br><p>Gracias<br>
						El equipo de Broadcaster Web SMS - Broadcaster<br></p>
						<img src="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/html/es/images/banner.png" width="100%">';
			 $message .= '</body></html>';*/


			 $message = '<html>
                     <head>
						<meta name="viewport" content="width=device-width" />
       					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Broadcaster | Equipo de asistencia Broadcaster
						</title>
							
						<style>
						* { 
							margin:0;
							padding:0;
						}
						* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

						img { 
							max-width: 100%; 
						}
						.collapse {
							margin:0;
							padding:0;
						}
						body {
							-webkit-font-smoothing:antialiased; 
							-webkit-text-size-adjust:none; 
							width: 100%!important; 
							height: 100%;
						}


						a { color: #2BA6CB;}

						.btn {
							text-decoration:none;
							color: #FFF;
							background-color: #666;
							padding:10px 16px;
							font-weight:bold;
							margin-right:10px;
							text-align:center;
							cursor:pointer;
							display: inline-block;
						}

						p.callout {
							padding:15px;
							background-color:#ECF8FF;
							margin-bottom: 15px;
						}
						.callout a {
							font-weight:bold;
							color: #2BA6CB;
						}

						table.social {
						/* 	padding:15px; */
							background-color: #ebebeb;
							
						}
						.social .soc-btn {
							padding: 3px 7px;
							font-size:12px;
							margin-bottom:10px;
							text-decoration:none;
							color: #FFF;font-weight:bold;
							display:block;
							text-align:center;
						}
						a.fb { background-color: #3B5998!important; }
						a.tw { background-color: #1daced!important; }
						a.gp { background-color: #DB4A39!important; }
						a.ms { background-color: #000!important; }

						.sidebar .soc-btn { 
							display:block;
							width:100%;
						}

						table.head-wrap { width: 100%;}

						.header.container table td.logo { padding: 15px; }
						.header.container table td.label { padding: 15px; padding-left:0px;}

						table.body-wrap { width: 100%;}

						table.footer-wrap { width: 100%;	clear:both!important;
						}
						.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
						.footer-wrap .container td.content p {
							font-size:10px;
							font-weight: bold;
							
						}

						h1,h2,h3,h4,h5,h6 {
						font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
						}
						h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

						h1 { font-weight:200; font-size: 24px;}
						h2 { font-weight:200; font-size: 22px;}
						h3 { font-weight:500; font-size: 20px;}
						h4 { font-weight:500; font-size: 18px;}
						h5 { font-weight:900; font-size: 16px;}
						h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

						.collapse { margin:0!important;}

						p, ul { 
							margin-bottom: 10px; 
							font-weight: normal; 
							font-size:14px; 
							line-height:1.6;
						}
						p.lead { font-size:17px; }
						p.last { margin-bottom:0px;}

						ul li {
							margin-left:5px;
							list-style-position: inside;
						}

						ul.sidebar {
							background:#ebebeb;
							display:block;
							list-style-type: none;
						}
						ul.sidebar li { display: block; margin:0;}
						ul.sidebar li a {
							text-decoration:none;
							color: #666;
							padding:10px 16px;
						/* 	font-weight:bold; */
							margin-right:10px;
						/* 	text-align:center; */
							cursor:pointer;
							border-bottom: 1px solid #777777;
							border-top: 1px solid #FFFFFF;
							display:block;
							margin:0;
						}
						ul.sidebar li a.last { border-bottom-width:0px;}
						ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

						.container {
							display:block!important;
							max-width:600px!important;
							margin:0 auto!important; /* makes it centered */
							clear:both!important;
						}

						.content {
							padding:15px;
							max-width:600px;
							margin:0 auto;
							display:block; 
						}

						.content table { width: 100%; }

						.column {
							width: 300px;
							float:left;
						}
						.column tr td { padding: 15px; }
						.column-wrap { 
							padding:0!important; 
							margin:0 auto; 
							max-width:600px!important;
						}
						.column table { width:100%;}
						.social .column {
							width: 280px;
							min-width: 279px;
							float:left;
						}

						@media only screen and (max-width: 600px) {
							
							a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

							div[class="column"] { width: auto!important; float:none!important;}
							
							table.social div[class="column"] {
								width:auto!important;
							}

						}
						</style>

						</head>
						 
						<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

						<!-- HEADER -->
						<table class="head-wrap" bgcolor="#fff">
							<tr>
								<td></td>
								<td class="header container" align="">
									
									<!-- /content -->
									<div class="content">
										<table bgcolor="#fff" >
											<tr>
												<td></td>
												<td align="right"><h6 class="collapse">Equipo de Asistencia de Broadcaster</h6></td>
											</tr>
										</table>
									</div><!-- /content -->
									
								</td>
								<td></td>
							</tr>
						</table><!-- /HEADER -->

						<!-- BODY -->
						<table class="body-wrap" bgcolor="ececec">
							<tr>
								<td></td>
								<td class="container" align="" bgcolor="#FFFFFF">
									
									<!-- content -->
									<div class="content">
										<table>
											<tr>
												<td>
																	
												
													
													<h2>Se han agregado : '.$creditito.' pesos a tu cuenta.</h2><BR><h3>Ya puedes utilizarlo para enviar tus mensajes.</h3>

													
													<p>
										El equipo de Broadcaster Web SMS - Broadcaster<br></p>
													
													<h5 style="text-align: center; color: #00b7e3;"><strong>Gracias</strong></h5>
												</td>
											</tr>
										</table>
										
									</div><!-- /content -->

									
									<!-- content -->
									<div class="content">
										<table bgcolor="">
											<tr>
												<td>
													
													<!-- social & contact -->
													<table bgcolor="" class="social" width="100%">
														<tr>
															<td>
																
																<!--- column 1 -->
																<div class="column">
																	<table bgcolor="" cellpadding="" align="left">
																<tr>
																	<td>				
																		
																		<h5 class="">Ir a sitio:</h5>
																		<p class=""><a href="http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/login.php" class="soc-btn tw">Ir al sitio</a></p>
												
																		
																	</td>
																</tr>
															</table><!-- /column 1 -->
																</div>
																
																<!--- column 2 -->
																<div class="column">
																	<table bgcolor="" cellpadding="" align="left">
																<tr>
																	<td>				
																									

																		<p>Tel:<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30</a><br />
																			<b>Ext.</b> 1009, 1010<br/>
						                 <a href="mailto:sury.nolasco@conceptomovil.com">sury.nolasco@conceptomovil.com</a></p>
						                
																	</td>
																</tr>
															</table><!-- /column 2 -->	
																</div>
																
																<div class="clear"></div>
							
															</td>
														</tr>
													</table><!-- /social & contact -->
													
												</td>
											</tr>
										</table>
									</div><!-- /content -->
									

								</td>
								<td></td>
							</tr>
						</table><!-- /BODY -->

							  
										

						<!-- FOOTER -->
						<table class="footer-wrap">
							<tr>
								<td></td>
								<td class="container">
									
										<!-- content -->
										<div class="content">
											<table>
												<tr>
													<td align="center">
														<p>
															<a style="color: #000;" href="http://www.broadcastersms.com/">Broadcaster</a> |
															<a style="color: #000;" href="#">Equipo de Asistencia</a> |
															<a style="color: #000;" href="callto:+52 (55) 11 01 56 30">+52 (55) 11 01 56 30   <b>Ext.</b> 1009, 1010</a> |
															<a style="color: #000;" href="http://www.broadcastersms.com/">broadcastersms.com</a> |
															
														</p>
													</td>
												</tr>
											</table>
										</div><!-- /content -->
										
								</td>
								<td></td>
							</tr>
						</table><!-- /FOOTER -->

						</body>
						</html>';
	    	 mail($correo,"BROADCASTERWEBSMS",$message, $headers);

	    	    $contenido = urlencode("Se han agregado : ".$creditito." pesos a tu cuenta. \nEl equipo de cuentas Broadcaster Web SMS"." \nhttp://www.broadcastersms.com");
		       	$msisdn = $usuario[0]['usuario_msisdn'];

		       	echo $msisdn." ".$usuario[0]['usuario_operador']." OPERADOR <br>";
		       	  if($usuario[0]['usuario_operador'] == 'telcel' || $usuario[0]['usuario_operador'] == 'Telcel' || $usuario[0]['usuario_operador'] == 'TELCEL'){
						$operador = $usuario[0]['usuario_operador'];
						$marcacion = '26262';
						$user = 'sendsmsmt_26262';
						$smscId = 'telcel_26262';
						$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
						$url    = sprintf($url, "52".$msisdn, $contenido);

					}elseif($usuario[0]['usuario_operador'] == 'movistar' || $usuario[0]['usuario_operador'] == 'Movistar' || $usuario[0]['usuario_operador'] == 'MOVISTAR' || $usuario[0]['usuario_operador'] == 'Virgin' || $usuario[0]['usuario_operador'] == 'VIRGIN'){
				        $operador = $usuario[0]['usuario_operador'];
				        $marcacion = '26262';
						$user = 'sendsmsmovistar_26262';
						$smscId = 'movistar_26262';
						$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";

					}elseif($usuario[0]['usuario_operador'] == 'iusacell' || $usuario[0]['usuario_operador'] == 'Iusacell' || $usuario[0]['usuario_operador'] == 'IUSACELL' || $usuario[0]['usuario_operador'] == 'Unefon' || $usuario[0]['usuario_operador'] == 'UNEFON' || $usuario[0]['usuario_operador'] == 'AT&T'){
						$operador = $usuario[0]['usuario_operador'];
						$marcacion = '26262';
						$user = 'sendsmsiusacell_26262';
						$smscId = 'iusacell_26262';
						$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";

					}

					try{
												$req =& new HTTP_Request($url);
												if (!PEAR::isError($req->sendRequest())) {
												     $response1 = $req->getResponseBody();
												} else {
												     $response1 = "";     
												}


												$response1 = '0: Accepted for delivery';

												if ($response1 == '0: Accepted for delivery') {
													$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
													$XMLFILE .= "<status>OK</status>";
													

													#INSERTA MT 
													$data_mt=array(
												        		'mt_medio'      => "Base",
												        		'mt_servicio'	=> "RECARGA",
												        		'mt_marcacion' 	=> "26262",
												        		'mt_operador' 	=> $operador,
												        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
												        		'mt_msisdn'     => $msisdn,
												        		'mt_contenido'  => urldecode($contenido),
												        		'mt_fecha'      => date('Y-m-d H:i:s'),
												        		'mt_tag'		=> "mail",
												        		'usuario_id'    => $usuario[0]['usuario_id']
												    		   );
													$insert = $db->insert('mt_sms',$data_mt);
													echo "200";


												
												}else{
													$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
													$XMLFILE .= "<status>ERROR</status>";
													echo "500"; 
												}
												//echo $XMLFILE
												 		
											}catch(Exception $e){
												echo "500"; 
											} 
		}

		if($subject=="=?UTF-8?Q?Transacci=C3=B3n_Empresarial_en_PagoFacil.net?="){
			echo "YES";
			echo $email_number;
			imap_setflag_full($inbox, trim($email_number), '\\Seen');
		}else{
			echo "NO";
			echo $email_number;
			imap_clearflag_full($inbox,trim($email_number),'\\Seen');
		}

    }


} 



/* Cerramos la connexión */

imap_close($inbox);

exit;


$logger->log("Fin::..", Zend_Log::INFO);
  
?>