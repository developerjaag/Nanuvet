<?php

/*
 * Archivo para consultar los usuarios que tienen un vinculo con una sucursal en particular
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
	
	    //decision para el idioma
        if(isset($_SESSION['usuario_idioma'])){
    
            $idiomaIndex = $_SESSION['usuario_idioma'];
			//$idiomaIndex = "En";
     
        }else{
            $idiomaIndex = Config::getUserLanguage();
            
            switch ($idiomaIndex) {
            	case 'es':
            		$idiomaIndex="Es";
            		break;
            		
            	case 'en':
            		$idiomaIndex="En";
            		break;
            	
            	default:
            		$idiomaIndex="Es";
            		break;
            }
            
            
        }//fin else para detectar idioma   
        
      //importar archivo de idioma
       require_once("../../Lang/".$idiomaIndex.".php");
 
 	$idSucursal 	= $_POST['idSucursal'];
	$nombreSucursal = $_POST['nombre'];

     //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las ciudades
    require_once("../../Models/sucursales_model.php");
	
	$objetoSucursales = new sucursales();
	
	$usuariosVinculados = $objetoSucursales->consultarUsuariosDeLaSucursal($idSucursal);
	
	//consultar usuarios que no esten vinculados con la sucursal (Para select)
	$usuariosQueNoEstanEnLASucursal = $objetoSucursales->usuariosQueNoEstanEnLASucursal($idSucursal);

	//se importa la vista para el contenido del modal
	require_once("../../Views/sucursales/modalVincularUsuarios.phtml");
	

