<?php

/**
 * modelo que permite gestionar los datos de la pagina web
 */
class index extends Config {
	
	
	//metodo que permite almacenar un titular cuando se registra
	public function guardarRegistroNuevoTitular($identificacion, $nombre, $nombrePersonaContacto, $telefono1, $telefono2, $celular,
												$direccion, $email, $nombrePais, $nombreCiudad, $cantidadLicencias, 
												$valorPago, $descripcionVenta, $referenciaVenta, $vendedor=""){
													
													
			$identificacion 			= parent::escaparQueryBDWeb($identificacion);
			$nombre						= parent::escaparQueryBDWeb($nombre);
			$nombrePersonaContacto 		= parent::escaparQueryBDWeb($nombrePersonaContacto);
			$telefono1 					= parent::escaparQueryBDWeb($telefono1);
			$telefono2 					= parent::escaparQueryBDWeb($telefono2);
			$celular					= parent::escaparQueryBDWeb($celular);
			$direccion 					= parent::escaparQueryBDWeb($direccion);
			$email 						= parent::escaparQueryBDWeb($email);
			$nombrePais 				= parent::escaparQueryBDWeb($nombrePais);
			$nombreCiudad 				= parent::escaparQueryBDWeb($nombreCiudad);
			$referenciaVenta			= parent::escaparQueryBDWeb($referenciaVenta);
			$vendedor					= parent::escaparQueryBDWeb($vendedor);
			
			$query	= "INSERT INTO tb_registrosClientes(identificacion, nombre, nombrePersonaContacto, telefono1, telefono2, celular,".
						" direccion, email, nombrePais, nombreCiudad, cantidadLicencias, fechaRegistro, horaRegistro, valorPago, ".
						" descripcionVenta, referenciaVenta, vendedor) ".
					  " VALUES ".
					  " ('$identificacion', '$nombre', '$nombrePersonaContacto', '$telefono1', '$telefono2', '$celular', '$direccion', '$email', '$nombrePais', ".
					  " '$nombreCiudad', '$cantidadLicencias', NOW(), NOW(), '$valorPago', '$descripcionVenta', '$referenciaVenta', '$vendedor' )";
			
			
			$conexion = parent::conexionWeb();
			
			if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
		
	}//fin metodo guardarRegistroNuevoTitular
	
