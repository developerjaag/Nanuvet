<?php

/*
 * Sibcontrolador para el reporte de los pacientes
 * */
 
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
 
 //si llega el formulario con filtros para la busqueda
if(isset($_POST['envioFormFiltros']) and  $_POST['envioFormFiltros'] == 'enviar'){
	
	
	//se reciben las variables
	$_SESSION['filtro_post'] 					= "Si";
	
	$_SESSION['filtro_1']			= $_POST['idEspecie'];
	$_SESSION['filtro_2']			= $_POST['idRaza'];
	$_SESSION['filtro_3']			= $_POST['idPropietario'];
	$_SESSION['filtro_4'] 			= $_POST['fechaInicial'];
	$_SESSION['filtro_5']			= $_POST['fechaFinal'];
	
	//se redirecciona nuevamente a reportes pacientes
     header('Location: '.Config::ruta().'reportes/pacientes/' );	

	exit();
	
}
 
if( isset($_SESSION['filtro_post']) AND $_SESSION['filtro_post'] == "Si"){
	
				$idEspecie 			= $_SESSION['filtro_1'];
				$idRaza				= $_SESSION['filtro_2'];
				$idPropietario		= $_SESSION['filtro_3'];
				$fechaInicial 		= $_SESSION['filtro_4'];
				$fechaFinal			= $_SESSION['filtro_5'];
				
				$listadoPacientes = $objetoReportes->pacientes_aplicarFiltrosPacientes($idEspecie, $idRaza, $idPropietario, $fechaInicial, $fechaFinal);
			
				$listadoPacientesExportar = $listadoPacientes;
				
				$totalRegistros = $objetoReportes->pacientes_TotalAplicarFiltrosPacientes($idEspecie, $idRaza, $idPropietario, $fechaInicial, $fechaFinal);

	
		}else{
  
			 //se consulta el total de los pacientes existentes
				$TotalPacientes = $objetoReportes->pacientes_tatalPacientes();	
				$records_per_page = 30;//total de registros por pagina
				
				require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo
			
				
				$pagination = new Zebra_Pagination();//se instancia el objeto
				
				$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
				
				$pagination->method('get');//metod por el que se recive la variable
			
				$pagination->variable_name('id2');//nombre de la variable get
				
				$pagination->padding(false);//para que no se muestre un cero adelante
				
				$paginaActual = $pagination->get_page() - 1;
				
				$listadoPacientes = $objetoReportes->pacientes_listarPacientes($paginaActual,$records_per_page);//se llama al metodo para listar los pacientes segun los limites de la consulta
				
				$pagination->records($TotalPacientes);
				
				$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
				
				//para el contenido a exportar, son todos los pacientes	
				$listadoPacientesExportar = $objetoReportes->pacientes_listarPacientes('0',$TotalPacientes);	
			//fin paginación
			
			$totalRegistros = $TotalPacientes;
 
 	}
?>