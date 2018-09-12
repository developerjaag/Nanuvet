<?php

/*
 * Archivo para consultar el reporte gerencial por fechas
 */
 
 $fechaInicio 	= $_POST['fechaInicio'];
 $fechaFin		= $_POST['fechaFin'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los reportes
	require_once("../../../Models/reportes_model.php");
	
	$objetoReportes = new reportes();

 $totalCitas			= $objetoReportes->gerencial_totalCitas($fechaInicio, $fechaFin);
 $totalCitasCanceladas	= $objetoReportes->gerencial_totalCitas($fechaInicio,$fechaFin,"Cancelada");
 
 
 $totalConsultas			= $objetoReportes->gerencial_Totales('idConsulta', 'tb_consultas',$fechaInicio, $fechaFin);
 $totalCirugias				= $objetoReportes->gerencial_Totales('idCirugia', 'tb_cirugias',$fechaInicio, $fechaFin);
 $totalDesparasitantes		= $objetoReportes->gerencial_Totales('idDesparasitanteMascota', 'tb_desparasitantesMascotas',$fechaInicio, $fechaFin);
 $totalExamenes				= $objetoReportes->gerencial_Totales('idExamen', 'tb_examenes',$fechaInicio, $fechaFin);
 $totalHospitalizaciones	= $objetoReportes->gerencial_Totales('idHospitalizacion', 'tb_hospitalizacion', $fechaInicio, $fechaFin, "fechaIngreso");
 $totalVacunas				= $objetoReportes->gerencial_Totales('idMascotaVacunas', 'tb_mascotas_vacunas', $fechaInicio, $fechaFin);
 
 $totalFacturas				= $objetoReportes->gerencial_Totales('idFactura', 'tb_facturas', $fechaInicio, $fechaFin);
 
 $valorInventario			= $objetoReportes->gerencial_valorInventario();
 
 require_once("../../../Views/reportes/gerencial/resultadoReporteGerencial.phtml");

?>