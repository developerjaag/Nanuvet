<?php

/*
 * Sibcontrolador para el reporte de los desparasitantes
 * */
 
 
 
 //si llega el formulario con filtros para la busqueda
if(isset($_POST['envioFormFiltros']) and  $_POST['envioFormFiltros'] == 'enviar'){
	
	
	//se reciben las variables
	$_SESSION['filtro_post'] 					= "Si";
	
	$_SESSION['filtro_1'] 			= $_POST['fechaInicial'];
	$_SESSION['filtro_2']			= $_POST['fechaFinal'];
	$_SESSION['filtro_4']			= $_POST['idDesparasitante'];
	$_SESSION['filtro_5']			= $_POST['idPropietario'];
	$_SESSION['filtro_6']			= $_POST['cita_pacientes'];
	$_SESSION['filtro_7'] 			= $_POST['fechaInicial2'];
	$_SESSION['filtro_8']			= $_POST['fechaFinal2'];
	
	//se redirecciona nuevamente a reportes desparasitantes
     header('Location: '.Config::ruta().'reportes/desparasitantes/' );	

	exit();
	
}
 
if( isset($_SESSION['filtro_post']) AND $_SESSION['filtro_post'] == "Si"){
	
				$fechaInicial 			= $_SESSION['filtro_1'];
				$fechaFinal				= $_SESSION['filtro_2'];
				$idDesparasitante		= $_SESSION['filtro_4'];
				$idPropietario			= $_SESSION['filtro_5'];
				$paciente				= $_SESSION['filtro_6'];
				$fechaInicialProximo 	= $_SESSION['filtro_7'];
				$fechaFinalProximo		= $_SESSION['filtro_8'];
				
				$listadoDesparasitantes = $objetoReportes->desparasitantes_aplicarFiltrosDesparasitantes($fechaInicial, $fechaFinal, $fechaInicialProximo, $fechaFinalProximo, $idDesparasitante, $idPropietario, $paciente);
			
				$listadoDesparasitantesExportar = $listadoDesparasitantes;
				
				$totalRegistros = $objetoReportes->desparasitantes_TotalAplicarFiltrosDesparasitantes($fechaInicial, $fechaFinal, $fechaInicialProximo, $fechaFinalProximo, $idDesparasitante, $idPropietario, $paciente);

	
		}else{
  
			 //se consulta el total de los desparasitantes existentes
				$TotalDesparasitantes = $objetoReportes->desparasitantes_tatalDesparasitantes();	
				$records_per_page = 30;//total de registros por pagina
				
				require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo
			
				
				$pagination = new Zebra_Pagination();//se instancia el objeto
				
				$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
				
				$pagination->method('get');//metod por el que se recive la variable
			
				$pagination->variable_name('id2');//nombre de la variable get
				
				$pagination->padding(false);//para que no se muestre un cero adelante
				
				$paginaActual = $pagination->get_page() - 1;
				
				$listadoDesparasitantes = $objetoReportes->desparasitantes_listarDesparasitantes($paginaActual,$records_per_page);//se llama al metodo para listar las cirugias segun los limites de la consulta
				
				$pagination->records($TotalDesparasitantes);
				
				$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
				
				//para el contenido a exportar, son todos los desparasitantes	
				$listadoDesparasitantesExportar = $objetoReportes->desparasitantes_listarDesparasitantes('0',$TotalDesparasitantes);	
			//fin paginación
			
			$totalRegistros = $TotalDesparasitantes;
 
 	}
?>