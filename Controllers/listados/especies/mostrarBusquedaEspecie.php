<?php

/*
 * Controlador para mostrar la informacion de una especie que se busca
 */
 	if(!isset($_SESSION)){
		    session_start();
		}
 
  	$idEspecie = $_POST['idEspecie'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las especies
	require_once("../../../Models/especies_model.php");
	
	$objetoEspecies = new especies(); 
	
	$listadoEspecies = $objetoEspecies->listarUnaEspecie($idEspecie);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				$lang_especies			= array();
				$lang_especies[6]			= "Activar especie";
				$lang_especies[7]			= "Desactivar especie";
				$lang_especies[8]			= "Especie";
				
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_general[12]   = "State";
				$lang_especies			= array();				
				$lang_especies[6]			= "Activate species";
				$lang_especies[7]			= "disable species";
				$lang_especies[8]			= "Specie";
				
    		break;
        
    }//fin swtich
 

?>


<table class="bordered highlight centered responsive-table">
									
		<thead>
			<tr>
				<th><?php echo $lang_especies[8]//Especie?></th>
				<th><?php echo $lang_general[12]//Estado?></th>
			</tr>
		</thead>
		
		<tbody>
			
			<?php									
				foreach ($listadoEspecies as $listadoEspecies1) {
					
					if($listadoEspecies1['estado'] == 'A'){																																																			//Desactivar especie
						$btn = '<span id="spanB_'.$listadoEspecies1['idEspecie'].'"> <a id="'.$listadoEspecies1['idEspecie'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarEspecie(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_especies[7].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
					}else{																																																											//Activar especie
						$btn = '<span id="spanB_'.$listadoEspecies1['idEspecie'].'"> <a id="'.$listadoEspecies1['idEspecie'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarEspecie(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_especies[6].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
					}
					
					$parametros = "'".$listadoEspecies1['idEspecie']."','".$listadoEspecies1['nombre']."'";
			?>
			
				<tr style="cursor: pointer;">
					<td <?php if(in_array("31", $_SESSION['permisos_usuario'] )){ ?> onclick="editarEspecie(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoEspecies1['nombre']?></td>
					<td>
						<?php echo $btn ?>											
					</td>
				</tr>											
					
			<?php		
				}//fin foreach								
			?>
			
			
			
		</tbody>
		
		
	</table>