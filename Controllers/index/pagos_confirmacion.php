<?php
	/*
	 * Esta es la pagina de confirmación, para saber cuando un pago ha sido exitoso
	 */
	 
	 //se reciben las variables que llegan por el metodo post
	 
	$merchant_id						= $_POST['merchant_id'];
	$state_pol							= $_POST['state_pol'];
	$risk								= $_POST['risk'];
	$response_code_pol					= $_POST['response_code_pol'];
	$reference_sale						= $_POST['reference_sale'];
	$reference_pol						= $_POST['reference_pol'];
	$sign								= $_POST['sign'];
	$extra1								= $_POST['extra1'];
	$extra2								= $_POST['extra2'];
	$payment_method						= $_POST['payment_method'];
	$payment_method_type				= $_POST['payment_method_type'];
	$installments_number				= $_POST['installments_number'];
	$value								= $_POST['value'];
	$tax								= $_POST['tax'];
	$additional_value					= $_POST['additional_value'];
	$transaction_date					= $_POST['transaction_date'];
	$currency							= $_POST['currency'];
	$email_buyer						= $_POST['email_buyer'];
	$cus								= $_POST['cus'];
	$pse_bank							= $_POST['pse_bank'];
	$test								= $_POST['test'];
	$description						= $_POST['description'];
	$billing_address					= $_POST['billing_address'];
	$shipping_address					= $_POST['shipping_address'];
	$phone								= $_POST['phone'];
	$office_phone						= $_POST['office_phone'];
	$account_number_ach					= $_POST['account_number_ach'];
	$account_type_ach					= $_POST['account_type_ach'];
	$administrative_fee					= $_POST['administrative_fee'];
	$administrative_fee_base			= $_POST['administrative_fee_base'];
	$administrative_fee_tax				= $_POST['administrative_fee_tax'];
	$airline_code						= $_POST['airline_code'];
	$attempts							= $_POST['attempts'];
	$authorization_code					= $_POST['authorization_code'];
	$bank_id							= $_POST['bank_id'];
	$billing_city						= $_POST['billing_city'];
	$billing_country					= $_POST['billing_country'];
	$commision_pol						= $_POST['commision_pol'];
	$commision_pol_currency				= $_POST['commision_pol_currency'];
	$customer_number					= $_POST['customer_number'];
	$date								= $_POST['date'];
	$error_code_bank					= $_POST['error_code_bank'];
	$error_message_bank					= $_POST['error_message_bank'];
	$exchange_rate						= $_POST['exchange_rate'];
	$ip									= $_POST['ip'];
	$nickname_buyer						= $_POST['nickname_buyer'];
	$nickname_seller					= $_POST['nickname_seller'];
	$payment_method_id					= $_POST['payment_method_id'];
	$payment_request_state				= $_POST['payment_request_state'];
	$pseReference1						= $_POST['pseReference1'];
	$pseReference2						= $_POST['pseReference2'];
	$pseReference3						= $_POST['pseReference3'];
	$response_message_pol				= $_POST['response_message_pol'];
	$shipping_city						= $_POST['shipping_city'];
	$shipping_country					= $_POST['shipping_country'];
	$transaction_bank_id				= $_POST['transaction_bank_id'];
	$transaction_id						= $_POST['transaction_id'];
	$payment_method_name				= $_POST['payment_method_name'];	
	
	
	 
	
 //se incorpora el archivo de configuracion
 require_once ("../../Config/config.php");
 //se incorpora el modelo encargado de registrar los datos en la BD
 require_once ("../../Models/index_model.php");
 
 
 //se instancian el objeto del modelo
 $objetoIndex = new index();
 
 //se llama al metodo para que almacene los datos de la confirmación
 $ultimoIdIngresadoConfirmacion = $objetoIndex->guardarConfirmacionPayu($merchant_id,$state_pol,$risk,$response_code_pol,$reference_sale,$reference_pol,$sign,$extra1,$extra2,$payment_method,
										$payment_method_type,$installments_number,$value,$tax,$additional_value,$transaction_date,$currency,$email_buyer,$cus,
										$pse_bank,$test,$description,$billing_address,$shipping_address,$phone,$office_phone,$account_number_ach,$account_type_ach,
										$administrative_fee,$administrative_fee_base,$administrative_fee_tax,$airline_code,$attempts,$authorization_code,$bank_id,$billing_city,
										$billing_country,$commision_pol,$commision_pol_currency,$customer_number,$date,$error_code_bank,$error_message_bank,$exchange_rate,
										$ip,$nickname_buyer,$nickname_seller,$payment_method_id,$payment_request_state,$pseReference1,$pseReference2,$pseReference3,$response_message_pol,
										$shipping_city,$shipping_country,$transaction_bank_id,$transaction_id,$payment_method_name);
										
 $ultimoIdIngresadoConfirmacion = $ultimoIdIngresadoConfirmacion['idConfirmacion'];	
										
 //$firmaParaComparar =  "4Vj8eK4rloUd272L48hsrarnUA~".$merchant_id."~".$reference_sale."~".$value."~COP";//produccion
 $firmaParaComparar =  "4Vj8eK4rloUd272L48hsrarnUA~".$merchant_id."~".$reference_sale."~".$value."~COP";//pruebas
 $firmaParaComparar =  sha1($firmaParaComparar);
 
 //verificar que las firmas coinsidan
 if($firmaParaComparar == $sign){
 	
	//Se actualiza el registro indicando que las firmas coinciden
	$objetoIndex->actualizarConfirmacionPayuFirmas("Coinciden", $ultimoIdIngresadoConfirmacion);
	
 }else{
 	
	//Se actualiza el registro indicando que las NO firmas coinciden
 	$objetoIndex->actualizarConfirmacionPayuFirmas("No coinciden", $ultimoIdIngresadoConfirmacion);
 }
 
 //para conocer el resultado de la transaccion
 
 //transaccion aprobada
 if( ($state_pol == '4' or $state_pol == 4) and ($response_message_pol == 'APPROVED') and ($response_code_pol == '1' or $response_code_pol == 1) ){
 	//se procede a realizar los registros en la BD admin y crear la nueva base de datos
 	$objetoIndex->actualizarConfirmacionPayuResultado("Aprobada", $ultimoIdIngresadoConfirmacion);
	
	//se detecta que se va a realizar según la referencia de venta
	//N=Nueva BD- A= Adicion de licencias- R= renovación de licencia
	$arrayStringReferenciaVenta = str_split($reference_sale);
	
	$idioma	= $arrayStringReferenciaVenta['1'].$arrayStringReferenciaVenta['2'];
	
	switch ($arrayStringReferenciaVenta['0']) {
		
		case 'N':
			
			//se consultan los datos que habia ingresado el usuario mediante la referencia de pago
			$datosUsuario	= $objetoIndex->consultarDatosUsuarioParaListadoNV($reference_sale);
			
			//se envian los datos para ingresarolos al listado de clientes
			$identificacion				= $datosUsuario['identificacion'];
			$nombre						= $datosUsuario['nombre'];
			$nombrePersonaContacto		= $datosUsuario['nombrePersonaContacto'];
			$telefono1					= $datosUsuario['telefono1'];
			$telefono2					= $datosUsuario['telefono2'];
			$celular					= $datosUsuario['celular'];
			$direccion					= $datosUsuario['direccion'];
			$email						= $datosUsuario['email'];
			$nombrePais					= $datosUsuario['nombrePais'];
			$nombreCiudad				= $datosUsuario['nombreCiudad'];
			$cantidadLicencias			= $datosUsuario['cantidadLicencias'];
			$vendedor					= $datosUsuario['vendedor'];
			
			//se limpian las cadenas de caracteres especiales
			$identificacion		= preg_replace('([^A-Za-z0-9])', '', $identificacion); 
			$nombre				= preg_replace('([^A-Za-z0-9])', '', $nombre);
			
			$ultimoIdCliente = $objetoIndex->ingresarUsuarioListadoNV($identificacion,$nombre,$nombrePersonaContacto,$direccion,$telefono1,$telefono2,$celular,$email,
											 $nombrePais,$nombreCiudad,$cantidadLicencias, $vendedor);
											 
			$ultimoIdCliente = $ultimoIdCliente['idListadoClienteNV'];
			
			//se cuenta un año apartir de la fecha
			$fecha = date('Y-m-d');
			$fechaFin = strtotime ( '+1 year' , strtotime ( $fecha ) ) ;
			$fechaFin = date ( 'Y-m-d' , $fechaFin );
			
			//se ingresan tantas licencias como se tengan
			for ($i=0; $i < $cantidadLicencias; $i++) { 
				
				//se registran las licencias
				$objetoIndex->ingresarLicenciaCliente($fechaFin, '', $ultimoIdCliente);
				
			}//fin for
			
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
			
			
			$nombreBD	= "db_".$ultimoIdCliente."_".$dosDigitosNom[0]."_".$cuatroUltimosDigitos."_".$fecha;
			
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
            $mail­->Username = "softnanuvet@gmail.com";
            $mail­->Password = "Chessmaster1";
            $mail­->SetFrom('softnanuvet@gmail.com', 'info NanuVet');
            $mail­->AddReplyTo("softnanuvet@gmail.com","info NanuVet");
            
			
			
			//variables para determinar el idioma del email
			if($idioma == 'En'){
				//ingles
				$subject		= "Login NanuVet";
				$genial			= "Great, everything is ready!";
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
				$genial			= "Genial, todo esta listo!";
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
													
														<p style="color:#a6a6a6;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:15px;padding-top:0;padding-bottom:0;line-height:18px;" class="reminder">'.$enCasoProblema.' info@nanuvet.com</p>
														
													
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
            echo "Error al enviar: ";
            } else {
            echo "Mensaje enviado!";
            }

			
				
			
		break;

		case 'A'://adicon licenica
			
			
			//para tomar la primera parte del string
			$stringPor0 = explode( '0', $reference_sale );
			
			//para tomar la parte que contiene la cantidad de licencias
			$stringPor0lic  = explode( '0lic', $reference_sale );
			
			$idTitular	= substr($stringPor0[0], 3, 5);
			
			//se cuenta un año apartir de la fecha
			$fecha = date('Y-m-d');
			$fechaFin = strtotime ( '+1 year' , strtotime ( $fecha ) ) ;
			$fechaFin = date ( 'Y-m-d' , $fechaFin );
			
			//se ingresan tantas licencias como se tengan
			for ($i=0; $i < $stringPor0lic[1]; $i++) { 
				
				//se registran las licencias
				$objetoIndex->ingresarLicenciaCliente($fechaFin, '', $idTitular[0]);
				
			}//fin for
			
			//se suman las licencias al cliente
			$objetoIndex->sumarLicenciasCliente($idTitular[0], $stringPor0lic[1]);
			
			
		break;
			
		case 'R'://renovacion licencia
			
		break;
	}
	
	
	
 }//fin transaccion aprobada
 
 //transaccion rechazada
 if( ($state_pol == '6' or $state_pol == 6) ){
 	
	$estadoTransaccion = "Rechazada";
	
	
	if( ($response_message_pol == 'PAYMENT_NETWORK_REJECTED') and ($response_code_pol == '4' or $response_code_pol == 4)  ){
		$mensaje	= "Transacción rechazada por entidad financiera";		
	}//fin if

	if( ($response_message_pol == 'ENTITY_DECLINED') and ($response_code_pol == '5' or $response_code_pol == 5)  ){
		$mensaje	= "Transacción rechazada por el banco";
	}//fin if
		
 	if( ($response_message_pol == 'INSUFFICIENT_FUNDS') and ($response_code_pol == '6' or $response_code_pol == 6)  ){
		$mensaje	= "Fondos insuficientes";
	}//fin if
	
 	if( ($response_message_pol == 'INVALID_CARD') and ($response_code_pol == '7' or $response_code_pol == 7)  ){
		$mensaje	= "Tarjeta inválida";
	}//fin if	
	
 	if( ($response_message_pol == 'CONTACT_THE_ENTITY') and ($response_code_pol == '8' or $response_code_pol == 8)  ){
		$mensaje	= "Contactar entidad financiera";
	}//fin if
	
 	if( ($response_message_pol == 'BANK_ACCOUNT_ACTIVATION_ERROR' or $response_message_pol == 'BANK_ACCOUNT_NOT_AUTHORIZED_FOR_AUTOMATIC_DEBIT' or 
		 $response_message_pol == 'INVALID_AGENCY_BANK_ACCOUNT' or $response_message_pol == 'INVALID_BANK_ACCOUNT' or 
		 $response_message_pol == 'INVALID_BANK' ) and ($response_code_pol == '8' or $response_code_pol == 8)  ){
		 	
		$mensaje	= "Débito automático no permitido";
		
	}//fin if
	
 	if( ($response_message_pol == 'EXPIRED_CARD') and ($response_code_pol == '9' or $response_code_pol == 9)  ){
		$mensaje	= "Tarjeta vencida";
	}//fin if	
	
 	if( ($response_message_pol == 'RESTRICTED_CARD') and ($response_code_pol == '10' or $response_code_pol == 10)  ){
		$mensaje	= "Tarjeta restringida";
	}//fin if		
	
 	if( ($response_message_pol == 'INVALID_EXPIRATION_DATE_OR_SECURITY_CODE') and ($response_code_pol == '12' or $response_code_pol == 12)  ){
		$mensaje	= "Fecha de expiración o código de seguridadinválidos";
	}//fin if	

	if( ($response_message_pol == 'REPEAT_TRANSACTION') and ($response_code_pol == '13' or $response_code_pol == 13)  ){
		$mensaje	= "Reintentar pago";
	}//fin if	
	
	if( ($response_message_pol == 'INVALID_TRANSACTION') and ($response_code_pol == '14' or $response_code_pol == 14)  ){
		$mensaje	= "Transacción inválida";
	}//fin if	
	
	if( ($response_message_pol == 'EXCEEDED_AMOUNT') and ($response_code_pol == '17' or $response_code_pol == 17)  ){
		$mensaje	= "El valor excede el máximo permitido por la entidad";
	}//fin if		
	
	if( ($response_message_pol == 'ABANDONED_TRANSACTION') and ($response_code_pol == '19' or $response_code_pol == 19)  ){
		$mensaje	= "Transacción abandonada por el pagador";
	}//fin if				

	if( ($response_message_pol == 'CREDIT_CARD_NOT_AUTHORIZED_FOR_INTERNET_TRANSACTIONS') and ($response_code_pol == '22' or $response_code_pol == 22)  ){
		$mensaje	= "Tarjeta no autorizada para comprar por internet";
	}//fin if		

	if( ($response_message_pol == 'ANTIFRAUD_REJECTED') and ($response_code_pol == '23' or $response_code_pol == 23)  ){
		$mensaje	= "Transacción rechazada por sospecha de fraude";
	}//fin if		
	
	if( ($response_message_pol == 'DIGITAL_CERTIFICATE_NOT_FOUND') and ($response_code_pol == '9995' or $response_code_pol == 9995)  ){
		$mensaje	= "Certificado digital no encotnrado";
	}//fin if	
	
	if( ($response_message_pol == 'BANK_UNREACHABLE') and ($response_code_pol == '9996' or $response_code_pol == 9996)  ){
		$mensaje	= "Error tratando de comunicarse con el banco";
	}//fin if	

	if( ($response_message_pol == 'PAYMENT_NETWORK_NO_CONNECTION') and ($response_code_pol == '9996' or $response_code_pol == 9996)  ){
		$mensaje	= "No fue posible establecer comunicación con la entidad financiera";
	}//fin if		
	
	if( ($response_message_pol == 'PAYMENT_NETWORK_NO_RESPONSE') and ($response_code_pol == '9996' or $response_code_pol == 9996)  ){
		$mensaje	= "No se recibió respuesta de la entidad financiera";
	}//fin if
	
	if( ($response_message_pol == 'ENTITY_MESSAGING_ERROR') and ($response_code_pol == '9997' or $response_code_pol == 9997)  ){
		$mensaje	= "Error comunicándose con la entidad financiera";
	}//fin if
	
	if( ($response_message_pol == 'NOT_ACCEPTED_TRANSACTION') and ($response_code_pol == '9998' or $response_code_pol == 9998)  ){
		$mensaje	= "Transacción no permitida";
	}//fin if	
	
	if( ($response_message_pol == 'INTERNAL_PAYMENT_PROVIDER_ERROR' or $response_message_pol == 'INACTIVE_PAYMENT_PROVIDER' or 
		 $response_message_pol == 'ERROR' or $response_message_pol == 'ERROR_CONVERTING_TRANSACTION_AMOUNTS' or 
		 $response_message_pol == 'BANK_ACCOUNT_ACTIVATION_ERROR' or $response_message_pol == 'FIX_NOT_REQUIRED' 
		 or $response_message_pol == 'AUTOMATICALLY_FIXED_AND_SUCCESS_REVERSAL' or 
		 $response_message_pol == 'AUTOMATICALLY_FIXED_AND_UNSUCCESS_REVERSAL' or $response_message_pol == 'AUTOMATIC_FIXED_NOT_SUPPORTED' or 
		 $response_message_pol == 'NOT_FIXED_FOR_ERROR_STATE' or $response_message_pol == 'ERROR_FIXING_AND_REVERSING' 
		 or $response_message_pol == 'ERROR_FIXING_INCOMPLETE_DATA' or 
		 $response_message_pol == 'PAYMENT_NETWORK_BAD_RESPONSE'  ) and ($response_code_pol == '9999' or $response_code_pol == 9999)  ){
		 	
		$mensaje	= "Error";
		
	}//fin if	
	
		
	//se actualiza el registro en la base de datos, para ingresar el estado de la transaccion y el mensaje
	$objetoIndex->actualizarConfirmacionPayuResultado($estadoTransaccion.": ".$mensaje, $ultimoIdIngresadoConfirmacion);
	
			
 }//fin transaccion rechazada

 
 //transaccion declinada
 if( ($state_pol == '5' or $state_pol == 5) and ($response_message_pol == 'EXPIRED_TRANSACTION') and ($response_code_pol == '20' or $response_code_pol == 20) ){
 		
 	$mensaje	= "Transacción expirada";
	//se actualiza el registro en la base de datos, para ingresar el estado de la transaccion y el mensaje
	$objetoIndex->actualizarConfirmacionPayuResultado($mensaje, $ultimoIdIngresadoConfirmacion);	 
	 
 }//fin transaccion declinada	
 	
	
?>