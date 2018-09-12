<?php

/*
 * Archivo utilizado para crear una BD Demo
 */
 
 
 
 //se reciben las variables

	$identificacion 			= $_POST['identificacion_titular'];
	$nombre 					= $_POST['nombre_titular'];
	$nombrePersonaContacto 		= $_POST['personaContacto_titular'];
	$direccion 					= $_POST['direccion_titular'];
	$telefono1 					= $_POST['telefono1_titular'];
	$telefono2 					= $_POST['telefono2_titular'];
	$celular 					= $_POST['celular_titular'];
	$email 						= $_POST['email_titular'];
	$nombrePais 				= $_POST['pais_titular'];
	$nombreCiudad 				= $_POST['ciudad_titular'];
	$idioma						= $_POST['idioma'];
	$cantidadLicencias			= 2;
	
	
	//se limpian las cadenas de caracteres especiales
	$identificacion		= preg_replace('([^A-Za-z0-9])', '', $identificacion); 
	$nombre				= preg_replace('([^A-Za-z0-9])', '', $nombre);
	
	
 //se incorpora el archivo de configuracion
 require_once ("../../Config/config.php");
 //se incorpora el modelo encargado de registrar los datos en la BD
 require_once ("../../Models/index_model.php");
 
 
 //se instancian el objeto del modelo
 $objetoIndex = new index();	

	$ultimoIdCliente = $objetoIndex->ingresarUsuarioListadoNV($identificacion, $nombre, $nombrePersonaContacto, $direccion, $telefono1, $telefono2, $celular, $email,
									 $nombrePais, $nombreCiudad, $cantidadLicencias, 'Si');
									 
	$ultimoIdCliente = $ultimoIdCliente['idListadoClienteNV'];


	//se cuenta 15 dias apartir de la fecha
	$fecha = date('Y-m-d');
	$fechaFin = strtotime ( '+15 days' , strtotime ( $fecha ) ) ;
	$fechaFin = date ( 'Y-m-d' , $fechaFin );
	
	
	
	//se registran las licencias
	$objetoIndex->ingresarLicenciaCliente($fechaFin, 'Demo', $ultimoIdCliente);
	$objetoIndex->ingresarLicenciaCliente($fechaFin, 'Demo', $ultimoIdCliente);


			//se procede a crear la nueva base de datos
			
			//se arma el nombre de la base de datos			
			
			
			//se extraen los cuatro últimos digitos de la identificación			
			$digitos	= str_split($identificacion);

			$cantidad = sizeof($digitos);

			$uno 	= $digitos[$cantidad-4];
			$dos 	= $digitos[$cantidad-3];
			$tres 	= $digitos[$cantidad-2];
			$cuatro = $digitos[$cantidad-1];

			$cuatroUltimosDigitos = $uno.$dos.$tres.$cuatro;
			
			//se extraen los dos primeros caracteres del nombre
			$dosDigitosNom	= str_split($nombre, 2);	
			
			//se toma la fecha actual sin guiones
			$fecha = date('Y-m-d');
			$fecha = str_replace("-", "", $fecha);		
			
			
			$nombreBD	= "db_".$ultimoIdCliente."_".$dosDigitosNom[0]."_".$cuatroUltimosDigitos."_".$fecha."_DEMO";
			
			//actualizar el registro en los listados de clientes NV para adicionar los datos y nombre de la base de datos
			$objetoIndex->actualizarUsuarioListadoNV('localhost', 'root', '3104588379Chessmaster1Quiana', $nombreBD, $ultimoIdCliente);
			
			
			 //se incorpora el archivo de configuracion
 			require_once ("../../Config/CrearDB.php");
			//se intancia el objeto con los datos para crear la BD
			$objetocrearBD = new crearBD('localhost', 'root', '3104588379Chessmaster1Quiana', $nombreBD);
			
			//se llama al metodo que crea la base de datos
			$objetocrearBD->crearBDCLiente();
			//se generan los insert 
			$objetocrearBD->insertPais();
			$objetocrearBD->encabezadoTutoriales();
			$objetocrearBD->insertEspecies();
			$objetocrearBD->insertRazas();
			$objetocrearBD->insertIdiomas();
			$objetocrearBD->ingresarPermisos();
			$objetocrearBD->ingresarPrimerosPaneles();
			
			//se ingresa el registro de la clinica
			$objetocrearBD->insertClinica($identificacion, $nombre, $telefono1, $telefono2, $celular, $direccion, $email);
			
			//se procede a ingresar el primer usuario
			//se crea la contraseña
			$passGenerada = $dosDigitosNom[0].$cuatroUltimosDigitos;
			$passMostrarEmail = $passGenerada;
			$passGenerada = password_hash($passGenerada, PASSWORD_DEFAULT);
			
			//se elige la licencia para ser utilizada
			$idLicencia = $objetoIndex->elegirLicenciaDisponible($ultimoIdCliente);
			$idLicencia	= $idLicencia['idLicencia'];
			
			//se ingresa el usuario en la BD			
			$objetocrearBD->ingresarPrimerUsuario($identificacion,$nombre,'',$passGenerada,$telefono1,$celular,$direccion,$email,$idLicencia);
			
			//se actualiza la licencia para que se marque como utilizada
			$objetoIndex->marcarLicenciaComoUtilizada($idLicencia);
			
			//se dan los permisos al primer usuario
			$objetocrearBD->primerosPermisosUsuario();

			//Crear carpeta del cliente y las subcarpetas
			  $ruta = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/";
			  
			  $ruta2 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/adjuntos_pacientes/";
			  $ruta3 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/img_pacientes/";
			  $ruta4 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/img_productos/";
			  $ruta5 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/img_proveedores/";
			  $ruta6 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/img_sucursales/";
			  $ruta7 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/img_usuarios/";
			  $ruta8 = "../../Public/uploads/".$ultimoIdCliente."_".$identificacion."/logoClinica/";
			  
					if(!is_file($ruta)){
						mkdir($ruta,0774, true);
					}
					
					if(!is_file($ruta2)){
						mkdir($ruta2,0774, true);
					}
			  
					if(!is_file($ruta3)){
						mkdir($ruta3,0774, true);
					}
					
					if(!is_file($ruta4)){
						mkdir($ruta4,0774, true);
					}  
					if(!is_file($ruta5)){
						mkdir($ruta5,0774, true);
					}
					
					if(!is_file($ruta6)){
						mkdir($ruta6,0774, true);
					}  
					if(!is_file($ruta7)){
						mkdir($ruta7,0774, true);
					}
					
					if(!is_file($ruta8)){
						mkdir($ruta8,0774, true);
					}	
					
			//finaliza la creacion de las carpetas para uploads

			//se envia el E-mail con la información de ingreso al cliente
			
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
				$subject		= "Ingreso NanuVet";
				$genial			= "Genial, tu cuenta demo por 15 días esta lista!";
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
							
														<h4 class="secondary"><strong><singleline label="Title">'.$titleLogin.'</singleline></strong></h4>
														<multiline label="Description"> <p>'.$paraIngresarLogin.'</p>
												                                                                                                
												                                                                                                <p><b><span style="font-size: 14px;">'.$ingresarIdentificacionTitular.' '.$identificacion.'</span></b></p>
												                                                                                                <p><b><span style="font-size: 14px;">'.$ingresarSuIdentificacion.' '.$identificacion.'</span></b></p>
												                                                                                                <p><b><span style="font-size: 14px;">'.$ingresarContrasena.' '.$passMostrarEmail.'</span></b></p></multiline>
							
													</td>
												</tr>
												</table>
										
											</td>
										</tr>
										</table>  
										<img border="0" src="../../Public/img/envioEmail/spacer.gif" width="1" height="15" class="divider">
										</layout>
										<layout label="Article, tip or resource">
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td bgcolor="#ef3101" nowrap><img border="0" src="../../Public/img/envioEmail/spacer.gif" width="5" height="1"></td>
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
															
															<td><a href="http://twitter.com/nanuvet"><img border="0" src="../../Public/img/envioEmail/twitter.gif" width="42" height="32" alt="Follow us on Twitter"></a></td>
															<td><a href="http://www.facebook.com/nanuvet/"><img border="0" src="../../Public/img/envioEmail/facebook.gif" width="32" height="32" alt="Visit us on Facebook"></a></td>
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
            $mail­->AddAddress($address, $nombrePersonaContacto);
            if(!$mail­->Send()) {
            //echo "Error al enviar: ";
            error_log('error al enviar email');
            } else {
            //echo "Mensaje enviado!";
            error_log('email enviado');
            }


?>


        <br />
        <br />
        <br />

		<div class="container">
	        
	    
	    
    	    <div class="row">
              <div class="col s12 m12 l12">
                <div class="card-panel">
                	
                	<h2>Tu cuenta demo está lista. Verifica tu E-mail</h2>

                </div>
              </div>
            </div><!-- fin row-->
        
        </div><!-- fin container -->