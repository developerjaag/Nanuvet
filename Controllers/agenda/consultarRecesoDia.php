<?php

/*
 * metodo para consultar los recesos de un dia
 */
 
 $idUsuario		= $_POST['idUsuario'];
 $dia			= $_POST['dia'];


	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultadoRecesosDia	= $objetoAgenda->consultarRecesosDia($idUsuario, $dia);
 

	foreach ($resultadoRecesosDia as $resultadoRecesosDia) {
		
?>

		<li class="collection-item">
			<div>
				<table>
					<tr>						
						<td><?php echo $resultadoRecesosDia['horaInicio']?></td>
						<td><?php echo $resultadoRecesosDia['horaFin']?></td>
						<td style="text-align: right;"><i onclick="inactivarRecesoDia('<?php echo $resultadoRecesosDia['idAgendaHorarioReceso'] ?>','<?php echo $dia ?>')" style="cursor: pointer;" class="fa fa-trash fa-2x" aria-hidden="true"></i></td>
					</tr>
				</table>
				
			</div>
		</li>	
		
<?php		
	}

?>
	