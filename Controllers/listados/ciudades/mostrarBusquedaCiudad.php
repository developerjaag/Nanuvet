<?php

/*
 * Controlador para mostrar la informacion de una ciudad que se busca
 */
 
 
  	$idCiudad = $_POST['idCiudad'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../../Models/ciudades_model.php");
	
	$objetoCiudades = new ciudades(); 
	
	$listadoCiudades = $objetoCiudades->listarUnaCiudad($idCiudad);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_barrios   =   array();
				$lang_general   = 	array();
				$lang_ciudades  =   array();
				$lang_ciudades[7]   = "Activar ciudad";
				$lang_ciudades[8]   = "Desactivar ciudad";
				$lang_barrios[9]   = "Ciudad";
				$lang_barrios[10]   = "País";
				$lang_general[12]   = "Estado";
    		break;
    		
    	case 'En':
				$lang_barrios   =   array();
				$lang_general   = 	array();
				$lang_ciudades  =   array();
				$lang_ciudades[7]   = "Activate city";
				$lang_ciudades[8]   = "Disable city";
				$lang_barrios[9]   = "City";
				$lang_barrios[10]   = "Country";
				$lang_general[12]   = "State";
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
			
			<thead>
				<tr>
					<th><?php echo $lang_barrios[9]//Ciudad?></th>
					<th><?php echo $lang_barrios[10]//País?></th>
					<th><?php echo $lang_general[12]//Estado?></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php									
					foreach ($listadoCiudades as $listadoCiudades1) {
						
						if($listadoCiudades1['estado'] == 'A'){																																																			//Desactivar ciudad
							$btn = '<span id="spanB_'.$listadoCiudades1['idCiudad'].'"> <a id="'.$listadoCiudades1['idCiudad'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarCiudad(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_ciudades[8].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}else{																																																											//Activar ciudad
							$btn = '<span id="spanB_'.$listadoCiudades1['idCiudad'].'"> <a id="'.$listadoCiudades1['idCiudad'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarCiudad(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_ciudades[7].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}
						
						$parametros = "'".$listadoCiudades1['idCiudad']."','".$listadoCiudades1['nombreC']."','".$listadoCiudades1['idPais']."'";
				?>
				
					<tr style="cursor: pointer;">
						<td <?php if(in_array("19", $_SESSION['permisos_usuario'] )){?> onclick="editarCiudad(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoCiudades1['nombreC']?></td>
						<td <?php if(in_array("19", $_SESSION['permisos_usuario'] )){?> onclick="editarCiudad(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoCiudades1['nombreP']?></td>
						<td>
							<?php echo $btn ?>											
						</td>
					</tr>											
						
				<?php		
					}//fin foreach								
				?>
				
				
				
			</tbody>
			
			
		</table>