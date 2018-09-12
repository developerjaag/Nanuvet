<?php 

/*
 * SubControlador para las cirugias
 */
 
  
 $informacionPropietario = $objetoReplica->replica_consultarInformacionPropietario($_GET['id1']);
 
 $informacionPaciente	= $objetoReplica->replica_consultarInformacionPaciente($_GET['id2']);
 
 $listadoFormulas	= $objetoReplica->listado_formulasPaciente($_GET['id2']);



?>