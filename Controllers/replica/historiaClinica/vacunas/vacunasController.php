<?php
/*
 * Sub controlador para las vacunas replica
 */

 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoVacunasPaciente	= $objetoReplica->listado_vacunasPaciente($_GET['id2']);

?>