	//metodo para almacenar la respuesta que devulve Payu
	public function guardarRespuestaPayu($merchantId,$transactionState,$risk,$polResponseCode,$referenceCode,$reference_pol,$signature,$polPaymentMethod,$installmentsNumber,
					$TX_VALUE,$TX_TAX,$buyerEmail,$processingDate,$currency,$cus,$pseBank,$lng,$description,$lapResponseCode,$lapPaymentMethod,$lapPaymentMethodType,
					$lapTransactionState,$message,$extra1,$extra2,$extra3,$authorizationCode,$merchant_address,$merchant_name,$merchant_url,$orderLanguage,$pseCycle,
					$pseReference1,$pseReference2,$pseReference3,$telephone,$transactionId,$trazabilityCode,$TX_ADMINISTRATIVE_FEE,$TX_TAX_ADMINISTRATIVE_FEE,$TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE,
					$action_code_description,$cc_holder,$cc_number,$processing_date_time,$request_number){
						
						
		
		$resultado = "";
		
		$merchantId									=	parent::escaparQueryBDWeb($merchantId);
		$transactionState							=	parent::escaparQueryBDWeb($transactionState);
		$risk										=	parent::escaparQueryBDWeb($risk);
		$polResponseCode							=	parent::escaparQueryBDWeb($polResponseCode);
		$referenceCode								=	parent::escaparQueryBDWeb($referenceCode);
		$reference_pol								=	parent::escaparQueryBDWeb($reference_pol);
		$signature									=	parent::escaparQueryBDWeb($signature);
		$polPaymentMethod							=	parent::escaparQueryBDWeb($polPaymentMethod);
		$installmentsNumber							=	parent::escaparQueryBDWeb($installmentsNumber);
		$TX_VALUE									=	parent::escaparQueryBDWeb($TX_VALUE);
		$TX_TAX										=	parent::escaparQueryBDWeb($TX_TAX);
		$buyerEmail									=	parent::escaparQueryBDWeb($buyerEmail);
		$processingDate								=	parent::escaparQueryBDWeb($processingDate);
		$currency									=	parent::escaparQueryBDWeb($currency);
		$cus										=	parent::escaparQueryBDWeb($cus);
		$pseBank									=	parent::escaparQueryBDWeb($pseBank);
		$lng										=	parent::escaparQueryBDWeb($lng);
		$description								=	parent::escaparQueryBDWeb($description);
		$lapResponseCode							=	parent::escaparQueryBDWeb($lapResponseCode);
		$lapPaymentMethod							=	parent::escaparQueryBDWeb($lapPaymentMethod);
		$lapPaymentMethodType						=	parent::escaparQueryBDWeb($lapPaymentMethodType);
		$lapTransactionState						=	parent::escaparQueryBDWeb($lapTransactionState);
		$message									=	parent::escaparQueryBDWeb($message);
		$extra1										=	parent::escaparQueryBDWeb($extra1);
		$extra2										=	parent::escaparQueryBDWeb($extra2);
		$extra3										=	parent::escaparQueryBDWeb($extra3);
		$authorizationCode							=	parent::escaparQueryBDWeb($authorizationCode);
		$merchant_address							=	parent::escaparQueryBDWeb($merchant_address);
		$merchant_name								=	parent::escaparQueryBDWeb($merchant_name);
		$merchant_url								=	parent::escaparQueryBDWeb($merchant_url);
		$orderLanguage								=	parent::escaparQueryBDWeb($orderLanguage);
		$pseCycle									=	parent::escaparQueryBDWeb($pseCycle);
		$pseReference1								=	parent::escaparQueryBDWeb($pseReference1);
		$pseReference2								=	parent::escaparQueryBDWeb($pseReference2);
		$pseReference3								=	parent::escaparQueryBDWeb($pseReference3);
		$telephone									=	parent::escaparQueryBDWeb($telephone);
		$transactionId								=	parent::escaparQueryBDWeb($transactionId);
		$trazabilityCode							=	parent::escaparQueryBDWeb($trazabilityCode);
		$TX_ADMINISTRATIVE_FEE						=	parent::escaparQueryBDWeb($TX_ADMINISTRATIVE_FEE);
		$TX_TAX_ADMINISTRATIVE_FEE					=	parent::escaparQueryBDWeb($TX_TAX_ADMINISTRATIVE_FEE);
		$TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE		=	parent::escaparQueryBDWeb($TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE);
		$action_code_description					=	parent::escaparQueryBDWeb($action_code_description);
		$cc_holder									=	parent::escaparQueryBDWeb($cc_holder);
		$cc_number									=	parent::escaparQueryBDWeb($cc_number);
		$processing_date_time						=	parent::escaparQueryBDWeb($processing_date_time);
		$request_number								=	parent::escaparQueryBDWeb($request_number);
		
		
		
		$query = "INSERT INTO tb_respuestaPagos
					(merchantId,transactionState,risk,polResponseCode,referenceCode,reference_pol,signature,polPaymentMethod,installmentsNumber,
					TX_VALUE,TX_TAX,buyerEmail,processingDate,currency,cus,pseBank,lng,description,lapResponseCode,lapPaymentMethod,lapPaymentMethodType,
					lapTransactionState,message,extra1,extra2,extra3,authorizationCode,merchant_address,merchant_name,merchant_url,orderLanguage,pseCycle,
					pseReference1,pseReference2,pseReference3,telephone,transactionId,trazabilityCode,TX_ADMINISTRATIVE_FEE,TX_TAX_ADMINISTRATIVE_FEE,TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE,
					action_code_description,cc_holder,cc_number,processing_date_time,request_number)
				VALUES
					('$merchantId','$transactionState','$risk','$polResponseCode','$referenceCode','$reference_pol','$signature','$polPaymentMethod','$installmentsNumber',
					'$TX_VALUE','$TX_TAX','$buyerEmail','$processingDate','$currency','$cus','$pseBank','$lng','$description','$lapResponseCode','$lapPaymentMethod','$lapPaymentMethodType',
					'$lapTransactionState','$message','$extra1','$extra2','$extra3','$authorizationCode','$merchant_address','$merchant_name','$merchant_url','$orderLanguage','$pseCycle',
					'$pseReference1','$pseReference2','$pseReference3','$telephone','$transactionId','$trazabilityCode','$TX_ADMINISTRATIVE_FEE','$TX_TAX_ADMINISTRATIVE_FEE','$TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE',
					'$action_code_description','$cc_holder','$cc_number','$processing_date_time','$request_number');";
		
		$conexion = parent::conexionWeb();
			
		if($res = $conexion->query($query)){
            
                $resultado = "Ok";
        }

        return $resultado;
		
	} //fin metodo guardarRespuestaPayu
	
