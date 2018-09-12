<?php

/*
 * Sub controlador para el reporte de citas
 */
 
 
 $listadoUsuariosCitas  = $objetoReportes->citas_usuariosCitas();
 $listadoTiposCitas 	= $objetoReportes->citas_tiposCitas();
 
//si llega el formulario con filtros para la busqueda
if(isset($_POST['envioFormFiltros']) and  $_POST['envioFormFiltros'] == 'enviar'){
	
	
	//se reciben las variables
	$_SESSION['filtro_post'] 					= "Si";
	
	$_SESSION['filtro_1'] 			= $_POST['fechaInicial'];
	$_SESSION['filtro_2']			= $_POST['fechaFinal'];
	$_SESSION['filtro_3']			= $_POST['usuarios'];
	$_SESSION['filtro_4']			= $_POST['tipoCita'];
	$_SESSION['filtro_5']			= $_POST['idPropietario'];
	$_SESSION['filtro_6']			= $_POST['cita_pacientes'];

	//se redirecciona nuevamente a reportes citas
     header('Location: '.Config::ruta().'reportes/citas/' );	

	exit();
	
}

		if( isset($_SESSION['filtro_post']) AND $_SESSION['filtro_post'] == "Si"){
			
				$fechaInicial 	= $_SESSION['filtro_1'];
				$fechaFinal		= $_SESSION['filtro_2'];
				$usuarios		= $_SESSION['filtro_3'];
				$tipoCita		= $_SESSION['filtro_4'];
				$idPropietario	= $_SESSION['filtro_5'];
				$paciente		= $_SESSION['filtro_6'];
				
				$listadoCitas = $objetoReportes->citas_aplicarFiltrosCitas($fechaInicial, $fechaFinal, $usuarios, $tipoCita, $idPropietario, $paciente);
			
				$listadoCitasExportar = $listadoCitas;
				
				$totalRegistros = $objetoReportes->citas_TotalAplicarFiltrosCitas($fechaInicial, $fechaFinal, $usuarios, $tipoCita, $idPropietario, $paciente);
			
		}else{
 
				 //se consulta el total de las citas existentes
						$TotalCitas = $objetoReportes->citas_tatalCitas();	
						$records_per_page = 30;//total de registros por pagina
						
						require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo
				
						
				   		$pagination = new Zebra_Pagination();//se instancia el objeto
						
						$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
						
						$pagination->method('get');//metod por el que se recive la variable
				
						$pagination->variable_name('id2');//nombre de la variable get
						
						$pagination->padding(false);//para que no se muestre un cero adelante
						
						$paginaActual = $pagination->get_page() - 1;
						
						$listadoCitas = $objetoReportes->citas_listarCitas($paginaActual,$records_per_page);//se llama al metodo para listar las citas segun los limites de la consulta
						
						$pagination->records($TotalCitas);
						
						$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
						
						//para el contenido a exportar, son todas las citas	
						$listadoCitasExportar = $objetoReportes->citas_listarCitas('0',$TotalCitas);	
					//fin paginación
					
					$totalRegistros = $TotalCitas;
		}
?>