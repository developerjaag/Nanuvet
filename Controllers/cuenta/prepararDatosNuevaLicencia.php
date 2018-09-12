<?php


/*
 * Controlador para preparar los datos en la compra de una nueva licencia
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 $plan	= $_POST['plan'];
 
 
 	//se incluye el archivo de configuración
	require_once("../../Config/config.php");
	
	//se incluye el modelo de la cuenta
	require_once ("../../Models/cuenta_model.php");
	
	$objetoCuenta	= new cuenta();
	
	//consultar los datos del titular de la cuenta
	$idTitularTabla	= $_SESSION['BDC_id'];
	
	$datosTitular	= $objetoCuenta->consultarDatosTitular($idTitularTabla);

	
    //decision para el idioma
        if(isset($_SESSION['usuario_idioma'])){
    
            $idioma = $_SESSION['usuario_idioma'];
     
        }else{
            $idioma = Config::getUserLanguage();
            
            switch ($idioma) {
            	case 'es':
            		$idioma="Es";
            		break;
            		
            	case 'en':
            		$idioma="En";
            		break;
            	
            	default:
            		$idioma="Es";
            		break;
            }
            
            
        }//fin else para detectar idioma   



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
				$referenciaVenta	=  "A".$idioma.$idTitularTabla."0".$referenciaVenta."0lic".$cantidadLicencias;//A para indicar que es una adicion de licencia en una BD
				
				$datosFirma			=  "161zxZ4D0aIV7EaZPJQP9g70f8~563742~".$referenciaVenta."~".$valorPO."~COP";//produccion
				//$datosFirma			=  "4Vj8eK4rloUd272L48hsrarnUA~508029~".$referenciaVenta."~".$valorPO."~COP";//pruebas
				$firmaPO			=  sha1($datosFirma);
				

		     
		  }//fin if
		   
		}//fin for
		
		$titular_identifiacion	= $datosTitular['identificacion'];
		$titular_direccion		= $datosTitular['direccion'];
		$titular_email			= $datosTitular['email'];
		$titular_celular		= $datosTitular['celular'];
		$titular_telefono1		= $datosTitular['telefono1'];
		
		$retorno = array('mensaje' => 'Ok', 'valorPO' => $valorPO, 'referenciaVenta' => $referenciaVenta, 'descripcionVenta' => $descripcionVenta,
				 'firmaPO' => $firmaPO, 'titular_identifiacion' => $titular_identifiacion, 
				 'titular_direccion' => $titular_direccion,  'titular_email' => $titular_email, 'titular_celular' => $titular_celular,
				 'titular_telefono1' => $titular_telefono1);
				 
		echo json_encode($retorno);

?>