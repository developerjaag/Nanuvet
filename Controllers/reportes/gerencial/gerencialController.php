<?php

/*
 * Subcontrolador para el reporte gerencial
 */
 
 
 $totalCitas			= $objetoReportes->gerencial_totalCitas();
 $totalCitasCanceladas	= $objetoReportes->gerencial_totalCitas("","","Cancelada");
 
 
 $totalConsultas			= $objetoReportes->gerencial_Totales('idConsulta', 'tb_consultas');
 $totalCirugias				= $objetoReportes->gerencial_Totales('idCirugia', 'tb_cirugias');
 $totalDesparasitantes		= $objetoReportes->gerencial_Totales('idDesparasitanteMascota', 'tb_desparasitantesMascotas');
 $totalExamenes				= $objetoReportes->gerencial_Totales('idExamen', 'tb_examenes');
 $totalHospitalizaciones	= $objetoReportes->gerencial_Totales('idHospitalizacion', 'tb_hospitalizacion', "", "", "fechaIngreso");
 $totalVacunas				= $objetoReportes->gerencial_Totales('idMascotaVacunas', 'tb_mascotas_vacunas');
 
 $totalFacturas				= $objetoReportes->gerencial_Totales('idFactura', 'tb_facturas');
 
 $valorInventario			= $objetoReportes->gerencial_valorInventario();
 

?>