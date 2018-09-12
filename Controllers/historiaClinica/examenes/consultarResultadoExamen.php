<?php

	/*
	 * Archivo para consultar los resultados de un examen
	 */
	 
	 $idExamenDetalle  = $_POST['idExamenDetalle'];
	 
	//se importa el config y el modelo
	require_once('../../../Config/config.php');
	
	require_once('../../../Models/examenes_model.php');	 
	
	$objetoExamen  = new examenes();
	
	$resultadoExamen = $objetoExamen->consultarResultadoExamen($idExamenDetalle);
	 
	$varSW = 0;
	
	if(sizeof($resultadoExamen) > 0){
		$varSW = 1;
	}
	
	if($varSW == 0){
		echo "SinData";
	}else{
		
		foreach ($resultadoExamen as $resultadoExamen1) {
			
			?>	
			
				<table>
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Resultado general</th>
							<th>Usuario</th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td><?php echo $resultadoExamen1['fecha'] ?></td>
							<td><?php echo $resultadoExamen1['hora'] ?></td>
							
							<?php 
								switch ($resultadoExamen1['general']) {
									case 'Bueno':
										$resultadoGeneral = "Bueno";
									break;
									case 'Regular':
										$resultadoGeneral = "Regular";
									break;
									case 'Malo':
										$resultadoGeneral = "Malo";
									break;
									
								}
							?>
							
							<td><?php echo $resultadoGeneral ?></td>
							<td><?php echo "(".$resultadoExamen1['identificacion'].") ".$resultadoExamen1['nombreUsuario']." ".$resultadoExamen1['apellido'] ?></td>
						</tr>
					</tbody>
					
				</table>
			
				<blockquote>
    				<p class="flow-text"><?php echo $resultadoExamen1['observaciones'] ?></p>
    			</blockquote>

			<?php
			
			
		}//fin foreach
		
		
	}//fin else
	 

?>