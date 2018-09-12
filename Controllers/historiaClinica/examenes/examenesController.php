<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){



 		//se importa el modelo
		require_once("Models/examenes_model.php"); 

		//se declara el objeto
		$objetoExamenes	= new examenes();


		//validar si se envia el formulario de un nuevo examen
		if(isset($_POST['hidden_evioFormNuevoExamen']) and $_POST['hidden_evioFormNuevoExamen'] == "enviar"){
			
			//se reciben las variables
			$idPaciente		= $_POST['idPaciente'];
			$idPacienteReplica	= $_POST['idPacienteReplica'];
			
			
			$observaciones	= trim($_POST['observaciones']);
			
			
			$contadorIE	= $_POST['contadorIE'];
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Examen guardado correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Exam saved successfully!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if($contadorIE <= "0"){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$idExamenGuardado  = $objetoExamenes->guardarExamenEncabezado($idUsuario, $idPaciente, $observaciones, $_SESSION['sucursalActual_idSucursal'], $idPacienteReplica);
		        
				
				
				//para guardar los items de al examen 
				if($contadorIE > "0"){
					
					for ($i=1; $i <= $contadorIE; $i++) { 
						
						$nombre 		= trim($_POST['iENombre_'.$i]);
						$observacion 	= trim($_POST['iEObservacion_'.$i]);
						$id  			= $_POST['iEId_'.$i];
						
						$objetoExamenes->guardarItemDetalleExamen($nombre,$observacion,$id,$idExamenGuardado[0],$idExamenGuardado[1]);
						
						
					}//fin for
					
				}//fin if para guardar los itesm adicionales de examen
					        	

				//comprobar si el paciente esta hospitalizado
				if(sizeof($comprobarHospitalizacionActiva) > 0){
					$objetoExamenes->relacionarExamenHospitalizacion($idExamenGuardado[0],$comprobarHospitalizacionActiva[0]['idHospitalizacion']);
				}						        										        	
					        	
				
				$_SESSION['mensaje']   = $ok;
				
				//se redirecciona nuevamente a examenes 
				 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/examenes/' );	
				 		
				exit();	
				
			 }//fin sw == 0 					
			
			
		}//fin if si llega nuevo examen

	
		
 //se consulta el total de los examenes existentes
		$TotalExamenes = $objetoExamenes->tatalExamenesEncabezado($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoExamenes = $objetoExamenes->listarExamenesEncabezado($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar los examenes segun los limites de la consulta
		
		$pagination->records($TotalExamenes);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación			
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>		 