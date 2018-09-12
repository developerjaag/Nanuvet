<?php

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){ 



 		//se importa el modelo
		require_once("Models/consultas_model.php"); 

		//se declara el objeto
		$objetoConsultas	= new consultas();
		
		//validar si se envia el formulario con archivos adjuntos
		if(isset($_POST['envioArchivosAdjuntos']) and $_POST['envioArchivosAdjuntos'] == "adjuntosConsulta"){
			
			//se recibe la variable que contiene el id de la consulta
			$idConsultaEnvioAdjunto	= $_POST['idConsultaAdjuntos'];
			
			
			$totalAdjuntos	= count($_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]['name']);
			
			
			
			// Loop through each file
			for($i=0; $i<$totalAdjuntos; $i++) {
				
				
			  //Get the temp file path
			  $tmpFilePath = $_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]['tmp_name'][$i];		
			  			
			
			  //Make sure we have a filepath
			  if ($tmpFilePath != ""){
			    
				$tmpNombreFotoServidor = $_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]["tmp_name"][$i];  //nombre que el  servidor le da al archivo
				$ext = explode(".", $_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]["name"][$i]); // se toma la extension del archivo
				
				$ext = $ext[1];
				//validar la extension
				if( ($ext == 'PNG') or ($ext == 'png') or ($ext == 'jpg') or ($ext == 'JPG') or ($ext == 'jpeg') or ($ext == 'JPEG') or ($ext == 'PDF') or ($ext == 'pdf')
						or ($ext == 'DOC') or ($ext == 'doc') or ($ext == 'txt') or ($ext == 'TXT') or ($ext == 'XLS') or ($ext == 'xls') or ($ext == 'xlsx') or ($ext == 'XSLX')
						or ($ext == 'mp4') or ($ext == 'avi')or ($ext == 'wmv') ){
							
							
			 
							
						//validar el tamaño del archivo
						if($_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]["size"][$i] > 5242880){
							$_SESSION['mensaje'] = "Existen archivos que superan el tamaño permitido de 5M";
						}else {
							 
							//se construye el nombre para el archivo
		                     $nombreArchivo = $idConsultaEnvioAdjunto."_".$_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]["name"][$i];
							 $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre
						     
						     $tmpNombreArchivoServidor = $_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]["tmp_name"][$i];  //nombre que el  servidor le da al archivo
						   						    
						     //$nombreArchivo = $nombreArchivo; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/adjuntos_pacientes/".$_POST['idPropietarioAdjuntos']."/".$_POST['idPacienteAdjuntos'];
						     //si no existe la ruta se crea
						     if(!file_exists($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreArchivoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/adjuntos_pacientes/".$_POST['idPropietarioAdjuntos']."/".$_POST['idPacienteAdjuntos']."/".$nombreArchivo);//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						    $peso = $_FILES['archivosAdjuntosConsulta_'.$idConsultaEnvioAdjunto]["size"][$i];
							
							
							
							$objetoConsultas->guardarArchivoAdjuntoConsulta($idConsultaEnvioAdjunto, $nombreArchivo, $peso, $_SESSION['usuario_idUsuario']);
							
							
							$_SESSION['mensaje'] = "Todo salió bien!";
							
						}//fin else si el tamaño es permitido
					
				}else{
					
							$_SESSION['mensaje'] = "Existen archivos que no cumplen con las extensiones permitidas";
					
				}//fin else validar extension
				
				
			  }//fin if si tiene ruta
			  
			}//fin for
			
			
		
				
				//se redirecciona nuevamente a consultas 
				 header('Location: '.Config::ruta().'historiaClinica/'.$_POST['idPacienteAdjuntos'].'/consultas/' );	
				 		
				exit();	
		}//fin validar si se envian adjuntos

		//validar si se envia el formulario de un nueva consulta
		if(isset($_POST['envioNuevoConsulta']) and $_POST['envioNuevoConsulta'] == "envio" ){
			

			
			//se reciben las variables
			$idPaciente		= $_POST['idPaciente'];
			$idPacienteReplica	= $_POST['idPacienteReplica'];
			$edadActual		= $_POST['edadActualPaciente'];
			
			$motivoConsulta	= trim($_POST['motivoConsulta']);
			$observaciones	= trim($_POST['observacionesConsulta']);
			
			$diagnosticos	= $_POST['select_diagnosticos'];
			
			$plan			= trim($_POST['planConsulta']);
			
			$peso			= trim($_POST['pesoExamenF']);
			$altura			= trim($_POST['alturaExamenF']);
			$temperatura	= trim($_POST['temperaturaExamenF']);
			$observacionesExamenFisico	= trim($_POST['observacionesExamenF']);
			
			$contadorLIIEF	= $_POST['contadorLIIEF'];
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Consulta guardada correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="consultation saved successfully!";
		    		break;
		        
		    }//fin swtich			

		    
		    
		    //validar si algun campo obligatorio llega vacio
		    if(sizeof($diagnosticos)<=0){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos			    

		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$idConsultaGuardada  = $objetoConsultas->guardarConsulta($motivoConsulta, $observaciones, $plan, $edadActual, $idPaciente, $idUsuario, $_SESSION['sucursalActual_idSucursal'], $idPacienteReplica);
		        
				
				//guardar los diagnosticos d econsulta
				foreach ($_POST['select_diagnosticos'] as $selectedDX) {					
					
					$objetoConsultas->guardarDxConsulta($selectedDX,$idConsultaGuardada[0],$idConsultaGuardada[1] );
					
				}//fin foreach
				
				//exit;
				//para guardar lo del examen fisico
				if( ($peso != "") OR ($altura != "") OR ($temperatura != "") OR ($observacionesExamenFisico != "") OR ($contadorLIIEF > "0" )  ){
								
					$idExamenFisicoGuardado = 	$objetoConsultas->guardarExamenFisico($peso, $altura, $temperatura, $observacionesExamenFisico, $idConsultaGuardada[0], $idConsultaGuardada[1]);	
						
					
				}//fin if para guardar examen fisico
				
				//para guardar los items que se adicionen al examen fisico
				if($contadorLIIEF > "0"){
					
					for ($i=1; $i <= $contadorLIIEF; $i++) { 
						
						$nombre 		= trim($_POST['iEFNombre_'.$i]);
						$observacion 	= trim($_POST['iEFObservacion_'.$i]);
						$estadoRevision = $_POST['iEFEstado_'.$i];
						
						$objetoConsultas->guardarItemAdicionalExamenFisico($nombre,$observacion,$estadoRevision,$idExamenFisicoGuardado[0],$idExamenFisicoGuardado[1]);
						
						
					}//fin for
					
				}//fin if para guardar los itesm adicionales de examen fisico
					        	
				
				$_SESSION['mensaje']   = $ok;


				//comprobar si el paciente esta hospitalizado
				if(sizeof($comprobarHospitalizacionActiva) > 0){
					$objetoConsultas->relacionarConsultaHospitalizacion($idConsultaGuardada[0],$comprobarHospitalizacionActiva[0]['idHospitalizacion']);
				}	

				
				//se redirecciona nuevamente a consultas 
				 header('Location: '.Config::ruta().'historiaClinica/'.$idPaciente.'/consultas/' );	
				 		
				exit();	
				
			 }//fin sw == 0 		     
		     		    			
			
		}//fin validar si llega una nueva consulta		
		
		
 //se consulta el total de las consultas existentes
		$TotalConsultas = $objetoConsultas->tatalConsultas($_GET['id1']);	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id3');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoConsultas = $objetoConsultas->listarConsultas($_GET['id1'],$paginaActual,$records_per_page);//se llama al metodo para listar las consultas segun los limites de la consulta
		
		$pagination->records($TotalConsultas);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación		
		
		
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>