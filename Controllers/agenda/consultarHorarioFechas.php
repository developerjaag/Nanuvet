<?php

/*
 * Archivo para listar las fechas que tengna un horario configurado 
 */
 
 $idUsuario 	= $_POST['idUsuario']; 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultadoHorarioFechasUsuario	= $objetoAgenda->consultarHoriosFechasListado($idUsuario);
 

	foreach ($resultadoHorarioFechasUsuario as $resultadoHorarioFechasUsuario1) {
		
?>

		<li class="collection-item">
			<div>
				<table>
					<tr>
						<td style="text-align: center;"><?php echo $resultadoHorarioFechasUsuario1['fecha']?></td>
						<td><?php echo $resultadoHorarioFechasUsuario1['horaInicio']?></td>
						<td><?php echo $resultadoHorarioFechasUsuario1['horaFin']?></td>
						<td style="text-align: right;"><i onclick="inactivarHorarioFecha(<?php echo $resultadoHorarioFechasUsuario1['idAgendaHorarioFechaUsuario']?>)" style="cursor: pointer;" class="fa fa-trash fa-2x" aria-hidden="true"></i></td>
					</tr>
				</table>
				
			</div>
		</li>	
		
<?php		
	}

?>