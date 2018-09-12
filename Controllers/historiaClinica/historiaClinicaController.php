<?php


/*
 * Archivo para mostrar el contenido de la historia clinica d eun paciente
 */
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 	
			//se intancia el modelo de los pacientes, para mostrar sus datos
			require_once ("Models/nuevoPacientePropietario_model.php");
			//se importa el modelo de hospitalizacion 
			require_once ("Models/hospitalizacion_model.php");
			$objetoPacientePropietario = new nuevo();
			$objetoHospitalizacionComprobar	= new hospitalizacion();
			
			$comprobarHospitalizacionActiva = $objetoHospitalizacionComprobar->comprobarAltaHospitalizacion($_GET['id1']);

			
			if(isset($_GET['id1'])){
				$datosPropietarioPaciente = $objetoPacientePropietario->consultarDatosPropietarioPaciente($_GET['id1']);
				
				$datosPP_idPropietario				= $datosPropietarioPaciente[0]['idPropietario'];
				$datosPP_identificacionPropietario	= $datosPropietarioPaciente[0]['identificacion'];
				$datosPP_nombrePropietario			= $datosPropietarioPaciente[0]['nombrePropietario'];
				$datosPP_apellidoPropietario		= $datosPropietarioPaciente[0]['apellido'];
				$datosPP_celularPropietario			= $datosPropietarioPaciente[0]['celular'];
				
				$datosPP_nombrePaciente				= $datosPropietarioPaciente[0]['nombrePaciente'];
				$datosPP_fechaNacimientoPaciente	= $datosPropietarioPaciente[0]['fechaNacimiento'];
				$datosPP_urlFotoPaciente			= $datosPropietarioPaciente[0]['urlFoto'];
				$datosPP_estadoPaciente				= $datosPropietarioPaciente[0]['estado'];
				$datosPP_sexoPaciente				= $datosPropietarioPaciente[0]['sexo'];
				$datosPP_esterilizadoPaciente		= $datosPropietarioPaciente[0]['esterilizado'];
				$datosPP_nombreRazaPaciente			= $datosPropietarioPaciente[0]['nombreRaza'];
				$datosPP_idReplica					= $datosPropietarioPaciente[0]['idReplica'];
				
				
				
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
							         
							    return $tiempo;
							}//fin funcion tiempo de vida php
							
					$datosPP_edadPacientePaciente 		= tiempoTranscurridoFechas($datosPP_fechaNacimientoPaciente);
				
				
			}//fin if si llega el id del paciente por get id1
			
			//se llama al metodo que consulta datos del propietario y del paciente
	
			//se importa el controlador segun el item de la HC
			if(isset($_GET['id2'])){
				
				if(is_file("Controllers/historiaClinica/".$_GET['id2']."/".$_GET['id2']."Controller.php")){
					//se importa el controlador de apoyo
					require_once("Controllers/historiaClinica/".$_GET['id2']."/".$_GET['id2']."Controller.php");
				}else{
					//se importa el controlador de consultas por defecto
					require_once("Controllers/historiaClinica/consultas/consultasController.php");
				}
				
			}
	
	
			//se consultan los metodo para totalizar la cantidad de elementos de la historia clinica
			$menuTotalCirugias			= $objetoPacientePropietario->totalCirugiasPaciente($_GET['id1']);
			$menuTotalConsultas			= $objetoPacientePropietario->totalConsultasPaciente($_GET['id1']);
			$menuDesparasitantes		= $objetoPacientePropietario->totalDesparasitantesPaciente($_GET['id1']);
			$menuTotalExamenes			= $objetoPacientePropietario->totalExamenesPaciente($_GET['id1']);
			$menuTotalFormulas			= $objetoPacientePropietario->totalFormulasPaciente($_GET['id1']);
			$menuTotalHospitalizaciones	= $objetoPacientePropietario->totalHospitalizacionesPaciente($_GET['id1']);
			$menuTotalVacunas			= $objetoPacientePropietario->totalVacunasPaciente($_GET['id1']);
	
	
            //se importa el layout del menu
            require_once("Views/Layout/menu.phtml");
			if(isset($_GET['id2'])){
				
				if( is_file("Views/historiaClinica/".$_GET['id2']."/".$_GET['id2'].".phtml") ){
					//se importa la vista que corresponda al item de historia clinica
					require_once("Views/historiaClinica/".$_GET['id2']."/".$_GET['id2'].".phtml");
				}else{
					//se importa la vista de consultas por defecto
					require_once("Views/historiaClinica/consultas/consultas.phtml");
				}				
				
			}else{
				//se importa la vista de consultas por defecto
				require_once("Views/historiaClinica/consultas/consultas.phtml");
			}
			
	
			//se importa el footer
            require_once("Views/Layout/footer.phtml");
	
     }else{
        header('Location: '.Config::ruta());
		exit();
    }	


?>