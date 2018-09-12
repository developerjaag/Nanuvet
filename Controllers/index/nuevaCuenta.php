<?php

/**
 * Controlador para continuar con la compra
 * */

 require_once('../../Config/config.php');//se importa las configuraciones
 $idiomaIndex = Config::getUserLanguage();
 
 //se recibe la variable con el valor del plan seleccionado
 $plan = $_POST['idPrecio'];
  //se llama al json que tiene los precios
 $data = file_get_contents("../../Views/index/resources/precios.json");
 $precios = json_decode($data, true);
 
 $tamano = sizeof($precios["precios"]);
                                    
  for($i=0; $i < $tamano; $i++){
   
    if($precios['precios'][$i]['id'] == $plan){
     
	 switch ($idiomaIndex) {
            	case 'es':
            		
						$textoDelPlan = "Cantidad de licencias:".$precios['precios'][$i]['id']." Valor total: $".$precios['precios'][$i]['precio'];
					
            		break;
            		
            	case 'en':
					
					$textoDelPlan = "Number of licenses:".$precios['precios'][$i]['id']." total price: $".$precios['precios'][$i]['precio'];
					
            		break;
            	
            	default:
					
					$textoDelPlan = "Cantidad de licencias:".$precios['precios'][$i]['id']." Valor total: $".$precios['precios'][$i]['precio'];
					
            		break;
            }
	 
	 
      
     
    }//fin if
   
  }//fin for
 
 
 //se muestra la vista
 require_once("../../Views/index/formularioNuevaCuenta.phtml");
