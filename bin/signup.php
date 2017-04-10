<?php
require_once ("../etc/config.php");
ini_set('memory_limit', '-1');
$config  = Zend_Registry::get('config');

/*        if ($auth->hasIdentity()) 
           { */
  $acciones = array(
                     'listar'	=> 'listar',
                     'agregar'	=> 'agregar',
                     'editar'	=> 'actualizar',
                     'eliminar'	=> 'eliminar'
                   );

  $smarty->assign('application', $config->application);
  $smarty->assign('help',"https://conceptomovil.zendesk.com/hc/es-419/articles/115001413806-Broadcaster-Creaci%C3%B3n-de-una-cuenta-");

  if (!isset($_REQUEST['accion'])) { //Si no se ha enviado una accion
		listar();
	} else { //Si hay una accion, ejecutarla
		while( list($k, $v) = each($acciones) ){
			if( $k == $_REQUEST['accion'] ){
				$v();
			}
		}
	}
/*} else {
    header("Location: login.php");
}*/


function listar($flag=0){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');

	$smarty -> display("signup.html");

	if($flag == 1){
		echo '<script type="text/javascript">
		document.getElementById("login").style.display = "none";
		</script>';

		echo "<div class='alert' style='position: absolute;top: 4vh;width: 70%;margin: 0 15%;z-index: 9999999;padding: 15% 0%;'>
		      <center>
			    <h1>
			    <strong>¡Éxito!</strong> ¡Bienvenido a Broadcaster!
			    <br> Redireccionando a la página principal...
			    </h1>
			  </center>
			  </div>";

	    echo '<script type="text/javascript">
	               setTimeout(function(){ window.location = "http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/login.php"; }, 3000);
		      </script>';
	}

	if($flag == 2){
		echo "<div class='alert alert-danger' style='position: absolute; top: 0; width: 100%;'>
		      <center>
			    <strong>¡Error!</strong> Ese usuario o correo o teléfono ya existe en base o hubo un problema en base.
			  </center>
			  </div>";
	}

}


