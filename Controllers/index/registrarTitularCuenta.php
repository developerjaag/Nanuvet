<?php

/*
 * Archivo que se utiliza para guardar el titular de la cuenta y enviar los datos a la pasarela de pagos
 */
 
	$identificacion_titular 	= $_POST['identificacion_titular'];
	$nombre_titular 			= $_POST['nombre_titular'];
	$personaContacto_titular 	= $_POST['personaContacto_titular'];
	$direccion_titular 			= $_POST['direccion_titular'];
	$telefono1_titular 			= $_POST['telefono1_titular'];
	$telefono2_titular 			= $_POST['telefono2_titular'];
	$celular_titular 			= $_POST['celular_titular'];
	$email_titular 				= $_POST['email_titular'];
	$pais_titular 				= $_POST['pais_titular'];
	$ciudad_titular 			= $_POST['ciudad_titular'];
	$plan						= $_POST['plan'];
	$idioma						= $_POST['idioma'];
	$vendedor					= $_POST['vendedor'];

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


//validar la esistencia del contenido en las variables   
	$sw = 0;
	if($identificacion_titular == ''){
		$sw = 1;
	} 
	if($nombre_titular == ''){
		$sw = 1;
	}
	if($personaContacto_titular == ''){
		$sw = 1;
	} 
	if($direccion_titular == ''){
		$sw = 1;
	}    
	if($telefono1_titular == ''){
		$sw = 1;
	} 
	if($celular_titular == ''){
		$sw = 1;
	}
	if($email_titular == ''){
		$sw = 1;
	} 
	if($pais_titular == ''){
		$sw = 1;
	} 
	if($ciudad_titular == ''){
		$sw = 1;
	} 
	if($plan <= 0){
		$sw = 1;
	}
	
	$resultadoEmail	= comprobar_email($email_titular);
	
	if($resultadoEmail == 0){
		$sw = 2;
	}
	
	if($sw == 1){
		$retorno =  array('mensaje' => 'Error' );
	}else if($sw == 0){
		//se incluye el archivo de configuración
		require_once("../../Config/config.php");
		
		//se referencia al modelo que se encargará de almacenar los datos
	    require_once("../../Models/index_model.php");		
		
		$objetoIndex = new index();

		$data = file_get_contents("../../Views/index/resources/precios.json");
		$precios = json_decode($data, true);
		 
		$tamano = sizeof($precios["precios"]);
		                                    
		for($i=0; $i < $tamano; $i++){
		   
		  if($precios['precios'][$i]['id'] == $plan){
		     
		     $textoDelPlan = "Cantidad de licencias:".$precios['precios'][$i]['id']." Valor total: $".$precios['precios'][$i]['precio'];

				$cantidadLicencias	=  $precios['precios'][$i]['id'];
				$valorPago			=  $precios['precios'][$i]['precio'];
				$valorPO			=  $precios['precios'][$i]['precioPO'];
				$descripcionVenta	=  $precios['precios'][$i]['display'];
				$referenciaVenta	=  uniqid();//para generar una referencia aleatoria y única
				$referenciaVenta	=  "N".$idioma.$referenciaVenta;//N para indicar que es una nueva BD
				
				$datosFirma			=  "161zxZ4D0aIV7EaZPJQP9g70f8~563742~".$referenciaVenta."~".$valorPO."~COP";//produccion
				//$datosFirma			=  "4Vj8eK4rloUd272L48hsrarnUA~508029~".$referenciaVenta."~".$valorPO."~COP";//pruebas
				$firmaPO			=  sha1($datosFirma);
				

		     
		  }//fin if
		   
		}//fin for

		

		
		$objetoIndex->guardarRegistroNuevoTitular($identificacion_titular, $nombre_titular, $personaContacto_titular, $telefono1_titular, 
									$telefono2_titular, $celular_titular, $direccion_titular, $email_titular, $pais_titular, 
									$ciudad_titular, $cantidadLicencias, $valorPago, $descripcionVenta, $referenciaVenta, $vendedor);
		
		$retorno = array('mensaje' => 'Ok', 'valorPO' => $valorPO, 'referenciaVenta' => $referenciaVenta, 'descripcionVenta' => $descripcionVenta,
						 'firmaPO' => $firmaPO);
	}else if($sw == 2){
		$retorno =  array('mensaje' => 'Error E-mail');
	}
	
	echo json_encode($retorno);
	

	   