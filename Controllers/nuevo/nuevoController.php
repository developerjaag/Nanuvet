<?php

/*
 * Controlador para generar nuevos propietarios o pacientes
 */

    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
    	
		//si se envia el formulario de la busqueda de un propietario
		if( isset($_POST['envioFormBusqueda']) and $_POST['envioFormBusqueda'] == "envio" ){
				
			$_SESSION['idPropietario']			= $_POST['idPropietarioBusqueda'];	
			
			
		   if(($_GET['id1'] != 'iframe') and ($_GET['id2'] != 'iframe') and ($_GET['id3'] != 'iframe')){
	        			
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
       		 	header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/' );	

			}else{
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
       		 	header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/iframe/' );	
			}
			
			 		
			 exit();
				
		}	//fin if si se envia formulario de busqueda
		
		
		//se se realiza la busqueda desde el buscador general (Menu)
		if( isset($_GET['id1']) and is_numeric($_GET['id1']) ){
			$_SESSION['idPropietario']			= $_GET['id1'];	
			
		}//fin if validar variable GET
		
		//si se envia el formulario del nuevo propietario
		if( isset($_POST['hidden_envioForm']) and $_POST['hidden_envioForm'] == "enviar" ){
			
			
			//se reciben los datos
			$identificacion		= 	$_POST['propietario_identificacion'];
			$nombre				= 	$_POST['propietario_nombre'];
			$apellido			= 	$_POST['propietario_apellido'];
			$telefono			= 	$_POST['propietario_telefono'];
			$celular			= 	$_POST['propietario_celular'];
			$direccion			= 	$_POST['propietario_direccion'];
			$email				= 	$_POST['propietario_email'];
			$idPais				= 	$_POST['idPais'];
			$idCiudad			= 	$_POST['idCiudad'];
			$idBarrio			= 	$_POST['idBarrio'];
			
			
			$sw        = 0;//para controlar si entra en un error
        
	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
					if( isset($_POST['hidden_envioFormEditar']) ){
						$ok="Propietario editado correctamente!";
					}else{
						$ok="Propietario guardado correctamente!";	
					}
	        		
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
					if( isset($_POST['hidden_envioFormEditar']) ){
						$ok="Owner edit successfully!";
					}else{
						$ok="Owner saved successfully!";
					}
	        		
	        		break;
	            
	        }//fin swtich
	        
	        
	        //validar si algun campo obligatorio llega vacio
	        if(($identificacion == "") or ($nombre == "") or ($apellido == "") or ($telefono == "") or ($celular == "") or ($direccion == "") or ($email == "") or ($idPais == "") or ($idCiudad == "") or ($idBarrio == "")){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
	         
	         //si no exite error
	         if($sw == 0){
	         	
				//se importa el modelo
				require_once("Models/nuevoPacientePropietario_model.php"); 
				
				//se declara el objeto
				$objetoModel	= new nuevo();
				
				
				if( isset($_POST['hidden_envioFormEditar']) ){
					
						$idPropietarioForm = $_POST['idPropietarioForm'];
						$idPropietarioREPLICA = $_POST['idPropietarioREPLICA'];
						//se llama al metodo que edita los datos del propietario y consulta el id
						$idPropietario	= $objetoModel->editarPropietario($idPropietarioForm, $identificacion, $nombre, $apellido, $telefono, $celular, $direccion, $email, $idPais, $idCiudad, $idBarrio, $idPropietarioREPLICA);
				
						$_SESSION['idPropietario']			= $idPropietario;
						
				}else{
					//se llama al metodo que guarda los datos del nuevo propietario y consulta el id
					$idPropietario	= $objetoModel->guardarPropietario($identificacion, $nombre, $apellido, $telefono, $celular, $direccion, $email, $idPais, $idCiudad, $idBarrio);
				
					$_SESSION['idPropietario']			= $idPropietario['idPropietario'];
				}
			

				
	         
	         	$_SESSION['mensaje'] = $ok;
	         	
	         }//Fin if si no exite error
	         
	        if(($_GET['id1'] != 'iframe') and ($_GET['id2'] != 'iframe') and ($_GET['id3'] != 'iframe')){
	        			
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
       		 	header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/' );	

			}else{
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
       		 	header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/iframe/' );	
			}
	         
	         
			 		
			 exit();
			
		}//fin if si se envia el formulario	del nuevo propietario
		
		
		
		
		
		//si se envia el formulario del nuevo paciente
		if( isset($_POST['envioFormNuevopaciente']) and $_POST['envioFormNuevopaciente'] == "envio"  ){
			
			
			//se reciben los datos
			$idEspecie					= $_POST['idEspecie'];
			$idRaza						= $_POST['idRaza'];
			$paciente_nombre			= $_POST['paciente_nombre'];
			$paciente_chip				= $_POST['paciente_chip'];
			$paciente_sexo				= $_POST['paciente_sexo'];
			$fechaNacimiento			= $_POST['fechaNacimiento'];
			$paciente_esterilizado		= $_POST['paciente_esterilizado'];
			$paciente_color				= $_POST['paciente_color'];
			$paciente_alimento			= $_POST['paciente_alimento'];
			$frecuenciaAlimento			= $_POST['frecuenciaAlimento'];
			$paciente_bano				= $_POST['paciente_bano'];
			$idPropietario				= $_POST['idPropietarioPaciente'];
			$idPropietario_replica		= $_POST['idPropietarioPaciente_Replica'];
			$urlFotoPaciente			= "";
			$idReplica					= $_POST['idReplica'];
			
			$_SESSION['idPropietario'] = $idPropietario;

			
			$sw        = 0;//para controlar si entra en un error
        
	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
					$ok="Paciente guardado correctamente!";	
	        		
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
					$ok="Patient saved successfully!";
	        		
	        		break;
	            
	        }//fin swtich
	        
	         //validar si algun campo obligatorio llega vacio
	        if(($idEspecie == "") or ($idRaza == "") or ($paciente_nombre == "") or ( ($fechaNacimiento == "") or ($fechaNacimiento == "____/__/__") ) or ($paciente_color == "") or ($frecuenciaAlimento == "") ){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
	         
	         
	         //si todo va bien
	         if($sw == 0){
						
				//se verifica si tiene foto 	
	             if($_FILES['fotoPaciente']['tmp_name']!=""){
	                 		
		                 //validar el tipo de archivo subido
		                 if( ( $_FILES['fotoPaciente']['type'] == "image/jpg" ) or ( $_FILES['fotoPaciente']['type'] == "image/JPG" ) 
		                 		or ( $_FILES['fotoPaciente']['type'] == "image/png" ) or ( $_FILES['fotoPaciente']['type'] == "image/PNG" ) 
		                 		or ( $_FILES['fotoPaciente']['type'] == "image/jpeg" ) or ( $_FILES['fotoPaciente']['type'] == "image/JPEG" )  ){
		                     
		                     //se copia el archivo en el servidor
		                     
		                     //se construye el nombre para el archivo
		                     $nombreArchivo = $idPropietario."_".$paciente_nombre."_".$paciente_sexo;
							 $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre						     
						     $tmpNombreFotoServidor = $_FILES["fotoPaciente"]["tmp_name"];  //nombre que el  servidor le da al archivo
						     
						     $ext = explode(".", $_FILES["fotoPaciente"]["name"]); // se toma la extension del archivo
						     
						     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/img_pacientes/";
						     //si no existe la ruta se crea
						     if(!is_file($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreFotoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/img_pacientes/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						     $urlFotoPaciente   = $nombreArchivo;				     
						     
							
		                     
		                 }//fin if validar tipo de archivo
		                 
	                 }//fin if para saber si se ingreso foto
				
					
				//se importa el modelo
				require_once("Models/nuevoPacientePropietario_model.php"); 
				
				//se declara el objeto
				$objetoModel	= new nuevo();
				
				
					//se llama al metodo que guarda los datos del nuevo paciente
					$objetoModel->guardarPaciente($idEspecie, $idRaza, $paciente_nombre, $paciente_chip, $paciente_sexo, $fechaNacimiento, $paciente_esterilizado,
							$paciente_color, $paciente_alimento, $frecuenciaAlimento, $paciente_bano, $urlFotoPaciente, $idPropietario, $idPropietario_replica, $idReplica );
			
					
	         			
				$_SESSION['PacienteCreado'] = 'Si';
					         		
	         	$_SESSION['mensaje'] = $ok;			
				
	         }//fin if si todo va bien
	        
	        
	        if(($_GET['id1'] != 'iframe') and ($_GET['id2'] != 'iframe') and ($_GET['id3'] != 'iframe')){
	        			
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
       		 	header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/' );	

			}else{
						
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
       		 	header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/iframe/' );		
				
			}
	        
			 exit();
			
			
		}//fin if si se envia el formulario del nuevo paciente
		
		
		
		
		
		
		//si se envia el formulario de la edicion del paciente
		if( isset($_POST['envioFormEditarpaciente']) and $_POST['envioFormEditarpaciente'] == "envio"  ){
		
			//se reciben las variables
			$idPropietarioPaciente 		= $_POST['editarPacinete_idPropietarioPaciente'];
			$idEspecie 					= $_POST['editarPacinete_idEspecie'];
			$idRaza 					= $_POST['editarPacinete_idRaza'];
			$idPaciente 				= $_POST['editarPacinete_idPaciente'];
			$paciente_estado 			= $_POST['editarPacinete_paciente_estado'];
			$paciente_nombre 			= $_POST['editarPacinete_paciente_nombre'];
			$paciente_chip 				= $_POST['editarPacinete_paciente_chip'];
			$paciente_sexo 				= $_POST['editarPacinete_paciente_sexo'];
			$fechaNacimiento 			= $_POST['editarPacinete_fechaNacimiento'];
			$paciente_esterilizado 		= $_POST['editarPacinete_paciente_esterilizado'];
			$paciente_color 			= $_POST['editarPacinete_paciente_color'];
			$paciente_alimento 			= $_POST['editarPacinete_paciente_alimento'];
			$frecuenciaAlimento 		= $_POST['editarPacinete_frecuenciaAlimento'];
			$paciente_bano 				= $_POST['editarPacinete_paciente_bano'];
			$urlFotoPaciente			= "";
			
			$_SESSION['idPropietario'] = $idPropietarioPaciente;
			
			$sw        = 0;//para controlar si entra en un error
        
	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
					$ok="Paciente editado correctamente!";
	        		
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
					$ok="Patient edit successfully!";
	        		
	        		break;
	            
	        }//fin swtich

			
			//validar si algun campo obligatorio llega vacio
	        if( ($idPropietarioPaciente == "") or  ($idPaciente == "") or ($paciente_estado == "") or ($idEspecie == "") or ($idRaza == "") or ($paciente_nombre == "") or ( ($fechaNacimiento == "") or ($fechaNacimiento == "____/__/__") ) or ($paciente_color == "") or ($frecuenciaAlimento == "") ){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
		
		
			  //si todo va bien
	         if($sw == 0){
						
				//se verifica si tiene foto 	
	             if($_FILES['editarPacinete_fotoPaciente']['tmp_name']!=""){
	                 		
		                 //validar el tipo de archivo subido
		                 if( ( $_FILES['editarPacinete_fotoPaciente']['type'] == "image/jpg" ) or ( $_FILES['editarPacinete_fotoPaciente']['type'] == "image/JPG" ) 
		                 		or ( $_FILES['editarPacinete_fotoPaciente']['type'] == "image/png" ) or ( $_FILES['editarPacinete_fotoPaciente']['type'] == "image/PNG" ) 
		                 		or ( $_FILES['editarPacinete_fotoPaciente']['type'] == "image/jpeg" ) or ( $_FILES['editarPacinete_fotoPaciente']['type'] == "image/JPEG" )  ){
		                     
		                     //se copia el archivo en el servidor
		                     
		                     //se construye el nombre para el archivo
		                     $nombreArchivo = $idPropietarioPaciente."_".$paciente_nombre."_".$paciente_sexo;
							 $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre						     
						     $tmpNombreFotoServidor = $_FILES["editarPacinete_fotoPaciente"]["tmp_name"];  //nombre que el  servidor le da al archivo
						     
						     $ext = explode(".", $_FILES["editarPacinete_fotoPaciente"]["name"]); // se toma la extension del archivo
						     
						     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/img_pacientes/";
						     //si no existe la ruta se crea
						     if(!is_file($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreFotoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/img_pacientes/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						     $urlFotoPaciente   = $nombreArchivo;				     
						     
							
		                     
		                 }//fin if validar tipo de archivo
		                 
	                 }//fin if para saber si se ingreso foto
				
					
				//se importa el modelo
				require_once("Models/nuevoPacientePropietario_model.php"); 
				
				//se declara el objeto
				$objetoModel	= new nuevo();

				
					//se llama al metodo que guarda los datos del nuevo paciente
					$objetoModel->editarPaciente($idPropietarioPaciente, $idEspecie, $idRaza, $idPaciente, $paciente_estado, $paciente_nombre, $paciente_chip,
												 $paciente_sexo, $fechaNacimiento, $paciente_esterilizado, $paciente_color, $paciente_alimento, $frecuenciaAlimento,
												 $paciente_bano, $urlFotoPaciente);
			
					
	         			
				$_SESSION['PacienteCreado'] = 'Si';
					         		
	         	$_SESSION['mensaje'] = $ok;			
				
	         }//fin if si todo va bien
	         
	        if(($_GET['id1'] != 'iframe') and ($_GET['id2'] != 'iframe') and ($_GET['id3'] != 'iframe')){
	        			
	        
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
	       		 header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/' );	

			}else{
				
				//se redirecciona nuevamente a nuevo (con las variables de sesion conteniendo los datos del nuevo propietario)
	       		 header('Location: '.Config::ruta().'nuevo/'.$_SESSION['idPropietario'].'/iframe' );						
								
			}
	        	         

			 		
			 exit();
		
		
		}//fin if si se envia el formulario de editar un paciente
		
		
		
		
		
		
		
		
		
		//funcion para calcular el tiempo de vida con php
		function tiempoTranscurridoFechas($fechaInicio){
			    $fecha1 = new DateTime($fechaInicio);
			    $fecha2 = new DateTime();
			    $fecha = $fecha1->diff($fecha2);
			    $tiempo = "";
			         
			    //años
			    if($fecha->y > 0)
			    {
			        $tiempo .= $fecha->y;
			             
			        if($fecha->y == 1)
			            $tiempo .= " año, ";
			        else
			            $tiempo .= " años, ";
			    }
			         
			    //meses
			    if($fecha->m > 0)
			    {
			        $tiempo .= $fecha->m;
			             
			        if($fecha->m == 1)
			            $tiempo .= " mes, ";
			        else
			            $tiempo .= " meses, ";
			    }
			         
			    //dias
			    if($fecha->d > 0)
			    {
			        $tiempo .= $fecha->d;
			             
			        if($fecha->d == 1)
			            $tiempo .= " día ";
			        else
			            $tiempo .= " días ";
			    }
			         
			    // //horas
			    // if($fecha->h > 0)
			    // {
			        // $tiempo .= $fecha->h;
// 			             
			        // if($fecha->h == 1)
			            // $tiempo .= " hora, ";
			        // else
			            // $tiempo .= " horas, ";
			    // }
			         
			    // //minutos
			    // if($fecha->i > 0)
			    // {
			        // $tiempo .= $fecha->i;
// 			             
			        // if($fecha->i == 1)
			            // $tiempo .= " minuto";
			        // else
			            // $tiempo .= " minutos";
			    // }
			    // else if($fecha->i == 0) //segundos
			        // $tiempo .= $fecha->s." segundos";
			         
			    return $tiempo;
			}//fin funcion tiempo de vida php
		
		
		
		
		
            
        //se importan los layout modales de crear , ciudad y barrio
        require_once("Views/Layout/modals/modal_nuevaCiudad.phtml");
        require_once("Views/Layout/modals/modal_nuevoBarrio.phtml");

	
		if(!in_array("iframe", $_GET)){		
			//se importa el layout del menu
        	require_once("Views/Layout/menu.phtml");
		}		
		
		   /*	$_SESSION['idPropietario']		= "1";
			$_SESSION['propietario_nombre']	= "Jheison";
			$_SESSION['propietario_apellido'] = "Alzate";*/
		
		//se valida si existen las variables de session del propietario para saber que vista mostrar (Nuevo propietario o listado y nuevo paciente)
		if( ( (isset($_SESSION['idPropietario']) and $_SESSION['idPropietario'] != '')  ) 
			or ( (isset($_SESSION['PacienteCreado']) and $_SESSION['PacienteCreado'] != '')  ) ){
			
			//se consulta la cantidad de pacientes del propietario	
			
			//se importa el modelo
			require_once("Models/nuevoPacientePropietario_model.php"); 
			
			//se declara el objeto
			$objetoModel	= new nuevo();
			
			$idPropietario	= $_SESSION['idPropietario'];
			
			//se consultan todos los datos del propietario para llevarlos al formulario de edicion
			$todaInformacionPropietario	= $objetoModel->ConsultarInformacionPropietario($idPropietario);
			
			//se consulta la informacion del propietario en la base de datos de REPLICA
			$informacionPropietario_REPLICA	= $objetoModel->consultarInfoPropietario_Replica($todaInformacionPropietario['identificacion']);
			
					/*Validar si la informacion de REPLICA y la local coinciden*/
					$noCoincideInformacionPropietario = "";
					$noCoincideInformacionPropietarioMuestraForm = "";
					
					if(sizeof($informacionPropietario_REPLICA) > 0){						
					
						if($informacionPropietario_REPLICA['nombre'] != $todaInformacionPropietario['nombre']){
							$noCoincideInformacionPropietario = 'No coinciden';
							$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
						}
						if($informacionPropietario_REPLICA['apellido'] != $todaInformacionPropietario['apellido']){
							$noCoincideInformacionPropietario = 'No coinciden';
							$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
						}
						if($informacionPropietario_REPLICA['telefono'] != $todaInformacionPropietario['telefono']){
							$noCoincideInformacionPropietario = 'No coinciden';
							$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
						}
						if($informacionPropietario_REPLICA['celular'] != $todaInformacionPropietario['celular']){
							$noCoincideInformacionPropietario = 'No coinciden';
							$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
						}
						if($informacionPropietario_REPLICA['direccion'] != $todaInformacionPropietario['direccion']){
							$noCoincideInformacionPropietario = 'No coinciden';
							$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
						}
						if($informacionPropietario_REPLICA['email'] != $todaInformacionPropietario['email']){
							$noCoincideInformacionPropietario = 'No coinciden';
							$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
						}
					
					}else{
						$noCoincideInformacionPropietario = 'No coinciden';
						$noCoincideInformacionPropietarioMuestraForm	= 'No coinciden';
					}
					/*Fin Validar si la informacion de REPLICA y la local coinciden*/
			
			//se llama al metodo para listar los pacientes
			$listadoPacientes	= $objetoModel->listarPacientesPorPropietario($idPropietario);
			
			if(sizeof($informacionPropietario_REPLICA) > 0){
				//se llama al metodo para listar los pacientes en la REPLICA
				$listaPacientes_REPLICA = $objetoModel->listarPacientesPorPropietario_REPLICA($informacionPropietario_REPLICA['idPropietario']);	
			}
				
			$swImportar = 1;
			$pacienterParaIMportarDesdeREPLICA = array();
			
			
			$idsReplicaEnPacientes = array();
			
			foreach ($listadoPacientes as $listadoPacientes1) {
						
						
						$idsReplicaEnPacientes[]	= $listadoPacientes1['idReplica'];
						
						/*if($listadoPacientes1['idReplica'] ==  $listaPacientes_REPLICA1['idPaciente']){
							$swImportar = 0;
							break;
						}else{
							$swImportar = 1;
						}*/
						
			}//fin foreach para llenar los ids de replica
			
			
			if(sizeof($informacionPropietario_REPLICA) > 0){
			
				foreach ($listaPacientes_REPLICA as $listaPacientes_REPLICA1) {
					
					if(in_array($listaPacientes_REPLICA1['idMascota'],$idsReplicaEnPacientes, TRUE)){
						$swImportar = 0;
					}else{
						$swImportar = 1;
					}
					
					if($swImportar == 1 and $listaPacientes_REPLICA1['estado'] == 'vivo'){
						
						$pacienterParaIMportarDesdeREPLICA[] = array('idPaciente' => $listaPacientes_REPLICA1['idMascota'], 
																		'nombrePaciente' =>  $listaPacientes_REPLICA1['nombre'],
																		'numeroChip' =>  $listaPacientes_REPLICA1['numeroChip'],
																		'sexo' =>  $listaPacientes_REPLICA1['sexo'],
																		'esterilizado' =>  $listaPacientes_REPLICA1['esterilizado'],
																		'color' =>  $listaPacientes_REPLICA1['color'],
																		'fechaNacimiento' =>  $listaPacientes_REPLICA1['fechaNacimiento'],
																		'alimento' =>  $listaPacientes_REPLICA1['alimento'],
																		'frecuenciaDiaria' =>  $listaPacientes_REPLICA1['frecuenciaDiaria'],
																		'frecuenciaBanoDias' =>  $listaPacientes_REPLICA1['frecuenciaBanoDias']
																	);
					}//fin si el paciente esta vivo en la replica
					
				}//fin foreach
			
			}//fin if sino existe el propietario en la replica
			
			//se importa la vista del listado y nuevo paciente
			require_once("Views/nuevo/listadoNuevoPaciente.phtml");			
			
		}else{
			
				//permiso crear propietario
				if(!in_array("59", $_SESSION['permisos_usuario'] )){
					
					require_once("Views/Layout/sinPermiso.phtml");	
					
				}else{
					//se importa la vista del nuevo propietario
					require_once("Views/nuevo/nuevo.phtml");
				}
			
							
			
		}//fin else	

		if(!in_array("iframe", $_GET)){		
			//se importa el footer
        	require_once("Views/Layout/footer.phtml");	
		}
		
			
		
		//se destuyen las variables de sesion que contienen los datos del propietario, ya debieron quedar en input
		unset ($_SESSION['idPropietario']);
		unset ($_SESSION['propietario_nombre']);
		unset ($_SESSION['propietario_apellido']);
		unset ($_SESSION['PacienteCreado']);
		
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    }  
?>
