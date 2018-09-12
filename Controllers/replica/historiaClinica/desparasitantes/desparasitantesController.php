<?php 

/*
 * SubControlador para los desparasitantes
 */
 
 
 
 		//validar si se envia el formulario de un nuevo desparasitante
		if(isset($_POST['hidden_evioFormNuevoDesparasitante']) and $_POST['hidden_evioFormNuevoDesparasitante'] == "enviar"){
			
			//se reciben las variables
			$idPaciente					= $_POST['idPaciente'];		
			
			$nombreDesparasitante		= $_POST['buscarDesparasitante'];
			$dosificacion				= $_POST['dosificacion'];
			$fechaProximoDesparasitante	= $_POST['fechaProximoDesparasitante'];
			$observaciones				= trim($_POST['observaciones']);
			
		
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($idiomaIndex){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Aplicación desparasitante guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Deworm application saved correctly!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if($dosificacion == ""){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
		     
			 	$objetoReplica->guardarAplicacionDesparasitante($idPaciente, $nombreDesparasitante, $dosificacion, $fechaProximoDesparasitante, $observaciones  );

				
				$_SESSION['mensaje']   = $ok;
				

				
			 }//fin sw == 0 	
			 				
			//se redirecciona nuevamente a desparasitantes 
			 header('Location: '.Config::ruta().'replica/'.$_GET['id1'].'/'.$_GET['id2'].'/historiaClinica/desparasitantes/' );	
			 		
			exit();				
			
		}//fin if si llega nuevo desparasitante
 
 
  
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoDesparasitantesPaciente	= $objetoReplica->listado_desparasitantesPaciente($_GET['id2']);



?>