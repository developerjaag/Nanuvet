<?php


/*
 * Archivo para registrar y enviar un email para recuperar la contraseña
 */
 
 
	$titular 			= $_POST['titular'];
	$identificacion		= $_POST['identificacion'];
	$email				= $_POST['email']; 
	$idioma				= $_POST['idioma'];
	
	
	$cadena = $titular.$identificacion.rand(1,9999999).date('Y-m-d');
	$token = sha1($cadena);
	
	$enlaceEnviar = "http://nanuvet.com/restablecerPass/".sha1($titular)."/".sha1($identificacion)."/".$token;
	

	
 //se incorpora el archivo de configuracion
 require_once ("../../Config/config.php");
 //se incorpora el modelo encargado de registrar los datos en la BD
 require_once ("../../Models/index_model.php");	
 
 //se instancian el objeto del modelo
 $objetoIndex = new index();	
 
 $resultado = $objetoIndex->registrarPedidoContrasena($titular, $identificacion, $email, $token);

	if($resultado == "ok"){
		


//se importa la libreria encargada de realizar el envio atravez de gmail
			require_once("../../libs/PHPMailer-master/PHPMailerAutoload.php");
			
            
            $mail­ = new PHPMailer();
            
            //indico a la clase que use SMTP
            $mail­->IsSMTP();
            //para los acentos
            //$mail->CharSet="UTF-8";
            
            //permite modo debug para ver mensajes de las cosas que van ocurriendo
            $mail­->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            //Debo de hacer autenticación SMTP
            $mail­->SMTPAuth = true;
            $mail­->SMTPSecure = "tls";
            //indico el servidor de Gmail para SMTP
            $mail­->Host = "smtp.gmail.com";
            //indico el puerto que usa Gmail
            $mail­->Port = 587;
            //indico un usuario / clave de un usuario de gmail
            //$mail­->Username = "softnanuvet@gmail.com";
            //$mail­->Password = "Chessmaster1";
            $mail­->Username = "info.inocean@gmail.com";
            $mail­->Password = "3104588379Chessmaster";
            $mail­->SetFrom('softnanuvet@gmail.com', 'info NanuVet');
            $mail­->AddReplyTo("softnanuvet@gmail.com","info NanuVet");
            
			
			
			//variables para determinar el idioma del email
			if($idioma == 'En'){
				//ingles
				$subject		= "Login NanuVet";
				$genial			= "Great, Your demo account for 15 days is ready!";
				$paraIngresar	= "To enter our system uses access data listed below.";
				$porSeguridad	= "For safety, remember to change your password.";
				$titleLogin		= "Login";
				$paraIngresarLogin	= "To access the system, go to www.nanuvet.com and select the -Login- option or scroll to the bottom of the page. Then enter the following data:";
				$ingresarIdentificacionTitular = "Identification of the owner";
				$ingresarSuIdentificacion		= "Your identification:";
				$ingresarContrasena				= "Password";
				$textoTutorial					= "Our system will guide you to perform all the necessary settings and teach you to use our step by step modules.";
				$enCasoProblema					= "In case of difficulty writes";
				
			}else{
				//español
				$subject		= "Restablecer clave NanuVet";
				$genial			= "Link para reestablecer contraseña";
				$paraIngresar	= "Hemos recibido una petición para restablecer la contraseña de tu cuenta.";
				$porSeguridad	= "Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.";
				$titleLink		= "Click aqui para restablecer contraseña";	
				$enCasoProblema	= "En caso de inconvenientes escribe a";
				
			}//fin else
			
			$mail­->Subject = $subject;
			

            $mail­->MsgHTML('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
							   "http://www.w3.org/TR/html4/loose.dtd">
							
							<html lang="'.$idioma.'">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
								<title>NanuVet</title>
								<style>
								a:hover {
									text-decoration: underline !important;
								}
								td.promocell p { 
									color:#000000;
									font-size:16px;
									line-height:26px;
									font-family:Helvetica Neue,Helvetica,Arial,sans-serif;
									margin-top:0;
									margin-bottom:0;
									padding-top:0;
									padding-bottom:14px;
									font-weight:normal;
									text-align: center;
								}
								td.contentblock h4 {
									color:#444444 !important;
									font-size:16px;
									line-height:24px;
									font-family:Helvetica Neue,Helvetica,Arial,sans-serif;
									margin-top:0;
									margin-bottom:10px;
									padding-top:0;
									padding-bottom:0;
									font-weight:normal;
								}
								td.contentblock h4 a {
									color:#444444;
									text-decoration:none;
								}
								td.contentblock p { 
								  	color:#888888;
									font-size:13px;
									line-height:19px;
									font-family:Helvetica Neue,Helvetica,Arial,sans-serif;
									margin-top:0;
									margin-bottom:12px;
									padding-top:0;
									padding-bottom:0;
									font-weight:normal;
								}
								td.contentblock p a { 
								  	color:#3ca7dd;
									text-decoration:none;
								}
								@media only screen and (max-device-width: 480px) {
								     div[class="header"] {
								          font-size: 16px !important;
								     }
								     table[class="table"], td[class="cell"] {
								          width: 300px !important;
								     }
									table[class="promotable"], td[class="promocell"] {
								          width: 325px !important;
								     }
									td[class="footershow"] {
								          width: 300px !important;
								     }
									table[class="hide"], img[class="hide"], td[class="hide"] {
								          display: none !important;
								     }
								     img[class="divider"] {
									      height: 1px !important;
									 }
									 td[class="logocell"] {
										padding-top: 15px !important; 
										padding-left: 15px !important;
										width: 300px !important;
									 }
								     img[id="screenshot"] {
								          width: 325px !important;
								          height: 127px !important;
								     }
									img[class="galleryimage"] {
										  width: 53px !important;
								          height: 53px !important;
									}
									p[class="reminder"] {
										font-size: 11px !important;
									}
									h4[class="secondary"] {
										line-height: 22px !important;
										margin-bottom: 15px !important;
										font-size: 18px !important;
									}
								}
								</style>
							</head>
							<body bgcolor="#e4e4e4" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="-webkit-font-smoothing: antialiased;width:100% !important;background:#e4e4e4;-webkit-text-size-adjust:none;">
								
							<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#e4e4e4">
							<tr>
								<td bgcolor="#e4e4e4" width="100%">
							
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
								<tr>
									<td width="600" class="cell">
									
								   	<table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
									<tr>
										
									</tr>
									</table>
								
									<img border="0" src="../../Public/img/envioEmail/NanuVet.png" label="NanuVet" editable="true" width="600" height="253" id="screenshot">
								
									<table width="600" cellpadding="25" cellspacing="0" border="0" class="promotable">
									<tr>
										<td bgcolor="#4DB6AC" width="600" class="promocell">                      
										 
											<multiline label="Main feature intro"><p><b>'.$genial.'</b></p>
											<p>'.$paraIngresar.'</p>
											<p>'.$porSeguridad.'</p></multiline>
										
										</td>
									</tr>
									</table>
								
									<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="15" class="divider">
								
									<repeater>
										<layout label="New feature">
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td bgcolor="#85bdad" nowrap><img border="0" src="../../Public/img/envioEmail/spacer.gif" width="5" height="1"></td>
											<td width="100%" bgcolor="#ffffff">
										
												<table width="100%" cellpadding="20" cellspacing="0" border="0">
												<tr>
													<td bgcolor="#ffffff" class="contentblock">
							
														<a href="'.$enlaceEnviar.'">'.$titleLink.'</a>
														
				
													</td>
												</tr>
												</table>
										
											</td>
										</tr>
										</table>  
										</layout>
										
										
									</repeater>           
									
									</td>
								</tr>
								</table>
							
								<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="25" class="divider">
							
								<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f2f2f2">
								<tr>
									<td>
									
										<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="30">
									
										<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
										<tr>
											<td width="600" nowrap bgcolor="#f2f2f2" class="cell">
											
												<table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
												<tr>
													<td width="380" valign="top" class="footershow">
													
														<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="8">  
													
														<p style="color:#a6a6a6;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:15px;padding-top:0;padding-bottom:0;line-height:18px;" class="reminder">'.$enCasoProblema.' softnanuvet@gmail.com</p>
														
													
													</td>
													<td align="right" width="220" style="color:#a6a6a6;font-size:12px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;" valign="top" class="hide">
													
														<table cellpadding="0" cellspacing="0" border="0">
														<tr>
															
															<td><a href="http://twitter.com/"><img border="0" src="../../Public/img/envioEmail/twitter.gif" width="42" height="32" alt="Follow us on Twitter"></a></td>
															<td><a href="http://www.facebook.com/"><img border="0" src="../../Public/img/envioEmail/facebook.gif" width="32" height="32" alt="Visit us on Facebook"></a></td>
														</tr>
														</table>
													
														<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="10"><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:bold;">NanuVet</p><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:normal;">Medellin, Colombia</p></td>
												</tr>
												</table>
											
											</td>
										</tr>	
								   		</table>
							
										<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="25">
									
								   </td>
								</tr>
								</table>
								
								</td>
							</tr>
							</table>  	   			     	 
							
							</body>
							</html>');

            
            //indico destinatario
            $address = $email;
            $mail­->AddAddress($address, '');
            if(!$mail­->Send()) {
            //echo "Error al enviar: ";
            } else {
            //echo "Mensaje enviado!";
            }

		
	}//fin if si el resultado es ok
	
	echo $resultado;

?>