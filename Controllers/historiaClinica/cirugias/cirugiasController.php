<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){


 		//se importa el modelo
		require_once("Models/cirugias_model.php"); 

		//se declara el objeto
		$objetoCirugias	= new cirugias();




		//validar si se envia el formulario con archivos adjuntos
		if(isset($_POST['envioArchivosAdjuntos']) and $_POST['envioArchivosAdjuntos'] == "adjuntosCirugia"){
			
			//se recibe la variable que contiene el id de la cirugia
			$idCirugiaEnvioAdjunto	= $_POST['idCirugiaAdjuntos'];
			
			
			$totalAdjuntos	= count($_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]['name']);
			
			
			
			// Loop through each file
			for($i=0; $i<$totalAdjuntos; $i++) {
				
				
			  //Get the temp file path
			  $tmpFilePath = $_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]['tmp_name'][$i];		
			  			
			
			  //Make sure we have a filepath
			  if ($tmpFilePath != ""){
			    
				$tmpNombreFotoServidor = $_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]["tmp_name"][$i];  //nombre que el  servidor le da al archivo
				$ext = explode(".", $_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]["name"][$i]); // se toma la extension del archivo
				
				$ext = $ext[1];
				//validar la extension
				if( ($ext == 'PNG') or ($ext == 'png') or ($ext == 'jpg') or ($ext == 'JPG') or ($ext == 'jpeg') or ($ext == 'JPEG') or ($ext == 'PDF') or ($ext == 'pdf')
						or ($ext == 'DOC') or ($ext == 'doc') or ($ext == 'txt') or ($ext == 'TXT') or ($ext == 'XLS') or ($ext == 'xls') or ($ext == 'xlsx') or ($ext == 'XSLX')
						or ($ext == 'mp4') or ($ext == 'avi')or ($ext == 'wmv') ){
							
							
			 
							
						//validar el tamaño del archivo
						if($_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]["size"][$i] > 5242880){
							$_SESSION['mensaje'] = "Existen archivos que superan el tamaño permitido de 5M";
						}else {
							 
							//se construye el nombre para el archivo
		                     $nombreArchivo = $idCirugiaEnvioAdjunto."_".$_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]["name"][$i];
							 $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre
						     
						     $tmpNombreArchivoServidor = $_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]["tmp_name"][$i];  //nombre que el  servidor le da al archivo
						   						    
						     //$nombreArchivo = $nombreArchivo; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/adjuntos_pacientes/".$_POST['idPropietarioAdjuntos']."/".$_POST['idPacienteAdjuntos'];
						     //si no existe la ruta se crea
						     if(!file_exists($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreArchivoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/adjuntos_pacientes/".$_POST['idPropietarioAdjuntos']."/".$_POST['idPacienteAdjuntos']."/".$nombreArchivo);//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						    $peso = $_FILES['archivosAdjuntosCirugia_'.$idCirugiaEnvioAdjunto]["size"][$i];
							
							
							
							$objetoCirugias->guardarArchivoAdjuntoCirugia($idCirugiaEnvioAdjunto, $nombreArchivo, $peso, $_SESSION['usuario_idUsuario']);
							
							
							$_SESSION['mensaje'] = "Todo salió bien!";
							
						}//fin else si el tamaño es permitido
					
				}else{
					
							$_SESSION['mensaje'] = "Existen archivos que no cumplen con las extensiones permitidas";
					
				}//fin else validar extension
				
				
			  }//fin if si tiene ruta
			  
			}//fin for
			
				
				//se redirecciona nuevamente a consultas 
				 header('Location: '.Config::ruta().'historiaClinica/'.$_POST['idPacienteAdjuntos'].'/cirugias/' );	
				 		
				exit();	
		}//fin validar si se envian adjuntos






		//validar si se envia el formulario de un nueva cirugia
		if(isset($_POST['envioNuevoCirugia']) and $_POST['envioNuevoCirugia'] == "envio" ){
			
			
			//se reciben las variables
			$idPaciente		= $_POST['idPaciente'];
			$idPacienteReplica	= $_POST['idPacienteReplica'];
			$edadActual		= $_POST['edadActualPaciente'];
			
			$motivoCirugia	= trim($_POST['motivoCirugia']);
			$observaciones	= trim($_POST['observacionesCirugia']);
			$tipoAnestesia  = $_POST['tipoAnestesia'];
			
			$diagnosticos	= $_POST['select_cirugias'];
			
			$complicaciones	= trim($_POST['complicacionesCirugia']);
			$plan			= trim($_POST['planCirugia']);
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Cirugía guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Surgery saved successfully!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if(sizeof($diagnosticos)<=0){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$idCirugiaGuardada  = $objetoCirugias->guardarCirugia($motivoCirugia, $observaciones, $tipoAnestesia, $complicaciones, $plan, $edadActual, $idPaciente, $idUsuario, $_SESSION['sucursalActual_idSucursal'], $idPacienteReplica);
		        
				
				//guardar los diagnosticos de cirugia
				foreach ($_POST['select_cirugias'] as $selectedDX) {					
					
					$objetoCirugias->guardarDxCirugia($selectedDX,$idCirugiaGuardada[0],$idCirugiaGuardada[1]);
					
				}//fin foreach
				
				//comprobar si el paciente esta hospitalizado
				if(sizeof($comprobarHospitalizacionActiva) > 0){
					$objetoCirugias->relacionarCirugiaHospitalizacion($idCirugiaGuardada[0],$comprobarHospitalizacionActiva[0]['idHospitalizacion']);
				}
					        	
				
				$_SESSION['mensaje']   = $ok;
				
				//se redirecciona nuevamente a cirugias 
				 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/cirugias/' );	
				 		
				exit();	
				
			 }//fin sw == 0 		     
		     		    			
			
		}//fin validar si llega una nueva cirugias		


 //se consulta el total de las consultas existentes
		$TotalCirugias = $objetoCirugias->tatalCirugias($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metodo por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoCirugias = $objetoCirugias->listarCirugias($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar las consultas segun los limites de la consulta
		
		$pagination->records($TotalCirugias);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación		
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>		 