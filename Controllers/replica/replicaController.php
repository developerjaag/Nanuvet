<?php


/*
 * Controlador a nivel general de la replica
 */
 	
			//se intancia el modelo de los pacientes, para mostrar sus datos
			require_once ("Models/replica_model.php");
			
			$objetoReplica = new replica();
			
				
				
				
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
							
					//$datosPP_edadPacientePaciente 		= tiempoTranscurridoFechas($datosPP_fechaNacimientoPaciente);
				

			
			//se llama al metodo que consulta datos del propietario y del paciente
	
			//se importa el controlador segun el item de la HC
			
			
			if(isset($_GET['id4'])){
				
				if(is_file("Controllers/replica/historiaClinica/".$_GET['id4']."/".$_GET['id4']."Controller.php")){
					//se importa el controlador de apoyo
					require_once("Controllers/replica/historiaClinica/".$_GET['id4']."/".$_GET['id4']."Controller.php");
				}else{
					//se importa el controlador de listar pacientes por defecto
					require_once("Controllers/replica/pacientes/listarPacientesController.php");
				}
				
			}else{

						if(isset($_GET['id2'])){
							
							if(is_file("Controllers/replica/".$_GET['id2']."/".$_GET['id2']."Controller.php")){
								//se importa el controlador de apoyo
								require_once("Controllers/replica/".$_GET['id2']."/".$_GET['id2']."Controller.php");
							}else{
								//se importa el controlador de listar pacientes por defecto
								require_once("Controllers/replica/pacientes/listarPacientesController.php");
							}
							
						}else{
							require_once("Controllers/replica/pacientes/listarPacientesController.php");
						}
	
			}//fin else si no existe id4 o item de la historia clinica
			
			//se consultan los metodo para totalizar la cantidad de elementos de la historia clinica
			
			$menuTotalCirugias			= $objetoReplica->total_cirugias($_GET['id2']);
			$menuTotalConsultas			= $objetoReplica->total_consultas($_GET['id2']);
			$menuDesparasitantes		= $objetoReplica->total_desparasitantes($_GET['id2']);
			$menuTotalExamenes			= $objetoReplica->total_examenes($_GET['id2']);
			$menuTotalFormulas			= $objetoReplica->total_formulas($_GET['id2']);
			$menuTotalVacunas			= $objetoReplica->total_vacunas($_GET['id2']);
			$menuTotalAntipulgas		= $objetoReplica->total_antipulgas($_GET['id2']);
			
			/*
			$menuTotalHospitalizaciones	= $objetoPacientePropietario->totalHospitalizacionesPaciente($_GET['id1']);
			*/
	
	
            //se importa el layout del menu
            require_once("Views/Layout/menuReplica.phtml");
            
            
			if(isset($_GET['id4'])){
				
				if( is_file("Views/replica/historiaClinica/".$_GET['id4']."/".$_GET['id4'].".phtml") ){
					//se importa la vista que corresponda al item de historia clinica
					require_once("Views/replica/historiaClinica/".$_GET['id4']."/".$_GET['id4'].".phtml");
				}else{
					//se importa la vista de pacientes por defecto
					require_once("Views/replica/pacientes/listarPacientes.phtml");
				}				
				
			}else{
    
					if(isset($_GET['id2'])){
						
						if( is_file("Views/replica/".$_GET['id2']."/".$_GET['id2'].".phtml") ){
							//se importa la vista que corresponda al item de historia clinica
							require_once("Views/replica/".$_GET['id2']."/".$_GET['id2'].".phtml");
						}else{
							//se importa la vista de pacientes por defecto
							require_once("Views/replica/pacientes/listarPacientes.phtml");
						}				
						
					}else{
						//se importa la vista de pacientes por defecto
						require_once("Views/replica/pacientes/listarPacientes.phtml");
					}
			
			}//fin else si no existe el id 4 o item historia clinica
			
				
			//se importa el footer
            require_once("Views/Layout/footer.phtml");


?>