<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){



 		//se importa el modelo
		require_once("Models/desparasitantes_model.php"); 

		//se declara el objeto
		$objetoDesparasitantes	= new desparasitantes();


		//validar si se envia el formulario de un nuevo desparasitante
		if(isset($_POST['hidden_evioFormNuevoDesparasitante']) and $_POST['hidden_evioFormNuevoDesparasitante'] == "enviar"){
			
			//se reciben las variables
			$idPaciente					= $_POST['idPaciente'];		
			$idPacienteReplica			= $_POST['idPacienteReplica'];
			$idDesparasitante			= $_POST['idDesparasitanteBuscado'];
			$dosificacion				= $_POST['dosificacion'];
			$fechaProximoDesparasitante	= $_POST['fechaProximoDesparasitante'];
			$observaciones				= trim($_POST['observaciones']);
			
			$resultadoIdProducto	= $_POST['resultadoIdProducto'];
			$cantidadDisponible		= $_POST['cantidadDisponible'];
		
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
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
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$objetoDesparasitantes->guardarAplicacionDesparasitante($idPaciente, $idDesparasitante, $dosificacion, $fechaProximoDesparasitante, $observaciones, $idPacienteReplica  );

				
				//saber si se resta el desparasitante del inventario
				if($resultadoIdProducto != '0' AND $cantidadDisponible != '0'){
					
					require_once("Models/productos_model.php"); 
					
					$objetoProductos = new productos();
					
					$objetoProductos->descontarUnidadesVentaProducto($resultadoIdProducto, $_SESSION['sucursalActual_idSucursal'], '1');
					
					
				}
				
				$_SESSION['mensaje']   = $ok;
				

				
			 }//fin sw == 0 	
			 				
			//se redirecciona nuevamente a desparasitantes 
			 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/desparasitantes/' );	
			 		
			exit();				
			
		}//fin if si llega nuevo desparasitante

	
		
 //se consulta el total de los desparasitantes existentes
		$TotalDesparasitantes = $objetoDesparasitantes->tatalDesparasitantesPaciente($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoDesparasitantesPaciente = $objetoDesparasitantes->listarDesparasitantesPaciente($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar los desparasitantes segun los limites de la consulta
		
		$pagination->records($TotalDesparasitantes);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación			
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>		 