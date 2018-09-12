<?php

/*
 * Archivo para el envio de email a los clientes
 */
 
if(!isset($_SESSION)){
	    session_start();
	}
 
 $swClave = 0;
 
 
 //si no se ha ingresado la clave
 if (isset($_POST['clave']) and $_POST['clave'] == "3104588379Chessmaster") {
     
	 
 	$swClave = 1;	 
	 
 }
 
 if ($swClave == 1) {

	 //si se envio el formulario para enviar email
	 if (isset($_POST['envio']) and $_POST['envio'] == "enviarMail") {
	 	
		//se importa la libreria encargada de realizar el envio atravez de gmail
		require_once("../libs/PHPMailer-master/PHPMailerAutoload.php");
		
		$email = $_POST['email'];
		$nombrePersonaContacto = $_POST['nombre'];
		
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
        $mail­->Username = "softnanuvet@gmail.com";
        $mail­->Password = "Chessmaster1";
        $mail­->SetFrom('softnanuvet@gmail.com', 'info NanuVet');
        $mail­->AddReplyTo("softnanuvet@gmail.com","info NanuVet");
		
		$subject		= "Conoce a NanuVet";
	 	
		$mail­->Subject = $subject;
		
            $mail­->MsgHTML('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
							   "http://www.w3.org/TR/html4/loose.dtd">
							
<html lang="Es">
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


					
								<img border="0" src="img/volante1.png" label="NanuVet" editable="true" width="480" height="672" id="screenshot">
					
								<table width="600" cellpadding="25" cellspacing="0" border="0" class="promotable">
						
								</table>
					
								<img border="0" src="../Public/img/envioEmail/spacer.gif" width="1" height="15" class="divider">
					
						      
							</td>
						</tr>
					</table>

					<img border="0" src="../Public/img/envioEmail/spacer.gif" width="1" height="25" class="divider">

					<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f2f2f2">
						<tr>
							<td>
									
								<img border="0" src="../Public/img/envioEmail/spacer.gif" width="1" height="30">
						
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
									<tr>
										<td width="600" nowrap bgcolor="#f2f2f2" class="cell">
								
											<table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
												<tr>
													<td width="380" valign="top" class="footershow">
										
														<img border="0" src="../Public/img/envioEmail/spacer.gif" width="1" height="8">  
										
														<p style="color:#a6a6a6;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:15px;padding-top:0;padding-bottom:0;line-height:18px;" class="reminder"></p>
											
										
													</td>
													
													<td style="text-align: center; width: 150px; vertical-align: middle;">
																	<a href="http://www.nanuvet.com"><h3>www.nanuvet.com</h3></a>
																	&nbsp;
																</td>
													
													<td align="right" width="220" style="color:#a6a6a6;font-size:12px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;" valign="top" class="hide">
										
														<table cellpadding="0" cellspacing="0" border="0">
															<tr>
																
																<td>
																	<a href="http://twitter.com/nanuvet"><img border="0" src="../Public/img/envioEmail/twitter.gif" width="42" height="32" alt="Follow us on Twitter"></a>
																</td>
																<td>
																	<a href="http://www.facebook.com/nanuvet/"><img border="0" src="../Public/img/envioEmail/facebook.gif" width="32" height="32" alt="Visit us on Facebook"></a>
																</td>
															</tr>
														</table>
										
														<img border="0" src="../Public/img/envioEmail/spacer.gif" width="1" height="10"><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:bold;">NanuVet</p><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:normal;">Medellin, Colombia</p>
													</td>
												</tr>
											</table>
								
										</td>
									</tr>	
					   			</table>

								<img border="0" src="../Public/img/envioEmail/spacer.gif" width="1" height="25">
						
					   		</td>
						</tr>
					</table>
				
				</td>
			</tr>
		</table>  	   			     	 

	</body>
</htm>');

            
            //indico destinatario
            $address = $email;
            $mail­->AddAddress($address, $nombrePersonaContacto);
            if(!$mail­->Send()) {
            echo "Error al enviar: ";
            } else {
            echo "Mensaje enviado!";
            }		
		
		
	     $_SESSION['mensaje'] = "email enviado a: ".$nombrePersonaContacto." (".$email.")";
	     header('Location: http://www.nanuvet.com/aaa_envioPublicidad/' );	
		 exit();
	 }//fin if si se envia el formulario

     
 }


?>








<!Doctype html>
<html>
	<head>
		<title>Envio publicidad</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	
	<body>
		<h3 style="text-align: center;">
			<?php 
			if (isset($_SESSION['mensaje'])) {
				echo $_SESSION['mensaje'];
			}
				
			?>
		</h3>

		<form name="form_correo" id="form_correo" action="" method="post">
			
			<input type="hidden" name="envio" id="envio" value="enviarMail" />
			
			<input style="width: 328px; " type="email"  name="email" id="email" placeholder="email" required />
			<br>
			
			<input style="width: 328px; " type="text" name="nombre" id="nombre" placeholder="nombre empresa o persona" required />
			<br>
			
			<input style="width: 328px; " type="text" name="clave" id="clave" placeholder="clave" required />
			<br>
			
			<input type="submit" value="enviar" />
			
		</form>
	</body>
	
</html>







<?php
	unset ($_SESSION['mensaje']);
?>
