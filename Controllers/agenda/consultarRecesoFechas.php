<?php

/*
 * Archivo para listar las fechas que tengna un horario configurado 
 */
 
 	$idUsuario 	= $_POST['idUsuario']; 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultadoRecesoFechasUsuario	= $objetoAgenda->consultarRecesosFechasListado($idUsuario);
 

	foreach ($resultadoRecesoFechasUsuario as $resultadoRecesoFechasUsuario1) {
		
?>

		<li class="collection-item">
			<div>
				<table>
					<tr>
						<td style="text-align: center;"><?php echo $resultadoRecesoFechasUsuario1['fecha']?></td>
						<td><?php echo $resultadoRecesoFechasUsuario1['horaInicio']?></td>
						<td><?php echo $resultadoRecesoFechasUsuario1['horaFin']?></td>
						<td style="text-align: right;"><i onclick="inactivarRecesoFecha(<?php echo $resultadoRecesoFechasUsuario1['idAgendaHorarioRecesoFecha']?>)" style="cursor: pointer;" class="fa fa-trash fa-2x" aria-hidden="true"></i></td>
					</tr>
				</table>
				
			</div>
		</li>	
		
<?php		
	}

?>