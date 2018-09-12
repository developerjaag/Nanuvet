<?php

/*
 * Controlador para mostrar la informacion de una raza que se busca
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
  	$idRaza = $_POST['idRaza'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las razas
	require_once("../../../Models/razas_model.php");
	
	$objetoRazas = new razas(); 
	
	$listadoRazas = $objetoRazas->listarUnaRaza($idRaza);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general    = 	array();
				$lang_razas			= array();
				$lang_general[12]   = "Estado";
				$lang_razas[6]		= "Activar raza";
				$lang_razas[7]		= "Desactivar raza";
				$lang_razas[8]		= "Raza";
				$lang_razas[9]		= "Especie";
    		break;
    		
    	case 'En':
				$lang_general    = 	array();
				$lang_razas			= array();
				$lang_general[12]   = "State";
				$lang_razas[6]		= "Activar raza";
$lang_razas[7]		= "Desactivar raza";
$lang_razas[8]		= "Raza";
$lang_razas[9]		= "Especie";
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
									
				<thead>
					<tr>
						<th><?php echo $lang_razas[8]//Raza?></th>
						<th><?php echo $lang_razas[9]//Especie?></th>
						<th><?php echo $lang_general[12]//Estado?></th>
					</tr>
				</thead>
				
				<tbody>
					
					<?php									
						foreach ($listadoRazas as $listadoRazas1) {
							
							if($listadoRazas1['estado'] == 'A'){																																																			//Desactivar raza
								$btn = '<span id="spanB_'.$listadoRazas1['idRaza'].'"> <a id="'.$listadoRazas1['idRaza'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarRaza(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_razas[7].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
							}else{																																																											//Activar raza
								$btn = '<span id="spanB_'.$listadoRazas1['idRaza'].'"> <a id="'.$listadoRazas1['idRaza'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarRaza(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_razas[6].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
							}
							
							$parametros = "'".$listadoRazas1['idRaza']."','".$listadoRazas1['nombreR']."','".$listadoRazas1['idEspecie']."','".$listadoRazas1['nombreE']."'";
					?>
					
						<tr style="cursor: pointer;">
							<td <?php if(in_array("33", $_SESSION['permisos_usuario'] )){ ?> onclick="editarRaza(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoRazas1['nombreR']?></td>
							<td <?php if(in_array("33", $_SESSION['permisos_usuario'] )){ ?> onclick="editarRaza(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoRazas1['nombreE']?></td>
							<td>
								<?php echo $btn ?>											
							</td>
						</tr>											
							
					<?php		
						}//fin foreach								
					?>
					
					
					
				</tbody>
				
				
			</table>