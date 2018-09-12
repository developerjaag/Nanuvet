<?php

/*
 * Controlador para listar pacientes del propietario
 */
  
  
  //validar si llega el foirmulario d eun nuevo paciente
  if(isset($_POST['envioFormNuevopaciente']) AND $_POST['envioFormNuevopaciente'] == "envio"){
  	
	
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
			$urlFotoPaciente			= "";
			

			
			$sw        = 0;//para controlar si entra en un error
        
	        switch($idiomaIndex){
	            
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
						

				
				
					//se llama al metodo que guarda los datos del nuevo paciente
					$objetoReplica->guardarPaciente($idEspecie, $idRaza, $paciente_nombre, $paciente_chip, $paciente_sexo, $fechaNacimiento, $paciente_esterilizado,
							$paciente_color, $paciente_alimento, $frecuenciaAlimento, $paciente_bano, $urlFotoPaciente, $idPropietario);
			
										         		
	         	$_SESSION['mensaje'] = $ok;		

			}//fin if si todo va bien
	        
	        	
			
       		 	header('Location: '.Config::ruta().'replica/'.$_GET['id1'].'/' );		
				
			 exit();
	
	
  }//fin if si llega el formulario para guardar un paciente
  
  
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $listadoPacientes	= $objetoReplica->replica_listarPacientesPorPropietario($_GET['id1']);
 
 

?>