	//metodo para almacenar las variables de la confirmación de Payu
	public function guardarConfirmacionPayu($merchant_id,$state_pol,$risk,$response_code_pol,$reference_sale,$reference_pol,$sign,$extra1,$extra2,$payment_method,
										$payment_method_type,$installments_number,$value,$tax,$additional_value,$transaction_date,$currency,$email_buyer,$cus,
										$pse_bank,$test,$description,$billing_address,$shipping_address,$phone,$office_phone,$account_number_ach,$account_type_ach,
										$administrative_fee,$administrative_fee_base,$administrative_fee_tax,$airline_code,$attempts,$authorization_code,$bank_id,$billing_city,
										$billing_country,$commision_pol,$commision_pol_currency,$customer_number,$date,$error_code_bank,$error_message_bank,$exchange_rate,
										$ip,$nickname_buyer,$nickname_seller,$payment_method_id,$payment_request_state,$pseReference1,$pseReference2,$pseReference3,$response_message_pol,
										$shipping_city,$shipping_country,$transaction_bank_id,$transaction_id,$payment_method_name){
				


			$resultado  = "";
			$resultado2 = array();

			$merchant_id  							=	parent::escaparQueryBDWeb($merchant_id);
			$state_pol  							=	parent::escaparQueryBDWeb($state_pol);
			$risk  									=	parent::escaparQueryBDWeb($risk);
			$response_code_pol  					=	parent::escaparQueryBDWeb($response_code_pol);
			$reference_sale  						=	parent::escaparQueryBDWeb($reference_sale);
			$reference_pol  						=	parent::escaparQueryBDWeb($reference_pol);
			$sign  									=	parent::escaparQueryBDWeb($sign);
			$extra1  								=	parent::escaparQueryBDWeb($extra1);
			$extra2  								=	parent::escaparQueryBDWeb($extra2);
			$payment_method  						=	parent::escaparQueryBDWeb($payment_method);
			$payment_method_type  					=	parent::escaparQueryBDWeb($payment_method_type);
			$installments_number  					=	parent::escaparQueryBDWeb($installments_number);
			$value  								=	parent::escaparQueryBDWeb($value);
			$tax  									=	parent::escaparQueryBDWeb($tax);
			$additional_value  						=	parent::escaparQueryBDWeb($additional_value);
			$transaction_date  						=	parent::escaparQueryBDWeb($transaction_date);
			$currency  								=	parent::escaparQueryBDWeb($currency);
			$email_buyer  							=	parent::escaparQueryBDWeb($email_buyer);
			$cus  									=	parent::escaparQueryBDWeb($cus);
			$pse_bank  								=	parent::escaparQueryBDWeb($pse_bank);
			$test  									=	parent::escaparQueryBDWeb($test);
			$description  							=	parent::escaparQueryBDWeb($description);
			$billing_address  						=	parent::escaparQueryBDWeb($billing_address);
			$shipping_address  						=	parent::escaparQueryBDWeb($shipping_address);
			$phone  								=	parent::escaparQueryBDWeb($phone);
			$office_phone  							=	parent::escaparQueryBDWeb($office_phone);
			$account_number_ach  					=	parent::escaparQueryBDWeb($account_number_ach);
			$account_type_ach  						=	parent::escaparQueryBDWeb($account_type_ach);
			$administrative_fee  					=	parent::escaparQueryBDWeb($administrative_fee);
			$administrative_fee_base  				=	parent::escaparQueryBDWeb($administrative_fee_base);
			$administrative_fee_tax  				=	parent::escaparQueryBDWeb($administrative_fee_tax);
			$airline_code  							=	parent::escaparQueryBDWeb($airline_code);
			$attempts  								=	parent::escaparQueryBDWeb($attempts);
			$authorization_code  					=	parent::escaparQueryBDWeb($authorization_code);
			$bank_id  								=	parent::escaparQueryBDWeb($bank_id);
			$billing_city  							=	parent::escaparQueryBDWeb($billing_city);
			$billing_country  						=	parent::escaparQueryBDWeb($billing_country);
			$commision_pol  						=	parent::escaparQueryBDWeb($commision_pol);
			$commision_pol_currency  				=	parent::escaparQueryBDWeb($commision_pol_currency);
			$customer_number  						=	parent::escaparQueryBDWeb($customer_number);
			$date  									=	parent::escaparQueryBDWeb($date);
			$error_code_bank  						=	parent::escaparQueryBDWeb($error_code_bank);
			$error_message_bank  					=	parent::escaparQueryBDWeb($error_message_bank);
			$exchange_rate  						=	parent::escaparQueryBDWeb($exchange_rate);
			$ip  									=	parent::escaparQueryBDWeb($ip);
			$nickname_buyer  						=	parent::escaparQueryBDWeb($nickname_buyer);
			$nickname_seller  						=	parent::escaparQueryBDWeb($nickname_seller);
			$payment_method_id  					=	parent::escaparQueryBDWeb($payment_method_id);
			$payment_request_state  				=	parent::escaparQueryBDWeb($payment_request_state);
			$pseReference1  						=	parent::escaparQueryBDWeb($pseReference1);
			$pseReference2  						=	parent::escaparQueryBDWeb($pseReference2);
			$pseReference3  						=	parent::escaparQueryBDWeb($pseReference3);
			$response_message_pol  					=	parent::escaparQueryBDWeb($response_message_pol);
			$shipping_city  						=	parent::escaparQueryBDWeb($shipping_city);
			$shipping_country  						=	parent::escaparQueryBDWeb($shipping_country);
			$transaction_bank_id  					=	parent::escaparQueryBDWeb($transaction_bank_id);
			$transaction_id  						=	parent::escaparQueryBDWeb($transaction_id);
			$payment_method_name  					=	parent::escaparQueryBDWeb($payment_method_name);

			$query = "INSERT INTO tb_confirmacion
						(merchant_id,state_pol,risk,response_code_pol,reference_sale,reference_pol,sign,extra1,extra2,payment_method,
						payment_method_type,installments_number,value,tax,additional_value,transaction_date,currency,email_buyer,cus,
						pse_bank,test,description,billing_address,shipping_address,phone,office_phone,account_number_ach,account_type_ach,
						administrative_fee,administrative_fee_base,administrative_fee_tax,airline_code,attempts,authorization_code,bank_id,billing_city,
						billing_country,commision_pol,commision_pol_currency,customer_number,date,error_code_bank,error_message_bank,exchange_rate,
						ip,nickname_buyer,nickname_seller,payment_method_id,payment_request_state,pseReference1,pseReference2,pseReference3,response_message_pol,
						shipping_city,shipping_country,transaction_bank_id,transaction_id,payment_method_name)
					VALUES
						('$merchant_id','$state_pol','$risk','$response_code_pol','$reference_sale','$reference_pol','$sign','$extra1','$extra2','$payment_method',
						'$payment_method_type','$installments_number','$value','$tax','$additional_value','$transaction_date','$currency','$email_buyer','$cus',
						'$pse_bank','$test','$description','$billing_address','$shipping_address','$phone','$office_phone','$account_number_ach','$account_type_ach',
						'$administrative_fee','$administrative_fee_base','$administrative_fee_tax','$airline_code','$attempts','$authorization_code','$bank_id','$billing_city',
						'$billing_country','$commision_pol','$commision_pol_currency','$customer_number','$date','$error_code_bank','$error_message_bank','$exchange_rate',
						'$ip','$nickname_buyer','$nickname_seller','$payment_method_id','$payment_request_state','$pseReference1','$pseReference2','$pseReference3','$response_message_pol',
						'$shipping_city','$shipping_country','$transaction_bank_id','$transaction_id','$payment_method_name');";

			
			$conexion = parent::conexionWeb();
				
			if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
			$query2 = "SELECT MAX(idConfirmacion) as idConfirmacion FROM tb_confirmacion";
				
			if($res = $conexion->query($query2)){
	            
	               /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado2 = $filas;
                    }
	        }


