<?php

/*
 * Controlador para mostrar la informacion de una vacuna que se busca
 */
 	if(!isset($_SESSION)){
		    session_start();
		}
 
  	$idVacuna = $_POST['idVacuna'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las vacunas
	require_once("../../../Models/vacunas_model.php");
	
	$objetoVacunas = new vacunas(); 
	
	$listadoVacunas = $objetoVacunas->listarUnaVacuna($idVacuna);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				$lang_vacunas		= array();
				$lang_vacunas[4]	= "Descripción";
				$lang_vacunas[8]	= "Activar vacuna";
				$lang_vacunas[9]	= "Desactivar vacuna";
				$lang_vacunas[10]	= "Vacuna";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_general[12]   = "State";	
				$lang_vacunas		= array();
				$lang_vacunas[4]	= "Description";
				$lang_vacunas[8]	= "Activate vaccine";
				$lang_vacunas[9]	= "Disable vaccine";
				$lang_vacunas[10]	= "Vaccine";
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
									
				<thead>
					<tr>
						<th><?php echo $lang_vacunas[10]//Vacunas?></th>
						<th><?php echo $lang_vacunas[4]//Descripción?></th>
						<th><?php echo $lang_general[12]//Estado?></th>
					</tr>
				</thead>
				
				<tbody>
					
					<?php									
						foreach ($listadoVacunas as $listadoVacunas1) {
							
							if($listadoVacunas1['estado'] == 'A'){																																																			//Desactivar vacuna
								$btn = '<span id="spanB_'.$listadoVacunas1['idVacuna'].'"> <a id="'.$listadoVacunas1['idVacuna'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarVacuna(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_vacunas[9].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
							}else{																																																											//Activar vacuna
								$btn = '<span id="spanB_'.$listadoVacunas1['idVacuna'].'"> <a id="'.$listadoVacunas1['idVacuna'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarVacuna(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_vacunas[9].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
							}
							
							$parametros = "'".$listadoVacunas1['idVacuna']."','".$listadoVacunas1['nombre']."','".$listadoVacunas1['descripcion']."'";
					?>
					
						<tr style="cursor: pointer;">
							<td  <?php if(in_array("78", $_SESSION['permisos_usuario'] )){ ?> onclick="editarVacuna(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoVacunas1['nombre']?></td>
							<td  <?php if(in_array("78", $_SESSION['permisos_usuario'] )){ ?> onclick="editarVacuna(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoVacunas1['descripcion']?></td>
							<td>
								<?php echo $btn ?>											
							</td>
						</tr>											
							
					<?php		
						}//fin foreach								
					?>
					
					
					
				</tbody>
				
				
			</table>