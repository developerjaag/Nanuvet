<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){



 		//se importa el modelo
		require_once("Models/hospitalizacion_model.php"); 

		//se declara el objeto
		$objetoHospitalizacion	= new hospitalizacion();
		
		//consultar si el paciente tiene hospitalizaciones activas, sin alta
		$hospitalizacionActiva = $objetoHospitalizacion->comprobarAltaHospitalizacion($_GET['id1']);

		//se importa el modelo de sucursales para consultar los espacios de hospitalizacion
		require_once("Models/sucursales_model.php");
		
		$objetoSucursales	= new sucursales();
		
		$idSucursal = $_SESSION['sucursalActual_idSucursal'];
		
		$espaciosHospitalizacion = $objetoSucursales->consultarEspaciosHospitalizacionSucursal($idSucursal);


	if(sizeof($hospitalizacionActiva) <= 0){

		//validar si se envia el formulario de un nuevo desparasitante
		if(isset($_POST['hidden_evioFormNuevaHospitalizacion']) and $_POST['hidden_evioFormNuevaHospitalizacion'] == "enviar"){
			
			//se reciben las variables
			$idPaciente					= $_POST['idPaciente'];	
			$idPacienteReplica			= $_POST['idPacienteReplica'];	
			$fechaIngreso				= $_POST['fechaIngreso'];
			$horaIngreso				= $_POST['horaIngreso'];
			
			$idEspacioHospitalizaicon	= $_POST['espacioHospitalizacion'];
			
			$motivoHospitalizacion		= trim($_POST['motivoHospitalizacion']);
			$observaciones				= trim($_POST['observacionesHospitalizacion']);
			
		
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Hospitalización guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Hospitalization saved correctly!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if( ($motivoHospitalizacion == "") or ($fechaIngreso == "") or ($horaIngreso == "") or (($idEspacioHospitalizaicon == "0") or ($idEspacioHospitalizaicon == ""))){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$idSucursal = $_SESSION['sucursalActual_idSucursal'];
			 
			 	$idHospitalizacion = $objetoHospitalizacion->guardarHospitalizacion($idPaciente, $motivoHospitalizacion, $fechaIngreso, $horaIngreso, $observaciones, $idUsuario, $idSucursal, $idPacienteReplica );

				//guardar el vinculo del espacio del hospitalizacion con la hospitalizacion
				$objetoHospitalizacion->guardarEspacioHospitalizacionPaciente($idEspacioHospitalizaicon, $idHospitalizacion);
				$objetoHospitalizacion->ocuparEspacioHospitalizacion($idEspacioHospitalizaicon);
				
				$_SESSION['mensaje']   = $ok;
				

				
			 }//fin sw == 0 	
			 				
			//se redirecciona nuevamente a hospitalizacion 
			 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/hospitalizacion/' );	
			 		
			exit();				
			
		}//fin if si llega nueva hospitalizacion

	}//fin if si el paciente no tiene hospitalizaciones activas	
	
	
	
	//validar si llega el formulario para dar de alta a un paciente
	if(isset($_POST['hidden_evioFormAlta']) and $_POST['hidden_evioFormAlta'] == "enviarAlta"){

			//se reciben las variables
			$idPaciente					= $_POST['idPacienteAlta'];	
				
			$fechaAlta					= $_POST['fechaAlta'];
			$horaAlta					= $_POST['horaAlta'];
			$estado						= $_POST['alta_estado'];
						
			$cuidados					= trim($_POST['cuidadosAlta']);
			$observaciones				= trim($_POST['observacionesAlta']);
			
			$idHospitalizacion 			= $_POST['alta_idHospitalizacion'];
			
			$idEspacioHospitalizacion 			= $_POST['idEspacioHospitalizacionAlta'];
			$idRelacionEspacioHospitalizacion 	= $_POST['idRelacionEspacioHospitalizacion'];
			
		
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Se ha dado de alta al paciente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="It has discharge the patient!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if(  ($fechaAlta == "") or ($horaAlta == "") ){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 
			 	$objetoHospitalizacion->guardarAlta($fechaAlta, $horaAlta, $observaciones, $cuidados, $estado, $idHospitalizacion, $idUsuario);
				
				if($estado == "No"){
					//modificar el estado del paciente
					require_once("Models/nuevoPacientePropietario_model.php");
					$objetoPaciente = new nuevo();
					$objetoPaciente->pacienteFallece($idPaciente);
				}

				//liberar el espacio de hospitalizacion
				$objetoHospitalizacion->desvincularEspacioHospitalizacionPaciente($idRelacionEspacioHospitalizacion);
				$objetoHospitalizacion->liberarEspacioHospitalizacion($idEspacioHospitalizacion);
				
				$_SESSION['mensaje']   = $ok;
				

				
			 }//fin sw == 0 	
			 
			 //se redirecciona nuevamente a hospitalizacion 
			 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/hospitalizacion/' );	
			 		
			exit();			
		
	}//fin if si llega alta
		
 //se consulta el total de las hospitalizaciones existentes
		$TotalHospitalizaciones = $objetoHospitalizacion->tatalHospitalizaciones($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoHospitalizaciones = $objetoHospitalizacion->listarHospitalizaciones($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar las hospitalizaciones segun los limites de la consulta
		
		$pagination->records($TotalHospitalizaciones);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación			
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>		 