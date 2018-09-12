<?php

/*
 * Controlador para mostrar la informacion de un barrio que se busca
 */
 
 
  	$idBarrio = $_POST['idBarrio'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../../Models/barrios_model.php");
	
	$objetobarrios = new barrios(); 
	
	$informacionBarrio = $objetobarrios->listarUnBarrio($idBarrio);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_barrios   =   array();
				$lang_general   = 	array();
				$lang_barrios[6]   = "Activar barrio";
				$lang_barrios[7]   = "Desactivar barrio";
				$lang_barrios[8]   = "Barrio";
				$lang_barrios[9]   = "Ciudad";
				$lang_barrios[10]   = "País";
				$lang_general[12]   = "Estado";
    		break;
    		
    	case 'En':
				$lang_barrios   =   array();
				$lang_general   = 	array();
				$lang_barrios[6]   = "Activate neighborhood";
				$lang_barrios[7]   = "Disable neighborhood";
				$lang_barrios[8]   = "Neighborhood";
				$lang_barrios[9]   = "City";
				$lang_barrios[10]   = "Country";
				$lang_general[12]   = "State";
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
			
			<thead>
				<tr>
					<th><?php echo $lang_barrios[8]//Barrio?></th>
					<th><?php echo $lang_barrios[9]//Ciudad?></th>
					<th><?php echo $lang_barrios[10]//País?></th>
					<th><?php echo $lang_general[12]//Estado?></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php									
					foreach ($informacionBarrio as $listadoBarrios1) {
						
						if($listadoBarrios1['estado'] == 'A'){																																																			//Desactivar barrio
							$btn = '<span id="spanB_'.$listadoBarrios1['idBarrio'].'"> <a id="'.$listadoBarrios1['idBarrio'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarBarrio(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_barrios[7].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}else{																																																											//Activar barrio
							$btn = '<span id="spanB_'.$listadoBarrios1['idBarrio'].'"> <a id="'.$listadoBarrios1['idBarrio'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarBarrio(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_barrios[6].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}
						
						$parametros = "'".$listadoBarrios1['idBarrio']."','".$listadoBarrios1['nombreB']."','".$listadoBarrios1['idCiudad']."'";
				?>
				
					<tr style="cursor: pointer;">
						<td <?php if(in_array("16", $_SESSION['permisos_usuario'] )){ ?> onclick="editarBarrio(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoBarrios1['nombreB']?></td>
						<td <?php if(in_array("16", $_SESSION['permisos_usuario'] )){ ?> onclick="editarBarrio(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoBarrios1['nombreC']?></td>
						<td <?php if(in_array("16", $_SESSION['permisos_usuario'] )){ ?> onclick="editarBarrio(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoBarrios1['nombreP']?></td>
						<td>
							<?php echo $btn ?>											
						</td>
					</tr>											
						
				<?php		
					}//fin foreach								
				?>
				
				
				
			</tbody>
			
			
		</table>