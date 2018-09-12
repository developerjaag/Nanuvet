<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){



 		//se importa el modelo
		require_once("Models/vacunas_model.php"); 

		//se declara el objeto
		$objetoVacunas	= new vacunas();


		//validar si se envia el formulario de una nueva vacuna
		if(isset($_POST['hidden_evioFormNuevaVacuna']) and $_POST['hidden_evioFormNuevaVacuna'] == "enviar"){
			
			//se reciben las variables
			$idPaciente			= $_POST['idPaciente'];
			$idPacienteReplica	= $_POST['idPacienteReplica'];		
			$idVacuna			= $_POST['idVacunaBuscada'];			
			$fechaProximaVacuna	= $_POST['fechaProximaVacuna'];
			$observaciones		= trim($_POST['observaciones']);
			
			$resultadoIdProducto	= $_POST['resultadoIdProducto'];
			$cantidadDisponible		= $_POST['cantidadDisponible'];
		
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Aplicación de vacuna guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Vaccine application saved correctly!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if($idVacuna == "0"){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$objetoVacunas->guardarAplicacionVacuna($idPaciente, $idVacuna, $fechaProximaVacuna, $observaciones, $_SESSION['sucursalActual_idSucursal'], $idPacienteReplica  );

				
				//saber si se resta el desparasitante del inventario
				if($resultadoIdProducto != '0' AND $cantidadDisponible != '0'){
					
					require_once("Models/productos_model.php"); 
					
					$objetoProductos = new productos();
					
					$objetoProductos->descontarUnidadesVentaProducto($resultadoIdProducto, $_SESSION['sucursalActual_idSucursal'], '1');
					
					
				}
				
				$_SESSION['mensaje']   = $ok;
				

			 }//fin sw == 0 	
			 				
			//se redirecciona nuevamente a vacunas 
			 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/vacunas/' );	
			 		
			exit();	
							
			
		}//fin if si llega nueva vacuna

	
		
 //se consulta el total de las vacunas existentes
		$TotalVacunas = $objetoVacunas->tatalVacunasPaciente($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoVacunasPaciente = $objetoVacunas->listarVacunasPaciente($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar los desparasitantes segun los limites de la consulta
		
		$pagination->records($TotalVacunas);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación			
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>		 