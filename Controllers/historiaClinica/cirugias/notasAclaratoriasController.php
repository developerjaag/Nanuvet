<?php

/*
 * Controlador para consultar las notas aclaratorias de una consulta
 */
	if(!isset($_SESSION)){
		    session_start();
		}

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
		
		
		$idCirugia	= $_POST['idCirugia'];
		
		//se importa el config y el modelo
		require_once('../../../Config/config.php');
		
		require_once('../../../Models/cirugias_model.php');
		
		$objetoCirugias	= new cirugias();
		
		$datosNotasAclaratorias	= $objetoCirugias->consultarNotasAclaratorias($idCirugia);
		
		
		foreach ($datosNotasAclaratorias as $datosNotasAclaratorias1) {
		
			?>
			
			
			<blockquote>
				<h6><u><b><?php echo $datosNotasAclaratorias1['nombre']." ".$datosNotasAclaratorias1['apellido']." (".$datosNotasAclaratorias1['identificacion'].") -- ".$datosNotasAclaratorias1['fecha']." --"?></b></u></h6>
				<?php echo $datosNotasAclaratorias1['texto'] ?>
			</blockquote>
			
			
			<?php	
						
		}//fin foreach
		
		
		
	} 

?>