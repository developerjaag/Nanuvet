<?php

/*
 * Sibcontrolador para el reporte de consultas
 * */
 
  $listadoUsuariosConsultas  = $objetoReportes->citas_usuariosCitas();
 
 
 //si llega el formulario con filtros para la busqueda
if(isset($_POST['envioFormFiltros']) and  $_POST['envioFormFiltros'] == 'enviar'){
	
	
	//se reciben las variables
	$_SESSION['filtro_post'] 					= "Si";
	
	$_SESSION['filtro_1'] 			= $_POST['fechaInicial'];
	$_SESSION['filtro_2']			= $_POST['fechaFinal'];
	$_SESSION['filtro_3']			= $_POST['usuarios'];
	$_SESSION['filtro_4']			= $_POST['idDxConsulta'];
	$_SESSION['filtro_5']			= $_POST['idPropietario'];
	$_SESSION['filtro_6']			= $_POST['cita_pacientes'];

	//se redirecciona nuevamente a reportes consultas
     header('Location: '.Config::ruta().'reportes/consultas/' );	

	exit();
	
}
 
if( isset($_SESSION['filtro_post']) AND  $_SESSION['filtro_post'] == "Si"){
	
				$fechaInicial 	= $_SESSION['filtro_1'];
				$fechaFinal		= $_SESSION['filtro_2'];
				$usuarios		= $_SESSION['filtro_3'];
				$idDxConsulta	= $_SESSION['filtro_4'];
				$idPropietario	= $_SESSION['filtro_5'];
				$paciente		= $_SESSION['filtro_6'];
				
				$listadoConsultas = $objetoReportes->consultas_aplicarFiltrosConsultas($fechaInicial, $fechaFinal, $usuarios, $idDxConsulta, $idPropietario, $paciente);
			
				$listadoConsultasExportar = $listadoConsultas;
				
				$totalRegistros = $objetoReportes->consultas_TotalAplicarFiltrosConsultas($fechaInicial, $fechaFinal, $usuarios, $idDxConsulta, $idPropietario, $paciente);

	
		}else{
  
			 //se consulta el total de las consultas existentes
				$TotalConsultas = $objetoReportes->consultas_tatalConsultas();	
				$records_per_page = 30;//total de registros por pagina
				
				require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo
			
				
				$pagination = new Zebra_Pagination();//se instancia el objeto
				
				$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
				
				$pagination->method('get');//metod por el que se recive la variable
			
				$pagination->variable_name('id2');//nombre de la variable get
				
				$pagination->padding(false);//para que no se muestre un cero adelante
				
				$paginaActual = $pagination->get_page() - 1;
				
				$listadoConsultas = $objetoReportes->consultas_listarConsultas($paginaActual,$records_per_page);//se llama al metodo para listar las consultas segun los limites de la consulta
				
				$pagination->records($TotalConsultas);
				
				$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
				
				//para el contenido a exportar, son todas las consultas	
				$listadoConsultasExportar = $objetoReportes->consultas_listarConsultas('0',$TotalConsultas);	
			//fin paginación
			
			$totalRegistros = $TotalConsultas;
 
 	}
?>