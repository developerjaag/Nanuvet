<?php

/*
 * Sibcontrolador para el reporte de formulas
 * */
 
  $listadoUsuariosCirugia  = $objetoReportes->citas_usuariosCitas();
 
 
 //si llega el formulario con filtros para la busqueda
if(isset($_POST['envioFormFiltros']) and  $_POST['envioFormFiltros'] == 'enviar'){
	
	
	//se reciben las variables
	$_SESSION['filtro_post'] 					= "Si";
	
	$_SESSION['filtro_1'] 			= $_POST['fechaInicial'];
	$_SESSION['filtro_2']			= $_POST['fechaFinal'];
	$_SESSION['filtro_3']			= $_POST['usuarios'];
	$_SESSION['filtro_4']			= $_POST['idMedicamento'];
	$_SESSION['filtro_5']			= $_POST['idPropietario'];
	$_SESSION['filtro_6']			= $_POST['cita_pacientes'];

	//se redirecciona nuevamente a reportes formulas
     header('Location: '.Config::ruta().'reportes/formulas/' );	

	exit();
	
}
 
if( isset($_SESSION['filtro_post']) AND $_SESSION['filtro_post'] == "Si"){
	
				$fechaInicial 	= $_SESSION['filtro_1'];
				$fechaFinal		= $_SESSION['filtro_2'];
				$usuarios		= $_SESSION['filtro_3'];
				$idMedicamento	= $_SESSION['filtro_4'];
				$idPropietario	= $_SESSION['filtro_5'];
				$paciente		= $_SESSION['filtro_6'];
				
				$listadoFormulas = $objetoReportes->formulas_aplicarFiltrosFormulas($fechaInicial, $fechaFinal, $usuarios, $idMedicamento, $idPropietario, $paciente);
			
				$listadoFormulasExportar = $listadoFormulas;
				
				$totalRegistros = $objetoReportes->formulas_TotalAplicarFiltrosFormulas($fechaInicial, $fechaFinal, $usuarios, $idMedicamento, $idPropietario, $paciente);

	
		}else{
  
			 //se consulta el total de las formulas existentes
				$TotalFormulas = $objetoReportes->formulas_tatalFormulas();	
				$records_per_page = 30;//total de registros por pagina
				
				require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo
			
				
				$pagination = new Zebra_Pagination();//se instancia el objeto
				
				$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
				
				$pagination->method('get');//metod por el que se recive la variable
			
				$pagination->variable_name('id2');//nombre de la variable get
				
				$pagination->padding(false);//para que no se muestre un cero adelante
				
				$paginaActual = $pagination->get_page() - 1;
				
				$listadoFormulas = $objetoReportes->formulas_listarFormulas($paginaActual,$records_per_page);//se llama al metodo para listar las formulas segun los limites de la consulta
				
				$pagination->records($TotalFormulas);
				
				$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
				
				//para el contenido a exportar, son todas las cirugias	
				$listadoFormulasExportar = $objetoReportes->formulas_listarFormulas('0',$TotalFormulas);	
			//fin paginación
			
			$totalRegistros = $TotalFormulas;
 
 	}
?>