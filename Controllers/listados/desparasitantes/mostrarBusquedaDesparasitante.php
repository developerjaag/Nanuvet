<?php

/*
 * Controlador para mostrar la informacion de un desparasitante que se busca
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
	 
  	$idDesparasitante = $_POST['idDesparasitante'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los desparasitantes
	require_once("../../../Models/desparasitantes_model.php");
	
	$objetoDesparasitantes = new desparasitantes(); 
	
	$listadoDesparasitantes = $objetoDesparasitantes->listarUnDesparasitante($idDesparasitante);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				$lang_desparasitantes		= array();
				$lang_desparasitantes[4]	= "Descripción";
				$lang_desparasitantes[7]	= "Activar desparasitante";
				$lang_desparasitantes[8]	= "Desactivar desparasitante";
				$lang_desparasitantes[9]	= "Desparasitante";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_desparasitantes		= array();
				$lang_general[12]   = "State";
				$lang_desparasitantes[4]	= "Description";
				$lang_desparasitantes[7]	= "Activate desparasitante";
				$lang_desparasitantes[8]	= "Disable desparasitante";
				$lang_desparasitantes[9]	= "To deworm";			
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
									
			<thead>
				<tr>
					<th><?php echo $lang_desparasitantes[9]//Desparasitante?></th>
					<th><?php echo $lang_desparasitantes[4]//Descripción?></th>
					<th><?php echo $lang_general[12]//Estado?></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php									
					foreach ($listadoDesparasitantes as $listadoDesparasitantes1) {
						
						if($listadoDesparasitantes1['estado'] == 'A'){																																																			//Desactivar desparasitante
							$btn = '<span id="spanB_'.$listadoDesparasitantes1['idDesparasitante'].'"> <a id="'.$listadoDesparasitantes1['idDesparasitante'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarDesparasitante(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_desparasitantes[8].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}else{																																																											//Activar desparasitante
							$btn = '<span id="spanB_'.$listadoDesparasitantes1['idDesparasitante'].'"> <a id="'.$listadoDesparasitantes1['idDesparasitante'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarDesparasitante(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_desparasitantes[7].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}
						
						$parametros = "'".$listadoDesparasitantes1['idDesparasitante']."','".$listadoDesparasitantes1['nombre']."','".$listadoDesparasitantes1['descripcion']."'";
				?>
				
					<tr style="cursor: pointer;">
						<td  <?php if(in_array("83", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarDesparasitante(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoDesparasitantes1['nombre']?></td>
						<td  <?php if(in_array("83", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarDesparasitante(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoDesparasitantes1['descripcion']?></td>
						<td>
							<?php echo $btn ?>											
						</td>
					</tr>											
						
				<?php		
					}//fin foreach								
				?>
				
				
				
			</tbody>
			
			
		</table>