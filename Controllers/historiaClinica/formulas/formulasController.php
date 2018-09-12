<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){



 		//se importa el modelo
		require_once("Models/formulas_model.php"); 

		//se declara el objeto
		$objetoFormulas	= new formulas();


		if(isset($_POST['hidden_evioFormNuevaFormula']) and $_POST['hidden_evioFormNuevaFormula'] == "enviar"){
			
			
			//se reciben las variables
			$idPaciente		= $_POST['idPaciente'];
			$idPacienteReplica	= $_POST['idPacienteReplica'];
			$contadorIF		= $_POST['contadorIF'];
			$observaciones	= trim($_POST['observaciones']);
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Fórmula guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Formula saved successfully!";
		    		break;
		        
		    }//fin swtich	
		    
		    
		    		    //validar si algun campo obligatorio llega vacio
		    if($contadorIF <= "0"){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos	
		    				
		    				
		    if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
				
				$idFormulaGuardada  = $objetoFormulas->guardarFormula($idUsuario, $idPaciente, $observaciones, $_SESSION['sucursalActual_idSucursal'], $idPacienteReplica);
				
				for ($i=1; $i <= $contadorIF; $i++) { 
						
						$id  				= $_POST['iMId_'.$i];
						$nombre 			= trim($_POST['iMNombre_'.$i]);
						$cantidad	 		= trim($_POST['iMCantidad_'.$i]);
						$frecuencia 		= trim($_POST['iMFrecuencia_'.$i]);
						$dosificacion 		= trim($_POST['iMDosificacion_'.$i]);
						$observacion 		= trim($_POST['iMObservaciones_'.$i]);
						$viaAdministracion	= trim($_POST['iMViaAdministracion_'.$i]);
						
						
						$objetoFormulas->guardarMedicamentoFormula($id, $nombre,$cantidad,$frecuencia,$dosificacion,$observacion,$viaAdministracion, $idFormulaGuardada[0], $idFormulaGuardada[1]);
						
						
					}//fin for
				
			}//fin if si todo va bien sw = 0
			

				//comprobar si el paciente esta hospitalizado
				if(sizeof($comprobarHospitalizacionActiva) > 0){
					$objetoFormulas->relacionarFormulaHospitalizacion($idFormulaGuardada[0],$comprobarHospitalizacionActiva[0]['idHospitalizacion']);
				}				
			
										
		    $_SESSION['mensaje']   = $ok;
				
			//se redirecciona nuevamente a examenes 
			 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/formulas/' );	
			 		
			exit();					
			
		}//fin if si llega una nueva formula



	
		
 //se consulta el total de los formulas existentes
		$TotalFormulas = $objetoFormulas->tatalFormulas($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoFormulas = $objetoFormulas->listarFormulas($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar las formulas segun los limites de la consulta
		
		$pagination->records($TotalFormulas);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación			
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>		 