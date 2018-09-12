<?php 

/*
 * SubControlador para los anti Pulgas
 */
 
 
 
 		//validar si se envia el formulario de un nuevo antipulgas
		if(isset($_POST['hidden_evioFormNuevoAntipulgas']) and $_POST['hidden_evioFormNuevoAntipulgas'] == "enviar"){
			
			//se reciben las variables
			$idPaciente					= $_POST['idPaciente'];		
			
			$nombreProducto				= $_POST['nombreProducto'];
			
			$fechaProximoAntipulgas		= $_POST['fechaProximoAntipulgas'];
			$observaciones				= trim($_POST['observaciones']);
			
		
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($idiomaIndex){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Aplicación guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Application saved correctly!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if($nombreProducto == ""){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
		     
			 	$objetoReplica->guardarAplicacionAntipulgas($idPaciente, $nombreProducto, $fechaProximoAntipulgas, $observaciones );

				
				$_SESSION['mensaje']   = $ok;
				

				
			 }//fin sw == 0 	
			 				
			//se redirecciona nuevamente a antipulgas 
			 header('Location: '.Config::ruta().'replica/'.$_GET['id1'].'/'.$_GET['id2'].'/historiaClinica/antiPulgas/' );	
			 		
			exit();				
			
		}//fin if si llega nuevo antipulgas
 
 
  
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoAntipulgasPaciente	= $objetoReplica->listado_anipulgasPaciente($_GET['id2']);



?>