<?php 

/*
 * SubControlador para las cirugias
 */
 
  
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoCirugias	= $objetoReplica->listado_cirugiasPaciente($_GET['id2']);



?>