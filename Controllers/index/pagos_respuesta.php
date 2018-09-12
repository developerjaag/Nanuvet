<?php

/*
 * Archivo que recibe la respuesta de payu y muestra un mensaje al cliente (aún no se confirma la compra)
 */
 
 //variables que devulve Payu
 
 
 $merchantId								=	$_REQUEST['merchantId'];
 $transactionState							=	$_REQUEST['transactionState'];
 $risk										=	$_REQUEST['risk'];
 $polResponseCode							=	$_REQUEST['polResponseCode'];
 $referenceCode								=	$_REQUEST['referenceCode'];
 $reference_pol								=	$_REQUEST['reference_pol'];
 $signature									=	$_REQUEST['signature'];
 $polPaymentMethod							=	$_REQUEST['polPaymentMethod'];
 $polPaymentMethodType						=	$_REQUEST['polPaymentMethodType'];
 $installmentsNumber						=	$_REQUEST['installmentsNumber'];
 $TX_VALUE									=	$_REQUEST['TX_VALUE'];
 $TX_TAX									=	$_REQUEST['TX_TAX'];
 $buyerEmail								=	$_REQUEST['buyerEmail'];
 $processingDate							=	$_REQUEST['processingDate'];
 $currency									=	$_REQUEST['currency'];
 $cus										=	$_REQUEST['cus'];
 $pseBank									=	$_REQUEST['pseBank'];
 $lng										=	$_REQUEST['lng'];
 $description								=	$_REQUEST['description'];
 $lapResponseCode							=	$_REQUEST['lapResponseCode'];
 $lapPaymentMethod							=	$_REQUEST['lapPaymentMethod'];
 $lapPaymentMethodType						=	$_REQUEST['lapPaymentMethodType'];
 $lapTransactionState						=	$_REQUEST['lapTransactionState'];
 $message									=	$_REQUEST['message'];
 $extra1									=	$_REQUEST['extra1'];
 $extra2									=	$_REQUEST['extra2'];
 $extra3									=	$_REQUEST['extra3'];
 $authorizationCode							=	$_REQUEST['authorizationCode'];
 $merchant_address							=	$_REQUEST['merchant_address'];
 $merchant_name								=	$_REQUEST['merchant_name'];
 $merchant_url								=	$_REQUEST['merchant_url'];
 $orderLanguage								=	$_REQUEST['orderLanguage'];
 $pseCycle									=	$_REQUEST['pseCycle'];
 $pseReference1								=	$_REQUEST['pseReference1'];
 $pseReference2								=	$_REQUEST['pseReference2'];
 $pseReference3								=	$_REQUEST['pseReference3'];
 $telephone									=	$_REQUEST['telephone'];
 $transactionId								=	$_REQUEST['transactionId'];
 $trazabilityCode							=	$_REQUEST['trazabilityCode'];
 $TX_ADMINISTRATIVE_FEE						=	$_REQUEST['TX_ADMINISTRATIVE_FEE'];
 $TX_TAX_ADMINISTRATIVE_FEE					=	$_REQUEST['TX_TAX_ADMINISTRATIVE_FEE'];
 $TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE		=	$_REQUEST['TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE'];
 $action_code_description					=	$_REQUEST['action_code_description'];
 $cc_holder									=	$_REQUEST['cc_holder'];
 $cc_number									=	$_REQUEST['cc_number'];
 $processing_date_time						=	$_REQUEST['processing_date_time'];
 $request_number							=	$_REQUEST['request_number'];
 
 //se toma el idioma del numero de referencia (son el segundo y tercer caracter)
 $idioma =  str_split($referenceCode);
 $idioma =  $idioma[1].$idioma[2];
 

 
 //se incorpora el archivo de configuracion
 require_once ("../../Config/config.php");
 //se incorpora el modelo encargado de registrar los datos en la BD
 require_once ("../../Models/index_model.php");
 
 //se instancian el objeto del modelo
 $objetoIndex = new index();
 
 //se ingresan los datos de respuesta en la base de datos
 $objetoIndex->guardarRespuestaPayu($merchantId,$transactionState,$risk,$polResponseCode,$referenceCode,$reference_pol,$signature,$polPaymentMethod,$installmentsNumber,
					$TX_VALUE,$TX_TAX,$buyerEmail,$processingDate,$currency,$cus,$pseBank,$lng,$description,$lapResponseCode,$lapPaymentMethod,$lapPaymentMethodType,
					$lapTransactionState,$message,$extra1,$extra2,$extra3,$authorizationCode,$merchant_address,$merchant_name,$merchant_url,$orderLanguage,$pseCycle,
					$pseReference1,$pseReference2,$pseReference3,$telephone,$transactionId,$trazabilityCode,$TX_ADMINISTRATIVE_FEE,$TX_TAX_ADMINISTRATIVE_FEE,$TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE,
					$action_code_description,$cc_holder,$cc_number,$processing_date_time,$request_number);
					
	$mensajeRespuestaPO		= "Sin mensaje";	
	$mensajeRespuestaPOE	= "No message";	
				
	//transaccion aprobada
	if( ($transactionState == '4' or $transactionState == 4) and ($polResponseCode == '1' or $polResponseCode == 1) and ($lapResponseCode == 'APPROVED') and  ($lapTransactionState	== 'APPROVED' ) ){
		
		$mensajeRespuestaPO	= "Transacción aprobada";
		$mensajeRespuestaPOE	= "Transaction approved";
		
		
	}//fin transaccion aprobada
	
	//transacion rechazada
	if( ($transactionState == '6' or $transactionState == 6) and ($lapTransactionState	== 'DECLINED' ) ){
		
		//se define por que fue rechazada
		if( ($lapResponseCode == 'PAYMENT_NETWORK_REJECTED') and ($polResponseCode == '4' or $polResponseCode == 4) ){
			$mensajeRespuestaPO	= "Transacción rechazada por entidad financiera";
			$mensajeRespuestaPOE	= "Transaction rejected by financial institution";
		}//fin if
		
		if( ($lapResponseCode == 'ENTITY_DECLINED') and ($polResponseCode == '5' or $polResponseCode == 5) ){
			$mensajeRespuestaPO	= "Transacción rechazada por el banco";
			$mensajeRespuestaPOE	= "Transaction rejected by the bank";
		}//fin if

		if( ($lapResponseCode == 'INSUFFICIENT_FUNDS') and ($polResponseCode == '6' or $polResponseCode == 6) ){
			//Fondos insuficientes
			$mensajeRespuestaPO	= "Fondos insuficientes";
			$mensajeRespuestaPOE	= "Insufficient funds";
		}//fin if		

		if( ($lapResponseCode == 'INVALID_CARD') and ($polResponseCode == '7' or $polResponseCode == 7) ){
			$mensajeRespuestaPO	= "Tarjeta inválida";
			$mensajeRespuestaPOE	= "invalid card";
		}//fin if			

		if( ($lapResponseCode == 'CONTACT_THE_ENTITY') and ($polResponseCode == '8' or $polResponseCode == 8) ){
			$mensajeRespuestaPO	= "Contactar entidad financiera";
			$mensajeRespuestaPOE	= "Contact financial institution";
		}//fin if						

		
		if( ( ($lapResponseCode == 'BANK_ACCOUNT_ACTIVATION_ERROR') or ($lapResponseCode == 'BANK_ACCOUNT_NOT_AUTHORIZED_FOR_AUTOMATIC_DEBIT') 
				or ($lapResponseCode == 'INVALID_AGENCY_BANK_ACCOUNT') or ($lapResponseCode == 'INVALID_BANK_ACCOUNT') 
				or ($lapResponseCode == 'INVALID_BANK') ) and ($polResponseCode == '8' or $polResponseCode == 8) ){
			$mensajeRespuestaPO	= "Débito automático no permitido";
			$mensajeRespuestaPOE	= "Automatic not permitted debit";
		}//fin if
		
		if( ($lapResponseCode == 'EXPIRED_CARD') and ($polResponseCode == '9' or $polResponseCode == 9) ){
			$mensajeRespuestaPO	= "Tarjeta vencida";
			$mensajeRespuestaPOE	= "Expired card";
		}//fin if					

		if( ($lapResponseCode == 'RESTRICTED_CARD') and ($polResponseCode == '10' or $polResponseCode == 10) ){
			$mensajeRespuestaPO	= "Tarjeta restringida";
			$mensajeRespuestaPOE	= "Restricted card";
		}//fin if		

		if( ($lapResponseCode == 'INVALID_EXPIRATION_DATE_OR_SECURITY_CODE') and ($polResponseCode == '12' or $polResponseCode == 12) ){
			$mensajeRespuestaPO	= "Fecha de expiración o código de seguridad inválidos";
			$mensajeRespuestaPOE	= "Expiration date or invalid security code";
		}//fin if			

		if( ($lapResponseCode == 'REPEAT_TRANSACTION') and ($polResponseCode == '13' or $polResponseCode == 13) ){
			$mensajeRespuestaPO	= "Reintentar pago";
			$mensajeRespuestaPOE	= "Retrying payment";
		}//fin if			

		if( ($lapResponseCode == 'INVALID_TRANSACTION') and ($polResponseCode == '14' or $polResponseCode == 14) ){
			$mensajeRespuestaPO	= "Transacción inválida";
			$mensajeRespuestaPOE	= "Invalid transaction";
		}//fin if			

		if( ($lapResponseCode == 'EXCEEDED_AMOUNT') and ($polResponseCode == '17' or $polResponseCode == 17) ){
			$mensajeRespuestaPO	= "El valor excede el máximo permitido por la entidad";
			$mensajeRespuestaPOE	= "The value exceeds the maximum allowed by the entity";
		}//fin if		

		if( ($lapResponseCode == 'ABANDONED_TRANSACTION') and ($polResponseCode == '19' or $polResponseCode == 19) ){
			$mensajeRespuestaPO	= "Transacción abandonada por el pagador";
			$mensajeRespuestaPOE	= "Transaction abandoned by the payer";
		}//fin if											


		if( ($lapResponseCode == 'CREDIT_CARD_NOT_AUTHORIZED_FOR_INTERNET_TRANSACTIONS') and ($polResponseCode == '22' or $polResponseCode == 22) ){
			$mensajeRespuestaPO	= "Tarjeta no autorizada para comprar por internet";
			$mensajeRespuestaPOE	= "Card not authorized to buy online";
		}//fin if		
		
		if( ($lapResponseCode == 'ANTIFRAUD_REJECTED') and ($polResponseCode == '23' or $polResponseCode == 23) ){
			$mensajeRespuestaPO	= "Transacción rechazada por sospecha de fraude";
			$mensajeRespuestaPOE	= "Transaction rejected by suspected fraud";
		}//fin if

		if( ($lapResponseCode == 'DIGITAL_CERTIFICATE_NOT_FOUND') and ($polResponseCode == '9995' or $polResponseCode == 9995) ){
			$mensajeRespuestaPO	= "Certificado digital no encotnrado";
			$mensajeRespuestaPOE	= "Certificado digital no encotnrado";
		}//fin if		

		if( ($lapResponseCode == 'BANK_UNREACHABLE') and ($polResponseCode == '9996' or $polResponseCode == 9996) ){
			$mensajeRespuestaPO	= "Error tratando de comunicarse con el banco";
			$mensajeRespuestaPOE	= "Error trying to communicate with the bank";
		}//fin if	

		if( ($lapResponseCode == 'ENTITY_MESSAGING_ERROR') and ($polResponseCode == '9997' or $polResponseCode == 9997) ){
			$mensajeRespuestaPO	= "Error comunicándose con la entidad financiera";
			$mensajeRespuestaPOE	= "Error communicating with the financial institution";
		}//fin if		

		if( ($lapResponseCode == 'NOT_ACCEPTED_TRANSACTION') and ($polResponseCode == '9998' or $polResponseCode == 9998) ){
			$mensajeRespuestaPO	= "Transacción no permitida al tarjetahabiente";
			$mensajeRespuestaPOE	= "Transaction not allowed to cardholder";
		}//fin if			

		if( (($lapResponseCode == 'INTERNAL_PAYMENT_PROVIDER_ERROR') or ($lapResponseCode == 'INACTIVE_PAYMENT_PROVIDER') 
				or ($lapResponseCode == 'ERROR') or ($lapResponseCode == 'ERROR_CONVERTING_TRANSACTION_AMOUNTS') 
				or ($lapResponseCode == 'BANK_ACCOUNT_ACTIVATION_ERROR') or ($lapResponseCode == 'FIX_NOT_REQUIRED') 
				or ($lapResponseCode == 'AUTOMATICALLY_FIXED_AND_SUCCESS_REVERSAL') or ($lapResponseCode == 'AUTOMATICALLY_FIXED_AND_UNSUCCESS_REVERSAL') 
				or ($lapResponseCode == 'AUTOMATIC_FIXED_NOT_SUPPORTED') or ($lapResponseCode == 'NOT_FIXED_FOR_ERROR_STATE') 
				or ($lapResponseCode == 'ERROR_FIXING_AND_REVERSING') or ($lapResponseCode == 'ERROR_FIXING_INCOMPLETE_DATA') 
				or ($lapResponseCode == 'PAYMENT_NETWORK_BAD_RESPONSE')  ) and ($polResponseCode == '9999' or $polResponseCode == 9999) ){
			$mensajeRespuestaPO	= "Error";
			$mensajeRespuestaPO	= "Error";
		}//fin if			

		if( ($lapResponseCode == 'PAYMENT_NETWORK_NO_CONNECTION') and ($polResponseCode == '9996' or $polResponseCode == 9996) ){
			$mensajeRespuestaPO	= "No fue posible establecer comunicación con la entidad financiera";
			$mensajeRespuestaPOE	= "It was not possible to communicate with the financial institution";
		}//fin if				
		
		if( ($lapResponseCode == 'PAYMENT_NETWORK_NO_RESPONSE') and ($polResponseCode == '9996' or $polResponseCode == 9996) ){
			$mensajeRespuestaPO	= "No se recibió respuesta de la entidad financiera";
			$mensajeRespuestaPOE	= "No response was received from the financial institution";
		}//fin if	
																										
	}// fin if transacion rechazada

	//transaccion Expirada
	if( ($transactionState == '5' or $transactionState == 5) and ($polResponseCode == '5' or $polResponseCode == 5) and ($lapResponseCode == 'EXPIRED_TRANSACTION') and  ($lapTransactionState	== 'EXPIRED' ) ){
		
		$mensajeRespuestaPO	= "Transacción expirada";
		$mensajeRespuestaPOE	= "Expired transaction";

	}//fin transaccion Expirada

	
	//transacion Pendiente
	if( ($transactionState == '7' or $transactionState == 7) and ($lapTransactionState	== 'PENDING' ) ){

		if( ($lapResponseCode == 'PENDING_TRANSACTION_REVIEW') and ($polResponseCode == '15' or $polResponseCode == 15) ){
			$mensajeRespuestaPO	= "Transacción en validación manual";
			$mensajeRespuestaPOE	= "Transaction manual validation";
		}//fin if	

		if( ($lapResponseCode == 'PENDING_TRANSACTION_CONFIRMATION') and ($polResponseCode == '25' or $polResponseCode == 25) ){
			$mensajeRespuestaPO	= "Recibo de pago generado. En espera de pago";
			$mensajeRespuestaPOE	= "Payment receipt generated. Awaiting payment";
		}//fin if		

		if( ($lapResponseCode == 'PENDING_TRANSACTION_TRANSMISSION') and ($polResponseCode == '9998' or $polResponseCode == 9998) ){
			$mensajeRespuestaPO	= "Transacción no permitida";
			$mensajeRespuestaPOE	= "Transaction not allowed";
		}//fin if		

		if( ($lapResponseCode == 'PENDING_PAYMENT_IN_ENTITY') and ($polResponseCode == '25' or $polResponseCode == 25) ){
			$mensajeRespuestaPO	= "Recibo de pago generado. En espera de pago";
			$mensajeRespuestaPOE	= "Payment receipt generated. Awaiting payment";
		}//fin if			

		if( ($lapResponseCode == 'PENDING_PAYMENT_IN_BANK') and ($polResponseCode == '26' or $polResponseCode == 26) ){
			$mensajeRespuestaPO	= "Recibo de pago generado. En espera de pago";
			$mensajeRespuestaPOE	= "Payment receipt generated. Awaiting payment";
		}//fin if			

		if( ($lapResponseCode == 'PENDING_SENT_TO_FINANCIAL_ENTITY') and ($polResponseCode == '29' or $polResponseCode == 29) ){
			
		}//fin if		

		if( ($lapResponseCode == 'PENDING_AWAITING_PSE_CONFIRMATION') and ($polResponseCode == '9994' or $polResponseCode == 9994) ){
			$mensajeRespuestaPO	= "En espera de confirmación de PSE";
			$mensajeRespuestaPOE	= "Pending confirmation PSE";
		}//fin if		

		if( ($lapResponseCode == 'PENDING_NOTIFYING_ENTITY') and ($polResponseCode == '25' or $polResponseCode == 25) ){
			$mensajeRespuestaPO	= "Recibo de pago generado. En espera de pago";
			$mensajeRespuestaPOE	= "Payment receipt generated. Awaiting payment";
		}//fin if
															
	}//fin transaccion pendiente
	
	
	//se detecta que se va a realizar según la referencia de venta
	//N=Nueva BD- A= Adicion de licencias- R= renovación de licencia	
	$arrayStringReferenciaVenta = str_split($referenceCode);
	
	
	switch ($arrayStringReferenciaVenta['0']) {
		case 'N':
				//se incluye la vista para que se muestre la respuesta al usuario
				require_once("../../Views/index/pagos_respuesta.phtml");			
		break;
		
		case 'A':
				//se incluye la vista para que se muestre la respuesta al usuario
				require_once("../../Views/index/pagos_respuestaAdicionLicencia.phtml");			
		break;		
		
		default:
				//se incluye la vista para que se muestre la respuesta al usuario
				require_once("../../Views/index/pagos_respuesta.phtml");			
		break;
	}
	

	
?>