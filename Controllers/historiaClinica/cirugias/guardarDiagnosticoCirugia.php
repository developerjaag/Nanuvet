<?php

/**
 * Archivo para guardar un diagnostico de consulta
 */
	if(!isset($_SESSION)){
		    session_start();
		}
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 	
	$nombreDiagnostico 		= $_POST['nombre'];
	$codigoDiagnostico		= $_POST['codigo'];
	$observacionDiagnostico	= $_POST['observacion'];
	$precioDiagnostico		= $_POST['precio'];
	
	//se importa el config y el modelo
	require_once('../../../Config/config.php');
	
	require_once('../../../Models/diagnosticosCirugias_model.php');
	
	$objetoDiagnosticosCirugias   = new diagnosticosCirugias();
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La cirugía ya existe!";
    		$ok="Cirugía guardada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Surgery already exists!";
    		$ok="Surgery successfully saved!";
    		break;
        
    }//fin swtich
    

	    //validar si algun campo obligatorio llega vacio
    if(($nombreDiagnostico == "") or ($codigoDiagnostico == "")  or ($precioDiagnostico == "")){
         $sw = 1;			
         echo  $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el diagnostico existe
		    $comprobarExistencia    = $objetoDiagnosticosCirugias->comprobarExistenciaDiagnostico($nombreDiagnostico);
		    
		    //comprobar si la consulta arrojo datos (Existe el diagnostico)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        echo  $error2;
		        
		    }else{//sino se inserta el diagnostico
		        $guardarDiagnostico = $objetoDiagnosticosCirugias->guardarDiagnostico($nombreDiagnostico, $codigoDiagnostico, $observacionDiagnostico, $precioDiagnostico );
		        
		        echo $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	
 }//fin if	
 

?>