<?php

/*
 * Controlador para administrar la informacion de los usuarios
 */
 
     if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 
 
 		//se importa el modelo
 		require_once ("Models/usuarios_model.php");
		require_once ("Models/sucursales_model.php");
		require_once ("Models/cuenta_model.php");
		
		
		$objetoUsuarios 	= new usuarios();
		$objetoSucursales 	= new sucursales();
		$objetoCuenta		= new cuenta();
		
		
		//if para validar si se envia el formulario de un nuevo usuario
		if( isset($_POST['hidden_envioFormNuevo']) and $_POST['hidden_envioFormNuevo'] == "enviar" ){
			
			$identificacion			= $_POST['identificacion'];
			$nombre					= $_POST['nombre'];
			$apellido				= $_POST['apellido'];
			$telefono				= $_POST['telefono'];
			$celular				= $_POST['celular'];
			$direccion				= $_POST['direccion'];
			$email					= $_POST['email'];
			$sucursalesUsuario		= $_POST['sucursalesUsuario'];
			$licencia				= $_POST['idLicenciaParaUsuario'];
			
			
			if(isset($_POST['usarAgenda'])){
				$usarAgenda = 'Si';
			}else{
				$usarAgenda	= 'No';
			}
			
			if(isset($_POST['estado'])){
				$estado	= 'A';
			}else{
				$estado = 'I';
			}
			
			if($_SESSION['usuario_idioma'] == 'En'){
				$idioma = '2';
				$idiomaTxt = 'En';
			}else{
				$idioma = '1';
				$idiomaTxt = 'Es';
			}
			
			
			
			
			
			$sw        = 0;//para controlar si entra en un error_get_last
        
	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
	        		$ok="Usuario creado correctamente! (Se ha enviado un email al usuario con los datos de acceso)";
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
	        		$ok="User created successfully! (It has sent an email to the user with access data)";
	        		break;
	            
	        }//fin swtich
	        
	        
	        function comprobar_email($email){ 
			   	$mail_correcto = 0; 
			   	//compruebo unas cosas primeras 
			   	if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
			      	if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
			         	//miro si tiene caracter . 
			         	if (substr_count($email,".")>= 1){ 
			            	//obtengo la terminacion del dominio 
			            	$term_dom = substr(strrchr ($email, '.'),1); 
			            	//compruebo que la terminación del dominio sea correcta 
			            	if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
			               	//compruebo que lo de antes del dominio sea correcto 
			               	$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
			               	$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
			               	if ($caracter_ult != "@" && $caracter_ult != "."){ 
			                  	$mail_correcto = 1; 
			               	} 
			            	} 
			         	} 
			      	} 
			   	} 
			   	if ($mail_correcto) 
			      	return 1; 
			   	else 
			      	return 0; 
			}
			
			
			//validar si algun campo obligatorio llega vacio
	        if(($identificacion == "") or ($nombre == "") or ($apellido == "") or ($email == "")){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
			
			if($sw == 0){
				//comprobar emial
				$resultadoEmail	= comprobar_email($email);
	
				if($resultadoEmail == 0){
					$sw = 2;
					$_SESSION['mensaje']   = 'Error E-mail';
				}
			}
			
			if($sw == 0){
				
				
				//funcion para crear un codigo aleatorio
				function randomText($length) { 
					$key = "";
				    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz"; 
				
				    for($i = 0; $i < $length; $i++) { 
				
				        $key .= $pattern{rand(0, 35)}; 
				
				    } 
				
				    return $key; 
				
				}//fin funcion randomText
				
				
				//crear la contraseña
				$digitosPass = randomText(8);
				
				
				$pass = password_hash($digitosPass, PASSWORD_DEFAULT);
				
				//se guarda el usuario y se obtiene el id
				$idUltimoUsuarioGuardado = $objetoUsuarios->guardarUsuario($identificacion, $nombre, $apellido, $pass, $telefono, $celular, $direccion, $email, $usarAgenda, $idioma, $estado, $licencia);
				
				//se vincula el usuario con las sucursales
				foreach ($sucursalesUsuario as $sucursalesUsuario1) {
					$objetoSucursales->vincularUsuarioSucursal($idUltimoUsuarioGuardado,$sucursalesUsuario1);
				}//fin foreach
				
				//se marca la licencia como en usoa $licencia
				if($licencia != '0'){					
					$objetoCuenta->ocuparLicencia($licencia);
				}
				
				
				//se envia el email al usuario para que pueda ingresar
				
				//se importa la libreria encargada de realizar el envio atravez de gmail
				require_once("libs/PHPMailer-master/PHPMailerAutoload.php");
				
				$mail­ = new PHPMailer();
            
	            //indico a la clase que use SMTP
	            $mail­->IsSMTP();
				
				//permite modo debug para ver mensajes de las cosas que van ocurriendo
            	$mail­->SMTPDebug = 0;
				
				//Debo de hacer autenticación SMTP
	            $mail­->SMTPAuth = true;
	            $mail­->SMTPSecure = "tls";
	            //indico el servidor de Gmail para SMTP
	            $mail­->Host = "smtp.gmail.com";
	            //indico el puerto que usa Gmail
	            $mail­->Port = 587;
	            //indico un usuario / clave de un usuario de gmail
	            $mail­->Username = "info@nanuvet.com";
	            $mail­->Password = "3104588379chessmaster";
	            $mail­->SetFrom('info@nanuvet.com', 'info NanuVet');
	            $mail­->AddReplyTo("info@nanuvet.com","info NanuVet");
				
				
				//variables para determinar el idioma del email
				if($idiomaTxt == 'En'){
					//ingles
					$subject		= "Login NanuVet";
					$genial			= "Great, You have been granted access to NunaVet!";
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
					$subject		= "Ingreso NanuVet";
					$genial			= "Genial, Te han otorgado un acceso a NanuVet!";
					$paraIngresar	= "Para ingresar a nuestro sistema utiliza los datos de acceso que aparecen abajo.";
					$porSeguridad	= "Por seguridad, recuerda cambiar tu contraseña.";
					$titleLogin		= "Iniciar sesión";
					$paraIngresarLogin	= "Para ingresar al sistema, dirígete a www.nanuvet.com y elige la opción -Iniciar sesión- o desplázate hasta el final de la página. Luego ingresa los siguientes datos:";
					$ingresarIdentificacionTitular = "Identificación del títular:";
					$ingresarSuIdentificacion		= "Su identificación:";
					$ingresarContrasena				= "Contraseña";
					$textoTutorial					= "Nuestro sistema te guiará para realizar todas las configuraciones necesarias y te enseñara a utilizar todos nuestros módulos paso a paso.";
					$enCasoProblema					= "En caso de inconvenientes escribe a";
					
				}//fin else
				
				$mail­->Subject = $subject;
				
				$identificacionTitular 	= $_SESSION['identificacion_cliente'];
				$identificacion			= $identificacion;
				$passMostrarEmail		= $digitosPass;
				
				
				$mail­->MsgHTML('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
							   "http://www.w3.org/TR/html4/loose.dtd">
							
							<html lang="'.$idiomaTxt.'">
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
								
									<img border="0" src="Public/img/envioEmail/NanuVet.png" label="NanuVet" editable="true" width="600" height="253" id="screenshot">
								
									<table width="600" cellpadding="25" cellspacing="0" border="0" class="promotable">
									<tr>
										<td bgcolor="#4DB6AC" width="600" class="promocell">                      
										 
											<multiline label="Main feature intro"><p><b>'.$genial.'</b></p>
											<p>'.$paraIngresar.'</p>
											<p>'.$porSeguridad.'</p></multiline>
										
										</td>
									</tr>
									</table>
								
									<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="15" class="divider">
								
									<repeater>
										<layout label="New feature">
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td bgcolor="#85bdad" nowrap><img border="0" src="Public/img/envioEmail/spacer.gif" width="5" height="1"></td>
											<td width="100%" bgcolor="#ffffff">
										
												<table width="100%" cellpadding="20" cellspacing="0" border="0">
												<tr>
													<td bgcolor="#ffffff" class="contentblock">
							
														<h4 class="secondary"><strong><singleline label="Title">'.$titleLogin.'</singleline></strong></h4>
														<multiline label="Description"> <p>'.$paraIngresarLogin.'</p>
												                                                                                                
                                                        <p><b><span style="font-size: 14px;">'.$ingresarIdentificacionTitular.' '.$identificacionTitular.'</span></b></p>
                                                        <p><b><span style="font-size: 14px;">'.$ingresarSuIdentificacion.' '.$identificacion.'</span></b></p>
                                                        <p><b><span style="font-size: 14px;">'.$ingresarContrasena.' '.$passMostrarEmail.'</span></b></p></multiline>
							
													</td>
												</tr>
												</table>
										
											</td>
										</tr>
										</table>  
										<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="15" class="divider">
										</layout>
										<layout label="Article, tip or resource">
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td bgcolor="#ef3101" nowrap><img border="0" src="Public/img/envioEmail/spacer.gif" width="5" height="1"></td>
											<td width="100%" bgcolor="#ffffff">
										
												<table width="100%" cellpadding="20" cellspacing="0" border="0">
												<tr>
													<td bgcolor="#ffffff" class="contentblock">
							
														<h4 class="secondary"><strong><singleline label="Title">Tutorial</singleline></strong></h4>
														<multiline label="Description"><p>'.$textoTutorial.'</p></multiline>
							
													</td>
												</tr>
												</table>
										
											</td>
										</tr>
										</table>  
										
									</repeater>           
									
									</td>
								</tr>
								</table>
							
								<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="25" class="divider">
							
								<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f2f2f2">
								<tr>
									<td>
									
										<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="30">
									
										<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
										<tr>
											<td width="600" nowrap bgcolor="#f2f2f2" class="cell">
											
												<table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
												<tr>
													<td width="380" valign="top" class="footershow">
													
														<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="8">  
													
														<p style="color:#a6a6a6;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:15px;padding-top:0;padding-bottom:0;line-height:18px;" class="reminder">'.$enCasoProblema.' info@nanuvet.com</p>
														
													
													</td>
													<td align="right" width="220" style="color:#a6a6a6;font-size:12px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;" valign="top" class="hide">
													
														<table cellpadding="0" cellspacing="0" border="0">
														<tr>
															
															<td><a href="http://twitter.com/"><img border="0" src="Public/img/envioEmail/twitter.gif" width="42" height="32" alt="Follow us on Twitter"></a></td>
															<td><a href="http://www.facebook.com/"><img border="0" src="Public/img/envioEmail/facebook.gif" width="32" height="32" alt="Visit us on Facebook"></a></td>
														</tr>
														</table>
													
														<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="10"><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:bold;">NanuVet</p><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:normal;">Medellin, Colombia</p></td>
												</tr>
												</table>
											
											</td>
										</tr>	
								   		</table>
							
										<img border="0" src="Public/img/envioEmail/spacer.gif" width="1" height="25">
									
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
				$nombrePersonaContacto = $nombre." ".$apellido;
	            $mail­->AddAddress($address, $nombrePersonaContacto);
	            if(!$mail­->Send()) {
	            echo "Error al enviar: ";
	            } else {
	            echo "Mensaje enviado!";
	            }
				
				
				$_SESSION['mensaje']   = $ok;
				
			}//fin sw si toda va bien
			
			
			
			//se redirecciona nuevamente a usuarios
       		 header('Location: '.Config::ruta().'usuarios/' );	
			 		
			exit();
			
		}//fin if si se envia nuevo usuario
		
		
		//si llega editar usuario
		if( isset($_POST['envioEditarUsuario']) and $_POST['envioEditarUsuario'] == "enviar" ){
			
			
			//se reciben las variables
			$idUsuario			= $_POST['idUsuario'];
			$telefono 			= $_POST['editer_telefono'];
			$celular			= $_POST['editer_celular'];
			$direccion			= $_POST['editer_direccion'];
			
			if(isset($_POST['editer_usarAgenda'])){
				$utilizarAgenda		= 'Si';
			}else{
				$utilizarAgenda = 'No';
			}
			
			if(isset($_POST['editer_estado'])){
				$estado				= 'A';
			}else{
				$estado = 'I';
			}


	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
	        		$ok="Información actualizada correctamente!";
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
	        		$ok="Information successfully updated!";
	        		break;
	            
	        }//fin swtich

			
			//metodo para actualizar el usuario
			$objetoUsuarios->actualizarUsuarioDesdeAdmin($idUsuario, $telefono, $celular, $direccion, $utilizarAgenda, $estado);
			
			$_SESSION['mensaje'] = $ok;
			
			 //se redirecciona nuevamente a perfil
       		 header('Location: '.Config::ruta().'usuarios/' );	
			 		
			 exit();			
	
		}//fin if para editar usuario
		
		
		//consultar la información de los usuarios
		$listadoUsuarios = $objetoUsuarios->listarUsuarios();
		
		//consultar la información de las sucursales para el select
		$listadoSucursales = $objetoSucursales->consultarSucursalesSelect();
		
		$idCliente = $_SESSION['BDC_id'];
		
		//consultar las licencias disponibles y activas
		$listadoLicenciasDisponibles = $objetoCuenta->consultarLicenciasParaVincularUsuario($idCliente);
		
 
 		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");

					//saber si tiene permisos para ver los usuarios
					if(!in_array("12", $_SESSION['permisos_usuario'] )){
						
						require_once("Views/Layout/sinPermiso.phtml");	
						
					}else{
						
						//se importa la vista de los usuarios
						require_once("Views/usuarios/usuarios.phtml");							
					}        
					

		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
 
     	
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    }    			
