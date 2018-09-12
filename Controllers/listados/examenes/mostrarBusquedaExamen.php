<?php

/*
 * Controlador para mostrar la informacion de un examen que se busca
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
  	$idExamen = $_POST['idExamen'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los examenes
	require_once("../../../Models/examenes_model.php");
	
	$objetoExamenes = new examenes(); 
	
	$listadoExamenes = $objetoExamenes->listarUnExamen($idExamen);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				$lang_examenes			= array();
				$lang_examenes[5]		= "Código";
				$lang_examenes[6]		= "Precio";
				$lang_examenes[7]		= "Descripción";
				$lang_examenes[10]		= "Activar examen";
				$lang_examenes[11]		= "Desactivar examen";
				$lang_examenes[12]		= "Examen";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_general[12]   = "State";	
				$lang_examenes			= array();	
				$lang_examenes[5]		= "Code";
				$lang_examenes[6]		= "Price";
				$lang_examenes[7]		= "Description";
				$lang_examenes[10]		= "Activate examination";
				$lang_examenes[11]		= "Disable examination";
				$lang_examenes[12]		= "Exam";
    		break;
        
    }//fin swtich
 

?>


		<table class="bordered highlight centered responsive-table">
									
					<thead>
						<tr>
							<th><?php echo $lang_examenes[12]//Examen?></th>
							<th><?php echo $lang_examenes[5]//Código?></th>
							<th><?php echo $lang_examenes[6]//Precio?></th>
							<th><?php echo $lang_examenes[7]//Descripción?></th>
							<th><?php echo $lang_general[12]//Estado?></th>
						</tr>
					</thead>
					
					<tbody>
						
						<?php									
							foreach ($listadoExamenes as $listadoExamenes1) {
								
								if($listadoExamenes1['estado'] == 'A'){																																																			//Desactivar examen
									$btn = '<span id="spanB_'.$listadoExamenes1['idListadoExamen'].'"> <a id="'.$listadoExamenes1['idListadoExamen'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarExamen(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_examenes[11].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
								}else{																																																											//Activar examen
									$btn = '<span id="spanB_'.$listadoExamenes1['idListadoExamen'].'"> <a id="'.$listadoExamenes1['idListadoExamen'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarExamen(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_examenes[10].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
								}
								
								$parametros = "'".$listadoExamenes1['idListadoExamen']."','".$listadoExamenes1['nombre']."','".$listadoExamenes1['codigo']."','".$listadoExamenes1['precio']."','".$listadoExamenes1['descripcion']."'";
						?>
						
							<tr style="cursor: pointer;">
								<td <?php if(in_array("73", $_SESSION['permisos_usuario'] )){ ?> onclick="editarExamen(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoExamenes1['nombre']?></td>
								<td <?php if(in_array("73", $_SESSION['permisos_usuario'] )){ ?> onclick="editarExamen(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoExamenes1['codigo']?></td>
								<td <?php if(in_array("73", $_SESSION['permisos_usuario'] )){ ?> onclick="editarExamen(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoExamenes1['precio']?></td>
								<td <?php if(in_array("73", $_SESSION['permisos_usuario'] )){ ?> onclick="editarExamen(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoExamenes1['descripcion']?></td>
								<td>
									<?php echo $btn ?>											
								</td>
							</tr>											
								
						<?php		
							}//fin foreach								
						?>
						
						
						
					</tbody>
					
					
				</table>