	        return $resultado2;

		
	}//fin metodo guardarConfirmacionPayu
	
	//metodo para actualizar el registro de confirmación, indicando si las firmas coinciden o no
	public function actualizarConfirmacionPayuFirmas($mensajeFirmas, $idConfirmacion){
		
		$query = "UPDATE tb_confirmacion SET resultadoFirmas = '$mensajeFirmas' WHERE idConfirmacion = '$idConfirmacion' ";
		
		$conexion = parent::conexionWeb();
		
		$res = $conexion->query($query);
		
	}//fin metodo actualizarConfirmacionPayuFirmas

	
	//metodo para actualizar el registro de resultado de la confirmación
	public function actualizarConfirmacionPayuResultado($mensaje, $idConfirmacion){
		
		$query = "UPDATE tb_confirmacion SET resultadoTransaccion = '$mensaje' WHERE idConfirmacion = '$idConfirmacion' ";
		
		$conexion = parent::conexionWeb();
		
		$res = $conexion->query($query);
		
	}//fin metodo actualizarConfirmacionPayuFirmas	
		
		
	//metodo para consultar los datos de un usuario para pasarlos a la BD de clientes de NV
	public function consultarDatosUsuarioParaListadoNV($referenciaVenta){
		
		$pseReference3  	=	parent::escaparQueryBDWeb($referenciaVenta);
		
		$resultado = array();
		
		$query = "SELECT identificacion,nombre,nombrePersonaContacto,telefono1,telefono2,celular,direccion,email,nombrePais,nombreCiudad,
					cantidadLicencias, vendedor
				  FROM tb_registrosClientes 
				  WHERE  referenciaVenta = '$referenciaVenta' ";
		
		$conexion = parent::conexionWeb();
				
		if($res = $conexion->query($query)){
            
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
        }


        return $resultado;
		
		
	}//fin metodo consultarDatosUsuarioParaListadoNV
	
	
	
	//metodo para ingresar el usuario al alistado de clientes NV
	public function ingresarUsuarioListadoNV($identificacion,$nombre,$nombrePersonaContacto,$direccion,$telefono1,$telefono2,$celular,$email,
											 $nombrePais,$nombreCiudad,$cantidadLicencias, $vendedor, $demo = 'No'){
			
		$identificacion  			=	parent::escaparQueryBDAdmin($identificacion);	
		$nombre  					=	parent::escaparQueryBDAdmin($nombre);	
		$nombrePersonaContacto  	=	parent::escaparQueryBDAdmin($nombrePersonaContacto);	
		$direccion  				=	parent::escaparQueryBDAdmin($direccion);	
		$telefono1  				=	parent::escaparQueryBDAdmin($telefono1);	
		$telefono2  				=	parent::escaparQueryBDAdmin($telefono2);	
		$celular  					=	parent::escaparQueryBDAdmin($celular);	
		$email  					=	parent::escaparQueryBDAdmin($email);	
		$nombrePais  				=	parent::escaparQueryBDAdmin($nombrePais);	
		$nombreCiudad  				=	parent::escaparQueryBDAdmin($nombreCiudad);	
		$cantidadLicencias  		=	parent::escaparQueryBDAdmin($cantidadLicencias);	
		$demo  						=	parent::escaparQueryBDAdmin($demo);	
		$vendedor  					=	parent::escaparQueryBDAdmin($vendedor);	
			
		
		$resultado2 = array();
		
		$query = "INSERT INTO tb_listadoClienteNV
					(identificacion,nombre,nombrePersonaContacto,direccion,telefono1,telefono2,celular,email,nombrePais,nombreCiudad,cantidadLicencias,
					fechaInicio,estado, demo, vendedor)
				  VALUES
					('$identificacion','$nombre','$nombrePersonaContacto','$direccion','$telefono1','$telefono2','$celular','$email',
											 '$nombrePais','$nombreCiudad','$cantidadLicencias',NOW(),'A', '$demo', '$vendedor')";
		
		error_log("para Log query nuevo cliente: ".$query);
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);
		
		
		$query2 = "SELECT MAX(idListadoClienteNV) as idListadoClienteNV FROM tb_listadoClienteNV";
			
		if($res = $conexion->query($query2)){
            
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado2 = $filas;
                }
        }


        return $resultado2;
		
	}//fin metodo ingresarUsuarioListadoNV
	
	
	//metodo para registrar licencias de un cliente
	public function ingresarLicenciaCliente($fechaFin, $observacion, $idListadoClienteNV){
		
		$query = "INSERT INTO tb_licencias
					(fechaAdquisicion,fechaInicio,fechaFin,observacion,estado,idListadoClienteNV)
				  VALUES
					(NOW(), NOW(), '$fechaFin', '$observacion', 'Disponible', '$idListadoClienteNV');";
		
		error_log("para Log query nuevas licencias: ".$query);
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);
		
	}//fin metodo ingresarLicenciaCliente
	
	
	//metodo para actualizar los datos del registro de clientes NV para adicionar el nombre de base de datos y lo referente al servidos
	public function actualizarUsuarioListadoNV($ubicacionBD, $usuario_BD, $pass_BD, $nombre_BD, $idListadoClienteNV){
		
		$query = "UPDATE tb_listadoClienteNV SET 
					ubicacion_BD = '$ubicacionBD', usuario_BD = '$usuario_BD', pass_BD = '$pass_BD', nombre_BD = '$nombre_BD' 
				  WHERE idListadoClienteNV = '$idListadoClienteNV' ";
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);
		
		
	}//fin metodo 
	
	//metodo para elegir la licencia que se va a consumir con el usuario
	public function elegirLicenciaDisponible($idCliente){
			
		$resultado = array();
		
		$query = "SELECT idLicencia from tb_licencias 
					WHERE idListadoClienteNV = '$idCliente' AND estado = 'Disponible' LIMIT 1; ";	
		
		$conexion = parent::conexionAdmin();
		
		if($res = $conexion->query($query)){
            
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
        }
		
		return $resultado;
		
		
	}//fin metodo elegirLicenciaDisponible
	
	
	//metodo que marca la licencia como utilizada
	public function marcarLicenciaComoUtilizada($idLicencia){
					
		$query = "UPDATE tb_licencias SET 
					estado = 'EnUso'
				  WHERE idLicencia = '$idLicencia' ";
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);		
			
		
	}//fin metodo marcarLicenciaComoUtilizada
	
	
	//metodo para sumarle licencias a un cliente
	public function sumarLicenciasCliente($idTitular, $stringPor0lic){
		
		$query = "UPDATE tb_listadoClienteNV SET 
			cantidadLicencias = cantidadLicencias+'$stringPor0lic'
		  WHERE idListadoClienteNV = '$idTitular' ";
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);	
		
		
	}//fin metodo sumarLicenciasCliente
	
	
	//metodo para registrar la solicitud de una contraseña
	public function registrarPedidoContrasena($titular, $identificacion, $email, $token){
		
		$titular  			=	parent::escaparQueryBDAdmin($titular);
		$identificacion  	=	parent::escaparQueryBDAdmin($identificacion);
		$email  			=	parent::escaparQueryBDAdmin($email);
		$token  			=	parent::escaparQueryBDAdmin($token);
		
		$conexion = parent::conexionAdmin();
		
		$ubicacion 		= "";
		$usuario		= "";
		$pass			= "";
		$nombre			= "";
		
		$idUsuarioEncontrado 	= "";
		$emailUsuarioEncontrado = "";
		
		$query = "SELECT ubicacion_BD, usuario_BD, pass_BD, nombre_BD 
					FROM tb_listadoClienteNV
					WHERE identificacion = '$titular'";
					

					
		if($res = $conexion->query($query)){
            
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                	
                    $ubicacion 	= $filas['ubicacion_BD'];
                    $usuario 	= $filas['usuario_BD'];
					$pass 		= $filas['pass_BD'];
					$nombre 	= $filas['nombre_BD'];
					
                }//fin while
                
        }//fin if
        
        //si encontro el titular
        if($ubicacion != "" AND $usuario != "" AND $pass != "" AND $nombre != ""){
        	
			
				$conexionCliente = parent::conexionCliente($nombre, $ubicacion, $usuario, $pass);
				
				$query2 = "SELECT idUsuario, email FROM tb_usuarios WHERE identificacion = '$identificacion'";
				
						
				if($res2 = $conexionCliente->query($query2)){
		            
		               /* obtener un array asociativo */
		                while ($filas2 = $res2->fetch_assoc()) {
		                	
		                    $idUsuarioEncontrado 		= $filas2['idUsuario'];
		                    $emailUsuarioEncontrado 	= $filas2['email'];
		                    
		                }//fin while
		                
		        }//fin if
		        
		        if($idUsuarioEncontrado != "" AND $emailUsuarioEncontrado != ""){
		        	
					if($emailUsuarioEncontrado == $email){
						
						$query3 = "INSERT INTO tb_recuperarPass 
							(titular, identificacionIngresada, correoIngresado, idUsuarioEncontrado, correoUsuarioEncontrado, token, estado, fechaSolicitud)
							VALUES 
							('$titular', '$identificacion', '$email', '$idUsuarioEncontrado', '$emailUsuarioEncontrado', '$token', 'A', NOW())";
							
					
				
						$res = $conexion->query($query3);
						
					}else{
								
						return "email no coincide";	
						
					}
									
					
		        }else{
		        	
					return "error";
					
		        }//fin else si encontro algo usuario
				
				

			
        }else{//sino se encuentra el titular se devuelve error
        	return "Error";
        }//fin else si se encontro el titular
        
       return "ok";
		
		
	}//fin registrarPedidoContrasena
	
	
	//metodo para verificar si un token de cambio de contraseña es valido
	public function verificarTokenCambioPass($token){
		
		$resultado = array();
		
		$token  			=	parent::escaparQueryBDAdmin($token);
		
		$conexion = parent::conexionAdmin();	
		
		$query = "SELECT idRecuperarPass, titular, identificacionIngresada, fechaSolicitud, idUsuarioEncontrado 
					FROM tb_recuperarPass 
					WHERE token = '$token' AND fechaSolicitud >= date_add(NOW(), INTERVAL -2 DAY) AND estado = 'A'";	//para que el link no pase de dos dias
					
		if($res = $conexion->query($query)){
		            
		               /* obtener un array asociativo */
		                while ($filas = $res->fetch_assoc()) {
		                	
		                    $resultado = $filas;
		                    
		                }//fin while
		                
		 }//fin if
		 
		 return $resultado;
		
	}//fin metodo verificarTokenCambioPass
	
	
	
	//metodo para cambiar la contraseña de un usuario que la restablecio
	public function cambiarPassUsuario($titular, $idUsuario, $passCambiada){
		
		$titular  				=	parent::escaparQueryBDAdmin($titular);
		$idUsuario  			=	parent::escaparQueryBDAdmin($idUsuario);
		$passCambiada  			=	parent::escaparQueryBDAdmin($passCambiada);
		
		$conexion = parent::conexionAdmin();
		
		$ubicacion 		= "";
		$usuario		= "";
		$pass			= "";
		$nombre			= "";
		
		$query = "SELECT ubicacion_BD, usuario_BD, pass_BD, nombre_BD 
					FROM tb_listadoClienteNV
					WHERE identificacion = '$titular'";
					

					
		if($res = $conexion->query($query)){
            
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                	
                    $ubicacion 	= $filas['ubicacion_BD'];
                    $usuario 	= $filas['usuario_BD'];
					$pass 		= $filas['pass_BD'];
					$nombre 	= $filas['nombre_BD'];
					
                }//fin while
                
        }//fin if
        
        
        if($ubicacion != "" AND $usuario != "" AND $pass != "" AND $nombre != ""){
        	
			
				$conexionCliente = parent::conexionCliente($nombre, $ubicacion, $usuario, $pass);
				
				$resultado = "OK";
		
				$query2 = "UPDATE tb_usuarios  SET pass = '$passCambiada' WHERE idUsuario = '$idUsuario' ";
				
		    		
		        $res2 = $conexionCliente->query($query2);
		
		        return $resultado;
		        
		}
        
		
	}//fin metodo cambiarPassUsuario
	
	
	//funcion para desactivar el token de cambio pass
	public function desactivarTokenPass($token){
		
		$token  			=	parent::escaparQueryBDAdmin($token);
		
		$query = "UPDATE tb_recuperarPass SET estado = 'Usado'
					where token = '$token'";
					
		$conexion = parent::conexionAdmin();
		
		$conexion->query($query);
		
	}//fin metodo desactivarTokenPass
	
	
	//metodo para guardar un mensaje d eun usuario desde contactenos
	public function guardarMensajeContactenos($nombre, $email, $texto){
		
		$nombre  			=	parent::escaparQueryBDWeb($nombre);
		$email  			=	parent::escaparQueryBDWeb($email);
		$texto  			=	parent::escaparQueryBDWeb($texto);
		
		
		$query = "INSERT INTO tb_mensajesContactenos (nombrePersona, email, mensaje, fechaHora, estado) 
					VALUES ('$nombre', '$email', '$texto', NOW(), 'Registrado')";
					
		$conexion = parent::conexionWeb();
		
		$conexion->query($query);
		
	}//fin metodo 

}//fin clase