function agregar(){
	$smarty = Zend_Registry::get('smarty');
	$config = Zend_Registry::get('config');
	$db 	=  Zend_Registry::get('db');


	$query= "SELECT * FROM usuario WHERE  usuario_nombre= '".$_REQUEST['username']."' OR usuario_login='".$_REQUEST['email']."' OR usuario_msisdn='".$_REQUEST['msisdn']."';";
    $result = $db->fetchAll($query); 


    if(count($result)<=0){
       $data_mt=array(
	        		'empresa_id'	=> $_REQUEST['enterprise'],
	        		'usuario_nombre' 	=> $_REQUEST['username'],
	        		'usuario_login' 	=> $_REQUEST['email'],
	        		'usuario_nombre_real' 	=> $_REQUEST['name'],
	        		'usuario_operador' 	=> $_REQUEST['operator'],
	        		'usuario_msisdn' 	=> $_REQUEST['msisdn'],
	        		'usuario_password'      => md5($_REQUEST['password']),
	        		'usuario_fecha'      => date('Y-m-d H:i:s'),
	        		'usuario_secreto' 	=> $_REQUEST['secret'],
	        		'usuario_activo'		=> 1
				  );
	   $insert = $db->insert('usuario',$data_mt);

	   $query2 = "SELECT usuario_id FROM usuario WHERE usuario_msisdn='".$_REQUEST['msisdn']."';";
       $result2 = $db->fetchAll($query2);


       $data_cr=array(
	        		'credito_valor'	=> 0.00,
	        		'usuario_id' 	=> $result2[0]['usuario_id'],
				  );
	   $insert = $db->insert('credito',$data_cr);

	   $headers = "From: sms@conceptomovil.com\r\n";
	   $headers .= "MIME-Version: 1.0\r\n";
       $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
	   /*$message = '<html><body>';
	   $message .= '<h1>Broadcaster Web SMS - Broadcaster</h1>';
	   $message .= '<h2>Bienvenido a Broadcaster <br> Su usuario es : '.$_REQUEST['username'].' <BR> Su clave es:'.$_REQUEST['password'].'</h2><br>
	   Sitio web: http://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/bin/login.php<p>
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
																	
												
													
													<h2>Bienvenido a Broadcaster <br> Su usuario es : '.$_REQUEST['username'].' <BR> Su clave es:'.$_REQUEST['password'].'</h2>

													
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
	   mail($_REQUEST['email'],"BROADCASTERWEBSMS",$message, $headers);

	   $message2 = $_REQUEST['name']." ".$_REQUEST['email']." ".$_REQUEST['msisdn'];

	   mail("gabriela.altamirano@conceptomovil.com;sury.nolasco@conceptomovil.com","BROADCASTERWEBSMS",$message2, $headers);

	   /*$headers = "From: sms@conceptomovil.com" ;
	    mail($_REQUEST['email'],"BROADCASTERWEBSMS","Bienvenido a Broadcaster Web SMS su usuario es : ".$_REQUEST['username']." y su clave es: ".$_REQUEST['password'], $headers)*/;

	    $contenido = urlencode("Bienvenido a Broadcaster Web SMS \nSu usuario es : ".$_REQUEST['username']." \nSu clave es: ".$_REQUEST['password']." \nhttp://www.broadcastersms.com");
       	$msisdn = $_REQUEST['msisdn'];
       	  if($_REQUEST['operator'] == 'telcel' || $_REQUEST['operator'] == 'Telcel' || $_REQUEST['operator'] == 'TELCEL'){
				$operador = $_REQUEST['operator'];
				$marcacion = '26262';
				$user = 'sendsmsmt_26262';
				$smscId = 'telcel_26262';
				/*$url = 'http://localhost:13013/cgi-bin/sendsms?username=sendsmsmt_26262&password=kaiser&to=%s&text=%s';
				$url    = sprintf($url, "52".$msisdn, $contenido);*/

				$url = "http://administrador.cm-operations.com/telcel/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=SIGNUP&username=sendsmsmt_26262";

			}elseif($_REQUEST['operator'] == 'movistar' || $_REQUEST['operator'] == 'Movistar' || $_REQUEST['operator'] == 'MOVISTAR' || $_REQUEST['operator'] == 'Virgin' || $_REQUEST['operator'] == 'VIRGIN'){
		        $operador = $_REQUEST['operator'];
		        /*$marcacion = '26262';
				$user = 'sendsmsmovistar_26262';
				$smscId = 'movistar_26262';
				$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/


				$marcacion = '26262';
                $user = 'sendsmsmovistar_26262';
                $smscId = 'movistar_26262';

				$service = "WEBSMSSIGNUP";

                 $url = sprintf("http://administrador.cm-operations.com/movistar/router/router_mt.php?"."username=%s&message=%s&dial=%s&SOA=%s&service=%s", $user, $contenido, "26262", $msisdn, $service);

			}elseif($_REQUEST['operator'] == 'iusacell' || $_REQUEST['operator'] == 'Iusacell' || $_REQUEST['operator'] == 'IUSACELL' || $_REQUEST['operator'] == 'Unefon' || $_REQUEST['operator'] == 'UNEFON' || $_REQUEST['operator'] == 'AT&T' || $_REQUEST['operator'] == 'ATT' || $_REQUEST['operator'] == 'Att' || $_REQUEST['operator'] == 'att' || $_REQUEST['operator'] == 'Nextel' || $_REQUEST['operator'] == 'nextel'){
				$operador = "Att";
				$marcacion = '26262';
				$user = 'sendsmsiusacell_26262';
				$smscId = 'iusacell_26262';
				/*$url = "http://localhost:13013/cgi-bin/sendsms?username=$user&password=kaiser&to=$msisdn&text=$contenido";*/

				$url = "http://administrador.cm-operations.com/iusacell/router/router_mt.php?SOA=$msisdn&dial=26262&message=$contenido&service=WEBSMS&subservice=SIGNUP&username=sendsmsatt_26262";

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
										        		'mt_servicio'	=> "Contraseña",
										        		'mt_marcacion' 	=> "26262",
										        		'mt_operador' 	=> $operador,
										        		'mt_folio'      => rand(0,9).uniqid().rand(0,9),
										        		'mt_msisdn'     => $msisdn,
										        		'mt_contenido'  => urldecode($contenido),
										        		'mt_fecha'      => date('Y-m-d H:i:s'),
										        		'mt_tag'		=> "mail",
										        		'usuario_id'    => $result2[0]['usuario_id']
										    		   );
											$insert = $db->insert('mt_sms',$data_mt);
											/*echo "200";*/


										
										}else{
											$XMLFILE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
											$XMLFILE .= "<status>ERROR</status>";
											echo "500"; 
										}
										//echo $XMLFILE
										 		
									}catch(Exception $e){
										echo "500"; 
									} 


	   listar(1);
    }else{
        listar(2);
    }
 }

?>