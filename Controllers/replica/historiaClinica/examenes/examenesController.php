<?php 

/*
 * SubControlador para los examenes
 */
 
  
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoExamenes	= $objetoReplica->listado_examenesPaciente($_GET['id2']);



?>