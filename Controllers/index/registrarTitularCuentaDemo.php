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
	$idioma						= $_POST['idioma'];

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


		     
		     $textoDelPlan = "Cantidad de licencias: 2 Valor total: $0 DEMO";

				$cantidadLicencias	=  2;
				$valorPago			=  0;
				$descripcionVenta	=  "Cuenta Demo";
				$referenciaVenta	=  uniqid();//para generar una referencia aleatoria y única
				$referenciaVenta	=  "N".$idioma.$referenciaVenta."DEMO";//N para indicar que es una nueva BD

		

		
		$objetoIndex->guardarRegistroNuevoTitular($identificacion_titular, $nombre_titular, $personaContacto_titular, $telefono1_titular, 
									$telefono2_titular, $celular_titular, $direccion_titular, $email_titular, $pais_titular, 
									$ciudad_titular, $cantidadLicencias, $valorPago, $descripcionVenta, $referenciaVenta,"");
		
		$retorno = array('mensaje' => 'Ok');
	}else if($sw == 2){
		$retorno =  array('mensaje' => 'Error E-mail');
	}
	
	echo json_encode($retorno);
	
	
	
	
	
	
	
	
	
	
	
	   