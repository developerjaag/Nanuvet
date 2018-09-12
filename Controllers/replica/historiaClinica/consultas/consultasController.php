<?php 
/*
 * Subcontrolador para las consultas de la replica
 */
 
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoConsultas	= $objetoReplica->listado_consultasPaciente($_GET['id2']);
 
 

?>