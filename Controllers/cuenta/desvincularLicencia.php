<?php


/*
 * Archivo para devincular una licencia de un usuario
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 //se recibe el id
 $idLicencia	= $_POST['idLicencia'];
 
  //se importa el config
 require_once ("../../Config/config.php");
 
 //se importa el modelo de la cuenta
 require ("../../Models/cuenta_model.php");
 
 
 //se intancia el objeto
 $objetoCuenta	= new cuenta();
 
 //se llama al metodo que se encarga de consultar la cantidad de usuarios con licencia, en caso de ser mayor a 1 se desvincula la licencia
 $resultado	= $objetoCuenta->desvincularLicencia($idLicencia);
 
 //metodo para marcar una licencia como libre
 $objetoCuenta->liberarLicencia($idLicencia);

		 switch($_SESSION['usuario_idioma']){
	            
        case 'Es':
    		$ok="Licencia desvinculada!";
			$error="Error!. Solo existe un usuario con licencia!";
    		break;
    		
    	case 'En':
    		$ok="Unlinked license!";
			$error="Error!. There is only one licensed user!";
    		break;
        
    }//fin swtich

if($resultado == 'Cambio Ok'){
	
	$_SESSION['mensaje'] = $ok;
	
}else{
	$_SESSION['mensaje'] = $error;
}


?>